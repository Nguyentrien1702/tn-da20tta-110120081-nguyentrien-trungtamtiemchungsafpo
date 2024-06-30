<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục khách hàng</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
@include("nhanvien/header_nv")

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
    <!-- The Modal -->
    <div class="modal" id="Modalkhachhang" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-primary" style="font-weight: bold;">THÊM KHÁCH HÀNG</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="khachhangform" method="POST" action="/Nhanvien/themkhachhang" enctype="multipart/form-data" class="needs-validated">
            @csrf
            <!-- Modal body -->
            <div class="modal-body">
                <input type="text" id="makh" name="makh" style="display: none;">
                <div class="row">
                    <div class="col">
                        <h5 class="text-secondary">Thông tin khách hàng</h5>
                        <div class="form-group mb-3">
                            <label for="tenkh">Tên khách hàng:</label>
                            <input type="text" class="form-control" id="tenkh" name="tenkh" placeholder="Tên khách hàng" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label>Giới tính:</label>
                            <div class="form-check form-check-inline" style="margin-left: 10px;">
                                <input class="form-check-input" type="radio" id="gioitinh_nam" name="gioitinh" value="Nam" checked required>
                                <label class="form-check-label" for="gioitinh_nam">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="gioitinh_nu" name="gioitinh" value="Nữ" required>
                                <label class="form-check-label" for="gioitinh_nu">Nữ</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ngaysinhkh">Ngày sinh:</label>
                            <input type="date" class="form-control" id="ngaysinhkh" name="ngaysinhkh" min="1900-01-01" max="{{ date('Y-m-d') }}" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="diachi">Địa chỉ:</label>
                            <input type="text" class="form-control" id="diachikh" placeholder="số nhà, tên đường, phường/xã, quận/huyện, tỉnh/tp" name="diachikh" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
                        
                    </div>
                    <div class="col">
                        <h5 class="text-secondary">Thông tin liên hệ</h5>
                        <div class="form-group mb-3">
                            <label for="ten_nglh">Tên người liên hệ:</label>
                            <input type="text" class="form-control" id="ten_nglh" name="ten_nglh" placeholder="Tên người liên hệ">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="quanhevoikh">Quan hệ với khách hàng:</label>
                            <select name="quanhevoikh" id="quanhevoikh" class="form-control">
                                <option value="Bản thân">Bản thân</option>
                                <option value="Con">Con</option>
                                <option value="Cha">Cha</option>
                                <option value="Mẹ">Mẹ</option>
                                <option value="Vợ">Vợ</option>
                                <option value="Chồng">Chồng</option>
                                <option value="Anh">Anh</option>
                                <option value="Chị">Chị</option>
                                <option value="Em">Em</option>
                                <option value="Ông">Ông</option>
                                <option value="Bà">Bà</option>
                                <option value="Họ hàng">Họ hàng</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="emailkh">Email:</label>
                            <input type="email" class="form-control" id="emailkh" name="emailkh" placeholder="Email khách hàng">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="sdtkh">Số điện thoại:</label>
                            <input type="text" class="form-control" id="sdtkh" name="sdtkh" required maxlength="10" pattern="[0-9]{10}" placeholder="Số điện thoại">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                        </div>
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

    <h2 class="text-primary">DANH SÁCH KHÁCH HÀNG</h2>
    <table id="tablekhachhang" class="dataTable-table" style="width: 100%; ">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã khách hàng</th>
                <th>Tên khách hàng</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th colspan="2">Thao tác</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @if ($khachhangs->isEmpty())
                <tr>
                    <td colspan="9" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                </tr>
            @else
                @php
                    $i = 1; 
                @endphp
                @foreach($khachhangs as $khachhang)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ $khachhang->makh }}</td>
                        <td>{{ $khachhang->tenkh }}</td>
                        <td>{{ $khachhang->gioitinh }}</td>
                        <td>{{ \Carbon\Carbon::parse( $khachhang->ngaysinhkh )->format('d/m/Y') }}</td>
                        <td>{{ $khachhang->sdtkh }}</td>
                        <td>{{ $khachhang->emailkh }}</td>
                        <td>{{ $khachhang->diachikh }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm edit-post" data-bs-toggle="modal" data-bs-target="#Modalkhachhang" 
                                data-ma="{{ $khachhang->makh }}" 
                                data-tenkh="{{ $khachhang->tenkh }}"
                                data-gioitinh="{{ $khachhang->gioitinh }}"
                                data-emailkh="{{ $khachhang->emailkh }}" 
                                data-sdtkh="{{ $khachhang->sdtkh }}" 
                                data-ten_nglh="{{ $khachhang->ten_nglh }}" 
                                data-ngaysinhkh="{{ $khachhang->ngaysinhkh }}" 
                                data-quanhevoikh="{{ $khachhang->quanhevoikh }}"
                                data-diachi = "{{ $khachhang->diachikh }}">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                        </td>
                        <td><a href=""><i>Chi tiết</i></a></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</div>

@include("nhanvien/footer_nv")
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myTable = document.querySelector("#tablekhachhang");
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
        document.getElementById('khachhangform').addEventListener('submit', function(event) {
            var quanhevoikh = document.getElementById('quanhevoikh').value;
            var errorDiv = document.getElementById('quanhevoikh-error');
            if (quanhevoikh === "") {
                event.preventDefault();
                errorDiv.style.display = 'block';
            }
        });
        // Ẩn thông báo lỗi khi giá trị của select thay đổi
        document.getElementById('quanhevoikh').addEventListener('change', function() {
            var errorDiv = document.getElementById('quanhevoikh-error');
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
            var makh = this.getAttribute('data-ma');
            var tenkh = this.getAttribute('data-tenkh');
            var emailkh = this.getAttribute('data-emailkh');
            var sdtkh = this.getAttribute('data-sdtkh');
            var ten_nglh = this.getAttribute('data-ten_nglh');
            var ngaysinhkh = this.getAttribute('data-ngaysinhkh');
            var quanhevoikh = this.getAttribute('data-quanhevoikh');
            var diachi = this.getAttribute('data-diachi');
            
            // Điền dữ liệu vào các trường trong modal
            document.getElementById('makh').value = makh;
            document.getElementById('tenkh').value = tenkh;
            document.getElementById('emailkh').value = emailkh;
            document.getElementById('sdtkh').value = sdtkh;
            document.getElementById('ten_nglh').value = ten_nglh;
            document.getElementById('ngaysinhkh').value = ngaysinhkh;
            document.getElementById('quanhevoikh').value = quanhevoikh;
            document.getElementById('diachikh').value = diachi;

            // Đổi tiêu đề và nút Thêm thành Cập nhật
            document.querySelector('.modal-title').innerText = 'CẬP NHẬT KHÁCH HÀNG';
            document.querySelector('.modal-footer .btn-primary').innerText = 'Cập nhật';
        });
    });
    });
    

    document.getElementById('sdtkh').addEventListener('input', function (e) {
        // Loại bỏ mọi ký tự không phải số
        this.value = this.value.replace(/[^0-9]/g, '');
    });

</script>
</body>
</html>
