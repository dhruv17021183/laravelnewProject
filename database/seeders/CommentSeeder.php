<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<10;$i++){
            DB::table('comments')->insert([
                'created_at' => now(),
                'updated_at' => now(),
                'content' => str::random(20),
                'blog_posts_id' => 10,
            ]);
     }
    }
}
