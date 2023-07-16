<!-- # JS Plugins -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/bootstrap.min.js')}}"></script>

<!-- Main Script -->
<script src="{{asset('assets/js/script.js')}}"></script>

@stack('footer-code')

{!! $site['customFooterCode'] !!}
