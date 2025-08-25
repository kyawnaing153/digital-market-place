<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\{Page,Setting};
class AuthorPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

       $QuesAns = [ 
            [
              "question" => "Share your objectives with us, and we'll provide you with the information necessary for your success.",
              "options" =>[
                0 => "I currently sustain myself by creating and selling products through online platforms.",
                1 => "I aspire to transition into a full-time endeavor of crafting and selling products.",
                2 => "I intend to engage in part-time production and sale of items.",
                3 => "I pursue this as a hobby rather than a primary occupation.",
              ]
              ],
            [
              "question" => "What area do you specialize in?",
              "options" => [
                0 => "Website themes and templates",
                1 => "Code scripts and plugins",
                2 => "Stock video and templates",
                3 => "Graphic design assets and templates",
                4 => "3D models"
              ]
            ]
        ];



        $newArr = collect([
            'is_checked_author_tab'=> "1",
            "author_heading_content" => "<h3>Let's Get Started!</h3><p>We are currently accepting submissions from authors with expertise in:</p><p>✓ Website themes and templates</p><p>✓ Code scripts and plugins</p><p>✓ Stock Video and Templates</p><p>✓ Graphic design assets and Templates</p><p>✓ 3D Models</p>",
            "author_quest_ans" => serialize($QuesAns)
        ]);

        foreach ($newArr as $key => $value)
        {
            $obj = Setting::firstOrNew(['key' => $key]);
            $obj->key = $key;
            $obj->long_value = $value;
            $obj->save();
        }

        $obj = Page::firstOrNew(['slug'=>"author-terms-and-conditions"]);
        $obj->slug = "author-terms-and-conditions";
        $obj->heading = "Author Terms And Conditions";
        $obj->sub_heading = "Get latest news in your inbox consectetur dipiscing elit,sed do eiusmod tempor";
        $obj->description = "Get latest news in your inbox consectetur dipiscing elit,sed do eiusmod tempor";
        $obj->meta_title = "Get latest news in your inbox consectetur dipiscing elit,sed do eiusmod tempor";
        $obj->meta_keywords = "Get latest news in your inbox consectetur dipiscing elit,sed do eiusmod tempor";
        $obj->meta_desc = "Get latest news in your inbox consectetur dipiscing elit,sed do eiusmod tempor";
        $obj->save();
    }
}