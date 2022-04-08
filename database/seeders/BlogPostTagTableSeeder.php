<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\BlogPost;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagCount = Tag::all()->count();
        if(0 === $tagCount)
        {
            $this->command->info("No tags Found");
            return;
        }

        $howManyMin = (int)$this->command->ask('Minimum Tags On BlogPost?',0);
        $howManyMax = min((int)$this->command->ask('Minimum Tags On BlogPost?',$tagCount),$tagCount);
        
        BlogPost::all()->each(function(BlogPost $post)use($howManyMin,$howManyMax){
            $take = random_int($howManyMin,$howManyMax);

            $tags = Tag::inRandomOrder()->take($take)->get()->pluck('id');

            $post->post()->sync($tags);

        });


    }
}
