<?php

namespace Database\Seeders;

use App\Models\{Order, User, Owner};
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $owners = Owner::where('is_active', true)->get();

        if ($users->isEmpty() || $owners->isEmpty()) {
            $this->command->warn('ユーザーまたはアクティブなオーナーが見つかりません。UserSeederとOwnerSeederを先に実行してください。');
            return;
        }

        // 各ユーザーに対して注文を作成
        foreach ($users as $user) {
            // 注文確認中
            Order::factory(3)
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 注文確定
            Order::factory(5)
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 準備中
            Order::factory(3)
                ->preparing()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 発送済み
            Order::factory(4)
                ->shipped()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 配送完了
            Order::factory(6)
                ->delivered()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 完了
            Order::factory(8)
                ->completed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // キャンセル
            Order::factory(2)
                ->cancelled()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 決済方法別
            Order::factory(3)
                ->creditCard()
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            Order::factory(2)
                ->bankTransfer()
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            Order::factory(2)
                ->cod()
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            Order::factory(2)
                ->digitalWallet()
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 価格帯別
            Order::factory(5)
                ->cheap()
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            Order::factory(3)
                ->expensive()
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 送料別
            Order::factory(8)
                ->freeShipping()
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            Order::factory(5)
                ->withShipping()
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 決済状況別
            Order::factory(3)
                ->paymentFailed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            Order::factory(2)
                ->refunded()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // メモなし
            Order::factory(5)
                ->withoutNotes()
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 電話番号なし
            Order::factory(3)
                ->withoutPhone()
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 過去の注文
            Order::factory(10)
                ->past()
                ->completed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);

            // 最近の注文
            Order::factory(5)
                ->recent()
                ->confirmed()
                ->create([
                    'user_id' => $user->id,
                    'owner_id' => $owners->random()->id,
                ]);
        }

        $this->command->info('注文データを作成しました。');
    }
}
