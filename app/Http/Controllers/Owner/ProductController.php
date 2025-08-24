<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * オーナーの商品一覧を表示
     */
    public function index(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|integer',
            'status' => 'nullable|string|in:active,inactive,all',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        // フィルター条件を設定
        $filters = [];
        if (isset($validatedData['search'])) {
            $filters['search'] = $validatedData['search'];
        }
        if (isset($validatedData['category'])) {
            $filters['category'] = $validatedData['category'];
        }
        if (isset($validatedData['status'])) {
            $filters['status'] = $validatedData['status'];
        }

        $perPage = $validatedData['per_page'] ?? 12;

        // 認証されたオーナーのIDを取得
        $ownerId = Auth::guard('owner')->id();

        // Serviceメソッド呼び出し
        $products = $this->productService->getProductListByOwner($ownerId, $filters, $perPage);
        $categories = $this->productService->getCategories();

        return view('owner.products.index', compact('products', 'filters', 'categories'));
    }

    /**
     * 商品詳細を表示
     */
    public function show(int $id)
    {
        // 認証されたオーナーのIDを取得
        $ownerId = Auth::guard('owner')->id();

        // Serviceメソッド呼び出し
        $product = $this->productService->getProductByIdAndOwner($id, $ownerId);

        if (!$product) {
            abort(404);
        }

        return view('owner.products.show', compact('product'));
    }
}
