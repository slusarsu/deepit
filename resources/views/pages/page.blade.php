@extends('layouts.main', [
    'title' => $page->seo_title ?? $page->title,
    'seoDescription' => $page->seo_description,
    'seoKeyWords' => $page->seo_text_keys,
    'sidebar' => true,
    ])

@section('content')
    <div class="breadcrumbs mb-4">
        <a href="{{homeLink()}}">Home</a>
        <span class="mx-1">/</span>
        <a href="{{$page->link()}}">{{$page->title}}</a>
    </div>

    <img loading="lazy" decoding="async" src="{{$thumb ?? admRandomImage()}}" class="img-fluid w-100 mb-4" alt="Author Image">
    <h1 class="mb-4">{{$page->title}}</h1>
    <div class="content">
        {!! $page->content !!}
    </div>
@endsection
