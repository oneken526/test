@extends('layouts.app')

@section('title', '商品一覧')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- ヘッダー -->
    <x-shared.header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- ページタイトル -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">商品一覧</h1>
            <p class="mt-2 text-gray-600">お気に入りの商品を見つけてください</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- サイドバー（フィルター） -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">フィルター</h2>

                    <form method="GET" action="{{ route('user.products.index') }}" class="space-y-6">
                        <!-- 検索 -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">キーワード検索</label>
                            <input type="text"
                                   id="search"
                                   name="search"
                                   value="{{ $filters['search'] ?? '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="商品名、説明文で検索">
                        </div>

                        <!-- カテゴリ -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">カテゴリ</label>
                            <select id="category"
                                    name="category"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">すべてのカテゴリ</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ ($filters['category'] ?? '') === $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 価格範囲 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">価格範囲</label>
                            <div class="flex space-x-2">
                                <input type="number"
                                       name="min_price"
                                       value="{{ $filters['min_price'] ?? '' }}"
                                       placeholder="最小価格"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <span class="text-gray-500 self-center">〜</span>
                                <input type="number"
                                       name="max_price"
                                       value="{{ $filters['max_price'] ?? '' }}"
                                       placeholder="最大価格"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- 在庫状況 -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox"
                                       name="in_stock"
                                       value="1"
                                       {{ ($filters['in_stock'] ?? false) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">在庫ありのみ</span>
                            </label>
                        </div>

                        <!-- 注目商品 -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox"
                                       name="featured"
                                       value="1"
                                       {{ ($filters['featured'] ?? false) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">注目商品のみ</span>
                            </label>
                        </div>

                        <!-- フィルター適用ボタン -->
                        <div class="flex space-x-2">
                            <button type="submit"
                                    class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                                フィルター適用
                            </button>
                            <a href="{{ route('user.products.index') }}"
                               class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 transition-colors">
                                クリア
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- メインコンテンツ -->
            <div class="lg:w-3/4">
                <!-- 結果表示 -->
                <div class="mb-6">
                    <p class="text-gray-600">
                        {{ $products->total() }}件の商品が見つかりました
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
                    <div class="mt-8">
                        {{ $products->appends($filters)->links() }}
                    </div>
                @else
                    <!-- 商品が見つからない場合 -->
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-6xl mb-4">🔍</div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">商品が見つかりません</h3>
                        <p class="text-gray-600 mb-6">検索条件を変更してお試しください</p>
                        <a href="{{ route('user.products.index') }}"
                           class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
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
@endsection
