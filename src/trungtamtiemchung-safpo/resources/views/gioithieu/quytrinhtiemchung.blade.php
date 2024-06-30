<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quy trình chuẩn của Safpo</title>
    <style>
        #gioithieu{
            background-color: blue !important;
        }
        #gioithieu a{
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
            <a href="">Giới thiệu</a>
            >
            <a href="{{ url('/Gioi-thieu/Quy-trinh-tiem-chung') }}">Quy trình chuẩn của Safpo</a>
        </div>
        <section class="title">
        <hr>

        </section>
            <img src="{{ asset('images/quytrinhtiemchung.png') }}" alt="Quy-trinh-tiem-chung">
        </section>
        <section class="content_right col-md-3">
            @include("menu/hienthibaiviet")
        </section>
    </section>
</div>

@include("menu/footer")
</body>
</html>
