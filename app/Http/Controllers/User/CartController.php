<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * カートに商品を追加
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'integer|min:1|max:99',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => '商品が見つかりません。'
            ], 404);
        }

        if (!$product->isInStock()) {
            return response()->json([
                'success' => false,
                'message' => 'この商品は在庫切れです。'
            ], 400);
        }

        if ($product->stock_quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => '在庫が不足しています。'
            ], 400);
        }

        // セッションからカートを取得
        $cart = session()->get('cart', []);

        // 既にカートに存在する場合は数量を更新
        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $quantity;

            // 在庫チェック
            if ($newQuantity > $product->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => '在庫が不足しています。'
                ], 400);
            }

            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            // 新しくカートに追加
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image_url' => \App\Helpers\ImageHelper::getProductThumbnailUrl($product),
                'stock_quantity' => $product->stock_quantity,
            ];
        }

        // セッションにカートを保存
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'カートに商品を追加しました。',
            'cart_count' => $this->getCartItemCount(),
            'product_name' => $product->name,
        ]);
    }

    /**
     * カートから商品を削除
     */
    public function remove(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'カートから商品を削除しました。',
                'cart_count' => $this->getCartItemCount(),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => '商品が見つかりません。'
        ], 404);
    }

    /**
     * カートの商品数量を更新
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json([
                'success' => false,
                'message' => '商品が見つかりません。'
            ], 404);
        }

        $product = Product::find($productId);

        if (!$product || $quantity > $product->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => '在庫が不足しています。'
            ], 400);
        }

        $cart[$productId]['quantity'] = $quantity;
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => '数量を更新しました。',
            'cart_count' => $this->getCartItemCount(),
        ]);
    }

    /**
     * カートの内容を取得
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('user.cart.index', compact('cart', 'total'));
    }

    /**
     * カートを空にする
     */
    public function clear(): JsonResponse
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'カートを空にしました。',
            'cart_count' => 0,
        ]);
    }

    /**
     * カートの商品数を取得
     */
    private function getCartItemCount(): int
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * カートの商品数を取得（API）
     */
    public function count(): JsonResponse
    {
        return response()->json([
            'count' => $this->getCartItemCount(),
        ]);
    }
}
