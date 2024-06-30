<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <style>
        #lienhe{
            background-color: blue !important;
        }
        #lienhe a{
            color: white !important;
        }
    </style>
</head>
<body>
@include("menu/header")
<link rel="stylesheet" href="{{ asset('css/khachhang/lichsu.css') }}">

<div id="quytrinhchuancuasafpo" class="content-body">
    <section class="body row">
        <section class="content_left col-md-9">
            <div>
                <b>Liên hệ</b>
            </div>
            <section class="title">
                <hr>
                <h1>Thông tin liên hệ</h1>
            </section>
            <div class="container mt-4">
                <b>CÔNG TY TNHH AMV DỊCH VỤ Y TẾ </b><br>
                <b>PHÒNG TIÊM CHỦNG SAFPO 43 - TRÀ VINH</b>
                <i>
                    <p>Địa chỉ: Số 79, đường Lý Tự Trọng, phường 4, thành phố Trà Vinh, tỉnh Trà Vinh</p>
                    <p>Điện thoại: 0294 650 8508 </p>
                    <p>Email: dichvuyte@amv.vn</p>
                </i>
            </div>
        </section>
        <section class="content_right col-md-3">
            @include("menu/hienthibaiviet")
        </section>
    </section>
</div>

@include("menu/footer")
</body>
</html>
