<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Services\OwnerProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private OwnerProductService $productService
    ) {}

    /**
     * 商品一覧を表示
     */
    public function index(Request $request): View
    {
        $owner = Auth::guard('owner')->user();
        $search = $request->get('search');
        $category = $request->get('category');
        $perPage = $request->get('per_page', 15);

        // 検索条件に応じて商品を取得
        if ($search) {
            $products = $this->productService->searchProducts($owner, $search, $perPage);
        } elseif ($category) {
            $products = $this->productService->getProductsByCategory($owner, $category, $perPage);
        } else {
            $products = $this->productService->getProducts($owner, $perPage);
        }

        // 統計情報を取得
        $stats = $this->productService->getProductStats($owner);

        // カテゴリ一覧を取得（将来的に実装）
        $categories = $this->getCategories();

        return view('owner.products.index', compact('products', 'stats', 'categories', 'search', 'category'));
    }

    /**
     * 商品作成フォームを表示
     */
    public function create(): View
    {
        $categories = $this->getCategories();
        return view('owner.products.create', compact('categories'));
    }

    /**
     * 商品を保存
     */
    public function store(Request $request)
    {
        $owner = Auth::guard('owner')->user();

        try {
            $data = $this->validateProductData($request);
            $product = $this->productService->createProduct($owner, $data);

            return redirect()
                ->route('owner.products.index')
                ->with('success', '商品が正常に作成されました。');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * 商品詳細を表示
     */
    public function show(int $id): View
    {
        $owner = Auth::guard('owner')->user();

        try {
            $product = $this->productService->getProduct($owner, $id);
            $categories = $this->getCategories();
            return view('owner.products.show', compact('product', 'categories'));
        } catch (\Exception $e) {
            abort(404, '商品が見つかりません。');
        }
    }

    /**
     * 商品編集フォームを表示
     */
    public function edit(int $id): View
    {
        $owner = Auth::guard('owner')->user();

        try {
            $product = $this->productService->getProduct($owner, $id);
            $categories = $this->getCategories();
            return view('owner.products.edit', compact('product', 'categories'));
        } catch (\Exception $e) {
            abort(404, '商品が見つかりません。');
        }
    }

    /**
     * 商品を更新
     */
    public function update(Request $request, int $id)
    {
        $owner = Auth::guard('owner')->user();

        try {
            $data = $this->validateProductData($request, $id);
            $product = $this->productService->updateProduct($owner, $id, $data);

            return redirect()
                ->route('owner.products.index')
                ->with('success', '商品が正常に更新されました。');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * 商品を削除
     */
    public function destroy(int $id)
    {
        $owner = Auth::guard('owner')->user();

        try {
            $this->productService->deleteProduct($owner, $id);

            return redirect()
                ->route('owner.products.index')
                ->with('success', '商品が正常に削除されました。');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * 商品のステータスを変更
     */
    public function toggleStatus(int $id)
    {
        $owner = Auth::guard('owner')->user();

        try {
            $this->productService->toggleProductStatus($owner, $id);

            return back()->with('success', '商品のステータスが変更されました。');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * 商品の在庫数を更新
     */
    public function updateStock(Request $request, int $id)
    {
        $owner = Auth::guard('owner')->user();

        $request->validate([
            'stock_quantity' => 'required|integer|min:0',
        ]);

        try {
            $this->productService->updateProductStock($owner, $id, $request->stock_quantity);

            return back()->with('success', '在庫数が更新されました。');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * 在庫不足商品一覧を表示
     */
    public function lowStock(): View
    {
        $owner = Auth::guard('owner')->user();
        $products = $this->productService->getLowStockProducts($owner);
        $stats = $this->productService->getProductStats($owner);

        return view('owner.products.low-stock', compact('products', 'stats'));
    }

    /**
     * 商品データのバリデーション
     */
    private function validateProductData(Request $request, ?int $productId = null): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|integer|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category' => 'required|integer|in:1,2,3,4,5,6,7,8',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'sku' => 'nullable|string|max:100',
        ];

        // 更新時はSKUのユニークチェックを除外
        if ($productId) {
            $rules['sku'] = 'nullable|string|max:100';
        } else {
            $rules['sku'] = 'nullable|string|max:100|unique:products,sku';
        }

        return $request->validate($rules);
    }

    /**
     * カテゴリ一覧を取得
     */
    private function getCategories(): array
    {
        // 実際のプロジェクトでは、カテゴリテーブルから取得
        return [
            '1' => '電子機器',
            '2' => '衣類',
            '3' => '書籍',
            '4' => '食品',
            '5' => '家具',
            '6' => 'スポーツ用品',
            '7' => '美容・健康',
            '8' => 'おもちゃ',
        ];
    }
}
