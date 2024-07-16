<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục vaccine</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('backend/ckeditor_4.22.1_full_easyimage/ckeditor/ckeditor.js') }}"></script>
    <style>
        .h2 {
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
        #tenvc_benh{
            font-weight: bold;
            background:linear-gradient(90deg, #052065 44.77%, #0780CB 100%);
            color: #FBA307;
            padding: 15px 15px 15px 15px;
            margin-top: 0px;
            border-radius:7px;
        }
        #doituong label {
            font-weight: normal !important;
        }
    </style>
</head>

<body>
    @include("admin/header_admin")
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
    <button class="btn btn-primary mb-3" id="btn-themvaccine" data-bs-toggle="modal" data-bs-target="#Modalvaccine">Thêm vaccine</button>

    <div style="width: 100%; margin: auto;">
        <!-- Modal Thêm vaccine -->
        <div class="modal" id="Modalvaccine" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Header Modal -->
                    <div class="modal-header">
                        <h4 class="modal-title text-primary" style="font-weight: bold;">THÊM VACCINE</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Form Thêm/Sửa -->
                    <form id="vaccineForm" method="POST" action="/Admin/themvaccine" enctype="multipart/form-data"
                        class="needs-validated">
                        @csrf
                        <div class="modal-body">
                            <input type="text" id="mavc" name="mavc" style="display: none;">
                            <div class="row">
                                <!-- Các trường dữ liệu mới -->
                                <h5 style="color: gray; text-align: left">THÔNG TIN VACCINE</h5>
                                <div class="form-group mb-3">
                                    <label for="hinhanhminhhoa">Chọn hình ảnh minh họa:</label>
                                    <input type="file" class="form-control-file" id="hinhanhminhhoa" name="hinhanhminhhoa" required>
                                    <img id="previewImage" src="" alt="Preview" style="display: none; max-width: 100%; max-height: 200px; margin-top: 10px;">
                                </div>
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label for="tenvc">Tên vaccine:</label>
                                        <input type="text" class="form-control" id="tenvc" name="tenvc" placeholder="Tên vaccine" required>
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="nuocsx">Nước sản xuất:</label>                                        
                                        <select id="nuocsx" name="nuocsx" class="form-control">
                                            <option value="">-- Chọn nước sản xuất --</option>
                                        </select>
                                        <div id="nuocsx-error" style="color: red; display: none;">Vui lòng chọn nước sản xuất.</div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="gia">Giá:</label>
                                        <input type="text" placeholder="Giá" class="form-control" id="gia" name="gia" onkeyup="formatCurrency(this)" maxlength="13" required>
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="soluong">Số lượng:</label>
                                        <input type="number" class="form-control" id="soluong" name="soluong" min="0" max="10000" placeholder="Số lượng kho" required>
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    
                                    <!-- Select Mã nhà cung cấp -->
                                    <div class="form-group mb-3">
                                        <label for="mancc">Mã nhà cung cấp:</label>
                                        <select class="form-control" id="mancc" name="mancc" required>
                                            <option value="">-- Chọn nhà cung cấp --</option>
                                            <!-- Dữ liệu từ cơ sở dữ liệu -->
                                            @foreach($nhacungcaps as $nhacungcap)
                                            <option value="{{ $nhacungcap->mancc }}">{{ $nhacungcap->tenncc }}</option>
                                            @endforeach
                                        </select>
                                        <div id="mancc-error" style="color: red; display: none;">Vui lòng chọn nhà cung cấp.</div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="benh_nhombenh" class="form-label" style="font-weight: bold;">Nhóm bệnh:</label>
                                        <input type="text" class="form-control" id="benh_nhombenh" placeholder="Nhập hoặc chọn nhóm bệnh" name="benh_nhombenh" list="list">
                                        <datalist id="list">
                                            @foreach($nhombenhs as $benh_nhombenh)
                                            <option value="{{ $benh_nhombenh->tenbenh }}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    
                                    <!-- Các trường dữ liệu khác -->
                                    <div class="form-group mb-3">
                                        <label for="solieu">Số liều:</label>
                                        <input type="number" class="form-control" id="solieu" name="solieu" min="1" max="20" placeholder="Số liều tiêm" required>
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="khoangcachmuitiem">Khoảng cách mũi tiêm:</label>
                                        <input type="text" class="form-control" id="khoangcachmuitiem" placeholder="Khoảng cách mũi tiêm" name="khoangcachmuitiem" required>
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <h5 style="color: gray; text-align: left">Thông tin chi tiết về vaccine</h5>
                            <label for="">Đối tượng</label>
                                <div class="form-group mb-3" id="doituong" style="margin-left: 15px;">
                                @foreach($nhomtuois as $nhomtuoi)
                                    <div class="form-check">
                                        @if($nhomtuoi->tuoiketthuc != "")
                                            <input class="form-check-input" type="checkbox" name="nhomtuoi[]" value="{{ $nhomtuoi->manhomtuoi }}" id="nhomtuoi{{ $nhomtuoi->manhomtuoi }}">
                                            <label class="form-check-label" for="nhomtuoi{{ $nhomtuoi->manhomtuoi }}">
                                                {{ $nhomtuoi->doituong }}/({{ $nhomtuoi->tuoibatdau }} {{ $nhomtuoi->donvitinhbatdau }} - {{ $nhomtuoi->tuoiketthuc }} {{ $nhomtuoi->donvitinhketthuc }})
                                            </label>
                                        @else
                                            @if($nhomtuoi->tuoibatdau != "")
                                                <input class="form-check-input" type="checkbox" name="nhomtuoi[]" value="{{ $nhomtuoi->manhomtuoi }}" id="nhomtuoi{{ $nhomtuoi->manhomtuoi }}">
                                                <label class="form-check-label" for="nhomtuoi{{ $nhomtuoi->manhomtuoi }}">
                                                    {{ $nhomtuoi->doituong }}/{{ $nhomtuoi->tuoibatdau }} {{ $nhomtuoi->donvitinhbatdau }} trở lên
                                                </label>
                                            @else
                                                <input class="form-check-input" type="checkbox" name="nhomtuoi[]" value="{{ $nhomtuoi->manhomtuoi }}" id="nhomtuoi{{ $nhomtuoi->manhomtuoi }}">
                                                <label class="form-check-label" for="nhomtuoi{{ $nhomtuoi->manhomtuoi }}">
                                                    {{ $nhomtuoi->doituong }}
                                                </label>
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <h5 style="color: gray; text-align: left">Thông tin chi tiết về vaccine</h5>
                                        <textarea class="form-control" id="thongtinvc1" name="thongtinvc" rows="3" required></textarea>
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Footer Modal -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal thông tin vaccine -->
        <div class="modal" id="Modalttvaccine" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Header Modal -->
                    <div class="modal-header">
                        <h4 class="modal-title text-primary" style="font-weight: bold;">THÔNG TIN VACCINE</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="margin-left: 20px; margin-right: 20px; border: 1px solid blue; border-radius: 5px;">
                        <h4 id="tenvc_benh" class="mb-3"></h4>
                        <div id="ttvc">

                        </div>
                    </div>
                    <!-- Footer Modal -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng Danh sách vaccine -->
        <h2 class="text-primary h2">DANH SÁCH VACCINE</h2>
        <table id="tablevaccine" class="dataTable-table" style="width: 100%; ">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên vaccine</th>
                    <th>Nước sản xuất</th>
                    <th>Giá (VNĐ)</th>
                    <th>Số lượng</th>
                    <th>Nhà cung cấp</th>
                    <th>Nhóm bệnh</th>
                    <th>Số liều</th>
                    <th>Khoảng cách mũi tiêm</th>
                    <th>Thông tin vaccine</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <!-- Duyệt danh sách vật phẩm -->
                @if ($vaccines->isEmpty())
                <tr>
                    <td colspan="11" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                </tr>
                @else
                @php
                $i = 1;
                @endphp
                @foreach($vaccines as $vaccine)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $vaccine->tenvc }}</td>
                    <td>{{ $vaccine->nuocsx }}</td>
                    <td>{{ number_format($vaccine->gia, 0, ',', '.') }}</td>
                    <td>{{ $vaccine->soluong }}</td>
                    <td>{{ $vaccine->tenncc }}</td>
                    <td>{{ $vaccine->tenbenh }}</td>
                    <td>{{ $vaccine->solieu }}</td>
                    <td>{{ $vaccine->khoangcachmuitiem }}</td>                    
                    <td><i><a href="" data-bs-toggle="modal"
                            data-bs-target="#Modalttvaccine" data-mavc="{{ $vaccine->mavc }}"
                            data-tenvc="{{ $vaccine->tenvc }}" data-benh_nhombenh="{{ $vaccine->tenbenh }}" data-thongtinvc="{{ $vaccine->thongtinvc }}"
                            >Chi tiết</a></i></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm edit-post" data-bs-toggle="modal"
                            data-bs-target="#Modalvaccine" data-mavc="{{ $vaccine->mavc }}" data-hinhanhvc="{{ asset($vaccine->hinhanhvc) }}"
                            data-tenvc="{{ $vaccine->tenvc }}" data-nuocsx="{{ $vaccine->nuocsx }}"
                            data-gia="{{ $vaccine->gia }}" data-soluong="{{ $vaccine->soluong }}"
                            data-thongtinvc="{{ $vaccine->thongtinvc }}" data-mancc="{{ $vaccine->mancc }}"
                            data-benh_nhombenh="{{ $vaccine->tenbenh }}" data-solieu="{{ $vaccine->solieu }}"
                            data-khoangcachmuitiem="{{ $vaccine->khoangcachmuitiem }}">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <a href="{{ url('/Admin/xoavaccine', $vaccine->mavc) }}"
                            onclick="return confirm('Bạn có chắc muốn xóa không!')" class="btn btn-danger btn-sm">
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
    <script src="{{ asset('js/fetchCountries.js') }}"></script>
    <script>
    document.getElementById('hinhanhminhhoa').addEventListener('change', function() {
        const reader = new FileReader();

        reader.onload = function(e) {
            const previewImage = document.getElementById('previewImage');
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    });
    // Script xử lý khi DOM được tải
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btn-themvaccine').addEventListener('click', function(){
            document.getElementById('mavc').value = "";
            document.getElementById('tenvc').value = "";
            document.getElementById('nuocsx').value = "";
            document.getElementById('gia').value = "";
            document.getElementById('soluong').value = "";
            document.getElementById('mancc').value = "";
            document.getElementById('benh_nhombenh').value = "";
            document.getElementById('solieu').value = "";
            document.getElementById('khoangcachmuitiem').value = "";
            document.getElementById('hinhanhminhhoa').value = "";
            document.getElementById('previewImage').setAttribute('src', "");
            document.getElementById('previewImage').style.display = "none";
            // Lấy tất cả các checkbox của nhóm tuổi
            var checkboxes = document.querySelectorAll('#doituong input[type="checkbox"]');
            // Duyệt qua từng checkbox và bỏ chọn
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            ckeditorthongtinvc();
            CKEDITOR.instances.thongtinvc1.setData('');
            populateCountries();
        })
        
        // Tạo bảng dữ liệu với plugin simpleDatatables
        var myTable = document.querySelector("#tablevaccine");
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
        document.getElementById('vaccineform').addEventListener('submit', function(event) {
            var nuocsx = document.getElementById('nuocsx').value;
            var mancc = document.getElementById('mancc').value;
            var errorDiv = document.getElementById('nuocsx-error');
            var errorDiv_ncc = document.getElementById('mancc-error');
            if (nuocsx === "" || mancc === "") {
                event.preventDefault();
                errorDiv.style.display = 'block';
                errorDiv_ncc.style.display = 'block';
            }
        });

        
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý sự kiện click cho nút "Sửa"
        var editButtons = document.querySelectorAll('.edit-post');
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Lấy dữ liệu từ thuộc tính data của nút "Sửa"
                populateCountries();
                var mavc = this.getAttribute('data-mavc');
                var tenvc = this.getAttribute('data-tenvc');
                var nuocsx = this.getAttribute('data-nuocsx');
                var gia = this.getAttribute('data-gia');
                var soluong = this.getAttribute('data-soluong');
                var mancc = this.getAttribute('data-mancc');
                var benh_nhombenh = this.getAttribute('data-benh_nhombenh');
                var solieu = this.getAttribute('data-solieu');
                var khoangcachmuitiem = this.getAttribute('data-khoangcachmuitiem');
                var ttvc = this.getAttribute('data-thongtinvc');
                var hinhanhvc = this.getAttribute('data-hinhanhvc');

                // Điền dữ liệu vào các trường input tương ứng
                document.getElementById('mavc').value = mavc;
                document.getElementById('tenvc').value = tenvc;
                document.getElementById('nuocsx').value = nuocsx;
                document.getElementById('gia').value = dinhdanggia(gia);
                document.getElementById('soluong').value = soluong;
                document.getElementById('mancc').value = mancc;
                document.getElementById('benh_nhombenh').value = benh_nhombenh;
                document.getElementById('solieu').value = solieu;
                document.getElementById('khoangcachmuitiem').value = khoangcachmuitiem;
                document.getElementById('thongtinvc1').value = ttvc;
                // Gắn ảnh minh họa cho input file
                fetch(hinhanhvc)
                    .then(res => res.blob())
                    .then(blob => {
                        const file = new File([blob], hinhanhvc.split('/').pop(), { type: blob.type });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        document.getElementById('hinhanhminhhoa').files = dataTransfer.files;

                        const previewImage = document.getElementById('previewImage');
                        previewImage.src = URL.createObjectURL(blob);
                        previewImage.style.display = 'block';
                    });
                document.getElementById('previewImage').style.display = "block";
                // Khai báo biến nhomtuoiSelect để chọn phần tử HTML tương ứng
                var nhomtuoiSelect = $('#doituong');
                var checkboxes = document.querySelectorAll('#doituong input[type="checkbox"]');
                // Duyệt qua từng checkbox và bỏ chọn
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
                // Gọi AJAX để lấy danh sách nhóm tuổi
                $.ajax({
                    url: `/dsnhomtuoi?mavc=${mavc}`,
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(nhomtuoi) {
                            // Nếu có, đánh dấu checkbox tương ứng
                            $(`#nhomtuoi${nhomtuoi.manhomtuoi}`).prop('checked', true);                            
                        })             
                    }
                });
                ckeditorthongtinvc();
                CKEDITOR.instances.thongtinvc1;
                // Đổi tiêu đề và nút Thêm thành Cập nhật
                document.querySelector('.modal-title').innerText = 'CẬP NHẬT VACCINE';
                document.querySelector('.modal-footer .btn-primary').innerText = 'Cập nhật';
            });

            
        });
        // Sự kiện click cho các liên kết "Chi tiết"
        document.querySelectorAll('[data-bs-target="#Modalttvaccine"]').forEach(function(link) {
            link.addEventListener('click', function() {
                // Lấy dữ liệu từ các thuộc tính data của liên kết
                var mavc = this.getAttribute('data-mavc');
                var tenvc = this.getAttribute('data-tenvc');
                var benh_nhombenh = this.getAttribute('data-benh_nhombenh');
                var thongtinvc = this.getAttribute('data-thongtinvc');
                
                // Gắn dữ liệu vào modal body
                document.getElementById('tenvc_benh').innerText = tenvc + ": " + benh_nhombenh;
                document.getElementById('ttvc').innerHTML = thongtinvc;
            });
        });
    });

    // Ẩn thông báo lỗi khi giá trị của select thay đổi
    document.getElementById('nuocsx').addEventListener('change', function() {
        var errorDiv = document.getElementById('nuocsx-error');
        if (this.value !== "") {
            errorDiv.style.display = 'none';
        }else{
            errorDiv.style.display = 'block';
        }
    });
    // Ẩn thông báo lỗi khi giá trị của select thay đổi
    document.getElementById('mancc').addEventListener('change', function() {
        var errorDiv = document.getElementById('mancc-error');
        if (this.value !== "") {
            errorDiv.style.display = 'none';
        }else{
            errorDiv.style.display = 'block';
        }
    }); 

    function formatCurrency(input) {
        // Định dạng tiền tệ
        var currency = input.value.replace(/[^\d]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        // Hiển thị tiền tệ định dạng vào ô nhập
        input.value = currency;
    }
    function dinhdanggia(input) {
        // Định dạng tiền tệ
        var currency = input.replace(/[^\d]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        // Trả về giá trị đã định dạng
        return currency;
    }

    
    function ckeditorthongtinvc() {
        if (CKEDITOR.instances.thongtinvc1) {
            CKEDITOR.instances.thongtinvc1.destroy(true);
        }
        CKEDITOR.replace('thongtinvc1');
    }
    
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('#tablevaccine tbody tr');
        rows.forEach(row => {
            const quantity = row.children[4].textContent.trim();
            if (quantity == '0') {
                row.style.backgroundColor = 'yellow';
            }
        });
    });
</script>
</body>

</html>