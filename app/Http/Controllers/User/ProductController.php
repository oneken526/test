<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Helpers\PriceHelper;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * 商品一覧画面
     */
    public function index(Request $request)
    {
        // フィルターパラメータを取得
        $filters = $request->only([
            'search',
            'category',
            'min_price',
            'max_price',
            'in_stock',
            'featured'
        ]);

        // 価格範囲のバリデーション
        if (isset($filters['min_price']) && isset($filters['max_price'])) {
            if (!PriceHelper::validatePriceRange($filters['min_price'], $filters['max_price'])) {
                return back()->withErrors(['price_range' => '価格範囲が正しくありません。']);
            }
        }

        // 商品一覧を取得
        $products = $this->productService->getProductList($filters, 12);

        // カテゴリ一覧を取得
        $categories = $this->productService->getCategories();

        return view('user.products.index', compact('products', 'categories', 'filters'));
    }

    /**
     * 商品詳細画面
     */
    public function show(int $id)
    {
        $product = $this->productService->getProductDetail($id);

        if (!$product) {
            abort(404, '商品が見つかりません。');
        }

        return view('user.products.show', compact('product'));
    }

    /**
     * カテゴリ別商品一覧
     */
    public function category(string $category, Request $request)
    {
        $products = $this->productService->getProductsByCategory($category, 12);
        $categories = $this->productService->getCategories();

        return view('user.products.category', compact('products', 'categories', 'category'));
    }

    /**
     * 注目商品一覧
     */
    public function featured()
    {
        $products = $this->productService->getFeaturedProducts(12);
        $categories = $this->productService->getCategories();

        return view('user.products.featured', compact('products', 'categories'));
    }
}
