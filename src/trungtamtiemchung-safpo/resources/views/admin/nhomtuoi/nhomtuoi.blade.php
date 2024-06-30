<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục nhóm tuổi</title>
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
    <button class="btn btn-primary mb-3" id="btn-themnhomtuoi" data-bs-toggle="modal" data-bs-target="#Modalnhomtuoi">Thêm nhóm tuổi</button>
    <!-- The Modal -->
    <div class="modal" id="Modalnhomtuoi" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-primary" style="font-weight: bold;">THÊM NHÓM TUỔI</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="nhomtuoiform" method="POST" action="/Admin/themnhomtuoi" enctype="multipart/form-data" class="needs-validated">
            @csrf
            <!-- Modal body -->
            <div class="modal-body">
                <input type="text" id="manhomtuoi" name="manhomtuoi" style="display: none;">
                <div class="form-group mb-3">
                    <label for="doituong">Đối tượng:</label>
                    <input type="text" class="form-control" id="doituong" name="doituong" required>
                    <div class="valid-feedback"></div>
                    <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="tuoibatdau">Tuổi bắt đầu:</label>
                    <div class="d-flex">
                        <input type="number" class="form-control" id="tuoibatdau" name="tuoibatdau" min="0" max="1200">
                        <select class="form-control ms-2" id="donvitinhbatdau" name="donvitinhbatdau">
                            <option value="giờ">Giờ</option>
                            <option value="tuần">Tuần</option>  
                            <option value="tháng" selected>Tháng</option>
                            <option value="tuổi">Tuổi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="tuoiketthuc">Tuổi kết thúc:</label>
                    <div class="d-flex">
                        <input type="number" class="form-control" id="tuoiketthuc" name="tuoiketthuc" min="1" max="1200">
                        <select class="form-control ms-2" id="donvitinhketthuc" name="donvitinhketthuc">
                            <option value="giờ">Giờ</option>
                            <option value="tuần">Tuần</option>
                            <option value="tháng" selected>Tháng</option>
                            <option value="tuổi">Tuổi</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Thêm</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

    <h2 class="text-primary">DANH SÁCH NHÓM TUỔI</h2>
    <table id="tablenhomtuoi" class="dataTable-table" style="width: 100%; ">
        <thead>
            <tr>
                <th>STT</th>
                <th>Đối tượng</th>
                <th>Độ tuổi</th>
                <th id="tt">Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @if ($nhomtuois->isEmpty())
                <tr>
                    <td colspan="4" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                </tr>
            @else
                @php
                    $i = 1; 
                @endphp
                @foreach($nhomtuois as $nhomtuoi)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ $nhomtuoi->doituong }}</td>
                        <td>
                            @if($nhomtuoi->tuoiketthuc != "")
                                {{ $nhomtuoi->tuoibatdau }} {{ $nhomtuoi->donvitinhbatdau }} - {{ $nhomtuoi->tuoiketthuc }} {{ $nhomtuoi->donvitinhketthuc }}
                            @else
                                @if($nhomtuoi->tuoibatdau != "")
                                    {{ $nhomtuoi->tuoibatdau }} {{ $nhomtuoi->donvitinhbatdau }} trở lên
                                @endif
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm edit-post " data-bs-toggle="modal" data-bs-target="#Modalnhomtuoi" data-ma="{{ $nhomtuoi->manhomtuoi }}" data-tuoibatdau="{{ $nhomtuoi->tuoibatdau }}" data-tuoiketthuc="{{ $nhomtuoi->tuoiketthuc }}" data-donvitinhbatdau="{{ $nhomtuoi->donvitinhbatdau }}" data-donvitinhketthuc="{{ $nhomtuoi->donvitinhketthuc }}" data-doituong="{{ $nhomtuoi->doituong }}">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            @php    
                                $chitiettuoi_goivc = DB::table('chitiettuoi_goivc')->where('manhomtuoi', $nhomtuoi->manhomtuoi)->exists();
                            @endphp
                            @if (!$chitiettuoi_goivc)
                                <a href="{{ url('/Admin/xoanhomtuoi', $nhomtuoi->manhomtuoi) }}" onclick="return confirm('Bạn có chắc muốn xóa không!')" class="btn btn-danger btn-sm">
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

    document.addEventListener('DOMContentLoaded', function() {
        var myTable = document.querySelector("#tablenhomtuoi");
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
    document.querySelectorAll('.edit-post').forEach(function(button) {
        button.addEventListener('click', function() {
            // Lấy dữ liệu từ nút Sửa
            var manhomtuoi = this.getAttribute('data-ma');
            var doituong = this.getAttribute('data-doituong');
            var tuoibatdau = this.getAttribute('data-tuoibatdau');
            var donvitinhbatdau = this.getAttribute('data-donvitinhbatdau');
            var tuoiketthuc = this.getAttribute('data-tuoiketthuc');
            var donvitinhketthuc = this.getAttribute('data-donvitinhketthuc');
            
            // Điền dữ liệu vào các trường trong modal
            document.getElementById('manhomtuoi').value = manhomtuoi;
            document.getElementById('doituong').value = doituong;
            document.getElementById('tuoibatdau').value = tuoibatdau;
            document.getElementById('donvitinhbatdau').value = donvitinhbatdau;
            document.getElementById('tuoiketthuc').value = tuoiketthuc;
            document.getElementById('donvitinhketthuc').value = donvitinhketthuc;

            // Đổi tiêu đề và nút Thêm thành Cập nhật
            document.querySelector('.modal-title').innerText = 'CẬP NHẬT NHÓM TUỔI';
            document.querySelector('.modal-footer .btn-primary').innerText = 'Cập nhật';
        });
    });
    });

    // Khởi tạo modal khi nhấn nút thêm mới
    document.getElementById('btn-themnhomtuoi').addEventListener('click', function() {
        document.querySelector('.modal-title').innerText = 'THÊM NHÓM TUỔI';
        document.querySelector('.modal-footer .btn-primary').innerText = 'Thêm';
        document.getElementById('manhomtuoi').value = '';
        document.getElementById('doituong').value = '';
        document.getElementById('tuoibatdau').value = '';
        document.getElementById('tuoiketthuc').value = '';
        document.getElementById('donvitinhbatdau').value = 'tháng';
        document.getElementById('donvitinhketthuc').value = 'tháng';
    });

    
</script>
</body>
</html>
