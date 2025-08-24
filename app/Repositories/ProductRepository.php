<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    /**
     * 商品一覧を取得（ページネーション付き）
     */
    public function getProducts(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::with(['owner', 'coverImage', 'images'])
            ->where('is_active', true);

        // 検索フィルター適用
        $this->applyFilters($query, $filters);

        return $query->orderBy('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * オーナー別商品一覧を取得
     */
    public function getProductsByOwner(int $ownerId, array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::with(['coverImage', 'images'])
            ->where('owner_id', $ownerId);

        // 検索フィルター適用
        $this->applyFilters($query, $filters);

        return $query->orderBy('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * 注目商品を取得
     */
    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return Product::with(['owner', 'coverImage'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * カテゴリ別商品を取得
     */
    public function getProductsByCategory(int $category, int $perPage = 12): LengthAwarePaginator
    {
        return Product::with(['owner', 'coverImage'])
            ->where('is_active', true)
            ->where('category', $category)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * 商品詳細を取得
     */
    public function findById(int $id): ?Product
    {
        return Product::with(['owner', 'images', 'coverImage'])
            ->where('is_active', true)
            ->find($id);
    }

    /**
     * 商品を作成
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * 商品を更新
     */
    public function update(int $id, array $data): bool
    {
        $product = Product::findOrFail($id);
        return $product->update($data);
    }

    /**
     * 商品を削除
     */
    public function delete(int $id): bool
    {
        $product = Product::findOrFail($id);
        return $product->delete();
    }

    /**
     * 在庫数を更新
     */
    public function updateStock(int $id, int $quantity): bool
    {
        $product = Product::findOrFail($id);
        return $product->update(['stock_quantity' => $quantity]);
    }

    /**
     * 検索フィルターを適用
     */
    private function applyFilters($query, array $filters): void
    {
        // 検索キーワード
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // カテゴリフィルター
        if (!empty($filters['category'])) {
            $query->where('category', (int)$filters['category']);
        }

        // 価格範囲フィルター
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // 在庫状況フィルター
        if (isset($filters['in_stock']) && $filters['in_stock']) {
            $query->where('stock_quantity', '>', 0);
        }

        // 注目商品フィルター
        if (isset($filters['featured']) && $filters['featured']) {
            $query->where('is_featured', true);
        }

        // オーナーIDフィルター
        if (!empty($filters['owner_id'])) {
            $query->where('owner_id', $filters['owner_id']);
        }

        // ステータスフィルター（オーナー用）
        if (!empty($filters['status'])) {
            switch ($filters['status']) {
                case 'active':
                    $query->where('is_active', true);
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'all':
                    // 全件表示（フィルターなし）
                    break;
            }
        }
    }

    /**
     * 商品統計を取得
     */
    public function getProductStats(int $ownerId = null): array
    {
        $query = Product::query();

        if ($ownerId) {
            $query->where('owner_id', $ownerId);
        }

        return [
            'total' => $query->count(),
            'active' => $query->where('is_active', true)->count(),
            'featured' => $query->where('is_featured', true)->count(),
            'out_of_stock' => $query->where('stock_quantity', 0)->count(),
        ];
    }

    /**
     * 関連商品を取得
     */
    public function getRelatedProducts(int $productId, int $category, int $limit = 4): Collection
    {
        return Product::with(['owner', 'coverImage'])
            ->where('is_active', true)
            ->where('id', '!=', $productId)
            ->where('category', $category)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * カテゴリ一覧を取得
     */
    public function getCategories(): array
    {
        $categories = [
            1 => 'おもちゃ',
            2 => 'スポーツ',
            3 => '家具',
            4 => '書籍',
            5 => '美容',
            6 => '衣類',
            7 => '電子機器',
            8 => '食品'
        ];

        return $categories;
    }

    /**
     * オーナー別商品詳細を取得
     */
    public function findByIdAndOwner(int $id, int $ownerId): ?Product
    {
        return Product::with(['owner', 'images', 'coverImage'])
            ->where('id', $id)
            ->where('owner_id', $ownerId)
            ->first();
    }

    /**
     * 商品画像を作成
     */
    public function createImage(array $data)
    {
        return \App\Models\ProductImage::create($data);
    }

    /**
     * 商品画像を削除
     */
    public function deleteImage(int $imageId): bool
    {
        $image = \App\Models\ProductImage::find($imageId);
        if ($image) {
            // ファイルを削除
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($image->path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->path);
            }
            return $image->delete();
        }
        return false;
    }
}
