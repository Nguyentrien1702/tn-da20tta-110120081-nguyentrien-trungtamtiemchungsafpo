<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin khách hàng</title>
    <style>
        h2 {
            text-align: center;
            color: blue;
            font-weight: bold !important;
        }
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
    </style>
</head>
<body>
@include("menu/header")

<div id="quytrinhchuancuasafpo" class="content-body">
@if(session('success'))
    <div id="thanhcong" class="alert alert-success">{{ session('success') }}</div>
    <script>
        var dangtc = document.getElementById("thanhcong");
        setTimeout(function () {
                // Ẩn thông báo sau 2 giây
                dangtc.style.display = 'none';
            }, 5000);
    </script>
@endif
    <section class="body row">
        <section class="content_left col-md-9">
            <div>
                <a href="">Khách hàng</a>
                >
                <a href="">Lịch sử tiêm chủng</a>
            </div>
            <section class="title">
            <hr>
            </section>
            <h2 style="text-align: center; color: blue; font-weight: bold">LỊCH SỬ TIÊM CHỦNG</h2>
            <table id="tablelstiem" class="dataTable-table" style="width: 100%; ">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên vaccine</th>
                        <th>Mũi tiêm</th>
                        <th>Ngày tiêm dự kiến</th>
                        <th>Ngày tiêm thực tế</th>
                        <th>Trạng thái tiêm</th>
                        <th>Trạng thái đăng ký</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @if ($lstiems->isEmpty())
                        <tr>
                            <td colspan="6" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                        </tr>
                    @else
                        @php
                            $i = 1; 
                        @endphp
                        @foreach($lstiems as $lstiem)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $lstiem->tenvc }}</td>
                                <td>{{ $lstiem->muitiem }}</td>
                                <td>{{ \Carbon\Carbon::parse($lstiem->ngaytiemdukien)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($lstiem->ngaytiemthucte)
                                        {{  \Carbon\Carbon::parse($lstiem->ngaytiemthucte)->format('d/m/Y')  }}
                                    @endif
                                </td>
                                <td>{{ $lstiem->trangthaigoitiem }}</td>
                                <td>{{ $lstiem->trangthaidk }}</td>
                                <td><a href="#"><i>Chi tiết</i></a></td>                            
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </section>
        <section class="content_right col-md-3">
            @include("menu/hienthibaiviet")
        </section>
    </section>
</div>

@include("menu/footer")
</body>
</html>
