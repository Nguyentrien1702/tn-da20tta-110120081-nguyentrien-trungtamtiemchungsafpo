<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch tiêm chờ xác nhận</title>
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
@include("admin/header_admin")

<div class="mb-5" style="width: 100%; margin: auto">
<ul class="nav nav-tabs" id="loginTab" role="tablist" style="font-weight: bold;">
    <li class="nav-item">
        <a class="nav-link active" id="vcle-tab" data-toggle="tab" href="#vcle" role="tab" aria-controls="vcle" aria-selected="true">Vaccine lẻ</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="vcgoi-tab" data-toggle="tab" href="#vcgoi" role="tab" aria-controls="vcgoi" aria-selected="false">Gói vaccine</a>
    </li>
</ul>
<div class="tab-content" id="loginTabContent">
    <div class="tab-pane fade show active" id="vcle" role="tabpanel" aria-labelledby="vcle-tab">
        <h2 class="text-primary">DANH SÁCH VACCINE ĐÃ ĐĂNG KÝ</h2>
        <table id="tablexnlichtiem" class="dataTable-table" style="width: 100%; ">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên người tiêm</th>
                    <th>Ngày sinh</th>
                    <th>Số điện thoại</th>
                    <th>Tên vaccine</th>
                    <th>Ngày tiêm mong muốn</th>
                    <th id="tt">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($vcles->isEmpty())
                    <tr>
                        <td colspan="7" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                    </tr>
                @else
                    @php
                        $i = 1; 
                    @endphp
                    @foreach($vcles as $vcle)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $vcle->tenkh }}</td>
                            <td>{{ \Carbon\Carbon::parse( $vcle->ngaysinhkh )->format('d/m/Y') }}</td>
                            <td>{{ $vcle->sdtkh }}</td>
                            <td>{{ $vcle->tenvc }}</td>
                            <td>{{ $vcle->ngaytiemmongmuon }}</td>
                            <td>
                                <a href="" onclick="return confirm('Xác nhận hủy đăng ký!')" class="btn btn-primary btn-sm">
                                    <i class="fas fa-check"></i> Hủy đăng ký
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="vcgoi" role="tabpanel" aria-labelledby="vcgoi-tab">
    <h2 class="text-primary">DANH SÁCH GÓI VACCINE ĐÃ ĐĂNG KÝ</h2>
        <table id="tablexnlichtiem" class="dataTable-table" style="width: 100%; ">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên người tiêm</th>
                    <th>Ngày sinh</th>
                    <th>Số điện thoại</th>
                    <th>Tên gói</th>
                    <th>Số liều vc</th>
                    <th>Ngày tiêm mong muốn</th>
                    <th id="tt">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            @if ($vcgois->isEmpty())
                    <tr>
                        <td colspan="7" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                    </tr>
                @else
                    @php
                        $i = 1; 
                    @endphp
                    @foreach($vcgois as $vcgoi)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $vcgoi->tenkh }}</td>
                            <td>{{ \Carbon\Carbon::parse( $vcgoi->ngaysinhkh )->format('d/m/Y') }}</td>
                            <td>{{ $vcgoi->sdtkh }}</td>
                            <td>{{ $vcgoi->tengoi }}</td>
                            <td>{{ $vcgoi->soluongmuitiem }}</td>
                            <td>{{ \Carbon\Carbon::parse( $vcgoi->ngaytiemmongmuon )->format('d/m/Y') }}</td>
                            <td>
                                <a href="" onclick="return confirm('Xác nhận hủy đăng ký!')" class="btn btn-primary btn-sm">
                                    <i class="fas fa-check"></i> Hủy đăng ký
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

</div>

@include("admin/footer_admin")
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myTable = document.querySelector("#tablexnlichtiem");
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
    });
</script>
</body>
</html>
