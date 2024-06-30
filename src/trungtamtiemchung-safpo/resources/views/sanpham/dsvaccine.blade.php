<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <style>
        #sanpham{
            background-color: blue;
        }
        #sanpham a{
            color: white !important;
        }
        .d-flex {
            display: flex;
        }
        .flex-column {
            flex-direction: column;
        }
        .align-items-center {
            align-items: center;
        }
        .mt-auto {
            margin-top: auto;
        }
        .product-item {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .product-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .product-item img {
            transition: transform 0.3s;
        }
        .product-item:hover img {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
@include("menu/header")
<link rel="stylesheet" href="{{ asset('css/khachhang/lichsu.css') }}">

<div id="quytrinhchuancuasafpo" class="content-body">
    <section class="body row">
        <section class="content_left col-md-9 mt-2">
        <h4 style="padding: 0px; margin: 0px; color: blue">DANH SÁCH SẢN PHẨM</h4>
        <hr style="border-width: 2px !important;" class="mb-3">
            <div class="row mt-3" >
                @if($vaccines)
                    @foreach ($vaccines as $vaccine)
                    @php
                        $index = 1;
                    @endphp
                        <div class="col-md-4 mt-3 d-flex flex-column align-items-center product-item" style="min-height: 260px;">
                            <a style="text-decoration: none;" href="{{ url('/ct-vaccine', $vaccine->mavc) }}">
                                <img style="width: 280px" src="{{ asset($vaccine->hinhanhvc) }}" alt="">
                                <div class="text-center">
                                    {{ $vaccine->tenvc }} ({{ $vaccine->nuocsx}})
                                    <p style="color: gray; line-height: 1;">{{ $vaccine->tenbenh }}</p>
                                </div>
                            </a>
                            <div class="mt-auto" style="width: 100%;">
                                <p style="text-align: right; color: blue;">Giá: {{ number_format($vaccine->gia, 0, ',', '.') }} VND</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- Liên kết phân trang -->
            <div class="d-flex justify-content-center mt-4">
                {{ $vaccines->links('vendor.pagination.bootstrap-4') }}
            </div>
        </section>
        <section class="content_right col-md-3 mt-2">
            @include("menu/hienthibaiviet")
        </section>
    </section>
</div>

@include("menu/footer")
</body>
</html>
