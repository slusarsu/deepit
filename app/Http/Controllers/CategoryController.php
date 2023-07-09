<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public CategoryService $categoryService;
    public PostService $postService;
    public function __construct(CategoryService $categoryService, PostService $postService)
    {
        $this->categoryService = $categoryService;
        $this->postService = $postService;
    }

    public function show(Request $request, $slug)
    {
        $category = $this->categoryService->getOneBySlug($slug);

        $posts = $this->postService->getAllByCategorySlug($slug, globalPaginationCount());

        return view('category', compact('category', 'posts'));
    }
}
