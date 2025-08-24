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

    /**
     * 商品登録画面を表示
     */
    public function create()
    {
        $categories = $this->productService->getCategories();
        return view('owner.products.create', compact('categories'));
    }

    /**
     * 商品を登録
     */
    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category' => 'required|integer|min:1|max:8',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 認証されたオーナーのIDを追加
        $validatedData['owner_id'] = Auth::guard('owner')->id();

        try {
            // 商品を作成
            $product = $this->productService->createProduct($validatedData);

            // 画像アップロード処理
            if ($request->hasFile('cover_image')) {
                $this->productService->uploadCoverImage($product->id, $request->file('cover_image'));
            }

            if ($request->hasFile('images')) {
                $this->productService->uploadProductImages($product->id, $request->file('images'));
            }

            return redirect()->route('owner.products.index')
                ->with('success', '商品が正常に登録されました。');

        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['error' => '商品の登録に失敗しました: ' . $e->getMessage()]);
        }
    }

    /**
     * 商品編集画面を表示
     */
    public function edit(int $id)
    {
        // 認証されたオーナーのIDを取得
        $ownerId = Auth::guard('owner')->id();

        // Serviceメソッド呼び出し
        $product = $this->productService->getProductByIdAndOwner($id, $ownerId);

        if (!$product) {
            abort(404);
        }

        $categories = $this->productService->getCategories();

        return view('owner.products.edit', compact('product', 'categories'));
    }

    /**
     * 商品を更新
     */
    public function update(Request $request, int $id)
    {
        // 認証されたオーナーのIDを取得
        $ownerId = Auth::guard('owner')->id();

        // 商品が存在し、オーナーが所有しているか確認
        $product = $this->productService->getProductByIdAndOwner($id, $ownerId);

        if (!$product) {
            abort(404);
        }

        // バリデーション
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category' => 'required|integer|min:1|max:8',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $id,
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // 商品を更新
            $this->productService->updateProduct($id, $validatedData);

            // 画像アップロード処理
            if ($request->hasFile('cover_image')) {
                $this->productService->uploadCoverImage($id, $request->file('cover_image'));
            }

            if ($request->hasFile('images')) {
                $this->productService->uploadProductImages($id, $request->file('images'));
            }

            return redirect()->route('owner.products.show', $id)
                ->with('success', '商品が正常に更新されました。');

        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['error' => '商品の更新に失敗しました: ' . $e->getMessage()]);
        }
    }

    /**
     * 商品を削除
     */
    public function destroy(int $id)
    {
        // 認証されたオーナーのIDを取得
        $ownerId = Auth::guard('owner')->id();

        // 商品が存在し、オーナーが所有しているか確認
        $product = $this->productService->getProductByIdAndOwner($id, $ownerId);

        if (!$product) {
            abort(404);
        }

        try {
            // 商品を削除
            $this->productService->deleteProduct($id);

            return redirect()->route('owner.products.index')
                ->with('success', '商品が正常に削除されました。');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => '商品の削除に失敗しました: ' . $e->getMessage()]);
        }
    }
}
