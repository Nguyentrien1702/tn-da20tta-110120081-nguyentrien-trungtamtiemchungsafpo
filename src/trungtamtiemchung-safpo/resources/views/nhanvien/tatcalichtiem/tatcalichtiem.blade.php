<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách lịch tiêm</title>
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
    .dataTable-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .dataTable-table tr:nth-child(odd) {
        background-color: white;
    }
</style>
</head>
<body>
@include("nhanvien/header_nv")

<div class="mb-5" style="width: 100%; margin: auto">
@if(session('success'))
    <div id="success" class="alert alert-success">{{ session('success') }}</div>
    <script>
        var dangtc = document.getElementById("success");
        setTimeout(function () {
                // Ẩn thông báo sau 2 giây
                dangtc.style.display = 'none';
            }, 3000);
    </script>
@endif
<div id="lichhen">
    <h2 class="text-primary">DANH SÁCH TẤT CẢ LỊCH TIÊM</h2>
    <table id="tablexnlichhen" class="dataTable-table" style="width: 100%; ">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã khách hàng</th>
                <th>Ngày tiêm dự kiến</th>
                <th>Số lượng vaccine</th>
                <th>Danh sách vaccine</th>
                <th>Trạng thái đăng ký</th>
                <th>Trạng thái tiêm</th>
                <th id="tt">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @if ($tatcalichtiems->isEmpty())
                <tr>
                    <td colspan="8" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                </tr>
            @else
                @php
                    $i = 1; 
                @endphp
                @foreach($tatcalichtiems as $tatcalichtiem)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ $tatcalichtiem->makh }}</td>
                        <td>{{ \Carbon\Carbon::parse( $tatcalichtiem->ngaytiemdukien )->format('d/m/Y') }}</td>
                        <td>{{ $tatcalichtiem->soluongvc }}</td>
                        <td>{{ $tatcalichtiem->ds_tenvaccine }}</td>
                        <td>{{ $tatcalichtiem->trangthaidk }}</td>
                        <td>{{ $tatcalichtiem->trangthaitiem }}</td>
                        <td>
                            <a href="#" class="detail-post" data-ma="{{ $tatcalichtiem->makh }}" data-ngaytiem="{{ $tatcalichtiem->ngaytiemdukien }}">
                                <i>Chi tiết</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 65% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle" style="color: blue; font-weight: bold;">THÔNG TIN CHI TIẾT MŨI TIÊM</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                    <div id="ttkh"></div>
                    <table class="dataTable-table" style="margin: auto;">
                        <thead style="background-color: gainsboro;">
                            <tr style="text-align: center;">
                                <th>Tên vaccine</th>
                                <th>Ngày đăng ký</th>
                                <th>Ngày tiêm dự kiến</th>
                                <th>Ngày tiêm thực tế</th>
                                <th>Trạng thái tiêm</th>
                                <th>Nhân viên tiêm</th>
                                <th>Hình thức đăng ký</th>
                                <th>Tổng thanh toán</th>
                            </tr>
                        </thead>
                        <tbody id="detailBody">
                            <!-- Dữ liệu sẽ được thêm vào đây -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@include("nhanvien/footer_nv")
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeDataTable('tablexnlichhen');
    });

    function initializeDataTable(tableId) {
        var myTable = document.getElementById(tableId);
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
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý sự kiện khi nhấn nút chi tiết
        document.querySelectorAll('.detail-post').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn chặn hành động mặc định của thẻ a

                var makh = this.getAttribute('data-ma');
                var ngaytiem = this.getAttribute('data-ngaytiem');

                // Gọi AJAX để lấy chi tiết các mũi tiêm của khách hàng
                $.ajax({
                    url: '/Nhanvien/getchitietmuitiemkh', // URL API để lấy chi tiết mũi tiêm
                    method: 'GET',
                    data: { makh: makh, ngaytiem: ngaytiem },
                    success: function(response) {
                        // Xóa dữ liệu cũ
                        $('#ttkh').empty();
                        $('#detailBody').empty();
                        // Kiểm tra dữ liệu từ server và hiển thị
                        if (response.details.length > 0) {
                            response.details.forEach(function(item) {
                                // Xử lý dữ liệu và hiển thị trong modal
                                $('#ttkh').html(`
                                    <p><strong>Mã khách hàng:</strong> ${item.makh}</p>
                                    <p><strong>Tên khách hàng:</strong> ${item.tenkh}</p>
                                `);
                                // Định dạng ngày
                                var ngaydk = new Date(item.ngaydk).toLocaleDateString('vi-VN');
                                var ngaytiemdukien = new Date(item.ngaytiemdukien).toLocaleDateString('vi-VN');
                                var ngaytiemthucte = item.ngaytiemthucte ? new Date(item.ngaytiemthucte).toLocaleString('vi-VN') : '';

                                // Định dạng tiền
                                var sotiendathanhtoan = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.sotiendathanhtoan);

                                // Thêm dòng vào bảng chi tiết
                                $('#detailBody').append(`
                                    <tr>
                                        <td>${item.tenvc}</td>
                                        <td>${ngaydk}</td>
                                        <td>${ngaytiemdukien}</td>
                                        <td>${ngaytiemthucte}</td>
                                        <td>${item.trangthaitiem}</td>
                                        ${(() => {
                                            let tenNhanVien = '';
                                            response.nhanviens.forEach(function(nv) {
                                                if (nv.manv == item.nguoitiem) {
                                                    tenNhanVien = nv.tennv;
                                                }
                                            });
                                            return `<td>${tenNhanVien}</td>`;
                                        })()}
                                        <td>${item.hinhthucdk}</td>
                                        <td>${sotiendathanhtoan}</td>
                                    </tr>
                                `);

                            });
                        }
                        
                        $('#detailModal').modal('show');
                    },
                    error: function() {
                        alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
                    }
                });
            });
        });
    });
</script>
</body>
</html>
