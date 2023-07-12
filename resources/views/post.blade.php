@extends('layouts.main', [
    'title' => $post->seo_title ?? $post->title,
    'seoDescription' => $post->seo_description,
    'seoKeyWords' => $post->seo_text_keys,
    'seoAuthor' => $post->user->name,
    'sidebar' => true,
    ])

@section('content')
    <div class="breadcrumbs mb-4">
        <a href="{{homeLink()}}">Home</a>
        <span class="mx-1">/</span>
        <a href="{{$post->link()}}">Posts</a>
        <span class="mx-1">/</span>
        <a href="{{$post->link()}}">{{$post->title}}</a>
    </div>
    <article>
        <img loading="lazy" decoding="async" src="{{$thumb ?? randomImage()}}" alt="Post Thumbnail" class="w-100">

        <div class="d-flex justify-content-between mt-3">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="margin-right:5px;margin-top:-4px" class="text-dark" viewBox="0 0 16 16">
                    <path d="M5.5 10.5A.5.5 0 0 1 6 10h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z" />
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z" />
                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z" />
                </svg> <span>{{$post->getDate()}}</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                </svg>
                <span>{{$post->views}}</span>
            </div>
        </div>
        <h1 class="my-3">{{$post->title}}</h1>
        <ul class="post-meta mb-4">
            @foreach($post->categories as $category)
                <li>
                    <a href="{{$category->link()}}">{{$category->title}}</a>
                </li>
            @endforeach
        </ul>
        <div class="content text-left">
            {!! $post->content !!}
        </div>
        <ul class="post-meta my-4">
            @foreach($post->tags as $tag)
                <li>
                    <a href="{{$tag->link()}}">{{$tag->title}}</a>
                </li>
            @endforeach
        </ul>
    </article>
@endsection
