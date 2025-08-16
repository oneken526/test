<?php

namespace App\Services;

use App\Models\Owner;
use App\Models\Product;
use App\Repositories\OwnerProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OwnerProductService
{
    public function __construct(
        private OwnerProductRepository $repository
    ) {}

    /**
     * オーナーの商品一覧を取得
     */
    public function getProducts(Owner $owner, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getOwnerProducts($owner, $perPage);
    }

    /**
     * 商品を検索
     */
    public function searchProducts(Owner $owner, string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->search($owner, $search, $perPage);
    }

    /**
     * カテゴリ別商品一覧を取得
     */
    public function getProductsByCategory(Owner $owner, string $category, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getByCategory($owner, $category, $perPage);
    }

    /**
     * 商品を作成
     */
    public function createProduct(Owner $owner, array $data): Product
    {
        // バリデーション
        $this->validateProductData($data);

        // トランザクション開始
        return DB::transaction(function () use ($owner, $data) {
            // 商品を作成
            $product = $this->repository->create($owner, $data);

            // 画像の処理（将来的に実装）
            if (isset($data['images'])) {
                $this->processProductImages($product, $data['images']);
            }

            return $product;
        });
    }

    /**
     * 商品を更新
     */
    public function updateProduct(Owner $owner, int $productId, array $data): Product
    {
        // 商品の存在確認と権限チェック
        $product = $this->repository->findById($owner, $productId);
        if (!$product) {
            throw new \Exception('商品が見つかりません。');
        }

        // バリデーション
        $this->validateProductData($data, $productId);

        // トランザクション開始
        return DB::transaction(function () use ($product, $data) {
            // 商品を更新
            $this->repository->update($product, $data);

            // 画像の処理（将来的に実装）
            if (isset($data['images'])) {
                $this->processProductImages($product, $data['images']);
            }

            return $product->fresh();
        });
    }

    /**
     * 商品を削除
     */
    public function deleteProduct(Owner $owner, int $productId): bool
    {
        // 商品の存在確認と権限チェック
        $product = $this->repository->findById($owner, $productId);
        if (!$product) {
            throw new \Exception('商品が見つかりません。');
        }

        return DB::transaction(function () use ($product) {
            // 関連する画像を削除（将来的に実装）
            $this->deleteProductImages($product);

            // 商品を削除
            return $this->repository->delete($product);
        });
    }

    /**
     * 商品のステータスを変更
     */
    public function toggleProductStatus(Owner $owner, int $productId): bool
    {
        $product = $this->repository->findById($owner, $productId);
        if (!$product) {
            throw new \Exception('商品が見つかりません。');
        }

        return $this->repository->updateStatus($product, !$product->is_active);
    }

    /**
     * 商品の在庫数を更新
     */
    public function updateProductStock(Owner $owner, int $productId, int $stockQuantity): bool
    {
        $product = $this->repository->findById($owner, $productId);
        if (!$product) {
            throw new \Exception('商品が見つかりません。');
        }

        if ($stockQuantity < 0) {
            throw new \Exception('在庫数は0以上である必要があります。');
        }

        return $this->repository->updateStock($product, $stockQuantity);
    }

    /**
     * 在庫不足商品一覧を取得
     */
    public function getLowStockProducts(Owner $owner, int $threshold = 10): Collection
    {
        return $this->repository->getLowStockProducts($owner, $threshold);
    }

    /**
     * 商品をIDで取得
     */
    public function getProduct(Owner $owner, int $productId): Product
    {
        $product = $this->repository->findById($owner, $productId);
        if (!$product) {
            throw new \Exception('商品が見つかりません。');
        }
        return $product;
    }

    /**
     * 商品統計情報を取得
     */
    public function getProductStats(Owner $owner): array
    {
        return $this->repository->getStats($owner);
    }

    /**
     * 商品データのバリデーション
     */
    private function validateProductData(array $data, ?int $productId = null): void
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|integer|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
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

        // 簡易バリデーション（実際のプロジェクトではFormRequestを使用）
        foreach ($rules as $field => $rule) {
            if (str_contains($rule, 'required') && !isset($data[$field])) {
                throw new \Exception("{$field}は必須です。");
            }
        }
    }

    /**
     * 商品画像の処理（将来的に実装）
     */
    private function processProductImages(Product $product, array $images): void
    {
        // 画像アップロード処理をここに実装
        // 現在はプレースホルダー
    }

    /**
     * 商品画像の削除（将来的に実装）
     */
    private function deleteProductImages(Product $product): void
    {
        // 画像削除処理をここに実装
        // 現在はプレースホルダー
    }
}
