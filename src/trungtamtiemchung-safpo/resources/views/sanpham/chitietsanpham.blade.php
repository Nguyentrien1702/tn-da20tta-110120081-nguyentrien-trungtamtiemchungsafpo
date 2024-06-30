<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trẻ nhỏ</title>
</head>
<body>
@include("menu/header")
<link rel="stylesheet" href="{{ asset('css/khachhang/lichsu.css') }}">

<div id="quytrinhchuancuasafpo" class="content-body">
    <section class="body row">
        <section class="content_left col-md-9">
        <div>
            <a href="">Sản phẩm</a>
            >
            <a href="">Vaccine{{ $ctvaccine->tenvc }}</a>
        </div>
        <hr style="border-width: 2px !important;" class="mb-3">
        <h3 class="mt-3 mb-4" style="font-weight: bold; color: blue">{{ $ctvaccine->tenvc }}: {{ $ctvaccine->tenbenh }}</h3>
        <div class="mt-3">{!! $ctvaccine->thongtinvc !!}</div>
        </section>
        <section class="content_right col-md-3">
            @include("menu/hienthibaiviet")
        </section>
    </section>
</div>

@include("menu/footer")
</body>
</html>
