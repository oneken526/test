@extends('layouts.owner')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- ヘッダー -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">商品編集</h1>
                        <p class="mt-1 text-sm text-gray-500">{{ $product->name }}を編集します</p>
                    </div>
                    <div>
                        <a href="{{ route('owner.products.show', $product->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            商品詳細に戻る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">エラーが発生しました</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('owner.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- 基本情報 -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">基本情報</h3>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- 商品名 -->
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">商品名 <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- 商品説明 -->
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">商品説明 <span class="text-red-500">*</span></label>
                            <textarea name="description" id="description" rows="4" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <!-- 価格 -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">価格 <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">¥</span>
                                </div>
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" min="0" step="1" required
                                    class="pl-7 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- 在庫数 -->
                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700">在庫数 <span class="text-red-500">*</span></label>
                            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- カテゴリ -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">カテゴリ <span class="text-red-500">*</span></label>
                            <select name="category" id="category" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">カテゴリを選択</option>
                                @foreach($categories as $key => $category)
                                    <option value="{{ $key }}" {{ old('category', $product->category) == $key ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- SKU -->
                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 詳細情報 -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">詳細情報</h3>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- 重量 -->
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700">重量 (kg)</label>
                            <input type="number" name="weight" id="weight" value="{{ old('weight', $product->weight) }}" min="0" step="0.01"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <!-- サイズ -->
                        <div>
                            <label for="dimensions" class="block text-sm font-medium text-gray-700">サイズ</label>
                            <input type="text" name="dimensions" id="dimensions" value="{{ old('dimensions', $product->dimensions) }}" placeholder="例: 30cm x 20cm x 10cm"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 設定 -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">設定</h3>

                    <div class="space-y-4">
                        <!-- 公開設定 -->
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                商品を公開する
                            </label>
                        </div>

                        <!-- 注目商品 -->
                        <div class="flex items-center">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                注目商品として設定する
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 現在の画像 -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">現在の画像</h3>

                    <div class="space-y-6">
                        <!-- カバー画像 -->
                        @if($product->coverImage)
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-3">カバー画像</h4>
                                <div class="flex items-center space-x-4">
                                    <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($product->coverImage) }}"
                                         alt="{{ $product->name }}"
                                         class="h-32 w-32 object-cover rounded-lg">
                                    <div>
                                        <p class="text-sm text-gray-600">{{ $product->coverImage->file_name }}</p>
                                        <p class="text-xs text-gray-500">{{ number_format($product->coverImage->file_size / 1024, 2) }} KB</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- 商品画像 -->
                        @if($product->images && $product->images->count() > 0)
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-3">商品画像</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($product->images->where('is_cover', false) as $image)
                                        <div class="relative">
                                            <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="h-24 w-24 object-cover rounded-lg">
                                            <div class="absolute top-1 right-1">
                                                <button type="button" class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600"
                                                        onclick="deleteImage({{ $image->id }})">
                                                    ×
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 画像アップロード -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">新しい画像を追加</h3>

                    <div class="space-y-6">
                        <!-- カバー画像 -->
                        <div>
                            <label for="cover_image" class="block text-sm font-medium text-gray-700">新しいカバー画像</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="cover_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>画像をアップロード</span>
                                            <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">またはドラッグ&ドロップ</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF 最大 2MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- 商品画像 -->
                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700">新しい商品画像（複数選択可）</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>画像をアップロード</span>
                                            <input id="images" name="images[]" type="file" class="sr-only" accept="image/*" multiple>
                                        </label>
                                        <p class="pl-1">またはドラッグ&ドロップ</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF 最大 2MB（複数選択可）</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 送信ボタン -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('owner.products.show', $product->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    キャンセル
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    商品を更新
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// ファイルアップロード時のプレビュー表示
document.addEventListener('DOMContentLoaded', function() {
    // カバー画像の処理関数
    function handleCoverImage(file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024).toFixed(2) + ' KB';

        const fileInfo = document.createElement('div');
        fileInfo.className = 'mt-2 p-2 bg-gray-50 rounded border file-info';
        fileInfo.innerHTML = `
            <div class="flex items-center space-x-2">
                <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-medium text-gray-700">${fileName}</span>
                <span class="text-xs text-gray-500">(${fileSize})</span>
            </div>
        `;

        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('img');
            preview.src = e.target.result;
            preview.className = 'mt-2 h-32 w-32 object-cover rounded-lg';

            const container = coverImageInput.closest('.border-dashed').querySelector('.space-y-1');

            if (container) {
                // 既存のプレビューとファイル情報を削除
                const existingPreview = container.querySelector('img');
                const existingFileInfo = container.querySelector('.file-info');
                if (existingPreview) {
                    existingPreview.remove();
                }
                if (existingFileInfo) {
                    existingFileInfo.remove();
                }

                container.appendChild(fileInfo);
                container.appendChild(preview);
            }
        };
        reader.readAsDataURL(file);
    }

    // 商品画像の処理関数
    function handleProductImages(files) {
        const container = imagesInput.closest('.border-dashed').querySelector('.space-y-1');

        if (container) {
            // 既存のプレビューとファイル情報を削除
            const existingPreviews = container.querySelectorAll('.image-preview');
            const existingFileInfos = container.querySelectorAll('.file-info');
            existingPreviews.forEach(preview => preview.remove());
            existingFileInfos.forEach(info => info.remove());

            // ファイル情報とプレビューを追加
            files.forEach((file, index) => {
                const fileName = file.name;
                const fileSize = (file.size / 1024).toFixed(2) + ' KB';

                const fileInfo = document.createElement('div');
                fileInfo.className = 'mt-2 p-2 bg-gray-50 rounded border file-info';
                fileInfo.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-700">${fileName}</span>
                            <span class="text-xs text-gray-500">(${fileSize})</span>
                        </div>
                        <span class="text-xs text-gray-400">画像 ${index + 1}</span>
                    </div>
                `;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('img');
                    preview.src = e.target.result;
                    preview.className = 'mt-2 h-24 w-24 object-cover rounded-lg image-preview';

                    container.appendChild(fileInfo);
                    container.appendChild(preview);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    // カバー画像のプレビュー
    const coverImageInput = document.getElementById('cover_image');
    if (coverImageInput) {
        // ファイル選択イベント
        coverImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleCoverImage(file);
            }
        });

        // ドラッグ＆ドロップイベント
        const coverDropZone = coverImageInput.closest('.border-dashed');
        if (coverDropZone) {
            coverDropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('border-blue-400', 'bg-blue-50');
            });

            coverDropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('border-blue-400', 'bg-blue-50');
            });

            coverDropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('border-blue-400', 'bg-blue-50');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const file = files[0];
                    if (file.type.startsWith('image/')) {
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        coverImageInput.files = dt.files;
                        handleCoverImage(file);
                    } else {
                        alert('画像ファイルを選択してください。');
                    }
                }
            });
        }
    }

    // 商品画像のプレビュー
    const imagesInput = document.getElementById('images');
    if (imagesInput) {
        // ファイル選択イベント
        imagesInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            if (files.length > 0) {
                handleProductImages(files);
            }
        });

        // ドラッグ＆ドロップイベント
        const imagesDropZone = imagesInput.closest('.border-dashed');
        if (imagesDropZone) {
            imagesDropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('border-blue-400', 'bg-blue-50');
            });

            imagesDropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('border-blue-400', 'bg-blue-50');
            });

            imagesDropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('border-blue-400', 'bg-blue-50');

                const files = Array.from(e.dataTransfer.files);
                if (files.length > 0) {
                    const imageFiles = files.filter(file => file.type.startsWith('image/'));

                    if (imageFiles.length > 0) {
                        const dt = new DataTransfer();
                        imageFiles.forEach(file => dt.items.add(file));
                        imagesInput.files = dt.files;
                        handleProductImages(imageFiles);
                    } else {
                        alert('画像ファイルを選択してください。');
                    }
                }
            });
        }
    }
});

// 画像削除機能
function deleteImage(imageId) {
    if (confirm('この画像を削除しますか？')) {
        // ここで画像削除のAPIを呼び出す
        fetch(`/owner/product-images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 画像要素を削除
                const imageElement = document.querySelector(`[data-image-id="${imageId}"]`);
                if (imageElement) {
                    imageElement.remove();
                }
                location.reload(); // ページを再読み込み
            } else {
                alert('画像の削除に失敗しました。');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('画像の削除に失敗しました。');
        });
    }
}
</script>
@endsection
