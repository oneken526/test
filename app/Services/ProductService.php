<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Helpers\{ImageHelper, PriceHelper};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * 商品一覧を取得
     */
    public function getProductList(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        try {
            $products = $this->productRepository->getProducts($filters, $perPage);

            // 価格と画像のフォーマット処理
            $products->getCollection()->transform(function ($product) {
                $product->formatted_price = PriceHelper::format($product->price);
                // dump($product);
                $product->image_url = ImageHelper::getProductThumbnailUrl($product);
                return $product;
            });
            // dd("aaa");

            return $products;
        } catch (\Exception $e) {
            Log::error('Product list retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * オーナー別商品一覧を取得
     */
    public function getProductListByOwner(int $ownerId, array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        try {
            $products = $this->productRepository->getProductsByOwner($ownerId, $filters, $perPage);

            // 価格と画像のフォーマット処理
            $products->getCollection()->transform(function ($product) {
                $product->formatted_price = PriceHelper::format($product->price);
                $product->image_url = ImageHelper::getProductThumbnailUrl($product);
                return $product;
            });

            return $products;
        } catch (\Exception $e) {
            Log::error('Owner product list retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 注目商品を取得
     */
    public function getFeaturedProducts(int $limit = 8): Collection
    {
        try {
            $products = $this->productRepository->getFeaturedProducts($limit);

            // 価格と画像のフォーマット処理
            $products->transform(function ($product) {
                $product->formatted_price = PriceHelper::format($product->price);
                $product->image_url = ImageHelper::getProductThumbnailUrl($product);
                return $product;
            });

            return $products;
        } catch (\Exception $e) {
            Log::error('Featured products retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * カテゴリ別商品を取得
     */
    public function getProductsByCategory(int $category, int $perPage = 12): LengthAwarePaginator
    {
        try {
            $products = $this->productRepository->getProductsByCategory($category, $perPage);

            // 価格と画像のフォーマット処理
            $products->getCollection()->transform(function ($product) {
                $product->formatted_price = PriceHelper::format($product->price);
                $product->image_url = ImageHelper::getProductThumbnailUrl($product);
                return $product;
            });

            return $products;
        } catch (\Exception $e) {
            Log::error('Category products retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 商品詳細を取得
     */
    public function getProductDetail(int $id)
    {
        try {
            $product = $this->productRepository->findById($id);

            if (!$product) {
                return null;
            }

            // 価格と画像のフォーマット処理
            $product->display_price = PriceHelper::format($product->price);
            $product->main_image_url = ImageHelper::getProductMainImageUrl($product);
            $product->thumbnail_url = ImageHelper::getProductThumbnailUrl($product);

            return $product;
        } catch (\Exception $e) {
            Log::error('Product detail retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 商品を作成
     */
    public function createProduct(array $data)
    {
        try {
            // 価格データのサニタイズ
            if (isset($data['price'])) {
                $data['price'] = PriceHelper::sanitize($data['price']);
            }

            $product = $this->productRepository->create($data);

            Log::info('Product created successfully: ' . $product->id);

            return $product;
        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 商品を更新
     */
    public function updateProduct(int $id, array $data): bool
    {
        try {
            // 価格データのサニタイズ
            if (isset($data['price'])) {
                $data['price'] = PriceHelper::sanitize($data['price']);
            }

            $result = $this->productRepository->update($id, $data);

            if ($result) {
                Log::info('Product updated successfully: ' . $id);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 商品を削除
     */
    public function deleteProduct(int $id): bool
    {
        try {
            $result = $this->productRepository->delete($id);

            if ($result) {
                Log::info('Product deleted successfully: ' . $id);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 在庫数を更新
     */
    public function updateStock(int $id, int $quantity): bool
    {
        try {
            if ($quantity < 0) {
                throw new \InvalidArgumentException('Stock quantity cannot be negative');
            }

            $result = $this->productRepository->updateStock($id, $quantity);

            if ($result) {
                Log::info('Product stock updated: ' . $id . ' to ' . $quantity);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Stock update failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 商品統計を取得
     */
    public function getProductStats(int $ownerId = null): array
    {
        try {
            return $this->productRepository->getProductStats($ownerId);
        } catch (\Exception $e) {
            Log::error('Product stats retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * 関連商品を取得
     */
    public function getRelatedProducts(int $productId, int $category, int $limit = 4): Collection
    {
        try {
            $products = $this->productRepository->getRelatedProducts($productId, $category, $limit);

            // 価格と画像のフォーマット処理
            $products->transform(function ($product) {
                $product->formatted_price = PriceHelper::format($product->price);
                $product->image_url = ImageHelper::getProductThumbnailUrl($product);
                return $product;
            });

            return $products;
        } catch (\Exception $e) {
            Log::error('Related products retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * カテゴリ一覧を取得
     */
    public function getCategories(): array
    {
        try {
            return $this->productRepository->getCategories();
        } catch (\Exception $e) {
            Log::error('Categories retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
