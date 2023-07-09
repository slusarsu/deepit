<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@includeIf('parts.head-scripts')

<body>

@includeIf('parts.header')

<main>
    <section class="section">
        <div class="container">
            @if(!empty($sidebar))
            <div class="row no-gutters-lg">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    @yield('content')
                </div>
                <div class="col-lg-4">
                    @includeIf('parts.sidebar')
                </div>
            </div>
            @endif

            @empty($sidebar)
                <div class="row no-gutters-lg">
                    @yield('content')
                </div>
            @endempty
        </div>
    </section>
</main>

@includeIf('parts.footer')

@includeIf('parts.footer-scripts')

</body>
</html>

