<?php

namespace App\Http\Controllers;

use App\Services\PageService;
use App\Services\PostService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private PageService $pageService;
    private PostService $postService;

    public function __construct(PageService $pageService, PostService $postService)
    {
        $this->pageService = $pageService;
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $posts = $this->postService->getAll(globalPaginationCount());

        return view('index', compact('posts'));
    }

    public function show(Request $request, $slug)
    {
        $page = $this->pageService->getOneBySlug($slug);

        if(!$page) {
            return redirect('/');
        }

        $cf = $page->customFields();
        $thumb = $page->thumb();
        $images = $page->images();
        $template = !empty($page->template) ? $page->template : 'page';

        return view('pages.'.$template, compact('page', 'cf', 'thumb', 'images'));
    }

    public function search(Request $request)
    {
        $phrase = $request->get('s');
        if(!$phrase) {
            return redirect('/');
        }
        $posts = $this->postService->searchByPhrase($phrase, globalPaginationCount());

        return view('search', compact('posts', 'phrase'));
    }
}
