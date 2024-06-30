<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trẻ sơ sinh</title>
    <style>
        #lichtiemchung{
            background-color: blue !important;
        }
        #lichtiemchung a{
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
                <a href="">Lịch tiêm chủng</a>
                >
                <a href="{{ url('/Gioi-thieu/Quy-trinh-tiem-chung') }}">Trẻ sơ sinh từ 24 giờ - 18 tháng</a>
            </div>
            <section class="title">
                <hr>
                <h1>Lịch tiêm chủng trẻ sơ sinh từ 24 giờ - 18 tháng</h1>
            </section>
            <div class="container mt-4">
                <img src="{{ asset('images/lichtiemchung/tresosinh.png') }}" alt="Biểu đồ tiêm chủng">
                <img src="{{ asset('images/lichtiemchung/tresosinh2.png') }}" alt="Danh sách bệnh">
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
