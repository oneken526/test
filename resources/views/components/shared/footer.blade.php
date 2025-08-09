<footer class="bg-gray-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- 会社情報 -->
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-lg font-semibold mb-4">EC Shop</h3>
                <p class="text-gray-300 text-sm">
                    お客様に最高の商品とサービスを提供することを心がけています。
                </p>
            </div>

            <!-- リンク -->
            <div>
                <h4 class="text-sm font-semibold mb-4">ショッピング</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="{{ route('user.products.index') }}" class="hover:text-white">商品一覧</a></li>
                    <li><a href="{{ route('user.products.featured') }}" class="hover:text-white">注目商品</a></li>
                    <li><a href="#" class="hover:text-white">カテゴリ</a></li>
                </ul>
            </div>

            <!-- サポート -->
            <div>
                <h4 class="text-sm font-semibold mb-4">サポート</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="#" class="hover:text-white">お問い合わせ</a></li>
                    <li><a href="#" class="hover:text-white">配送について</a></li>
                    <li><a href="#" class="hover:text-white">返品・交換</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8 text-center">
            <p class="text-gray-300 text-sm">
                &copy; {{ date('Y') }} EC Shop. All rights reserved.
            </p>
        </div>
    </div>
</footer>
