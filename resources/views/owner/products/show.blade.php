@extends('layouts.owner')

@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">商品詳細</h1>
        <div class="flex space-x-2">
            <a href="{{ route('owner.products.edit', $product->id) }}" 
               class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                編集
            </a>
            <a href="{{ route('owner.products.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                一覧に戻る
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
            <!-- 商品画像 -->
            <div>
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                     class="w-full h-96 object-cover rounded-lg">
                
                @if($product->images && $product->images->count() > 0)
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">その他の画像</h3>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-20 object-cover rounded">
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- 商品情報 -->
            <div>
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h2>
                    <div class="flex items-center space-x-4 mb-4">
                        <span class="text-3xl font-bold text-blue-600">{{ $product->formatted_price }}</span>
                        @if($product->is_active)
                            <span class="bg-green-500 text-white text-sm px-3 py-1 rounded">公開中</span>
                        @else
                            <span class="bg-gray-500 text-white text-sm px-3 py-1 rounded">非公開</span>
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">商品説明</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">カテゴリ</h3>
                            <p class="text-gray-700">{{ $product->category_name }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">在庫数</h3>
                            <p class="text-gray-700">{{ $product->stock_quantity }}個</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">登録日</h3>
                            <p class="text-gray-700">{{ $product->created_at->format('Y年m月d日') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">更新日</h3>
                            <p class="text-gray-700">{{ $product->updated_at->format('Y年m月d日') }}</p>
                        </div>
                    </div>

                    @if($product->is_featured)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">注目商品</h3>
                            <p class="text-green-600 font-semibold">✓ 注目商品として設定されています</p>
                        </div>
                    @endif
                </div>

                <!-- アクションボタン -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex space-x-4">
                        <a href="{{ route('owner.products.edit', $product->id) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded font-semibold">
                            商品を編集
                        </a>
                        <form method="POST" action="{{ route('owner.products.destroy', $product->id) }}" 
                              class="flex-1" onsubmit="return confirm('この商品を削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded font-semibold">
                                商品を削除
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
