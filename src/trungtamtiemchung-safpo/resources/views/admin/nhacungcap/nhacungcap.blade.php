<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhà cung cấp</title>
    <style>

        h2{
            text-align: center;
            color: blue;
            font-weight: bold !important;
        }
        .dataTable-table tr th, td{
            vertical-align: middle !important;
            text-align: center !important;
            border: 1px solid grey !important;
            padding: 5px 5px !important;
        }
        .dataTable-table tr th{
            background-color: gainsboro;
            font-size: 16px;
        }
        label{
            font-weight: bold;
        }
        .edit-post{
            margin-bottom: 2px;
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
    <button class="btn btn-primary mb-3" id="btn-themncc" data-bs-toggle="modal" data-bs-target="#Modalncc">Thêm nhà cung cấp</button>
    <!-- The Modal -->
    <div class="modal" id="Modalncc" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-primary" style="font-weight: bold;">THÊM NHÀ CUNG CẤP</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="nccform" method="POST" action="/Admin/themncc" enctype="multipart/form-data" class="was-validated">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" id="mancc" name="mancc" style="display: none;">
                    <div class="form-group mb-3">
                        <label for="tenncc">Tên nhà cung cấp:</label>
                        <input type="text" class="form-control" id="tenncc" name="tenncc" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="sdtncc">Số điện thoại nhà cung cấp:</label>
                        <input type="text" class="form-control" id="sdtncc" name="sdtncc" required maxlength="11" pattern="[0-9]{10}">
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="emailncc">Email nhà cung cấp:</label>
                        <input type="text" class="form-control" id="emailncc" name="emailncc" required>
                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="diachincc">Địa chỉ nhà cung cấp:</label>
                        <input type="text" class="form-control" id="diachincc" name="diachincc" required>
                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Thêm</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <h2 class="text-primary">DANH SÁCH NHÀ CUNG CẤP</h2>
    <table id="tablencc" class="dataTable-table" style="width: 100%; ">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên nhà cung cấp</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th id="tt">Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @if ($nhacungcaps->isEmpty())
                <tr>
                    <td colspan="6" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                </tr>
            @else
                @php
                    $i = 1; 
                @endphp
                @foreach($nhacungcaps as $nhacungcap)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ $nhacungcap->tenncc }}</td>
                        <td>{{ $nhacungcap->sdtncc }}</td>
                        <td>{{ $nhacungcap->emailncc }}</td>
                        <td>{{ $nhacungcap->diachincc }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm edit-post " data-bs-toggle="modal" data-bs-target="#Modalncc" data-ma="{{ $nhacungcap->mancc }}" data-ten="{{ $nhacungcap->tenncc }}" data-sdt="{{ $nhacungcap->sdtncc }}" data-email="{{ $nhacungcap->emailncc }}" data-diachi="{{ $nhacungcap->diachincc }}">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            @php
                                $nhacungcapInVaccine = DB::table('vaccine')->where('mancc', $nhacungcap->mancc)->exists();
                            @endphp
                            @if (!$nhacungcapInVaccine)
                                <a href="{{ url('/Admin/xoanhacungcap', $nhacungcap->mancc) }}" onclick="return confirm('Bạn có chắc muốn xóa không!')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</div>

@include("admin/footer_admin")
<script>
    document.getElementById('sdtncc').addEventListener('input', function (e) {
        // Loại bỏ mọi ký tự không phải số
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    document.addEventListener('DOMContentLoaded', function() {
        var myTable = document.querySelector("#tablencc");
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

        // Xử lý sự kiện khi nhấn nút sửa
        document.querySelectorAll('.edit-post').forEach(function (button) {
            button.addEventListener('click', function () {
                // Lấy dữ liệu từ nút Sửa
                var mancc = this.getAttribute('data-ma');
                var tenncc = this.getAttribute('data-ten');
                var sdtncc = this.getAttribute('data-sdt');
                var emailncc = this.getAttribute('data-email');
                var diachincc = this.getAttribute('data-diachi');
                
                // Điền dữ liệu vào các trường trong modal
                document.getElementById('mancc').value = mancc;
                document.getElementById('tenncc').value = tenncc;
                document.getElementById('sdtncc').value = sdtncc;
                document.getElementById('emailncc').value = emailncc;
                document.getElementById('diachincc').value = diachincc;

                // Đổi nút Thêm thành nút Cập nhật
                document.querySelector('.modal-title').innerText = 'CẬP NHẬT NHÀ CUNG CẤP';
                document.querySelector('.modal-footer .btn-primary').innerText = 'Cập nhật';
            });
        });
        // Khi mở modal thêm mới, đổi lại các thuộc tính
        document.getElementById('btn-themncc').addEventListener('click', function () {
            document.querySelector('.modal-title').innerText = 'THÊM NHÀ CUNG CẤP';
            document.querySelector('.modal-footer .btn-primary').innerText = 'Thêm';
            document.getElementById('mancc').value = '';
            document.getElementById('tenncc').value = '';
            document.getElementById('sdtncc').value = '';
            document.getElementById('emailncc').value = '';
            document.getElementById('diachincc').value = '';
        });
    });
</script>
</body>
</html>