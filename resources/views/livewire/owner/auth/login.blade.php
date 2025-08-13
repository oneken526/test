<div class="min-h-screen bg-gradient-to-br from-[#e9e3e6] via-[#c3baba] to-[#9a8f97] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md lg:max-w-lg xl:max-w-xl">
        <!-- ロゴとタイトル -->
        <div class="text-center mb-8">
            <div class="mb-6">
                <a href="{{ route('user.products.index') }}" class="text-4xl font-bold bg-gradient-to-r from-[#736f72] to-[#9a8f97] bg-clip-text text-transparent hover:from-[#9a8f97] hover:to-[#c3baba] transition-all duration-300">
                    EC Shop
                </a>
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-[#736f72] to-[#9a8f97] bg-clip-text text-transparent mb-2">
                オーナーログイン
            </h2>
            <p class="text-[#736f72] text-lg">オーナーアカウントにログインして店舗管理を続けましょう</p>
        </div>

        <!-- フォーム -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6 sm:p-8 lg:p-10">
            <!-- Session Status -->
            <x-auth-session-status class="text-center mb-6" :status="session('status')" />

            <form wire:submit="login" class="space-y-6">
                <!-- メールアドレス -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-[#736f72] mb-2">
                        メールアドレス <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            wire:model="email"
                            id="email"
                            type="email"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="owner@example.com"
                            class="w-full px-4 py-3 border-2 border-[#c3baba]/30 rounded-xl focus:outline-none focus:border-[#9a8f97] focus:ring-4 focus:ring-[#9a8f97]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-[#9a8f97]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- パスワード -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-[#736f72] mb-2">
                        パスワード <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            wire:model="password"
                            id="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="パスワードを入力"
                            class="w-full px-4 py-3 border-2 border-[#c3baba]/30 rounded-xl focus:outline-none focus:border-[#9a8f97] focus:ring-4 focus:ring-[#9a8f97]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-[#9a8f97]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- パスワードを忘れた場合 -->
                @if (Route::has('password.request'))
                    <div class="text-right">
                        <a href="{{ route('password.request') }}" class="text-sm text-[#9a8f97] hover:text-[#736f72] underline transition-colors duration-300">
                            パスワードを忘れた場合
                        </a>
                    </div>
                @endif

                <!-- ログイン状態を記憶 -->
                <div class="flex items-center space-x-3">
                    <input
                        wire:model="remember"
                        type="checkbox"
                        id="remember"
                        class="rounded border-[#9a8f97] text-[#736f72] focus:ring-[#9a8f97] focus:ring-offset-0"
                    >
                    <label for="remember" class="text-sm text-[#736f72]">
                        ログイン状態を記憶する
                    </label>
                </div>

                <!-- ログインボタン -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-[#736f72] to-[#9a8f97] text-white py-4 px-6 rounded-xl hover:from-[#9a8f97] hover:to-[#c3baba] transition-all duration-300 transform hover:scale-105 font-bold text-lg shadow-lg"
                >
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span>ログイン</span>
                    </div>
                </button>
            </form>

            <!-- 新規登録リンク -->
            @if (Route::has('owner.register'))
                <div class="mt-6 text-center">
                    <p class="text-[#736f72] text-sm">
                        オーナーアカウントをお持ちでないですか？
                        <a href="{{ route('owner.register') }}" class="text-[#9a8f97] hover:text-[#736f72] font-semibold underline transition-colors duration-300">
                            新規登録
                        </a>
                    </p>
                </div>
            @endif
        </div>

        <!-- フッター情報 -->
        <div class="mt-8 text-center">
            <p class="text-xs text-[#9a8f97]">
                © 2024 EC Shop. All rights reserved.
            </p>
        </div>
    </div>
</div>
