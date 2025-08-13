@props(['product'])

<div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden hover:shadow-2xl hover:scale-105 transition-all duration-500 transform">
    <!-- 商品画像 -->
    <div class="relative overflow-hidden">
        <img src="{{ $product->image_url }}"
             alt="{{ $product->name }}"
             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">

        <!-- 注目商品バッジ -->
        @if($product->is_featured)
            <div class="absolute top-3 left-3">
                <span class="inline-block bg-gradient-to-r from-[#f26a8d] to-[#f49cbb] text-white text-xs px-3 py-1 rounded-full font-bold shadow-lg">
                    ⭐ 注目商品
                </span>
            </div>
        @endif

        <!-- 在庫状況バッジ -->
        <div class="absolute top-3 right-3">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold shadow-lg
                       {{ $product->stock_quantity <= 0 ? 'bg-gradient-to-r from-red-400 to-red-500 text-white' :
                          ($product->stock_quantity <= 10 ? 'bg-gradient-to-r from-yellow-400 to-yellow-500 text-white' :
                           'bg-gradient-to-r from-green-400 to-green-500 text-white') }}">
                {{ $product->stock_status }}
            </span>
        </div>

        <!-- オーバーレイ効果 -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    </div>

    <!-- 商品情報 -->
    <div class="p-6">
        <!-- 商品名 -->
        <h3 class="text-xl font-bold text-[#880d1e] mb-3 line-clamp-2 group-hover:text-[#dd2d4a] transition-colors duration-300">
            <a href="{{ route('user.products.show', $product->id) }}" class="hover:no-underline">
                {{ $product->name }}
            </a>
        </h3>

        <!-- カテゴリ -->
        <p class="text-xs text-[#f26a8d] mb-2 font-medium flex items-center">
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
            </svg>
            {{ $product->category_name }}
        </p>

        <!-- 店舗名 -->
        @if($product->owner)
            <p class="text-sm text-[#f26a8d] mb-3 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd"></path>
                </svg>
                {{ $product->owner->shop_name ?: $product->owner->name }}
            </p>
        @endif

        <!-- 価格 -->
        <div class="mb-4">
            <span class="text-2xl font-bold bg-gradient-to-r from-[#880d1e] to-[#dd2d4a] bg-clip-text text-transparent">
                {{ $product->formatted_price }}
            </span>
        </div>

        <!-- 商品説明 -->
        @if($product->description)
            <p class="text-sm text-gray-600 mb-6 line-clamp-3 leading-relaxed">
                {{ Str::limit($product->description, 100) }}
            </p>
        @endif

        <!-- アクションボタン -->
        <div class="flex space-x-3">
            <a href="{{ route('user.products.show', $product->id) }}"
               class="flex-1 bg-gradient-to-r from-[#dd2d4a] to-[#f26a8d] text-white text-center py-3 px-4 rounded-xl hover:from-[#880d1e] hover:to-[#dd2d4a] transition-all duration-300 transform hover:scale-105 font-semibold shadow-lg">
                詳細を見る
            </a>

            @if($product->isInStock())
                <button class="bg-gradient-to-r from-[#f26a8d] to-[#f49cbb] text-white py-3 px-4 rounded-xl hover:from-[#dd2d4a] hover:to-[#f26a8d] transition-all duration-300 transform hover:scale-105 font-semibold shadow-lg"
                        onclick="addToCart({{ $product->id }})">
                    カートに追加
                </button>
            @else
                <button class="bg-gradient-to-r from-gray-400 to-gray-500 text-white py-3 px-4 rounded-xl cursor-not-allowed font-semibold shadow-lg" disabled>
                    在庫切れ
                </button>
            @endif
        </div>
    </div>
</div>

<script>
function addToCart(productId) {
    // カートに追加する処理（後で実装）
    console.log('Add to cart:', productId);

    // おしゃれな通知を表示
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-gradient-to-r from-[#f26a8d] to-[#f49cbb] text-white px-6 py-4 rounded-xl shadow-2xl z-50 transform translate-x-full transition-transform duration-500';
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="font-semibold">カートに追加しました！</span>
        </div>
    `;

    document.body.appendChild(notification);

    // アニメーション
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 500);
    }, 3000);
}
</script>
