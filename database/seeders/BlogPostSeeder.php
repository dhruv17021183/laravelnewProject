<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<30;$i++){
            DB::table('blog_posts')->insert([
                'created_at' => now(),
                'updated_at' => now(),
                'title' => str::random(7),
                'Content' => str::random(20),
                'user_id' => 20,
            ]);
     }
    }
}
