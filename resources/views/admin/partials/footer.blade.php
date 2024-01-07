    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/popper.js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap/js/bootstrap.min.js') }} "></script>
    <!-- waves js -->
    <script src="{{ asset('assets/pages/waves/js/waves.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- slimscroll js -->
    <script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>

    <!-- menu js -->
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('assets/js/vertical/vertical-layout.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>

    @stack('js')

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/sweetalert2/sweetalert2.min.js') }}"></script>
    @if (session('success'))
        <script type="text/javascript">
            let timerInterval;
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                timer: 5000,
                icon: 'success',
                timerProgressBar: true,
                confirmButtonText: 'Oke',
                didOpen: () => {
                    timerInterval = setInterval(() => {}, 100)
                },
                willClose: () => {
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                }
            });
        </script>
    @endif
    @if (session('failed'))
        <script type="text/javascript">
            let timerInterval;
            Swal.fire({
                title: "Fail!",
                text: "{{ session('failed') }}",
                timer: 500000,
                icon: 'error',
                timerProgressBar: true,
                confirmButtonText: 'Oke',
                didOpen: () => {
                    timerInterval = setInterval(() => {}, 100)
                },
                willClose: () => {
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                }
            });
        </script>
    @endif
    </body>

    </html>
