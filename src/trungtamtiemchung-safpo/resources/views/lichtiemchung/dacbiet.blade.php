<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhóm đặc biệt</title>
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
                <a href="">Nhóm đặc biệt</a>
            </div>
            <section class="title">
                <hr>
                <h1>Lịch tiêm chủng nhóm đặc biệt</h1>
            </section>
            <div class="container mt-4">
                <img src="{{ asset('images/lichtiemchung/dacbiet.png') }}" alt="Biểu đồ tiêm chủng">
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
