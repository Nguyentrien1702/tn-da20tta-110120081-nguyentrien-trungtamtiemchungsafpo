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
    @include("nhanvien/header_nv")
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
   
    <div style="width: 100%; margin: auto;">

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
                    <td>
                        @php
                            $khoangCachNgay = $vaccine->khoangcachmuitiem;
                            if ($khoangCachNgay % 7 == 0) {
                                $khoangCach = $khoangCachNgay / 7 . " tuần";
                            } elseif ($khoangCachNgay % 30 == 0) {
                                $khoangCach = $khoangCachNgay / 30 . " tháng";
                            } else {
                                $khoangCach = $khoangCachNgay . " ngày";
                            }
                        @endphp
                        {{ $khoangCach }}
                    </td>                    
                    <td><i><a href="" data-bs-toggle="modal"
                            data-bs-target="#Modalttvaccine" data-mavc="{{ $vaccine->mavc }}"
                            data-tenvc="{{ $vaccine->tenvc }}" data-benh_nhombenh="{{ $vaccine->tenbenh }}" data-thongtinvc="{{ $vaccine->thongtinvc }}"
                            >Chi tiết</a></i></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

    </div>
    @include("nhanvien/footer_nv")
    <script src="{{ asset('js/fetchCountries.js') }}"></script>
    <script>
    // Script xử lý khi DOM được tải
    document.addEventListener('DOMContentLoaded', function() {
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

            // Tô màu đỏ cho các dòng có giá trị bằng 0 trong cột số lượng
            function highlightRows() {
                document.querySelectorAll("#tablevaccine tbody tr").forEach(function(row) {
                    var soLuongCell = row.cells[4]; // Cột số lượng là cột thứ 5 (chỉ số 4)
                    if (soLuongCell.innerText.trim() == "0") {
                        row.style.backgroundColor = "#eee250"; // Tô màu chữ cho toàn bộ dòng là màu đỏ
                    }else{
                        row.style.backgroundColor = "";
                    }
                });
            }


            // Initial highlighting
            highlightRows();

            // Highlight rows whenever the table is updated (e.g., pagination, search)
            dataTable.on('datatable.update', highlightRows);
        }

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
        })

        
        
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

    </script>
</body>

</html>