<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOGAN | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <main class="vh-100">
        <div class="container">
            <section class="section register d-flex flex-column align-items-center justify-content-center py-4 vh-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <p class="logo d-flex align-items-center w-auto">
                                    <span class="">LOGAN</span>
                                </p>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <h5 class="card-title text-center pb-0 fs-4">Login ke Akun</h5>
                                        <p class="text-center small">Masukkan username & password untuk login</p>
                                    </div>
                                    <form action="" method="post" class="row g-3 needs-validation login_form" novalidate>
                                        @csrf
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group">
                                                <input type="text" name="username" class="form-control" id="yourUsername" required>
                                            </div>
                                            <span class="text-danger error-text username_error"></span>
                                        </div>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                                            <span class="text-danger error-text password_error"></span>
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" value="" id="show-password" autocomplete="off">
                                                <label class="form-check-label" for="show-password">
                                                    Show Password
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12"> <button class="btn btn-primary w-100" type="submit">Login</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    {{-- Javascript Bundle with Popper --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#show-password').on('click', function() {
                var passInput = $("#yourPassword");
                if (passInput.attr('type') === 'password') {
                    passInput.attr('type', 'text');
                } else {
                    passInput.attr('type', 'password');
                }
            })

            $(".login_form").on('submit', function(e) {
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                        $('[class*="error"]').removeClass('error');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                                $('[name="' + prefix + '"]').addClass('error');
                            });
                        } else {
                            window.location.href = '{{ Session::put('previous_url') }}';
                        }
                    }
                });
            });
        })
    </script>
</body>

</html>
