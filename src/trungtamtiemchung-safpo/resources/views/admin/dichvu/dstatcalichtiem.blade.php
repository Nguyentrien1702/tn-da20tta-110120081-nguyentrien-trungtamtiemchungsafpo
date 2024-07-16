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
</style>
</head>
<body>
@include("admin/header_admin")

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
<ul class="nav nav-tabs mb-3" id="loginTab" role="tablist" style="font-weight: bold;">
    <li class="nav-item">
        <a class="nav-link active" id="tatca-tab" data-toggle="tab" href="#tatca" role="tab" aria-controls="tatca" aria-selected="true">Tất cả</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="chotiem-tab" data-toggle="tab" href="#chotiem" role="tab" aria-controls="chotiem" aria-selected="true">Chờ tiêm</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="dahuy-tab" data-toggle="tab" href="#dahuy" role="tab" aria-controls="dahuy" aria-selected="false">Đã hủy</a>
    </li>
</ul>
<div class="tab-content" id="loginTabContent">
    <div class="tab-pane fade show active" id="tatca" role="tabpanel" aria-labelledby="tatca-tab">
        <h2 class="text-primary">DANH SÁCH TẤT CẢ LỊCH TIÊM</h2>
        <table id="tabletclichtiem" class="dataTable-table" style="width: 100%; ">
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
    </div>
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

    <div class="tab-pane fade" id="chotiem" role="tabpanel" aria-labelledby="chotiem-tab">
        <h2 class="text-primary">DANH SÁCH KHÁCH HÀNG CHỜ TIÊM CHỦNG</h2>
        <table id="tablelstiem" class="table dataTable-table" style="width: 100%; ">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã kh</th>
                    <th>Tên người tiêm</th>
                    <th>Ngày sinh</th>
                    <th>Tên vaccine</th>
                    <th>Mũi tiêm</th>
                    <th>Trạng thái tiêm</th>
                    <th>Ngày tiêm dự kiến</th>
                    <th id="tt">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($dschotiems->isEmpty())
                    <tr>
                        <td colspan="9" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                    </tr>
                @else
                    @php
                        $i = 1; 
                    @endphp
                    @foreach($dschotiems as $dschotiem)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $dschotiem->makh }}</td>
                            <td>{{ $dschotiem->tenkh }}</td>
                            <td>{{ \Carbon\Carbon::parse( $dschotiem->ngaysinhkh )->format('d/m/Y') }}</td>
                            <td>{{ $dschotiem->tenvc }}</td>
                            <td>{{ $dschotiem->muitiem}}</td>
                            <td><i style="color: green;">{{ $dschotiem->trangthaitiem }}</i></td>
                            <td>{{ \Carbon\Carbon::parse( $dschotiem->ngaytiemdukien )->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ url('/Admin/xntiem/' . $dschotiem->madk_goi . '/' . $dschotiem->mavc) }}" onclick="return confirm('Xác nhận đã tiêm chủng!')" class="btn btn-primary btn-sm">
                                    <i class="fas fa-check"></i> Xác nhận tiêm
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <h2 class="text-primary">DANH SÁCH GÓI TIÊM</h2>
        <table id="tabledsgoitiem" class="table dataTable-table" style="width: 100%; ">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã kh</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày sinh</th>
                    <th>Tên gói</th>
                    <th>Ngày tiêm mong muốn</th>
                    <th>Số mũi đã tiêm</th>
                    <th>Số mũi còn lại</th>
                    <th>Thao tác</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if ($goiTiems->isEmpty())
                    <tr>
                        <td colspan="10" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                    </tr>
                @else
                    @php
                        $i = 1; 
                    @endphp
                    @foreach($goiTiems as $dsgoitiem)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $dsgoitiem->makh }}</td>
                            <td>{{ $dsgoitiem->tenkh }}</td>
                            <td>{{ \Carbon\Carbon::parse( $dsgoitiem->ngaysinhkh )->format('d/m/Y') }}</td>
                            <td>{{ $dsgoitiem->tengoi }}</td>
                            <td>{{ \Carbon\Carbon::parse( $dsgoitiem->ngaytiemmongmuon )->format('d/m/Y') }}</td>
                            <td>{{ $dsgoitiem->soluongdatiem }}</td>
                            <td>{{ $dsgoitiem->soluongmuitiem -  $dsgoitiem->soluongdatiem}}</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm">
                                    <i class="fas fa-check"></i> Tạo lịch tiêm
                                </a>
                            </td>
                            <td><a href="" class="btn-chi-tiet" data-makh="{{ $dsgoitiem->makh }}" data-madk-goi="{{ $dsgoitiem->madk_goi }}" data-bs-toggle="modal" data-bs-target="#modalchitietgoi"><i>Chi tiết</i></a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Modal chi tiết gói tiêm -->
        <div class="modal" id="modalchitietgoi" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title text-primary" style="font-weight: bold;">CHI TIẾT GÓI TIÊM</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="nccform" method="POST" action="" enctype="multipart/form-data" class="was-validated">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p><strong>Mã khách hàng:</strong> <span id="modal-makh"></span></p>
                        <p><strong>Tên gói tiêm:</strong> <span id="modal-tengoi"></span></p>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >Lưu</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

</div>

@include("admin/footer_admin")
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
<script>
    $(document).ready(function() {
        // Khi modal được hiển thị
        $('#modalchitietgoi').on('show.bs.modal', function (event) {
            // Lấy thông tin từ nút đã nhấn
            var button = $(event.relatedTarget); // Nút đã kích hoạt modal
            var makh = button.data('makh'); // Truy cập thuộc tính data-makh
            var madk_goi = button.data('madk-goi');

            // Gửi yêu cầu AJAX để lấy thông tin chi tiết
            $.ajax({
                url: '/Admin/ajax_ctgoitiem?madk_goi='+madk_goi, // Đường dẫn tới API để lấy thông tin chi tiết
                method: 'GET',
                success: function(data) {
                    if (data && data.length > 0) {
                        var goivaccine = data[0]; // Assuming only one record is returned
                        $('#modal-makh').text(goivaccine.makh);
                        $('#modal-tengoi').text(goivaccine.tengoi);
                    } else {
                        console.error('Empty response or invalid data format.');
                    }  
                    
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi nếu có
                    console.error('Failed to fetch data', error);
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeDataTable('tablelstiem');
        initializeDataTable('tabletclichtiem');
        initializeDataTable('tabledsgoitiem');
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
                    url: '/Admin/getchitietmuitiemkh', // URL API để lấy chi tiết mũi tiêm
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
