<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục bệnh</title>
    <script src="{{ asset('backend/ckeditor_4.22.1_full_easyimage/ckeditor/ckeditor.js') }}"></script>
    <style>
        h2{
            text-align: center;
            color: blue;
            font-weight: bold !important;
        }
        .dataTable-table tr th, td{
            vertical-align: middle !important;
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
        .modal-dialog {
            max-width: 800px !important; /* Chiều rộng tối đa */
            width: 90% !important; /* Chiều rộng */
        }
    </style>
</head>
<body>
@include("admin/header_admin")

<div class="mb-5" style="width: 70%; margin: auto">
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
@if(session('error'))
    <div id="dangthanhcong" class="alert alert-success text-danger">{{ session('error') }}</div>
    <script>
        var dangtc = document.getElementById("dangthanhcong");
        setTimeout(function () {
                // Ẩn thông báo sau 2 giây
                dangtc.style.display = 'none';
            }, 5000);
    </script>
@endif
    <button class="btn btn-primary mb-3" id="btn-thembenh" data-bs-toggle="modal" data-bs-target="#Modalbenh">Thêm bệnh - nhóm bệnh</button>
    <button class="btn btn-primary mb-3" id="btn-themfilebenh" data-bs-toggle="modal" data-bs-target="#Modalinsertfile">Thêm file</button>
    <!-- The Modal -->
    <div class="modal" id="Modalbenh" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-primary" style="font-weight: bold;">THÊM BỆNH - NHÓM BỆNH</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="benhform" method="POST" action="/Admin/thembenh" enctype="multipart/form-data" class="needs-validated">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" id="mabenh" name="mabenh" style="display: none;">
                    <div class="form-group mb-3">
                        <label for="tenbenh">Tên bệnh - nhóm bệnh:</label>
                        <input type="text" class="form-control" id="tenbenh" name="tenbenh" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="motabenh">Mô tả bệnh:</label>
                        <textarea class="form-control" id="motabenh1" name="motabenh" rows="5"></textarea>
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

    <!-- The Modal -->
    <div class="modal" id="Modalinsertfile" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title text-primary" style="font-weight: bold;">THÊM BỆNH - NHÓM BỆNH</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="benhform" method="POST" action="/Admin/themfilebenh" enctype="multipart/form-data" class="needs-validated">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="filebenh">Chọn file chứa danh sách bệnh:</label>
                        <input type="file" class="form-control" id="filebenh" name="filebenh" accept=".xls,.xlsx" required>
                        <div class="valid-feedback"></div>
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

    <h2 class="text-primary">DANH SÁCH BỆNH - NHÓM BỆNH</h2>
    <table id="tablebenh" class="dataTable-table" style="width: 100%; ">
        <thead>
            <tr>
                <th>STT</th>
                <th>Bệnh - nhóm bệnh</th>
                <th>Mô tả</th>
                <th id="tt">Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @if ($dmbenhs->isEmpty())
                <tr>
                    <td colspan="4" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                </tr>
            @else
                @php
                    $i = 1; 
                @endphp
                @foreach($dmbenhs as $dmbenh)
                    <tr>
                        <td>{{$i++}}</td>
                        <td style="text-align: left !important;">{{ $dmbenh->tenbenh }}</td>
                        <td>{{ $dmbenh->mota }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm edit-post " data-bs-toggle="modal" data-bs-target="#Modalbenh" data-ma="{{ $dmbenh->mabenh_nhombenh }}" data-ten="{{ $dmbenh->tenbenh }}" data-mota="{{ $dmbenh->mota }}">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            @php
                                $benhInVaccine = DB::table('vaccine')->where('benh_nhombenh', $dmbenh->mabenh_nhombenh)->exists();
                            @endphp
                            @if (!$benhInVaccine)
                                <a href="{{ url('/Admin/xoadmbenh', $dmbenh->mabenh_nhombenh) }}" onclick="return confirm('Bạn có chắc muốn xóa không!')" class="btn btn-danger btn-sm">
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
        var myTable = document.querySelector("#tablebenh");
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
                var mabenh = this.getAttribute('data-ma');
                var tenbenh = this.getAttribute('data-ten');
                var motabenh = this.getAttribute('data-mota');
                
                // Điền dữ liệu vào các trường trong modal
                document.getElementById('mabenh').value = mabenh;
                document.getElementById('tenbenh').value = tenbenh;

                // Đổi tiêu đề và nút Thêm thành Cập nhật
                document.querySelector('.modal-title').innerText = 'CẬP NHẬT BỆNH - NHÓM BỆNH';
                document.querySelector('.modal-footer .btn-primary').innerText = 'Cập nhật';
            });
        });

    });
        function initializeCKEditor() {
            if (CKEDITOR.instances.motabenh1) {
                CKEDITOR.instances.motabenh1.destroy(true);
            }
            CKEDITOR.replace('motabenh1');
        }

        
    // Khi mở modal thêm mới, đổi lại các thuộc tính
    document.getElementById('btn-thembenh').addEventListener('click', function() {
        document.querySelector('.modal-title').innerText = 'THÊM BỆNH - NHÓM BỆNH';
        document.querySelector('.modal-footer .btn-primary').innerText = 'Thêm';
        document.getElementById('mabenh').value = '';
        document.getElementById('tenbenh').value = '';
        initializeCKEditor();
            CKEDITOR.instances.motabenh1.setData('');
    });
</script>
</body>
</html>