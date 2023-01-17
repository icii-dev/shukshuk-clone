<?php

use App\Model\ProductOption;
use App\Model\ProductOptionValue;
use App\Model\Store;
use App\Model\StoreBalance;
use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(Store::class, 2)->create()->each(function (Store $store) {
//            $store->products()->saveMany(
//                factory(\App\Model\Product::class, random_int(0, 100))->make()
//            )->each(function (\App\Model\Product $product) {
//                $product->options()->saveMany(
//                    factory(ProductOption::class, random_int(0, 2))->make()
//                )->each(function (ProductOption $productOption) {
//                    $productOption->values()->saveMany(
//                        factory(ProductOptionValue::class, random_int(2,5))->make()
//                    );
//                });
//            });
//        });

        //insert store email, phone store for quick test
//        $stores = $stores = Store::with('user')->get();
//        foreach ($stores as $store){
//            $store->seller_email = 'cau2binhdinh@gmail.com';
//            $store->seller_phone = '+84933652114';
//            $store->save();
//        }
        $user = \App\Model\User::where('email', 'seller@shukshuk.com')->first();
        if ($user){
            DB::statement('
            INSERT INTO `stores`(`id`, `delivery_unit_id`, `name`, `slug`, `category_id`, `industry_id`, `description`, `user_id`, `address`, `lat`, `lng`, `status`, `created_at`, `updated_at`, `total_favorite`, `rating`, `type`, `featured`, `cover_image`, `proof_images`, `avatar_image`, `seller_id`) VALUES (1, NULL, \'Store 1\', \'store-1\', NULL, NULL, \'Excepturi beatae perspiciatis itaque. Ut qui saepe quas qui. Ducimus autem voluptas ullam nostrum accusantium aut animi. Excepturi beatae perspiciatis itaque. Ut qui saepe quas qui. Ducimus autem voluptas ullam nostrum accusantium aut animi.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-11-26 07:38:48\', \'2020-02-24 15:03:24\', 0, 5.0, 1, 0, NULL, NULL, \'default-avatar.png\', 0)
            , (2, NULL, \'Store 2\', \'store-2\', NULL, NULL, \'Excepturi beatae perspiciatis itaque. Ut qui saepe quas qui. Ducimus autem voluptas ullam nostrum accusantium aut animi. Excepturi beatae perspiciatis itaque. Ut qui saepe quas qui. Ducimus autem voluptas ullam nostrum accusantium aut animi. Excepturi beatae perspiciatis itaque. Ut qui saepe quas qui. Ducimus autem voluptas ullam nostrum accusantium aut animi. Excepturi beatae perspiciatis itaque. Ut qui saepe quas qui. Ducimus autem voluptas ullam nostrum accusantium aut animi.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-11-26 07:41:12\', \'2020-01-02 13:46:14\', 0, 0.0, 1, 1, NULL, NULL, \'default-avatar.png\', 0)
            , (7, 1, \'Magnam dolores dicta vel nisi.\', \'qui-et-porro-doloribus-saepe\', NULL, NULL, \'Excepturi beatae perspiciatis itaque. Ut qui saepe quas qui. Ducimus autem voluptas ullam nostrum accusantium aut animi.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-12-30 13:32:06\', \'2020-01-02 13:46:14\', '.$user->id.', 4.1, 1, 1, NULL, NULL, \'default-avatar.png\', 0)
            , (8, 1, \'Quod numquam ipsam mollitia ut omnis et corporis.\', \'veniam-ex-id-qui-voluptatibus-eum-omnis-sed\', NULL, NULL, \'Omnis iure quo fugit maiores non voluptatem. Dolor veniam in quis deleniti voluptatem dolor. Id sunt autem maxime non quis quia aperiam. Vitae beatae repellendus illo est distinctio et odit.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-12-30 13:32:45\', \'2020-01-02 13:46:14\', 1, 4.8, 1, 1, NULL, NULL, \'default-avatar.png\', 0)
            , (9, 1, \'Deleniti tempore repellendus eum perspiciatis.\', \'sed-cupiditate-et-illo-sunt\', NULL, NULL, \'Atque molestiae modi facere et dignissimos. Eos aliquam ut tempora fuga qui. Eum autem iure magni repellat voluptas harum nesciunt.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-12-30 13:32:45\', \'2020-01-02 13:46:14\', 7, 1.0, 1, 1, NULL, NULL, \'default-avatar.png\', 0)
            , (10, 1, \'Praesentium velit omnis vel est.\', \'sequi-praesentium-porro-sequi-quia-accusantium-nisi\', NULL, NULL, \'Et ipsa architecto sint expedita et. Aliquid maiores molestiae natus iure. Quia maiores molestiae eaque velit est. Quia sit sed mollitia iusto facilis provident quo.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-12-30 13:32:45\', \'2020-01-02 13:46:14\', 5, 0.4, 1, 1, NULL, NULL, \'default-avatar.png\', 0)
            , (11, 1, \'Voluptas omnis est minus possimus unde.\', \'omnis-ab-aliquam-rerum-in-sit-nemo-ut-et\', NULL, NULL, \'Deserunt a ut officia dolor tempora voluptatem ducimus dolorum. Et fuga harum adipisci repellendus ut et. Dolorem eum aut quidem sunt dolor ullam sed ex.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-12-30 13:32:45\', \'2020-06-13 10:02:08\', 6, 3.0, 1, 0, NULL, NULL, \'default-avatar.png\', 0)
            , (12, 1, \'Illum quibusdam assumenda nesciunt ex sunt blanditiis et.\', \'fugit-asperiores-ea-accusantium-sed-exercitationem-numquam-quia-sint\', NULL, NULL, \'Voluptas nihil occaecati est tenetur corrupti velit iure voluptatem. Adipisci aspernatur reiciendis neque.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-12-30 13:32:45\', \'2020-02-17 17:24:42\', 9, 3.1, 1, 1, NULL, NULL, \'default-avatar.png\', 0)
            , (13, 1, \'Sint blanditiis distinctio reprehenderit amet quisquam sed ea reprehenderit.\', \'commodi-ut-magnam-autem-quas-ut\', NULL, NULL, \'Possimus aperiam et vero quam. Qui sit a earum doloremque voluptatem. Voluptatum perferendis consequuntur ut qui assumenda ipsum molestiae.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-12-30 13:32:46\', \'2020-06-13 10:02:23\', 1, 2.3, 1, 0, NULL, NULL, \'default-avatar.png\', 0)
            , (14, 1, \'Id labore quas magnam.\', \'esse-consequatur-voluptatum-aut-quibusdam\', NULL, NULL, \'Dolore eos odio nam labore blanditiis dolores. Accusantium neque voluptate ut ea cupiditate ut dolorem. Voluptates ut autem quia possimus vel laborum.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-12-30 13:32:46\', \'2020-02-17 17:33:13\', 8, 3.0, 1, 1, NULL, NULL, \'default-avatar.png\', 0)
            , (15, 1, \'Consequatur aut dolor quibusdam illo.\', \'quod-nisi-praesentium-accusantium-unde-aliquid-et-vero\', NULL, NULL, \'Iusto voluptatibus voluptas debitis aut error. Quas illo ut a non voluptas soluta. Saepe iure qui asperiores tempore.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-12-30 13:32:46\', \'2020-01-02 13:46:14\', 0, 1.9, 2, 0, NULL, NULL, \'default-avatar.png\', 0)
            , (16, 1, \'Inventore quisquam vel et quia cumque nemo.\', \'minima-explicabo-maxime-tempore-vero\', NULL, NULL, \'Magnam cupiditate sed rerum distinctio et. Ut quaerat voluptatibus qui eos sunt. Sit est corrupti excepturi blanditiis. Occaecati quia et repudiandae unde natus et.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-12-30 13:32:46\', \'2020-02-18 09:58:46\', 7, 2.7, 1, 0, NULL, NULL, \'default-avatar.png\', 0)
            , (17, 1, \'Adipisci commodi nostrum repudiandae culpa.\', \'officia-laudantium-in-repudiandae-consectetur-voluptatem-autem\', NULL, NULL, \'Veritatis autem cupiditate deserunt animi quidem tempora. Sapiente est voluptatem in vero. Et doloribus quia ut consectetur itaque.\', '.$user->id.', \'Central Java, ID\', NULL, NULL, 1, \'2019-12-30 13:32:46\', \'2020-02-01 15:42:31\', 8, 2.6, 1, 0, NULL, NULL, \'default-avatar.png\', 0);
            ');
        }

        $stores = Store::all();
        foreach ($stores as $store){
            if(!$store->balance)
                $store->balance()->save(new StoreBalance(['total' => 0]));
        }

    }
}
