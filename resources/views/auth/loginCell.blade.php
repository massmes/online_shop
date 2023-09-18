@extends('home.layouts.home')

@section('title')
    صفحه ورود
@endsection

@section('script')
    <script>
        let loginToken;

        $('#checkOTPForm').hide();

        $('#resendOTPButton').hide();

        $('#loginForm').submit(function (event) {
            event.preventDefault();

            $.post("{{route('login.cellphone')}}", {

                '_token': "{{csrf_token()}}",
                'cellphone': $('#cellphoneInput').val(),

            }, function (response, status) {

                console.log(response, status);

                loginToken = response.login_token;
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'رمز یکبار مصرف ارسال گردید',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    showCloseButton: true,
                });

                $('#loginForm').fadeOut();
                $('#checkOTPForm').fadeIn();
                timer();

            }).fail(function (response) {

                console.log(response.responseJSON);

                $('#cellphoneInputError').fadeIn();
                $('#cellphoneInputErrorText').html(response.responseJSON.errors.cellphone[0]);

            });

        });

        $('#checkOTPForm').submit(function (event) {
            event.preventDefault();

            $.post("{{route('user.check.otp')}}", {
                '_token': "{{csrf_token()}}",
                'otp': $('#checkOTPInput').val(),
                'login_token': loginToken,

            }, function (response, status) {

                console.log(response, status);

                $(location).attr('href', "{{route('home.index')}}");

            }).fail(function (response) {

                console.log(response.responseJSON);

                $('#checkOTPInputError').fadeIn();
                $('#checkOTPInputErrorText').html(response.responseJSON.errors.otp[0]);

            });

        });


        $('#resendOTPButton').click(function (event) {
            event.preventDefault();

            $.post("{{route('user.resend.otp')}}", {

                '_token': "{{csrf_token()}}",
                'login_token': loginToken,

            }, function (response, status) {

                console.log(response, status);

                loginToken = response.login_token;

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'رمز یکبار مصرف ارسال گردید',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    showCloseButton: true,
                });

                $('#resendOTPButton').fadeOut();
                timer();
                $('#resendOTPTimer').fadeIn();

            }).fail(function (response) {

                console.log(response.responseJSON);

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'مشکل در ارسال مجدد رمز - مجددا تلاش کنید',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    showCloseButton: true,
                });

            });

        });


        function timer() {
            let time = "2:00";
            let interval = setInterval(function () {
                let countdown = time.split(':');
                let minutes = parseInt(countdown[0], 10);
                let seconds = parseInt(countdown[1], 10);
                --seconds;
                minutes = (seconds < 0) ? --minutes : minutes;
                if (minutes < 0) {
                    clearInterval(interval);
                    $('#resendOTPTimer').hide();
                    $('#resendOTPButton').fadeIn();
                }
                ;
                seconds = (seconds < 0) ? 59 : seconds;
                seconds = (seconds < 10) ? '0' + seconds : seconds;

                $('#resendOTPTimer').html(minutes + ':' + seconds);
                time = minutes + ':' + seconds;
            }, 1000);
        }

    </script>
@endsection

@section('content')

    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> ورود</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="login-register-area pt-100 pb-100" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4> ورود </h4>
                            </a>
                        </div>
                        <div class="tab-content">

                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">

                                        <form id="loginForm">
                                            <input id="cellphoneInput" placeholder="شماره تلفن همراه" type="text">

                                            <div id="cellphoneInputError" class="input-error-validation mb-3">
                                                <strong id="cellphoneInputErrorText"></strong>
                                            </div>

                                            <div class="button-box d-flex justify-content-between">
                                                <button type="submit">ارسال</button>
                                            </div>
                                        </form>

                                        <form id="checkOTPForm">
                                            <input id="checkOTPInput" placeholder="لطفا رمز ارسال شده را وارد کنید..."
                                                   type="text">

                                            <div id="checkOTPInputError" class="input-error-validation mb-3">
                                                <strong id="checkOTPInputErrorText"></strong>
                                            </div>

                                            <div class="button-box d-flex justify-content-between">
                                                <button type="submit">ورود</button>
                                                <div>
                                                    <button id="resendOTPButton" type="submit">ارسال مجدد</button>
                                                    <span id="resendOTPTimer"></span>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
