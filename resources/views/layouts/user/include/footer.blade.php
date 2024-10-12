<!-- footer section -->
<footer class="footer_section">
    <div class="container">
        <p>
            &copy; <span id="displayYear"></span> All Rights Reserved By
            <a href="{{ route('user.dashboard') }}">{{ $profile->village_name }}</a>
        </p>
    </div>
</footer>
<!-- footer section -->

<!-- jQery -->
<script src="{{ asset('template_user/js/jquery-3.4.1.min.js') }}"></script>
<!-- bootstrap js -->
<script src="{{ asset('template_user/js/bootstrap.js') }}"></script>
<!-- custom js -->
<script src="{{ asset('template_user/js/custom.js') }}"></script>
