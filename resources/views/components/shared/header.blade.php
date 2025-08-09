<header class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- ロゴ -->
            <div class="flex items-center">
                <a href="{{ route('user.products.index') }}" class="text-xl font-bold text-gray-900">
                    EC Shop
                </a>
            </div>

            <!-- ナビゲーション -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('user.products.index') }}"
                   class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                    商品一覧
                </a>
                <a href="{{ route('user.products.featured') }}"
                   class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                    注目商品
                </a>
                <a href="#"
                   class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                    カート
                </a>
            </nav>

            <!-- ユーザーメニュー -->
            <div class="flex items-center space-x-4">
                @auth('user')
                    <span class="text-gray-700 text-sm">{{ Auth::guard('user')->user()->name }}</span>
                    <form method="POST" action="{{ route('user.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-gray-900 text-sm">
                            ログアウト
                        </button>
                    </form>
                @else
                    <a href="{{ route('user.login') }}" class="text-gray-700 hover:text-gray-900 text-sm">
                        ログイン
                    </a>
                    <a href="{{ route('user.register') }}" class="text-gray-700 hover:text-gray-900 text-sm">
                        新規登録
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
