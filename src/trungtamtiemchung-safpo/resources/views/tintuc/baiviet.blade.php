<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quy trình chuẩn của Safpo</title>
    <style>
        h1{
            font-size: 24px !important;
            font-weight: bold;
        }
        h2{
            font-size: 18px  !important;
            margin-bottom: 15px !important;
        }
        h3{
            font-size: 17px  !important;
        }
        h4{
            font-size: 16px !important;
        }
        h5{
            font-size: 15px !important;
        }
        h6{
            font-size: 14px !important;
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
                <a href="">Tin tức</a>
                >
                <a href="">{{ $post->tenbaiviet }}</a>
            </div>
            <section class="title">
            <hr>

            </section>
                <h1 class="mt-3 mb-4">{{ $post->tenbaiviet }}</h1>
                <div class="mt-3">{!! $post->noidungbaiviet !!}</div>
                <p class="mt-3 text-right"><i>Ngày đăng tải: {{ $post->ngaydangtai }}</i></p>
        </section>
        <section class="content_right col-md-3">
            @include("menu/hienthibaiviet")
        </section>
    </section>
</div>

@include("menu/footer")
</body>
</html>
