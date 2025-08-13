<div class="min-h-screen bg-gradient-to-br from-[#fef2f2] via-[#fce7f3] to-[#fdf2f8] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md lg:max-w-lg xl:max-w-xl">
        <!-- ロゴとタイトル -->
        <div class="text-center mb-8">
            <div class="mb-6">
                <a href="{{ route('user.products.index') }}" class="text-4xl font-bold bg-gradient-to-r from-[#880d1e] to-[#dd2d4a] bg-clip-text text-transparent hover:from-[#dd2d4a] hover:to-[#f26a8d] transition-all duration-300">
                    EC Shop
                </a>
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-[#880d1e] to-[#dd2d4a] bg-clip-text text-transparent mb-2">
                アカウント作成
            </h2>
            <p class="text-[#dd2d4a] text-lg">新しいアカウントを作成してショッピングを始めましょう</p>
        </div>

        <!-- フォーム -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6 sm:p-8 lg:p-10">
            <!-- Session Status -->
            <x-auth-session-status class="text-center mb-6" :status="session('status')" />

            <form wire:submit="register" class="space-y-6">
                <!-- 名前 -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-[#dd2d4a] mb-2">
                        お名前 <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            wire:model.live="name"
                            id="name"
                            type="text"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="山田 太郎"
                            class="w-full px-4 py-3 border-2 border-[#f49cbb]/30 rounded-xl focus:outline-none focus:border-[#f26a8d] focus:ring-4 focus:ring-[#f26a8d]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-[#f26a8d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- メールアドレス -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-[#dd2d4a] mb-2">
                        メールアドレス <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            wire:model="email"
                            id="email"
                            type="email"
                            required
                            autocomplete="email"
                            placeholder="example@email.com"
                            class="w-full px-4 py-3 border-2 border-[#f49cbb]/30 rounded-xl focus:outline-none focus:border-[#f26a8d] focus:ring-4 focus:ring-[#f26a8d]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-[#f26a8d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <label for="password" class="block text-sm font-semibold text-[#dd2d4a] mb-2">
                        パスワード <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            wire:model="password"
                            id="password"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="8文字以上で入力"
                            class="w-full px-4 py-3 border-2 border-[#f49cbb]/30 rounded-xl focus:outline-none focus:border-[#f26a8d] focus:ring-4 focus:ring-[#f26a8d]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-[#f26a8d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- パスワード確認 -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-[#dd2d4a] mb-2">
                        パスワード確認 <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            wire:model="password_confirmation"
                            id="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="パスワードを再入力"
                            class="w-full px-4 py-3 border-2 border-[#f49cbb]/30 rounded-xl focus:outline-none focus:border-[#f26a8d] focus:ring-4 focus:ring-[#f26a8d]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-[#f26a8d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- 利用規約同意 -->
                <div class="flex items-start space-x-3">
                    <input
                        type="checkbox"
                        id="terms"
                        required
                        class="mt-1 rounded border-[#f26a8d] text-[#dd2d4a] focus:ring-[#f26a8d] focus:ring-offset-0"
                    >
                    <label for="terms" class="text-sm text-[#dd2d4a]">
                        <a href="#" class="text-[#f26a8d] hover:text-[#880d1e] underline">利用規約</a>と
                        <a href="#" class="text-[#f26a8d] hover:text-[#880d1e] underline">プライバシーポリシー</a>に同意します
                    </label>
                </div>

                <!-- 登録ボタン -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-[#dd2d4a] to-[#f26a8d] text-white py-4 px-6 rounded-xl hover:from-[#880d1e] hover:to-[#dd2d4a] transition-all duration-300 transform hover:scale-105 font-bold text-lg shadow-lg"
                >
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>アカウントを作成</span>
                    </div>
                </button>
            </form>

            <!-- ログインリンク -->
            <div class="mt-6 text-center">
                <p class="text-[#dd2d4a] text-sm">
                    すでにアカウントをお持ちですか？
                    <a href="{{ route('login') }}" class="text-[#f26a8d] hover:text-[#880d1e] font-semibold underline transition-colors duration-300">
                        ログイン
                    </a>
                </p>
            </div>
        </div>

        <!-- フッター情報 -->
        <div class="mt-8 text-center">
            <p class="text-xs text-[#f26a8d]">
                © 2024 EC Shop. All rights reserved.
            </p>
        </div>
    </div>
</div>
