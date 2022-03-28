<?php

use Illuminate\Database\Seeder;
use App\Tag;
use Illuminate\Support\Str;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags= ['happy','funny','traveling','healthy','fit'];
        foreach ($tags as $tag) { 
            $newTag = new Tag();
            $newTag->name=$tag;
            $newTag->slug= Str::of($tag)->slug('-');
            $newTag->save();
        }
    }
}
