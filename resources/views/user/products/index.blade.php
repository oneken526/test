@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#cbeef3] via-white to-[#f49cbb]">
    <!-- ヘッダー -->
    <x-shared.header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-24">
        <!-- ページタイトル -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">商品一覧</h1>
            <p class="mt-2 text-gray-600">お気に入りの商品を見つけてください</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- サイドバー（フィルター） -->
            <div class="lg:w-1/4">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6 sticky top-8">
                    <h2 class="text-xl font-bold text-[#880d1e] mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                        </svg>
                        フィルター
                    </h2>

                    <form method="GET" action="{{ route('user.products.index') }}" class="space-y-6">
                        <!-- 検索 -->
                        <div>
                            <label for="search" class="block text-sm font-semibold text-[#dd2d4a] mb-2">キーワード検索</label>
                            <div class="relative">
                                <input type="text"
                                       id="search"
                                       name="search"
                                       value="{{ $filters['search'] ?? '' }}"
                                       class="w-full px-4 py-3 border-2 border-[#f49cbb]/30 rounded-xl focus:outline-none focus:border-[#f26a8d] focus:ring-4 focus:ring-[#f26a8d]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                       placeholder="商品名、説明文で検索">
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-[#f26a8d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- カテゴリ -->
                        <div>
                            <label for="category" class="block text-sm font-semibold text-[#dd2d4a] mb-2">カテゴリ</label>
                            <select id="category"
                                    name="category"
                                    class="w-full px-4 py-3 border-2 border-[#f49cbb]/30 rounded-xl focus:outline-none focus:border-[#f26a8d] focus:ring-4 focus:ring-[#f26a8d]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm">
                                <option value="">すべてのカテゴリ</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" {{ ($filters['category'] ?? '') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 価格範囲 -->
                        <div>
                            <label class="block text-sm font-semibold text-[#dd2d4a] mb-2">価格範囲</label>
                            <div class="flex items-center space-x-2">
                                <input type="number"
                                       name="min_price"
                                       value="{{ $filters['min_price'] ?? '' }}"
                                       placeholder="最小価格"
                                       class="w-full px-3 py-3 border-2 border-[#f49cbb]/30 rounded-xl focus:outline-none focus:border-[#f26a8d] focus:ring-4 focus:ring-[#f26a8d]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm">
                                <span class="text-[#f26a8d] font-bold">〜</span>
                                <input type="number"
                                       name="max_price"
                                       value="{{ $filters['max_price'] ?? '' }}"
                                       placeholder="最大価格"
                                       class="w-full px-3 py-3 border-2 border-[#f49cbb]/30 rounded-xl focus:outline-none focus:border-[#f26a8d] focus:ring-4 focus:ring-[#f26a8d]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm">
                            </div>
                        </div>

                        <!-- 在庫状況 -->
                        <div>
                            <label class="flex items-center p-3 rounded-xl hover:bg-[#f49cbb]/10 transition-colors duration-200">
                                <input type="checkbox"
                                       name="in_stock"
                                       value="1"
                                       {{ ($filters['in_stock'] ?? false) ? 'checked' : '' }}
                                       class="rounded border-[#f26a8d] text-[#dd2d4a] focus:ring-[#f26a8d] focus:ring-offset-0">
                                <span class="ml-3 text-sm font-medium text-[#dd2d4a]">在庫ありのみ</span>
                            </label>
                        </div>

                        <!-- 注目商品 -->
                        <div>
                            <label class="flex items-center p-3 rounded-xl hover:bg-[#f49cbb]/10 transition-colors duration-200">
                                <input type="checkbox"
                                       name="featured"
                                       value="1"
                                       {{ ($filters['featured'] ?? false) ? 'checked' : '' }}
                                       class="rounded border-[#f26a8d] text-[#dd2d4a] focus:ring-[#f26a8d] focus:ring-offset-0">
                                <span class="ml-3 text-sm font-medium text-[#dd2d4a]">注目商品のみ</span>
                            </label>
                        </div>

                        <!-- フィルター適用ボタン -->
                        <div class="flex space-x-3 pt-4">
                            <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-[#dd2d4a] to-[#f26a8d] text-white py-3 px-6 rounded-xl hover:from-[#880d1e] hover:to-[#dd2d4a] transition-all duration-300 transform hover:scale-105 font-semibold shadow-lg">
                                フィルター適用
                            </button>
                            <a href="{{ route('user.products.index') }}"
                               class="bg-gradient-to-r from-gray-400 to-gray-500 text-white py-3 px-6 rounded-xl hover:from-gray-500 hover:to-gray-600 transition-all duration-300 transform hover:scale-105 font-semibold shadow-lg">
                                クリア
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- メインコンテンツ -->
            <div class="lg:w-3/4">
                <!-- 結果表示 -->
                <div class="mb-6 bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                    <p class="text-[#dd2d4a] font-semibold text-center">
                        <span class="text-2xl font-bold text-[#880d1e]">{{ $products->total() }}</span>件の商品が見つかりました
                    </p>
                </div>

                <!-- 商品グリッド -->
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <x-shared.product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- ページネーション -->
                    <div class="mt-8 flex justify-center">
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            {{ $products->appends($filters)->links() }}
                        </div>
                    </div>
                @else
                    <!-- 商品が見つからない場合 -->
                    <div class="text-center py-16 bg-white/60 backdrop-blur-sm rounded-2xl border border-white/20">
                        <div class="text-[#f26a8d] text-8xl mb-6">🔍</div>
                        <h3 class="text-2xl font-bold text-[#880d1e] mb-3">商品が見つかりません</h3>
                        <p class="text-[#dd2d4a] mb-8 text-lg">検索条件を変更してお試しください</p>
                        <a href="{{ route('user.products.index') }}"
                           class="inline-block bg-gradient-to-r from-[#dd2d4a] to-[#f26a8d] text-white py-3 px-8 rounded-xl hover:from-[#880d1e] hover:to-[#dd2d4a] transition-all duration-300 transform hover:scale-105 font-semibold shadow-lg">
                            すべての商品を見る
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- フッター -->
    <x-shared.footer />
</div>

<script>
// スクロール時のヘッダー効果
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('header');
    let lastScrollTop = 0;

    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // スクロール方向を判定
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // 下スクロール時はヘッダーを少し透明に
            header.style.transform = 'translateY(-100%)';
        } else {
            // 上スクロール時はヘッダーを表示
            header.style.transform = 'translateY(0)';
        }

        lastScrollTop = scrollTop;
    });
});
</script>
@endsection
