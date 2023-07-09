<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class PageService
{
    public static function getListOfPageTemplates(): array
    {
        $pagePaths = Storage::disk('views')->files('pages');
        $templates = [];
        foreach ($pagePaths as $item) {
            $itemArr = explode('/', $item);
            $last = end($itemArr);
            $result = str_replace('.blade.php','',$last);
            $templates[$result] = $result;
        }

        return $templates;
    }

    public function getOneBySlug(string $slug): object|null
    {
        $page = Page::query()->where('slug', $slug)->active()->first();

        if($page) {
            $page->increment('views');
            $page->save();
        }

        return $page;
    }
}
