@extends('layouts.owner')

@section('title', '商品一覧')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- ヘッダー -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">商品一覧</h1>
                </div>
                <a href="{{ route('owner.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    新規商品登録
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- フィルターセクション -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('owner.products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">検索</label>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="商品名で検索">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">カテゴリ</label>
                    <select name="category" id="category"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">すべて</option>
                        @foreach($categories as $key => $category)
                            <option value="{{ $key }}" {{ ($filters['category'] ?? '') == $key ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">ステータス</label>
                    <select name="status" id="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all" {{ ($filters['status'] ?? 'all') == 'all' ? 'selected' : '' }}>すべて</option>
                        <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>公開中</option>
                        <option value="inactive" {{ ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' }}>非公開</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        検索
                    </button>
                </div>
            </form>
        </div>

        <!-- 商品一覧 -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="relative">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-2 right-2">
                                @if($product->is_active)
                                    <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">公開中</span>
                                @else
                                    <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded">非公開</span>
                                @endif
                            </div>
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 100) }}</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xl font-bold text-blue-600">{{ $product->formatted_price }}</span>
                                <span class="text-sm text-gray-500">在庫: {{ $product->stock_quantity }}</span>
                            </div>

                            <div class="flex space-x-2">
                                <a href="{{ route('owner.products.show', $product->id) }}"
                                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded text-sm">
                                    詳細
                                </a>
                                <a href="{{ route('owner.products.edit', $product->id) }}"
                                   class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white text-center py-2 px-3 rounded text-sm">
                                    編集
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ページネーション -->
            <div class="mt-8">
                {{ $products->appends($filters)->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="text-gray-500 mb-4">
                    <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">商品が見つかりません</h3>
                <p class="text-gray-500 mb-4">条件に一致する商品がありません。検索条件を変更するか、新しい商品を登録してください。</p>
                <a href="{{ route('owner.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    新規商品登録
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
