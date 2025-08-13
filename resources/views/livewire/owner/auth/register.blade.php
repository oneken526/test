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
                オーナーアカウント作成
            </h2>
            <p class="text-[#736f72] text-lg">新しいオーナーアカウントを作成して店舗管理を始めましょう</p>
        </div>

        <!-- フォーム -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6 sm:p-8 lg:p-10">
            <!-- Session Status -->
            <x-auth-session-status class="text-center mb-6" :status="session('status')" />

            <form wire:submit="register" class="space-y-6">
                <!-- オーナー名 -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-[#736f72] mb-2">
                        オーナー名 <span class="text-red-500">*</span>
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
                            class="w-full px-4 py-3 border-2 border-[#c3baba]/30 rounded-xl focus:outline-none focus:border-[#9a8f97] focus:ring-4 focus:ring-[#9a8f97]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-[#9a8f97]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <label for="email" class="block text-sm font-semibold text-[#736f72] mb-2">
                        メールアドレス <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            wire:model="email"
                            id="email"
                            type="email"
                            required
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

                <!-- 店舗名 -->
                <div>
                    <label for="shop_name" class="block text-sm font-semibold text-[#736f72] mb-2">
                        店舗名 <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            wire:model="shop_name"
                            id="shop_name"
                            type="text"
                            required
                            autocomplete="organization"
                            placeholder="山田商店"
                            class="w-full px-4 py-3 border-2 border-[#c3baba]/30 rounded-xl focus:outline-none focus:border-[#9a8f97] focus:ring-4 focus:ring-[#9a8f97]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-[#9a8f97]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    @error('shop_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 電話番号 -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-[#736f72] mb-2">
                        電話番号
                    </label>
                    <div class="relative">
                        <input
                            wire:model="phone"
                            id="phone"
                            type="tel"
                            autocomplete="tel"
                            placeholder="03-1234-5678"
                            class="w-full px-4 py-3 border-2 border-[#c3baba]/30 rounded-xl focus:outline-none focus:border-[#9a8f97] focus:ring-4 focus:ring-[#9a8f97]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-[#9a8f97]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 住所 -->
                <div>
                    <label for="address" class="block text-sm font-semibold text-[#736f72] mb-2">
                        住所
                    </label>
                    <div class="relative">
                        <textarea
                            wire:model="address"
                            id="address"
                            rows="3"
                            placeholder="東京都渋谷区..."
                            class="w-full px-4 py-3 border-2 border-[#c3baba]/30 rounded-xl focus:outline-none focus:border-[#9a8f97] focus:ring-4 focus:ring-[#9a8f97]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm resize-none"
                        ></textarea>
                        <div class="absolute right-3 top-3">
                            <svg class="w-5 h-5 text-[#9a8f97]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('address')
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
                            autocomplete="new-password"
                            placeholder="8文字以上で入力"
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

                <!-- パスワード確認 -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-[#736f72] mb-2">
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
                            class="w-full px-4 py-3 border-2 border-[#c3baba]/30 rounded-xl focus:outline-none focus:border-[#9a8f97] focus:ring-4 focus:ring-[#9a8f97]/20 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                        >
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                            <svg class="w-5 h-5 text-[#9a8f97]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        class="mt-1 rounded border-[#9a8f97] text-[#736f72] focus:ring-[#9a8f97] focus:ring-offset-0"
                    >
                    <label for="terms" class="text-sm text-[#736f72]">
                        <a href="#" class="text-[#9a8f97] hover:text-[#736f72] underline">利用規約</a>と
                        <a href="#" class="text-[#9a8f97] hover:text-[#736f72] underline">プライバシーポリシー</a>に同意します
                    </label>
                </div>

                <!-- 登録ボタン -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-[#736f72] to-[#9a8f97] text-white py-4 px-6 rounded-xl hover:from-[#9a8f97] hover:to-[#c3baba] transition-all duration-300 transform hover:scale-105 font-bold text-lg shadow-lg"
                >
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>オーナーアカウントを作成</span>
                    </div>
                </button>
            </form>

            <!-- ログインリンク -->
            <div class="mt-6 text-center">
                <p class="text-[#736f72] text-sm">
                    すでにオーナーアカウントをお持ちですか？
                    <a href="{{ route('owner.login') }}" class="text-[#9a8f97] hover:text-[#736f72] font-semibold underline transition-colors duration-300">
                        ログイン
                    </a>
                </p>
            </div>
        </div>

        <!-- フッター情報 -->
        <div class="mt-8 text-center">
            <p class="text-xs text-[#9a8f97]">
                © 2024 EC Shop. All rights reserved.
            </p>
        </div>
    </div>
</div>
