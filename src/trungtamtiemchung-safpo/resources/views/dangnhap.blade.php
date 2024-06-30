<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Đăng Nhập</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 400px;
        }
        .hidden {
            display: none;
        }
        .center-choice {
            margin-bottom: 20px;
        }
        h2{
            font-weight: bold;
            text-transform: uppercase;
            color: blue;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div id="loginForm">
            <h2 class="text-center mb-4">Đăng Nhập</h2>
            @if(session('success'))
                <script>
                    alert("{{ session('success') }}");
                </script>
            @endif
            <ul class="nav nav-tabs" id="loginTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="true">Tài khoản</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="phone-tab" data-toggle="tab" href="#phone" role="tab" aria-controls="phone" aria-selected="false">Số điện thoại</a>
                </li>
            </ul>
            <div class="tab-content" id="loginTabContent">
                <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <form method="POST" action="/dangnhaptk">
                    @csrf
                        <div class="form-group mt-3">
                            <label for="madangnhap">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="madangnhap" name="txtmadangnhap" placeholder="Tên đăng nhập">
                        </div>
                        <div class="form-group">
                            <label for="matkhau">Mật khẩu</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="matkhau" name="txtmatkhau" placeholder="Mật khẩu">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                            <div class="alert alert-danger" role="alert" id="thongbao">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <a href="#" class="float-right">Quên mật khẩu?</a>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
                        <button type="button" class="btn btn-secondary btn-block" id="cancelAccountBtn">Hủy</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="phone" role="tabpanel" aria-labelledby="phone-tab">
                    <form id="phoneForm">
                    @csrf
                        <div class="form-group mt-3">
                            <label for="phoneNumber">Số điện thoại</label>
                            <input type="text" class="form-control" id="phoneNumber" placeholder="Số điện thoại" maxlength="10" pattern="[0-9]{10}">
                        </div>
                        <button type="button" class="btn btn-primary btn-block" id="sendCodeBtn">Gửi mã</button>
                        <div id="verificationSection" class="hidden">
                            <div class="form-group mt-3">
                                <label for="verificationCode">Mã xác minh</label>
                                <input type="text" class="form-control" id="verificationCode" placeholder="Mã xác minh">
                            </div>
                            <a href="#" class="btn btn-link btn-block hidden" id="resendCodeLink">Gửi lại mã</a>
                            <button type="submit" class="btn btn-primary btn-block">Xác nhận</button>
                        </div>
                        <button type="button" class="btn btn-secondary btn-block mt-3" id="cancelPhoneBtn">Hủy</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
    <script>
        $(document).ready(function(){
            $('#togglePassword').click(function(){
                var passwordField = $('#matkhau');
                var passwordFieldType = passwordField.attr('type');
                if(passwordFieldType == 'password'){
                    passwordField.attr('type', 'text');
                    $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            $('#phoneNumber').on('input', function(){
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href");

                if(target === "#account") {
                    $('#phoneNumber').val('');
                    $('#verificationCode').val('');
                    $('#verificationSection').hide();
                    $('#sendCodeBtn').show();
                    $('#resendCodeLink').hide();
                } else if(target === "#phone") {
                    $('#accountUsername').val('');
                    $('#accountPassword').val('');
                }
            });

            $('#sendCodeBtn').click(function(){
                var phoneNumber = $('#phoneNumber').val();
                if(phoneNumber.length === 10){
                    $('#verificationSection').show();
                    $('#sendCodeBtn').hide();
                    $('#resendCodeLink').show();
                } else {
                    alert('Vui lòng nhập số điện thoại hợp lệ.');
                }
            });

            $('#resendCodeLink').click(function(e){
                e.preventDefault();
                alert('Mã xác minh đã được gửi lại.');
            });

            $('#cancelAccountBtn').click(function(){
                $('#accountUsername').val('');
                $('#accountPassword').val('');
                window.location.href = '/';
            });

            $('#cancelPhoneBtn').click(function(){
                $('#phoneNumber').val('');
                $('#verificationCode').val('');
                $('#verificationSection').hide();
                $('#sendCodeBtn').show();
                $('#resendCodeLink').hide();
                window.location.href = '/';
            });
        });

        var madangnhapInput = document.getElementById('madangnhap');
        var matkhauInput = document.getElementById('matkhau');
        var errorAlert = document.getElementById('thongbao');

        madangnhapInput.addEventListener('focus', function() {
                errorAlert.style.display = 'none';
        });

        matkhauInput.addEventListener('focus', function() {
                errorAlert.style.display = 'none';
        });
    </script>
</body>
</html>
