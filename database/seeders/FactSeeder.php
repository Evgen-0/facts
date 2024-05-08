<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Fact;
use App\Models\User;
use Illuminate\Database\Seeder;

class FactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fact::factory()->createMany([
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/aQzqP7d_700bwp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/aRBwyWQ_460swp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/avy02wX_700bwp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/avypo7q_460swp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/aE0vjZN_460swp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/a6Zwr42_460swp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/aAyRb4o_460swp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/abA38Xv_460swp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/aLnRYrz_460swp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/an7Ye8L_460swp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/aPAw08B_460swp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/aPAwXdw_460swp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/a4PK5rZ_460swp.webp',
            ],
            [
                'user_id' => User::all()->random()->id,
                'category_id' => Category::all()->random()->id,
                'body' => 'https://img-9gag-fun.9cache.com/photo/ae9NNrj_460swp.webp',
            ]
        ]);
    }
}
