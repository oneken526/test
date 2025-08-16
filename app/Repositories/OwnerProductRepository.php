<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OwnerProductRepository
{
    /**
     * オーナーの商品一覧を取得（ページネーション付き）
     */
    public function getOwnerProducts(Owner $owner, int $perPage = 15): LengthAwarePaginator
    {
        return $owner->products()
            ->with(['coverImage', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * オーナーの商品一覧を取得（ページネーションなし）
     */
    public function getAllOwnerProducts(Owner $owner): Collection
    {
        return $owner->products()
            ->with(['coverImage', 'images'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * オーナーのアクティブ商品一覧を取得
     */
    public function getActiveOwnerProducts(Owner $owner): Collection
    {
        return $owner->activeProducts()
            ->with(['coverImage', 'images'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * オーナーの在庫不足商品一覧を取得
     */
    public function getLowStockProducts(Owner $owner, int $threshold = 10): Collection
    {
        return $owner->products()
            ->where('stock_quantity', '<=', $threshold)
            ->where('is_active', true)
            ->with(['coverImage', 'images'])
            ->orderBy('stock_quantity', 'asc')
            ->get();
    }

    /**
     * 商品をIDで取得
     */
    public function findById(Owner $owner, int $productId): ?Product
    {
        return $owner->products()
            ->with(['coverImage', 'images'])
            ->find($productId);
    }

    /**
     * 商品を作成
     */
    public function create(Owner $owner, array $data): Product
    {
        return $owner->products()->create($data);
    }

    /**
     * 商品を更新
     */
    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    /**
     * 商品を削除
     */
    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    /**
     * 商品のステータスを変更
     */
    public function updateStatus(Product $product, bool $isActive): bool
    {
        return $product->update(['is_active' => $isActive]);
    }

    /**
     * 商品の在庫数を更新
     */
    public function updateStock(Product $product, int $stockQuantity): bool
    {
        return $product->update(['stock_quantity' => $stockQuantity]);
    }

    /**
     * 商品の検索
     */
    public function search(Owner $owner, string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $owner->products()
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            })
            ->with(['coverImage', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * カテゴリ別商品一覧
     */
    public function getByCategory(Owner $owner, string $category, int $perPage = 15): LengthAwarePaginator
    {
        return $owner->products()
            ->where('category', $category)
            ->with(['coverImage', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * 商品統計情報を取得
     */
    public function getStats(Owner $owner): array
    {
        return [
            'total_products' => $owner->products()->count(),
            'active_products' => $owner->activeProducts()->count(),
            'inactive_products' => $owner->products()->where('is_active', false)->count(),
            'low_stock_products' => $owner->products()->where('stock_quantity', '<=', 10)->count(),
            'out_of_stock_products' => $owner->products()->where('stock_quantity', 0)->count(),
        ];
    }
}
