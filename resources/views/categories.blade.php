@extends('layouts.main', [
    'title' => $category->seo_title ?? $category->title,
    'seoDescription' => $category->seo_description,
    'seoKeyWords' => $category->seo_text_keys,
    'sidebar' => true,
    ])

@section('content')
    <div class="col-12">
        <div class="breadcrumbs mb-4">
            <a href="{{homeLink()}}">Home</a>
            <span class="mx-1">/</span>
            <a href="{{route('categories')}}">Categories</a>
        </div>

    </div>

    <div class="row">
        @foreach($categories as $key => $category)

            <div class="col-md-6 mb-4" id="category-{{$category->id}}">
                <article class="card article-card article-card-sm h-100">
                    <a href="{{$category->link()}}">
                        <div class="card-image">
                            <img loading="lazy" decoding="async" src="{{$category->thumb() ?? admRandomImage()}}" alt="{{$category->title}}" class="w-100">
                        </div>
                    </a>
                    <div class="card-body px-0 pb-0">
                        <h2>
                            <a class="post-title" href="{{$category->link()}}">{{$category->title}}</a>
                        </h2>
                        <p class="card-text">{!! $category->short !!}</p>
                    </div>
                </article>
            </div>

        @endforeach
    </div>

@endsection
