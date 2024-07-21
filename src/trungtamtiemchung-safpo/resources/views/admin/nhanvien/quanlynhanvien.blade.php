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
    <button class="btn btn-primary mb-3" id="btn-themnhanvien" data-bs-toggle="modal" data-bs-target="#Modalnhanvien">Thêm nhân viên</button>
    <!-- The Modal -->
    <div class="modal" id="Modalnhanvien" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-primary" style="font-weight: bold;">THÊM NHÂN VIÊN</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="nhanvienform" method="POST" action="/Admin/themnhanvien" enctype="multipart/form-data" class="needs-validated">
            @csrf
            <!-- Modal body -->
            <div class="modal-body">
                <input type="text" id="manv" name="manv" style="display: none;">
                <div class="row">
                    <div class="col">
                        <div class="form-group mb-3">
                            <label for="tennv">Tên nhân viên:</label>
                            <input type="text" class="form-control" id="tennv" name="tennv" placeholder="Tên nhân viên" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Giới tính:</label>
                            <div class="form-check form-check-inline" style="margin-left: 10px;">
                                <input class="form-check-input" type="radio" id="gioitinh_nam" name="gioitinh" checked value="Nam" required>
                                <label class="form-check-label" for="gioitinh_nam">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="gioitinh_nu" name="gioitinh" value="Nữ" required>
                                <label class="form-check-label" for="gioitinh_nu">Nữ</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ngaysinhnv">Ngày sinh:</label>
                            <input type="date" class="form-control" id="ngaysinhnv" name="ngaysinhnv" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="diachinv">Địa chỉ:</label>
                            <input type="text" class="form-control" id="diachinv" name="diachinv" required placeholder="Địa chỉ nhân viên">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
                    </div>
                    <div class="col">
                        
                        <div class="form-group mb-3">
                            <label for="emailnv">Email:</label>
                            <input type="email" class="form-control" id="emailnv" name="emailnv" placeholder="Email nhân viên" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="sdtnv">Số điện thoại:</label>
                            <input type="text" class="form-control" id="sdtnv" name="sdtnv" required maxlength="10" pattern="[0-9]{10}" placeholder="Số điện thoại">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ngaybdlamviec">Ngày bắt đầu làm việc:</label>
                            <input type="date" class="form-control" id="ngaybdlamviec" name="ngaybdlamviec" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="mavaitro">Vai trò:</label>
                            <select class="form-control" id="mavaitro" name="mavaitro">
                                <option value="" >-- Chọn vai trò --</option>
                                <option value="vt02">Bác sĩ</option>
                                <option value="vt03">Y tá</option>
                            </select>
                            <div id="mavaitro-error" style="color: red; display: none;">Vui lòng chọn vai trò.</div>
                        </div>
                    </div>
                </div>
                
                
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Thêm</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
            </div>
            </form>
        </div>
    </div>
    </div>

    <h2 class="text-primary">DANH SÁCH NHÂN VIÊN</h2>
    <table id="tablenhanvien" class="dataTable-table" style="width: 100%; ">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã nhân viên</th>
                <th>Tên nhân viên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Ngày bđ làm việc</th>
                <th>Vai trò</th>
                <th id="tt">Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @if ($nhanviens->isEmpty())
                <tr>
                    <td colspan="10" style="text-align: center;"><i>Không có dữ liệu.</i></td>
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
                        <td>{{ $nhanvien->gioitinh }}</td>
                        <td>{{ \Carbon\Carbon::parse( $nhanvien->ngaysinhnv )->format('d/m/Y') }}</td>
                        <td>{{ $nhanvien->sdtnv }}</td>
                        <td>{{ $nhanvien->emailnv }}</td>
                        <td>{{ $nhanvien->diachinv }}</td>
                        <td>{{ \Carbon\Carbon::parse( $nhanvien->ngaybdlamviec )->format('d/m/Y') }}</td>
                        <td>
                            @if($nhanvien->mavaitro == 'vt02')
                                Bác sĩ
                            @else
                                Y tá
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm edit-post" data-bs-toggle="modal" data-bs-target="#Modalnhanvien" 
                                data-ma="{{ $nhanvien->manv }}" 
                                data-tennv="{{ $nhanvien->tennv }}"
                                data-gioitinh="{{ $nhanvien->gioitinh }}"
                                data-emailnv="{{ $nhanvien->emailnv }}" 
                                data-sdtnv="{{ $nhanvien->sdtnv }}" 
                                data-diachinv="{{ $nhanvien->diachinv }}" 
                                data-ngaysinhnv="{{ $nhanvien->ngaysinhnv }}" 
                                data-ngaybdlamviec="{{ $nhanvien->ngaybdlamviec }}"
                                data-mavaitro="{{ $nhanvien->mavaitro }}">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            <a href="{{ url('/Admin/xoanhanvien', $nhanvien->manv) }}" onclick="return confirm('Bạn có chắc muốn xóa không!')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Xóa
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

        // Xử lý submit form
        document.getElementById('nhanvienform').addEventListener('submit', function(event) {
            var mavaitro = document.getElementById('mavaitro').value;
            var errorDiv = document.getElementById('mavaitro-error');
            if (mavaitro === "") {
                event.preventDefault();
                errorDiv.style.display = 'block';
            }
        });
        // Ẩn thông báo lỗi khi giá trị của select thay đổi
        document.getElementById('mavaitro').addEventListener('change', function() {
            var errorDiv = document.getElementById('mavaitro-error');
            if (this.value !== "") {
                errorDiv.style.display = 'none';
            }else{
                errorDiv.style.display = 'block';
            }
        });

        // Xử lý sự kiện khi nhấn nút sửa
    document.querySelectorAll('.edit-post').forEach(function(button) {
        button.addEventListener('click', function() {
            // Lấy dữ liệu từ nút Sửa
            var manv = this.getAttribute('data-ma');
            var tennv = this.getAttribute('data-tennv');
            var emailnv = this.getAttribute('data-emailnv');
            var sdtnv = this.getAttribute('data-sdtnv');
            var diachinv = this.getAttribute('data-diachinv');
            var ngaysinhnv = this.getAttribute('data-ngaysinhnv');
            var ngaybdlamviec = this.getAttribute('data-ngaybdlamviec');
            var mavaitro = this.getAttribute('data-mavaitro');
            var gioitinh =this.getAttribute('data-gioitinh');
            
            // Điền dữ liệu vào các trường trong modal
            document.getElementById('manv').value = manv;
            document.getElementById('tennv').value = tennv;
            document.getElementById('emailnv').value = emailnv;
            document.getElementById('sdtnv').value = sdtnv;
            document.getElementById('diachinv').value = diachinv;
            document.getElementById('ngaysinhnv').value = ngaysinhnv;
            document.getElementById('ngaybdlamviec').value = ngaybdlamviec;
            if(gioitinh == "Nam"){
                document.getElementById('gioitinh_nam').checked = true;
            }else{
                document.getElementById('gioitinh_nu').checked = true;
            }
            // Lấy thẻ select và tìm option có giá trị tương ứng để chọn
            var selectVaiTro = document.getElementById('mavaitro');
            for (var i = 0; i < selectVaiTro.options.length; i++) {
                if (selectVaiTro.options[i].value === mavaitro) {
                    selectVaiTro.selectedIndex = i;
                    break;
                }
            }

            document.getElementById('ngaybdlamviec').setAttribute('min', ngaybdlamviec);
            // Đổi tiêu đề và nút Thêm thành Cập nhật
            document.querySelector('.modal-title').innerText = 'CẬP NHẬT NHÂN VIÊN';
            document.querySelector('.modal-footer .btn-primary').innerText = 'Cập nhật';
        });
    });

    });

    //xử lý ngày sinh
    var birthdateInput = document.getElementById('ngaysinhnv');
    if (birthdateInput) {
        var today = new Date();
        var maxDate = new Date(today.getFullYear() - 20, 11, 31);
        var minDate = new Date(1950, 0, 1);

        birthdateInput.setAttribute('min', minDate.toISOString().split('T')[0]);
        birthdateInput.setAttribute('max', maxDate.toISOString().split('T')[0]);
    }

    // Khởi tạo modal khi nhấn nút thêm mới
    document.getElementById('btn-themnhanvien').addEventListener('click', function() {
        document.querySelector('.modal-title').innerText = 'THÊM NHÂN VIÊN';
        document.querySelector('.modal-footer .btn-primary').innerText = 'Thêm';
        document.getElementById('manv').value = '';
        document.getElementById('tennv').value = '';
        document.getElementById('emailnv').value = '';
        document.getElementById('sdtnv').value = '';
        document.getElementById('diachinv').value = '';
        document.getElementById('ngaysinhnv').value = '';
        document.getElementById('ngaybdlamviec').value = '';
        document.getElementById('mavaitro').value = '';

        // Gán min max cho ngaybdlamviec
        var today = new Date().toISOString().split('T')[0];
        var lastMonth = new Date();
        lastMonth.setMonth(lastMonth.getMonth() - 1);
        var lastMonthDate = lastMonth.toISOString().split('T')[0];

        document.getElementById('ngaybdlamviec').setAttribute('max', today);
        document.getElementById('ngaybdlamviec').setAttribute('min', lastMonthDate);
    });

    

    document.getElementById('sdtnv').addEventListener('input', function (e) {
        // Loại bỏ mọi ký tự không phải số
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
</body>
</html>
