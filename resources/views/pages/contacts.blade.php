@extends('layouts.main', [
    'title' => $page->seo_title ?? $page->title,
    'seoDescription' => $page->seo_description,
    'seoKeyWords' => $page->seo_text_keys,
//    'sidebar' => false,
    ])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs mb-4">
                <a href="{{homeLink()}}">Home</a>
                <span class="mx-1">/</span>
                <a href="{{$page->link()}}">{{$page->title}}</a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="pr-0 pr-lg-4">
                <div class="content">{!! $page->short !!}
                    <div class="mt-5">
                        <p class="h3 mb-3 font-weight-normal">
                            <a class="text-dark" href="{{$cf['email'] ?? ''}}">
                                {{$cf['email'] ?? ''}}
                            </a>
                        </p>
                        <p class="mb-3">
                            <a class="text-dark" href="tel:&#43;{{$cf['phone'] ?? ''}}">&#43;{{$cf['phone'] ?? ''}}</a>
                        </p>
                        <p class="mb-2">{{$cf['address'] ?? ''}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mt-4 mt-lg-0">
            <form method="post" action="{{admFormAction('Mtwstsqf0sLQccF')}}" class="row">
                @csrf
                <div class="col-md-6">
                    <input type="text" class="form-control mb-4" placeholder="Name" name="name" id="name">
                </div>
                <div class="col-md-6">
                    <input type="email" class="form-control mb-4" placeholder="Email" name="email" id="email">
                </div>
                <div class="col-12">
                    <input type="text" class="form-control mb-4" placeholder="Subject" name="subject" id="subject">
                </div>
                <div class="col-12">
                    <textarea name="message" id="message" class="form-control mb-4" placeholder="Type You Message Here" rows="5"></textarea>
                </div>
                <div class="col-12">
                    <button class="btn btn-outline-primary" type="submit">Send Message</button>
                </div>
            </form>
        </div>
    </div>
@endsection
