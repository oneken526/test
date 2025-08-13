<?php

namespace Database\Factories;

use App\Models\{Product, Owner};
use App\Enums\ProductStatus;
use App\Constants\ProductConsts;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = fake()->randomElement([1, 2, 3, 4, 5, 6, 7, 8]); // 1:おもちゃ, 2:スポーツ, 3:家具, 4:書籍, 5:美容, 6:衣類, 7:電子機器, 8:食品

        return [
            'owner_id' => Owner::factory(),
            'name' => $this->generateJapaneseProductName($category),
            'description' => $this->generateJapaneseDescription($category),
            'price' => fake()->numberBetween(100, 10000),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'category' => $category,
            'is_active' => true,
            'is_featured' => false,
            'weight' => fake()->randomFloat(2, 0.1, 10.0),
            'dimensions' => fake()->randomElement(['10x10x5cm', '20x15x10cm', '30x20x15cm', '50x30x20cm']),
            'sku' => fake()->unique()->regexify('[A-Z]{3}[0-9]{5}'),
        ];
    }

    /**
     * アクティブな商品
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * 非アクティブな商品
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * 下書き状態の商品
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * 注目商品
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'is_active' => true,
        ]);
    }

    /**
     * 在庫切れ商品
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_quantity' => 0,
            'is_active' => true,
        ]);
    }

    /**
     * 在庫少商品
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_quantity' => fake()->numberBetween(1, ProductConsts::LOW_STOCK_THRESHOLD),
            'is_active' => true,
        ]);
    }

    /**
     * 高価格商品
     */
    public function expensive(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => fake()->numberBetween(5000, 50000),
        ]);
    }

    /**
     * 低価格商品
     */
    public function cheap(): static
    {
        return $this->state(fn (array $attributes) => [
            'price' => fake()->numberBetween(100, 1000),
        ]);
    }

    /**
     * 特定カテゴリの商品
     */
    public function category(string $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $category,
        ]);
    }

    /**
     * おもちゃカテゴリ
     */
    public function toys(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 1,
        ]);
    }

    /**
     * スポーツカテゴリ
     */
    public function sports(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 2,
        ]);
    }

    /**
     * 家具カテゴリ
     */
    public function furniture(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 3,
        ]);
    }

    /**
     * 書籍カテゴリ
     */
    public function books(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 4,
        ]);
    }

    /**
     * 美容カテゴリ
     */
    public function beauty(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 5,
        ]);
    }

    /**
     * 衣類カテゴリ
     */
    public function clothing(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 6,
        ]);
    }

    /**
     * 電子機器カテゴリ
     */
    public function electronics(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 7,
        ]);
    }

    /**
     * 食品カテゴリ
     */
    public function food(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => 8,
        ]);
    }

    /**
     * 説明なしの商品
     */
    public function withoutDescription(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => null,
        ]);
    }

    /**
     * カテゴリなしの商品
     */
    public function withoutCategory(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => null,
        ]);
    }

    /**
     * SKUなしの商品
     */
    public function withoutSku(): static
    {
        return $this->state(fn (array $attributes) => [
            'sku' => null,
        ]);
    }

    /**
     * 重量なしの商品
     */
    public function withoutWeight(): static
    {
        return $this->state(fn (array $attributes) => [
            'weight' => null,
        ]);
    }

    /**
     * サイズなしの商品
     */
    public function withoutDimensions(): static
    {
        return $this->state(fn (array $attributes) => [
            'dimensions' => null,
        ]);
    }

        /**
     * 日本語の商品名を生成
     */
    private function generateJapaneseProductName(int $category): string
    {
        $categories = [
            1 => [ // おもちゃ
                'ぬいぐるみ', 'ブロック', 'パズル', 'ボードゲーム', 'おもちゃの車',
                '人形', '積み木', 'カードゲーム', 'プラモデル', '知育玩具', 'レゴ', 'お絵かきセット'
            ],
            2 => [ // スポーツ
                'ランニングシューズ', 'ヨガマット', 'テニスラケット', '水泳ゴーグル', '自転車',
                'ダンベル', 'ストレッチボード', 'スポーツバッグ', 'トレーニングウェア', 'ボール', 'スケートボード', 'サーフボード'
            ],
            3 => [ // 家具
                'ソファ', 'テーブル', '椅子', 'ベッド', '本棚',
                '収納棚', '照明器具', 'カーペット', 'カーテン', '花瓶', '時計', '鏡'
            ],
            4 => [ // 書籍
                '小説', 'ビジネス書', '料理本', '旅行ガイド', '写真集',
                '辞典', '雑誌', '漫画', '絵本', '参考書', 'エッセイ集', '歴史書'
            ],
            5 => [ // 美容
                '化粧水', '美容液', 'ファンデーション', 'リップグロス', 'マスカラ',
                'シャンプー', 'ボディソープ', '香水', 'ネイルポリッシュ', '化粧ブラシ', '美容クリーム', 'ヘアオイル'
            ],
            6 => [ // 衣類
                'カジュアルTシャツ', 'デニムジャケット', 'スニーカー', 'ハンドバッグ', 'サングラス',
                '帽子', 'スカーフ', 'ベルト', '靴下', '手袋', 'コート', 'ワンピース'
            ],
            7 => [ // 電子機器
                'スマートフォン', 'ノートパソコン', 'ワイヤレスイヤホン', 'Bluetoothスピーカー', 'タブレット',
                'デジタルカメラ', 'ゲーミングマウス', 'USBケーブル', '充電器', 'モニター', 'キーボード', 'マウスパッド'
            ],
            8 => [ // 食品
                'チョコレート', 'クッキー', '紅茶', 'コーヒー豆', 'ジャム',
                'オリーブオイル', 'パスタ', '調味料', 'ドライフルーツ', 'ナッツ', 'ハチミツ', 'オリーブ'
            ]
        ];

        $baseName = fake()->randomElement($categories[$category] ?? $categories[1]);

        // カテゴリ別の修飾語
        $categoryModifiers = [
            1 => ['知育', '安全', 'エデュケーショナル', 'クリエイティブ', '楽しい', '教育的', '高品質', '子供向け', '家族向け', '学習'], // おもちゃ
            2 => ['プロ仕様', '軽量', '耐久性', '防水', '通気性', '快適', '高性能', 'トレーニング用', '競技用', 'フィットネス'], // スポーツ
            3 => ['プレミアム', 'エコ', 'オーガニック', 'コンパクト', '省スペース', '静音', '多機能', '高級', 'デザイン', '実用的'], // 家具
            4 => ['ベストセラー', '限定版', '初版本', '図解付き', '完全版', '新装版', '愛蔵版', '文庫版', 'ハードカバー', '電子書籍'], // 書籍
            5 => ['プレミアム', 'オーガニック', 'ナチュラル', '無添加', '保湿', '美白', 'アンチエイジング', '高級', '美容液', 'スキンケア'], // 美容
            6 => ['プレミアム', 'オーガニック', 'デザイナー', 'カジュアル', 'エレガント', 'トレンド', '限定版', 'ベストセラー', '高級', 'スタイリッシュ'], // 衣類
            7 => ['プレミアム', 'ハイクオリティ', 'ワイヤレス', 'コンパクト', 'ポータブル', '防水', '軽量', '高級', '最新モデル', 'プロ仕様'], // 電子機器
            8 => ['オーガニック', '無添加', 'プレミアム', '高級', '限定版', '手作り', '天然', '健康', 'グルメ', '特選'] // 食品
        ];

        $modifier = fake()->randomElement($categoryModifiers[$category] ?? ['プレミアム', '高品質', '限定版']);

        return $modifier . ' ' . $baseName;
    }

    /**
     * 日本語の商品説明を生成
     */
    private function generateJapaneseDescription(int $category): string
    {
        $categoryDescriptions = [
            1 => [ // おもちゃ
                '安全性を重視し、お子様にも安心してお使いいただけます。',
                '知育効果があり、お子様の成長をサポートします。',
                '創造性を育むデザインで、想像力を広げます。',
                '家族で楽しめる商品で、コミュニケーションを促進します。',
                '教育的な要素を含み、学習効果も期待できます。',
                '高品質な素材を使用し、長くお使いいただけます。',
                '年齢に応じた難易度で、成長に合わせてお楽しみいただけます。',
                '楽しいデザインで、お子様が喜ぶ商品です。',
                'クリエイティブな遊び方を提案する商品です。',
                '安全基準を満たし、安心してお子様にお使いいただけます。'
            ],
            2 => [ // スポーツ
                'プロアスリートも使用する高品質な商品です。',
                '軽量設計で、運動時の負担を軽減します。',
                '通気性に優れ、快適にスポーツをお楽しみいただけます。',
                '防水加工で、様々な天候でお使いいただけます。',
                '耐久性に優れ、激しい運動にも耐えます。',
                'フィット感を重視した設計で、動きやすさを追求しています。',
                'トレーニング効果を高める機能が搭載されています。',
                '安全性を重視し、安心してスポーツをお楽しみいただけます。',
                '洗濯機で簡単にお手入れできます。',
                '競技用としても使用できる高性能な商品です。'
            ],
            3 => [ // 家具
                'お部屋のインテリアにマッチするデザインです。',
                '省スペース設計で、限られた空間でもお使いいただけます。',
                '静音設計で、静かな環境を保てます。',
                '多機能で、様々な用途にお使いいただけます。',
                'お手入れが簡単で、清潔を保てます。',
                '安全性を重視し、お子様にも安心してお使いいただけます。',
                '耐久性に優れ、長期間の使用に耐えます。',
                'コンパクトサイズで、省スペースでお使いいただけます。',
                'エコフレンドリーな素材を使用しています。',
                '実用的で、毎日の生活に役立つ商品です。'
            ],
            4 => [ // 書籍
                '読みやすさを重視したレイアウトで、快適に読書をお楽しみいただけます。',
                '図解や写真を豊富に使用し、理解しやすい内容になっています。',
                'ハードカバーで、長期間の保存に適しています。',
                'ベストセラー作品で、多くの読者に愛されています。',
                '限定版として、特別な装丁でお届けします。',
                '電子書籍版もご用意しております。',
                '図書館や学校でも採用されている信頼の商品です。',
                '初心者から上級者まで幅広くお楽しみいただけます。',
                '実用的な知識が詰まった参考書です。',
                '美しい写真と文章で構成された写真集です。'
            ],
            5 => [ // 美容
                'オーガニック成分を使用した肌に優しい商品です。',
                '無添加で、敏感肌の方にも安心してお使いいただけます。',
                '保湿効果に優れ、乾燥肌をケアします。',
                '美白効果で、美しい肌をサポートします。',
                'アンチエイジング効果で、若々しい肌を保ちます。',
                '高級感あふれる香りで、リラックスタイムを演出します。',
                '使いやすさを重視した設計で、毎日のスキンケアに便利です。',
                '美容液として、肌の奥まで浸透します。',
                'ナチュラルな成分で、肌に負担をかけません。',
                'プレミアム品質で、特別な日にもお使いいただけます。'
            ],
            6 => [ // 衣類
                '高品質な素材を使用し、長くお使いいただけます。',
                'オーガニックコットンを使用した肌に優しい商品です。',
                'トレンドを意識したデザインで、おしゃれに着こなせます。',
                '通気性に優れ、快適にお使いいただけます。',
                '洗濯機で簡単にお手入れできます。',
                'サイズ調整が可能で、フィット感を重視した設計です。',
                'デザイナーブランドの高級感あふれる商品です。',
                'カジュアルからフォーマルまで幅広くお使いいただけます。',
                '軽量で、旅行や外出時にも便利です。',
                '耐久性に優れ、長期間の使用に耐えます。'
            ],
            7 => [ // 電子機器
                '最新技術を採用した高性能な商品です。',
                '使いやすさを重視した設計で、初心者の方でも安心してお使いいただけます。',
                'コンパクトサイズで、持ち運びに便利です。',
                '省エネ設計で、環境にも家計にも優しい商品です。',
                'ワイヤレス対応で、コードレスでお使いいただけます。',
                '防水加工で、様々な環境でお使いいただけます。',
                '軽量設計で、負担を軽減します。',
                'プレミアム品質で、長期間の使用に耐えます。',
                '多機能で、様々な用途にお使いいただけます。',
                'プロ仕様の高品質な商品です。'
            ],
            8 => [ // 食品
                'オーガニック認証を受けた安全な商品です。',
                '無添加で、体に優しい成分のみを使用しています。',
                '手作りで、愛情たっぷりの商品です。',
                '高級感あふれる味わいで、特別な日にもお楽しみいただけます。',
                '健康を意識した成分で、毎日の食事に取り入れやすい商品です。',
                '天然の甘みで、砂糖不使用の商品です。',
                'グルメな味わいで、料理の幅を広げます。',
                '保存料不使用で、安心してお召し上がりいただけます。',
                '特選された原料を使用し、最高品質をお届けします。',
                '栄養価が高く、健康的な食事をサポートします。'
            ]
        ];

        $descriptions = $categoryDescriptions[$category] ?? $categoryDescriptions[1];
        return fake()->randomElement($descriptions);
    }
}

