@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#cbeef3] via-white to-[#f49cbb]">
    <!-- ヘッダー -->
    <x-shared.header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-24">
        <!-- パンくずリスト -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('user.products.index') }}" class="text-[#f26a8d] hover:text-[#dd2d4a] transition-colors duration-300">
                        商品一覧
                    </a>
                </li>
                <li class="text-[#dd2d4a]">/</li>
                <li class="text-[#880d1e] font-medium">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- 商品画像 -->
            <div class="space-y-6">
                <!-- メイン画像 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                    <img src="{{ $product->main_image_url }}"
                         alt="{{ $product->name }}"
                         class="w-full h-96 object-cover">
                </div>

                <!-- サブ画像（複数ある場合） -->
                @if($product->images && $product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images->take(4) as $image)
                            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden cursor-pointer hover:scale-105 transition-transform duration-300">
                                <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-24 object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- 商品情報 -->
            <div class="space-y-8">
                <!-- 商品名とカテゴリ -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="inline-block px-3 py-1 bg-gradient-to-r from-[#f26a8d] to-[#f49cbb] text-white text-sm font-bold rounded-full">
                            {{ $product->category_name }}
                        </span>
                        @if($product->is_featured)
                            <span class="inline-block px-3 py-1 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white text-sm font-bold rounded-full">
                                ⭐ 注目商品
                            </span>
                        @endif
                    </div>
                    <h1 class="text-3xl font-bold text-[#880d1e] mb-4">{{ $product->name }}</h1>
                </div>

                <!-- 価格 -->
                <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="flex items-baseline space-x-2">
                        <span class="text-4xl font-bold bg-gradient-to-r from-[#880d1e] to-[#dd2d4a] bg-clip-text text-transparent">
                            {{ $product->display_price }}
                        </span>
                        <span class="text-lg text-[#f26a8d]">（税込）</span>
                    </div>
                </div>

                <!-- 在庫状況 -->
                <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-semibold text-[#880d1e]">在庫状況</span>
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-lg
                                   {{ $product->stock_quantity <= 0 ? 'bg-gradient-to-r from-red-400 to-red-500 text-white' :
                                      ($product->stock_quantity <= 10 ? 'bg-gradient-to-r from-yellow-400 to-yellow-500 text-white' :
                                       'bg-gradient-to-r from-green-400 to-green-500 text-white') }}">
                            {{ $product->stock_status }}
                            @if($product->stock_quantity > 0)
                                （{{ $product->stock_quantity }}個）
                            @endif
                        </span>
                    </div>
                </div>

                <!-- 商品説明 -->
                @if($product->description)
                    <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                        <h3 class="text-xl font-bold text-[#880d1e] mb-4">商品説明</h3>
                        <p class="text-[#dd2d4a] leading-relaxed whitespace-pre-wrap">{{ $product->description }}</p>
                    </div>
                @endif

                <!-- 商品詳細情報 -->
                <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <h3 class="text-xl font-bold text-[#880d1e] mb-4">商品詳細</h3>
                    <div class="space-y-3">
                        @if($product->sku)
                            <div class="flex justify-between">
                                <span class="text-[#f26a8d] font-medium">商品番号</span>
                                <span class="text-[#dd2d4a]">{{ $product->sku }}</span>
                            </div>
                        @endif
                        @if($product->weight)
                            <div class="flex justify-between">
                                <span class="text-[#f26a8d] font-medium">重量</span>
                                <span class="text-[#dd2d4a]">{{ $product->weight }}kg</span>
                            </div>
                        @endif
                        @if($product->dimensions)
                            <div class="flex justify-between">
                                <span class="text-[#f26a8d] font-medium">サイズ</span>
                                <span class="text-[#dd2d4a]">{{ $product->dimensions }}</span>
                            </div>
                        @endif
                        @if($product->owner)
                            <div class="flex justify-between">
                                <span class="text-[#f26a8d] font-medium">販売店</span>
                                <span class="text-[#dd2d4a]">{{ $product->owner->shop_name ?: $product->owner->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- アクションボタン -->
                <div class="space-y-4">
                    @if($product->isInStock())
                        <button class="w-full bg-gradient-to-r from-[#dd2d4a] to-[#f26a8d] text-white py-4 px-6 rounded-2xl hover:from-[#880d1e] hover:to-[#dd2d4a] transition-all duration-300 transform hover:scale-105 font-bold text-lg shadow-xl"
                                onclick="addToCart({{ $product->id }})">
                            🛒 カートに追加
                        </button>
                    @else
                        <button class="w-full bg-gradient-to-r from-gray-400 to-gray-500 text-white py-4 px-6 rounded-2xl cursor-not-allowed font-bold text-lg shadow-xl" disabled>
                            📦 在庫切れ
                        </button>
                    @endif

                    <div class="flex space-x-4">
                        <button class="flex-1 bg-gradient-to-r from-[#f26a8d] to-[#f49cbb] text-white py-3 px-6 rounded-xl hover:from-[#dd2d4a] hover:to-[#f26a8d] transition-all duration-300 transform hover:scale-105 font-semibold shadow-lg">
                            ❤️ お気に入り
                        </button>
                        <button class="flex-1 bg-gradient-to-r from-[#cbeef3] to-[#8dd5e6] text-[#880d1e] py-3 px-6 rounded-xl hover:from-[#8dd5e6] hover:to-[#cbeef3] transition-all duration-300 transform hover:scale-105 font-semibold shadow-lg">
                            📤 シェア
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 関連商品 -->
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-[#880d1e] mb-8 text-center">関連商品</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts ?? [] as $relatedProduct)
                    <x-shared.product-card :product="$relatedProduct" />
                @endforeach
            </div>
        </div>
    </div>

    <!-- フッター -->
    <x-shared.footer />
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
        notification.style.transform = 'translateX(0)';
    }, 100);

    setTimeout(() => {
        notification.style.transform = 'translateX(full)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 500);
    }, 3000);
}
</script>
@endsection
