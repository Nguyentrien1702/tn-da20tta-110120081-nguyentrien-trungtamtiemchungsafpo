<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách lịch tiêm</title>
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
@include("nhanvien/header_nv")

<div class="mb-5" style="width: 100%; margin: auto">
@if(session('success'))
    <div id="success" class="alert alert-success">{{ session('success') }}</div>
    <script>
        var dangtc = document.getElementById("success");
        setTimeout(function () {
                // Ẩn thông báo sau 2 giây
                dangtc.style.display = 'none';
            }, 3000);
    </script>
@endif
<div id="lichhen">
    <h2 class="text-primary">DANH SÁCH LỊCH HẸN TIÊM VACCINE</h2>
    <table id="tablexnlichhen" class="dataTable-table" style="width: 100%; ">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã khách hàng</th>
                <th>Ngày tiêm dự kiến</th>
                <th>Số lượng vaccine</th>
                <th>Danh sách vaccine</th>
                <th>Trạng thái đăng ký</th>
                <th>Trạng thái tiêm</th>
                <th id="tt">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @if ($tatcalichtiems->isEmpty())
                <tr>
                    <td colspan="8" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                </tr>
            @else
                @php
                    $i = 1; 
                @endphp
                @foreach($tatcalichtiems as $tatcalichtiem)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ $tatcalichtiem->makh }}</td>
                        <td>{{ \Carbon\Carbon::parse( $tatcalichtiem->ngaytiemdukien )->format('d/m/Y') }}</td>
                        <td>{{ $tatcalichtiem->soluongvc }}</td>
                        <td>{{ $tatcalichtiem->ds_tenvaccine }}</td>
                        <td>{{ $tatcalichtiem->trangthaidk }}</td>
                        <td>{{ $tatcalichtiem->trangthaitiem }}</td>
                        <td>
                            <a href="#"><i>Chi tiết</i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

</div>

@include("nhanvien/footer_nv")
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeDataTable('tablexnlichhen');
    });

    function initializeDataTable(tableId) {
        var myTable = document.getElementById(tableId);
        if (myTable) {
            var dataTable = new simpleDatatables.DataTable(myTable, {
                labels: {
                    placeholder: "Tìm kiếm...",
                    perPage: " mục mỗi trang",
                    noRows: "Không có dữ liệu",
                    info: "Hiển thị {start} đến {end} của {rows} mục",
                    previous: "Trước",
                    next: "Tiếp",
                    noResults: "Không có kết quả nào khớp với tìm kiếm của bạn",
                },
                perPageSelect: [5, 10, 15, 20],
            });
        }
    }
</script>
</body>
</html>
