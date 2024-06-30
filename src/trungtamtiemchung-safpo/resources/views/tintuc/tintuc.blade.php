    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tin tức</title>
        <style>
            #tintuc{
                background-color: blue !important;
            }
            #tintuc a{
                color: white !important;
            }
        </style>
    </head>
    <body>
    @include("menu/header")
    <link rel="stylesheet" href="{{ asset('css/khachhang/lichsu.css') }}">

    <div id="chinhsachbaomat" class="content-body" style="width: 80%;">
        <section class="body" >
            <h4 style="padding: 0px; margin: 0px;">Tin tức</h4>
            <hr style="border-width: 2px !important;" class="mb-3">
            
            @foreach ($dsbaiviets as $baiviet)
                <div class="baiviet mb-3 d-flex">
                <a href="{{ url('/post', $baiviet->mabaiviet) }}">
                    <div style="padding: 0px; margin: 0px;">
                        <img src="{{ asset($baiviet->hinhanhminhhoa) }}" alt="" style="width: 300px; height: 200px;">
                    </div>
                    <div style="padding: 0px; margin: 0px;" class="ml-3">
                        <h5 style="color:black; margin:0px">{{ $baiviet->tenbaiviet }}</h5>
                </a>
                        <p style="font-size: 13px; margin: 0px">({{ \Carbon\Carbon::parse( $baiviet->ngaydangtai )->format('d/m/Y') }})</p>
                        <p style="font-size: 15px;">{{ $baiviet->motabaiviet }}</p>
                    </div>
                </div>
            @endforeach
            
    </div>
    <!-- Liên kết phân trang -->
    <div class="d-flex justify-content-center mt-4">
        {{ $dsbaiviets->links('vendor.pagination.bootstrap-4') }}
    </div>

    @include("menu/footer")
    </body>
    </html>
