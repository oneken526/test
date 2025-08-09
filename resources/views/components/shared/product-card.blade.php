@props(['product'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <!-- 商品画像 -->
    <div class="aspect-w-1 aspect-h-1 w-full">
        <img src="{{ $product->image_url }}"
             alt="{{ $product->name }}"
             class="w-full h-48 object-cover">
    </div>

    <!-- 商品情報 -->
    <div class="p-4">
        <!-- 商品名 -->
        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
            <a href="{{ route('user.products.show', $product->id) }}"
               class="hover:text-blue-600 transition-colors">
                {{ $product->name }}
            </a>
        </h3>

        <!-- 店舗名 -->
        @if($product->owner)
            <p class="text-sm text-gray-600 mb-2">
                {{ $product->owner->shop_name ?: $product->owner->name }}
            </p>
        @endif

        <!-- 価格 -->
        <div class="flex items-center justify-between mb-3">
            <span class="text-xl font-bold text-gray-900">
                {{ $product->formatted_price }}
            </span>

            <!-- 在庫状況 -->
            <span class="text-sm px-2 py-1 rounded-full
                       {{ $product->stock_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $product->stock_status }}
            </span>
        </div>

        <!-- 商品説明 -->
        @if($product->description)
            <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                {{ Str::limit($product->description, 100) }}
            </p>
        @endif

        <!-- アクションボタン -->
        <div class="flex space-x-2">
            <a href="{{ route('user.products.show', $product->id) }}"
               class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors text-sm">
                詳細を見る
            </a>

            @if($product->isInStock())
                <button class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors text-sm"
                        onclick="addToCart({{ $product->id }})">
                    カートに追加
                </button>
            @else
                <button class="bg-gray-400 text-white py-2 px-4 rounded-md cursor-not-allowed text-sm" disabled>
                    在庫切れ
                </button>
            @endif
        </div>

        <!-- 注目商品バッジ -->
        @if($product->is_featured)
            <div class="mt-3">
                <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                    ⭐ 注目商品
                </span>
            </div>
        @endif
    </div>
</div>

<script>
function addToCart(productId) {
    // カートに追加する処理（後で実装）
    console.log('Add to cart:', productId);
    alert('カートに追加しました！');
}
</script>
