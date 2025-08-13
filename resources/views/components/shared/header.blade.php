<header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md shadow-lg border-b border-white/20 transition-all duration-500 ease-in-out">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- ロゴ -->
            <div class="flex items-center">
                <a href="{{ route('user.products.index') }}" class="text-xl font-bold bg-gradient-to-r from-[#880d1e] to-[#dd2d4a] bg-clip-text text-transparent hover:from-[#dd2d4a] hover:to-[#f26a8d] transition-all duration-300">
                    EC Shop
                </a>
            </div>

            <!-- ナビゲーション -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('user.products.index') }}"
                   class="text-[#880d1e] hover:text-[#f26a8d] px-3 py-2 rounded-md text-sm font-medium transition-all duration-300 hover:scale-105">
                    商品一覧
                </a>
                <a href="{{ route('user.products.featured') }}"
                   class="text-[#880d1e] hover:text-[#f26a8d] px-3 py-2 rounded-md text-sm font-medium transition-all duration-300 hover:scale-105">
                    注目商品
                </a>
            </nav>

            <!-- カートアイコン -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('user.cart.index') }}" class="relative text-[#880d1e] hover:text-[#f26a8d] transition-all duration-300 hover:scale-105">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    @php
                        $cartCount = 0;
                        if (session()->has('cart')) {
                            $cart = session()->get('cart', []);
                            $cartCount = array_sum(array_column($cart, 'quantity'));
                        }
                    @endphp
                    @if($cartCount > 0)
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-gradient-to-r from-[#f26a8d] to-[#f49cbb] text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- ユーザーメニュー -->
                @auth('web')
                    <span class="text-[#880d1e] text-sm font-medium">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-[#880d1e] hover:text-[#f26a8d] text-sm font-medium transition-all duration-300 hover:scale-105">
                            ログアウト
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-[#880d1e] hover:text-[#f26a8d] text-sm font-medium transition-all duration-300 hover:scale-105">
                        ログイン
                    </a>
                    <a href="{{ route('register') }}" class="text-[#880d1e] hover:text-[#f26a8d] text-sm font-medium transition-all duration-300 hover:scale-105">
                        新規登録
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
