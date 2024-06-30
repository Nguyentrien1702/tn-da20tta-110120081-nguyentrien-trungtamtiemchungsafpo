<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục nhân viên</title>
    <script src="{{ asset('backend/ckeditor_4.22.1_full_easyimage/ckeditor/ckeditor.js') }}"></script>
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
        label {
            font-weight: bold;
        }
        .edit-post {
            margin-bottom: 2px;
        }
        .modal-dialog{
            max-width: 60% !important;
        }
    </style>
</head>
<body>
@include("admin/header_admin")

<div class="mb-5" style="width: 100%; margin: auto">
@if(session('success'))
    <div id="dangthanhcong" class="alert alert-success">{{ session('success') }}</div>
    <script>
        var dangtc = document.getElementById("dangthanhcong");
        setTimeout(function () {
                // Ẩn thông báo sau 2 giây
                dangtc.style.display = 'none';
            }, 5000);
    </script>
@endif

    <h2 class="text-primary">DANH SÁCH TÀI KHOẢN NHÂN VIÊN</h2>
    <table id="tablenhanvien" class="dataTable-table" style="width: 100%; ">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã nhân viên</th>
                <th>Tên nhân viên</th>
                <th>Mật khẩu</th>
                <th id="tt">Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @if ($nhanviens->isEmpty())
                <tr>
                    <td colspan="5" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                </tr>
            @else
                @php
                    $i = 1; 
                @endphp
                @foreach($nhanviens as $nhanvien)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ $nhanvien->manv }}</td>
                        <td>{{ $nhanvien->tennv }}</td>
                        <td>{{ $nhanvien->matkhau }}</td>
                        <td>
                            <a href="{{ url('/Admin/resetmk', $nhanvien->manv) }}" onclick="return confirm('Bạn có chắc muốn reset mật khẩu không!')" class="btn btn-danger btn-sm">
                                <i class="fas fa-sync-alt"></i> Reset mật khẩu
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</div>

@include("admin/footer_admin")
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myTable = document.querySelector("#tablenhanvien");
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
