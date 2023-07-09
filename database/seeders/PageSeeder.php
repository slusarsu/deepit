<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::query()->create([
            'title' => 'Contacts',
            'slug' => 'contacts',
            'short' => "<p><span style=\"color: #333333; font-family: 'Work Sans', sans-serif; font-size: 16px; background-color: #ffffff;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labor.</span></p>",
            'custom_fields' => [
                [
                    "data" => [
                        "text" => "hello@reporter.com",
                        "field_name" => "email"
                    ],
                    "type" => "text_input"
                ],
                [
                    "data" => [
                        "text" => "+211234565523",
                        "field_name" => "phone"
                    ],
                    "type" => "text_input"
                ],
                [
                    "data" => [
                        "text" => "9567 Turner Trace Apt. BC C3G8A4",
                        "field_name" => "address"
                    ],
                    "type" => "text_input"
                ]
            ],
            'images' => [],
            'template' => 'contacts',
            'is_enabled' => 1,
            'views' => rand(5,400),
        ]);

        Page::query()->create([
            'title' => 'About me',
            'slug' => 'about-me',
            'short' => "<p><span style=\"color: #333333; font-family: 'Work Sans', sans-serif; font-size: 16px; background-color: #ffffff;\">Hello, I&rsquo;m Hootan Safiyari. A Content writter, Developer and Story teller. Working as a Content writter at CoolTech Agency. Quam nihil &hellip;</span></p>",
            'content' => "<p><span style=\"color: #333333; font-family: 'Work Sans', sans-serif; font-size: 16px; background-color: #ffffff;\">Hello, I&rsquo;m Hootan Safiyari. A Content writter, Developer and Story teller. Working as a Content writter at CoolTech Agency. Quam nihil enim maxime corporis cumque totam aliquid nam sint inventore optio modi neque laborum officiis necessitatibus, facilis placeat pariatur! Voluptatem, sed harum pariatur adipisci voluptates voluptatum cumque, porro sint minima similique magni perferendis fuga! Optio vel ipsum excepturi tempore reiciendis id quidem? Vel in, doloribus debitis nesciunt fugit sequi magnam accusantium modi neque quis, vitae velit, pariatur harum autem a! Velit impedit atque maiores animi possimus asperiores natus repellendus excepturi sint architecto eligendi non, omnis nihil. Facilis, doloremque illum. Fugit optio laborum minus debitis natus illo perspiciatis corporis voluptatum rerum laboriosam.</span></p>
<blockquote>
<p><span style=\"color: #333333; font-family: 'Work Sans', sans-serif; font-size: 20px; font-style: italic; background-color: #ffffff;\">Facilis, doloremque illum. Fugit optio laborum minus debitis natus illo perspiciatis corporis voluptatum rerum laboriosam.</span></p>
</blockquote>
<p><span style=\"color: #333333; font-family: 'Work Sans', sans-serif; font-size: 16px; background-color: #ffffff;\">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam nihil enim maxime corporis cumque totam aliquid nam sint inventore optio modi neque laborum officiis necessitatibus, facilis placeat pariatur! Voluptatem, sed harum pariatur adipisci voluptates voluptatum cumque, porro sint minima similique magni perferendis fuga! Optio vel ipsum excepturi tempore reiciendis id quidem.</span></p>",
            'custom_fields' => [
                [
                    "data" => [
                        "text" => "Hootan Safiyari",
                        "field_name" => "name"
                    ],
                    "type" => "text_input"
                ],
                [
                    "data" => [
                        "text" => "Know More",
                        "field_name" => "button_text"
                    ],
                    "type" => "text_input"
                ]
            ],
            'images' => [],
            'template' => 'about-me',
            'is_enabled' => 1,
            'views' => rand(5,400),
        ]);
    }
}
