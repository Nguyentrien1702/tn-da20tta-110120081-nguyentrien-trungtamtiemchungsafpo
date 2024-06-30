<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bài viết</title>
    <script src="{{ asset('backend/ckeditor_4.22.1_full_easyimage/ckeditor/ckeditor.js') }}"></script>
    <style>
        .hidden {
            display: none;
        }
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
            max-width: 70% !important;
        }
        #tenbv{
            font-weight: bold;
            background:linear-gradient(90deg, #052065 44.77%, #0780CB 100%);
            color: #FBA307;
            padding: 15px 15px 15px 15px;
            margin-top: 0px;
            border-radius:7px;
        }
    </style>
</head>
<div>
@include("admin/header_admin")
@csrf
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

<button class="btn btn-primary mb-3" id="btn-thembaiviet">Thêm bài viết</button>
<div id="thembaiviet" style="display: none;">
    <form id="postForm" method="POST" action="/dangbaiviet" enctype="multipart/form-data">
        @csrf
        <input type="text" id="mabaiviet" name="mabaiviet" style="display: none;">
        <div class="form-group mb-3">
            <label for="tenbaiviet">Tiêu đề bài viết:</label>
            <input type="text" class="form-control" id="tenbaiviet" name="tenbaiviet" required>
        </div>
        <div class="form-group mb-3">
            <label for="hinhanhminhhoa">Chọn hình ảnh minh họa:</label>
            <input type="file" class="form-control-file" id="hinhanhminhhoa" name="hinhanhminhhoa" required>
            <img id="previewImage" src="" alt="Preview" style="display: none; max-width: 100%; max-height: 200px; margin-top: 10px;">
        </div>
        <div class="form-group mb-3">
            <label for="motabaiviet">Mô tả bài viết:</label>
            <textarea class="form-control" id="motabaiviet" name="motabaiviet" rows="3" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="loaibaiviet">Loại bài viết:</label>
            <select name="loaibaiviet" id="loaibaiviet" class="form-control">
                <option value="1">Tin tức</option>
                <option value="2">Bệnh học</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="mabenh">Bệnh/Nhóm bệnh:</label>
            <input type="text" class="form-control" id="mabenh" placeholder="Chọn nhóm bệnh" name="mabenh" list="list">
            <datalist id="list">
                @foreach($nhombenhs as $benh_nhombenh)
                <option value="{{ $benh_nhombenh->tenbenh }}"></option>
                @endforeach
            </datalist>
        </div>
        <div class="form-group mb-3">
            <label for="noidungbaiviet">Nội dung bài viết:</label>
            <textarea class="form-control" id="noidungbaiviet1" name="noidungbaiviet" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Đăng tải</button>
        <a href="" class="btn btn-danger">Hủy</a>
    </form>  
</div>

<!-- Modal thông tin baiviet -->
<div class="modal" id="Modalttbaiviet" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Header Modal -->
            <div class="modal-header">
                <h4 class="modal-title text-primary" style="font-weight: bold;">NỘI DUNG BÀI VIẾT</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="margin-left: 20px; margin-right: 20px; border: 1px solid blue; border-radius: 5px;">
                <h4 id="tenbv" class="mb-3"></h4>
                <div id="ndbv">

                </div>
            </div>
            <!-- Footer Modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Danh sách bài viết -->
    <div class="table-responsive mt-3">
        <h2>DANH SÁCH BÀI VIẾT</h2>
        <table width="100%" class="dataTable-table" id="tablebaiviet">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên bài viết</th>
                    <th scope="col">Hình ảnh minh họa</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Nội dung</th>
                    <th scope="col">Loại bài viết</th>
                    <th scope="col">Ngày đăng tải</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            @php
            use Illuminate\Support\Str;
            $i = 1; 
            @endphp
            @if ($dsbaiviets->isEmpty())
                <tr>
                    <td colspan="8" style="text-align: center;"><i>Không có bài viết nào.</i></td>
                </tr>
            @else
            @foreach ($dsbaiviets as $baiviet)
                <tr class="post-row">
                    <td>{{ $i++ }}</td>
                    <td style="width: 10%;">{{ $baiviet->tenbaiviet }}</td>
                    <td><img src="{{ asset($baiviet->hinhanhminhhoa) }}" alt="" style="width: 150px;"></td>
                    <td style="width: 25% !important;">{{ $baiviet->motabaiviet }}</td>
                    <td><i><a href="" data-bs-toggle="modal"
                            data-bs-target="#Modalttbaiviet" data-tenbv="{{ $baiviet->tenbaiviet }}" data-noidung="{{ $baiviet->noidungbaiviet }}"
                            >Chi tiết</a></i></td>
                    <td>
                        @if ($baiviet->loaibaiviet == 1)
                            Tin tức
                        @else
                            Bệnh học
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse( $baiviet->ngaydangtai )->format('d/m/Y') }}</td>
                    <td>
                    <button type="button" class="btn btn-primary btn-sm edit-post" data-post-id="{{ $baiviet->mabaiviet }}" data-post-title="{{ $baiviet->tenbaiviet }}" 
                        data-post-image="{{ asset($baiviet->hinhanhminhhoa) }}" data-post-description="{{ $baiviet->motabaiviet }}" data-post-content="{{ $baiviet->noidungbaiviet }}"
                        data-loaibaiviet="{{ $baiviet->loaibaiviet }}" data-mabenh="{{ $baiviet->tenbenh }}">
                        <i class="fas fa-edit"></i> Sửa
                    </button>
                    <a href="{{ url('/xoabaiviet', $baiviet->mabaiviet) }}" onclick="return confirm('Bạn có chắc muốn xóa bài viết này không!')" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Xóa
                    </a>
                    </td>     
                </tr>
            @endforeach
            @endif

            </tbody>
        </table>
        <div id="paginationContainer" class="pagination-container"></div>
    </div>

<script>
    document.getElementById('btn-thembaiviet').addEventListener('click', function() {
    
        document.getElementById('mabaiviet').value = "";
        document.getElementById('tenbaiviet').value = "";
        document.getElementById('previewImage').setAttribute('src', "");
        document.getElementById('previewImage').style.display = "none";
        document.getElementById('motabaiviet').value = "";
        document.getElementById('loaibaiviet').value = 1;
        document.getElementById('mabenh').value = "";
        document.getElementById('noidungbaiviet1').value = '';

        const thembaivietDiv = document.getElementById('thembaiviet');
        thembaivietDiv.style.display = "block";
        if (thembaivietDiv.style.display == "block" && !CKEDITOR.instances.noidungbaiviet1) {
            CKEDITOR.replace('noidungbaiviet1');
        }
        
    });

    document.getElementById('hinhanhminhhoa').addEventListener('change', function() {
        const reader = new FileReader();

        reader.onload = function(e) {
            const previewImage = document.getElementById('previewImage');
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    });

document.addEventListener('DOMContentLoaded', function () {
    // Tạo bảng dữ liệu với plugin simpleDatatables
    var myTable = document.querySelector("#tablebaiviet");
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

    const editButtons = document.querySelectorAll('.edit-post');

    editButtons.forEach(function (button) {
        
        button.addEventListener('click', function () {
        const formPosition = document.getElementById('thembaiviet').getBoundingClientRect().top;
        
        // Cuộn trang đến vị trí của form
        window.scrollTo({
            top: formPosition,
            behavior: 'smooth' // Cuộn mượt
        });
        // Hiển thị form
        const thembaivietDiv = document.getElementById('thembaiviet');
        thembaivietDiv.style.display = "block";
        if (thembaivietDiv.style.display == "block" && !CKEDITOR.instances.noidungbaiviet1) {
            CKEDITOR.replace('noidungbaiviet1');
        }
        const postid = this.getAttribute('data-post-id');
        const postTitle = this.getAttribute('data-post-title');
        const postImageSrc = this.getAttribute('data-post-image');
        const postDescription = this.getAttribute('data-post-description');
        const postContent = this.getAttribute('data-post-content');
        const loaibaiviet = this.getAttribute('data-loaibaiviet');
        const mabenh = this.getAttribute('data-mabenh');
            
            document.getElementById('mabaiviet').value = postid;
            document.getElementById('tenbaiviet').value = postTitle;
            document.getElementById('loaibaiviet').value = loaibaiviet;
            document.getElementById('mabenh').value = mabenh;
            document.getElementById('previewImage').style.display = "block";
            document.getElementById('previewImage').src = postImageSrc;
            document.getElementById('motabaiviet').value = postDescription;
            
            CKEDITOR.instances['noidungbaiviet1'].setData(postContent);
        });
    });

        // Sự kiện click cho các liên kết "Chi tiết"
        document.querySelectorAll('[data-bs-target="#Modalttbaiviet"]').forEach(function(link) {
            link.addEventListener('click', function() {
                // Lấy dữ liệu từ các thuộc tính data của liên kết
                var tenbv = this.getAttribute('data-tenbv');
                var noidung = this.getAttribute('data-noidung');
                
                // Gắn dữ liệu vào modal body
                document.getElementById('tenbv').innerText = tenbv;
                document.getElementById('ndbv').innerHTML = noidung;
            });
        });
        
        // Tìm phần tử hiển thị thông báo xóa
        const xoaMessage = document.getElementById('xoaMessage');

        // Kiểm tra xem phần tử tồn tại và có giá trị không
        if (xoaMessage) {
            // Hiển thị thông báo trong 2 giây
            setTimeout(function () {
                // Ẩn thông báo sau 2 giây
                xoaMessage.style.display = 'none';
            }, 2000);
        }
});

</script>



@include("admin/footer_admin")
</body>
</html>