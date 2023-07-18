<div class="widget">
    <h2 class="section-title mb-3">Recommended</h2>
    <div class="widget-body">
        <div class="widget-list">
            @foreach(getPopularPosts() as $key => $post)
                @if($key == 0)
                    <article class="card mb-4" id="popular-post-{{$post->id}}">
                        <div class="card-image">
                            <div class="post-info">
                                <span class="text-uppercase">
                                    {{$post->getDate()}}
                                </span>
                            </div>

                            <img loading="lazy" decoding="async" src="{{$post->thumb() ?? admRandomImage()}}" alt="{{$post->title}}" class="w-100">

                        </div>

                        <div class="card-body px-0 pb-1">
                            <h3>
                                <a class="post-title post-title-sm" href="{{$post->link()}}">
                                    {{$post->title}}
                                </a>
                            </h3>
                            <p class="card-text">
                                {{$post->shortLimited()}}
                            </p>
                            <div class="content"> <a class="read-more-btn" href="{{$post->link()}}">Read Full Article</a>
                            </div>
                        </div>

                    </article>
                @endif

                <a class="media align-items-center" href="{{$post->link()}}" id="popular-post-{{$post->id}}">
                    <img loading="lazy" decoding="async" src="{{$post->thumb() ?? admRandomImage()}}" alt="{{$post->title}}" class="w-100">

                    <div class="media-body ml-3">
                        <h3 style="margin-top:-5px">{{$post->title}}</h3>
                        <p class="mb-0 small">
                            {{$post->shortLimited()}}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
