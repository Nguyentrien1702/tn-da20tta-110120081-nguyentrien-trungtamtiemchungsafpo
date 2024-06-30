<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bài viết</title>
    <script src="{{ asset('backend/ckeditor_4.22.1_full_easyimage/ckeditor/ckeditor.js') }}"></script>
    <style>

        h2{
            text-align: center;
            color: blue;
            font-weight: bold !important;
        }
        .dataTable-table tr th, td{
            vertical-align: middle !important;
            text-align: center !important;
        }
        .dataTable-table tr th{
            background-color: gainsboro;
            font-size: 16px;
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
    <button class="btn btn-primary mb-3" id="btn-thembanner" data-bs-toggle="modal" data-bs-target="#Modalbanner">Thêm banner</button>
    <!-- The Modal -->
    <div class="modal" id="Modalbanner">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">THÊM BANNER</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="bannerform" method="POST" action="/thembanner" enctype="multipart/form-data">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    
                        <div class="form-group mb-3">
                            <label for="hinhanhbanner">Chọn hình banner: </label>
                            <input type="file" class="form-control-file" id="hinhanhbanner" name="hinhanhbanner">
                            <img id="previewImage" src="" alt="Preview" style="display: none; max-width: 100%; max-height: 200px; margin-top: 10px;">
                        </div>
                    
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Thêm</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <h2 class="text-primary">DANH SÁCH BANNER</h2>
    <table id="tablebanner" class="dataTable-table table table-striped" style="width: 100%; ">
        <thead>
            <tr>
                <th>STT</th>
                <th>Hình ảnh banner</th>
                <th>Ngày đăng tải</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @if ($banners->isEmpty())
                <tr>
                    <td colspan="4" style="text-align: center;"><i>Không có Banner nào.</i></td>
                </tr>
            @else
                @php
                    $i = 1; 
                @endphp
                @foreach($banners as $banner)
                    <tr>
                        <td>{{$i++}}</td>
                        <td><img src="{{ asset($banner->hinhanh) }}" alt="" style="width: 70%; margin: 5px 5px"> </td>
                        <td>{{ \Carbon\Carbon::parse( $banner->ngaydangbanner )->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ url('/xoabanner', $banner->mabanner) }}" onclick="return confirm('Bạn có chắc muốn xóa banner này không!')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myTable = document.querySelector("#tablebanner");
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

            var modal = document.getElementById('Modalbanner');
            // Bắt sự kiện hiển thị modal
            modal.addEventListener('show.bs.modal', function (event) {
                document.getElementById("hinhanhbanner").value = "";
                document.getElementById("previewImage").src = "";
                document.getElementById("previewImage").style.display = "none";
            });

            var form = document.getElementById('bannerform');
            form.addEventListener('submit', function(event) {
                var fileInput = document.getElementById('hinhanhbanner');
                // Kiểm tra xem người dùng đã chọn file hay chưa
                if (!fileInput.value) {
                    // Ngăn chặn gửi form và hiển thị cảnh báo
                    event.preventDefault();
                    alert('Vui lòng chọn một hình ảnh.');
                }
            });
        });
        document.getElementById('hinhanhbanner').addEventListener('change', function() {
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const image = new Image();
                image.src = e.target.result;

                image.onload = function() {
                    const width = this.width;
                    const height = this.height;

                    if (width >= 1100 && width <= 1200 && height >= 400 && height <= 450) {
                        // Kích thước của hình ảnh nằm trong phạm vi cho phép
                        const previewImage = document.getElementById('previewImage');
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                    } else {
                        // Kích thước không hợp lệ, hiển thị cảnh báo
                        alert('Kích thước hình ảnh không hợp lệ. Vui lòng chọn hình ảnh có kích thước từ 1100x400 đến 1200x450 pixel.');
                        document.getElementById('hinhanhbanner').value = ''; // Xóa giá trị file đã chọn
                    }
                };
            };

            reader.readAsDataURL(file);
        });
    </script>
</div>

@include("admin/footer_admin")
</body>
</html>
