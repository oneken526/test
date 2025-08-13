@extends('layouts.app')

@section('title', 'ショッピングカート')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#fef2f2] via-[#fce7f3] to-[#fdf2f8]">
    <!-- ヘッダー -->
    <div class="bg-white/80 backdrop-blur-sm border-b border-white/20 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('user.products.index') }}" class="text-[#880d1e] hover:text-[#dd2d4a] transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-[#880d1e] to-[#dd2d4a] bg-clip-text text-transparent">
                        ショッピングカート
                    </h1>
                </div>

                @if(count($cart) > 0)
                    <button onclick="clearCart()" class="bg-gradient-to-r from-red-400 to-red-500 text-white px-6 py-3 rounded-xl hover:from-red-500 hover:to-red-600 transition-all duration-300 font-semibold shadow-lg">
                        カートを空にする
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(count($cart) > 0)
            <!-- カート商品一覧 -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- 商品リスト -->
                <div class="lg:col-span-2">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                        <h2 class="text-2xl font-bold text-[#880d1e] mb-6">カート内の商品</h2>

                        <div class="space-y-6">
                            @foreach($cart as $productId => $item)
                                <div class="flex items-center space-x-4 p-4 bg-white/50 rounded-xl border border-white/20">
                                    <!-- 商品画像 -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item['image_url'] }}"
                                             alt="{{ $item['name'] }}"
                                             class="w-20 h-20 object-cover rounded-lg">
                                    </div>

                                    <!-- 商品情報 -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-[#880d1e] mb-2">
                                            {{ $item['name'] }}
                                        </h3>
                                        <p class="text-2xl font-bold bg-gradient-to-r from-[#880d1e] to-[#dd2d4a] bg-clip-text text-transparent">
                                            ¥{{ number_format($item['price']) }}
                                        </p>
                                    </div>

                                    <!-- 数量調整 -->
                                    <div class="flex items-center space-x-2">
                                        <button onclick="updateQuantity({{ $productId }}, {{ $item['quantity'] - 1 }})"
                                                class="w-8 h-8 bg-gradient-to-r from-[#f26a8d] to-[#f49cbb] text-white rounded-lg hover:from-[#dd2d4a] hover:to-[#f26a8d] transition-all duration-300 flex items-center justify-center"
                                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>

                                        <span class="w-12 text-center font-semibold text-[#880d1e]">
                                            {{ $item['quantity'] }}
                                        </span>

                                        <button onclick="updateQuantity({{ $productId }}, {{ $item['quantity'] + 1 }})"
                                                class="w-8 h-8 bg-gradient-to-r from-[#f26a8d] to-[#f49cbb] text-white rounded-lg hover:from-[#dd2d4a] hover:to-[#f26a8d] transition-all duration-300 flex items-center justify-center"
                                                {{ $item['quantity'] >= $item['stock_quantity'] ? 'disabled' : '' }}>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- 小計 -->
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-[#880d1e]">
                                            ¥{{ number_format($item['price'] * $item['quantity']) }}
                                        </p>
                                    </div>

                                    <!-- 削除ボタン -->
                                    <button onclick="removeFromCart({{ $productId }})"
                                            class="text-red-500 hover:text-red-700 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 注文サマリー -->
                <div class="lg:col-span-1">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6 sticky top-24">
                        <h2 class="text-2xl font-bold text-[#880d1e] mb-6">注文サマリー</h2>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">商品数:</span>
                                <span class="font-semibold">{{ count($cart) }}点</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">合計数量:</span>
                                <span class="font-semibold">{{ array_sum(array_column($cart, 'quantity')) }}個</span>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-xl font-bold text-[#880d1e]">合計金額:</span>
                                    <span class="text-2xl font-bold bg-gradient-to-r from-[#880d1e] to-[#dd2d4a] bg-clip-text text-transparent">
                                        ¥{{ number_format($total) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button onclick="proceedToCheckout()"
                                class="w-full bg-gradient-to-r from-[#dd2d4a] to-[#f26a8d] text-white py-4 px-6 rounded-xl hover:from-[#880d1e] hover:to-[#dd2d4a] transition-all duration-300 font-bold text-lg shadow-lg transform hover:scale-105">
                            レジに進む
                        </button>

                        <div class="mt-4 text-center">
                            <a href="{{ route('user.products.index') }}"
                               class="text-[#f26a8d] hover:text-[#dd2d4a] transition-colors duration-300 font-semibold">
                                買い物を続ける
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- 空のカート -->
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gradient-to-r from-[#f26a8d] to-[#f49cbb] rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>

                <h2 class="text-3xl font-bold text-[#880d1e] mb-4">カートが空です</h2>
                <p class="text-[#dd2d4a] mb-8 text-lg">商品を追加してショッピングを楽しみましょう！</p>

                <a href="{{ route('user.products.index') }}"
                   class="inline-block bg-gradient-to-r from-[#dd2d4a] to-[#f26a8d] text-white px-8 py-4 rounded-xl hover:from-[#880d1e] hover:to-[#dd2d4a] transition-all duration-300 font-bold text-lg shadow-lg transform hover:scale-105">
                    商品を見る
                </a>
            </div>
        @endif
    </div>
</div>

<script>
function updateQuantity(productId, newQuantity) {
    if (newQuantity < 1) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('{{ route("user.cart.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showErrorModal(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorModal('エラーが発生しました。');
    });
}

function removeFromCart(productId) {
    if (!confirm('この商品をカートから削除しますか？')) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('{{ route("user.cart.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showErrorModal(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorModal('エラーが発生しました。');
    });
}

function clearCart() {
    if (!confirm('カートを空にしますか？')) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('{{ route("user.cart.clear") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showErrorModal(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorModal('エラーが発生しました。');
    });
}

function proceedToCheckout() {
    // レジ機能は後で実装
    alert('レジ機能は準備中です。');
}

function showErrorModal(message) {
    const overlay = document.createElement('div');
    overlay.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center';
    overlay.id = 'error-modal-overlay';

    const modal = document.createElement('div');
    modal.className = 'bg-white rounded-2xl shadow-2xl p-8 max-w-md mx-4 transform scale-95 opacity-0 transition-all duration-300';
    modal.innerHTML = `
        <div class="text-center">
            <div class="w-16 h-16 bg-gradient-to-r from-red-400 to-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-[#880d1e] mb-2">エラー</h3>
            <p class="text-[#dd2d4a] mb-6">${message}</p>
            <button onclick="closeErrorModal()" class="bg-gradient-to-r from-[#dd2d4a] to-[#f26a8d] text-white py-3 px-6 rounded-xl hover:from-[#880d1e] hover:to-[#dd2d4a] transition-all duration-300 font-semibold">
                閉じる
            </button>
        </div>
    `;

    overlay.appendChild(modal);
    document.body.appendChild(overlay);

    setTimeout(() => {
        modal.classList.remove('scale-95', 'opacity-0');
        modal.classList.add('scale-100', 'opacity-100');
    }, 100);
}

function closeErrorModal() {
    const overlay = document.getElementById('error-modal-overlay');
    if (overlay) {
        const modal = overlay.querySelector('div');
        modal.classList.remove('scale-100', 'opacity-100');
        modal.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            document.body.removeChild(overlay);
        }, 300);
    }
}

// ESCキーでモーダルを閉じる
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeErrorModal();
    }
});

// オーバーレイクリックでモーダルを閉じる
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fixed') && event.target.classList.contains('bg-black/50')) {
        closeErrorModal();
    }
});
</script>
@endsection
