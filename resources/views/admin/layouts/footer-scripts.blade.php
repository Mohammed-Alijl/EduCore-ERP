<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
<script src="{{ URL::asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{ URL::asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Ionicons js -->
<script src="{{ URL::asset('assets/admin/plugins/ionicons/ionicons.js') }}"></script>
<!-- Moment js -->
<script src="{{ URL::asset('assets/admin/plugins/moment/moment.js') }}"></script>

<!-- Rating js-->
<script src="{{ URL::asset('assets/admin/plugins/rating/jquery.rating-stars.js') }}"></script>
<script src="{{ URL::asset('assets/admin/plugins/rating/jquery.barrating.js') }}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{ URL::asset('assets/admin/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ URL::asset('assets/admin/plugins/perfect-scrollbar/p-scroll.js') }}"></script>
<!--Internal Sparkline js -->
<script src="{{ URL::asset('assets/admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{ URL::asset('assets/admin/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<!-- right-sidebar js -->
<script src="{{ URL::asset('assets/admin/plugins/sidebar/sidebar-rtl.js') }}"></script>
<script src="{{ URL::asset('assets/admin/plugins/sidebar/sidebar-custom.js') }}"></script>
<!-- Eva-icons js -->
<script src="{{ URL::asset('assets/admin/js/eva-icons.min.js') }}"></script>
@yield('js')
<!-- Sticky js -->
<script src="{{ URL::asset('assets/admin/js/sticky.js') }}"></script>
<!-- custom js -->
<script src="{{ URL::asset('assets/admin/js/custom.js') }}"></script><!-- Left-menu js-->
<script src="{{ URL::asset('assets/admin/plugins/side-menu/sidemenu.js') }}"></script>

<!-- Theme Toggle Logic -->
<script>
    $(document).ready(function() {
        var body = $('body');
        var themeToggleBtn = $('#theme-toggle');
        var moonIcon = $('#theme-icon-moon');
        var sunIcon = $('#theme-icon-sun');

        var savedTheme = localStorage.getItem('valex-theme');

        if (savedTheme === 'dark' || document.documentElement.classList.contains('dark-theme')) {
            body.addClass('dark-theme');
            moonIcon.hide();
            sunIcon.show();
        } else {
            body.removeClass('dark-theme');
            sunIcon.hide();
            moonIcon.show();
        }

        themeToggleBtn.on('click', function(e) {
            e.preventDefault();
            if (body.hasClass('dark-theme')) {
                body.removeClass('dark-theme');
                document.documentElement.classList.remove('dark-theme');
                sunIcon.hide();
                moonIcon.show();
                localStorage.setItem('valex-theme', 'light');
            } else {
                body.addClass('dark-theme');
                document.documentElement.classList.add('dark-theme');
                moonIcon.hide();
                sunIcon.show();
                localStorage.setItem('valex-theme', 'dark');
            }
        });
    });
</script>
@stack('scripts')
