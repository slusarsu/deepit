<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public TagService $tagService;
    public PostService $postService;
    public function __construct(TagService $tagService, PostService $postService)
    {
        $this->tagService = $tagService;
        $this->postService = $postService;
    }

    public function show(Request $request, $slug)
    {
        $tag = $this->tagService->getOneBySlug($slug);

        $posts = $this->postService->getAllByTagSlug($slug, globalPaginationCount());

        return view('tag', compact('tag', 'posts'));
    }
}
