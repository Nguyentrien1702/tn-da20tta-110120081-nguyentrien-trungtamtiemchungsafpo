<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <style>
        .dataTable-table tr th, td {
            vertical-align: middle !important;
            text-align: center !important;
            border: 1px solid grey !important;
            padding: 5px 5px !important;
        }
        .dataTable-table tr th {
            background-color: gainsboro;
            font-size: 16px;
        }
        .td_col5{
            font-weight: bold;
        }
        #ct_vaccine tr:nth-child(even) {
            background-color: #f2f2f2; /* Màu nền cho các dòng chẵn */
        }

        #ct_vaccine tr:nth-child(odd) {
            background-color: #ffffff; /* Màu nền cho các dòng lẻ */
        }
        #tengoi_ct{
            font-weight: bold;
            background:linear-gradient(90deg, #052065 44.77%, #0780CB 100%);
            color: #FBA307;
            padding: 15px 15px 15px 15px;
            margin-top: 0px;
            border-radius:7px;
        }s
    </style>
</head>
<body>
@include("menu/header")
<link rel="stylesheet" href="{{ asset('css/khachhang/lichsu.css') }}">

<div id="quytrinhchuancuasafpo" class="content-body">
    <section class="body row">
        <section class="content_left col-md-9 mt-2">
        <h4 style="padding: 0px; margin: 0px; color: blue">DANH SÁCH GÓI VACCINE</h4>
        <hr style="border-width: 2px !important;" class="mb-3">
            <div class="mt-3" >
                @if ($goivcs->isEmpty())
                    Không có thông tin!
                @else
                    @foreach($goivcs as $goivc)
                        @php
                        $i = 1;
                        @endphp
                    <h4 id="tengoi_ct" class="mb-3 mt-5" style="text-align: center !important;">{{ $goivc->tengoi }}</h4>
                    <table id="ct_vaccine" class="dataTable-table" style="width: 95%; margin: auto">
                        <thead>
                            <th>STT</th>
                            <th>Phòng bệnh</th>
                            <th>Tên vaccine</th>
                            <th>Nước sx</th>
                            <th>Số mũi theo phác đồ</th>
                            <th>Số mũi theo gói</th>
                        </thead>
                        <tbody>
                            @foreach($dsgoivaccines as $dsgoivaccine)
                                @if ($goivc->magoi == $dsgoivaccine->magoi)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{ $dsgoivaccine->tenbenh }}</td>
                                    <td>{{ $dsgoivaccine->tenvc }}</td>
                                    <td>{{ $dsgoivaccine->nuocsx }}</td>
                                    <td>{{ $dsgoivaccine->solieu }}</td>
                                    <td>{{ $dsgoivaccine->soluongmuitiem }}</td>  
                                </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td colspan="5" class="td_col5">Tổng số liều</td>
                                <td>{{ $goivc->soluongmuitiem}}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td_col5">Giá gói</td>
                                <td>{{ number_format($goivc->tonggiatien, 0, ',', '.')}} VNĐ</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td_col5">Giá gói ưu đãi</td>
                                <td>{{ number_format($goivc->tonggiatien * (1 - ($goivc->uudai/100)), 0, ',', '.')}} VNĐ</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="td_col5">Số tiền ưu đãi ({{$goivc->uudai}}%)</td>
                                <td>{{number_format($goivc->tonggiatien * ($goivc->uudai/100), 0, ',', '.')}} VNĐ</td>
                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                @endif
            </div>
            <!-- Liên kết phân trang -->
            <div class="d-flex justify-content-center mt-4">
                {{ $goivcs->links('vendor.pagination.bootstrap-4') }}
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
