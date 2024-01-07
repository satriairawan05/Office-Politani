<!-- Warning Section Ends -->
<!-- Required Jquery -->
<script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.min.js') }} "></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js') }} "></script>
<script type="text/javascript" src="{{ asset('assets/js/popper.js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap/js/bootstrap.min.js') }} "></script>
<!-- waves js -->
<script src="{{ asset('assets/pages/waves/js/waves.min.js') }}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('assets/js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/common-pages.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#togglePassword i').click(function(event) {
            event.preventDefault();
            const passwordInput = $('#passwordInput');
            const togglePassword = $('#togglePassword i');

            if (passwordInput.attr('type') === 'text') {
                passwordInput.attr('type', 'password');
                togglePassword.removeClass('fa-eye-slash').addClass('fa-eye');
            } else if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                togglePassword.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
    });
</script>
</body>

</html>
