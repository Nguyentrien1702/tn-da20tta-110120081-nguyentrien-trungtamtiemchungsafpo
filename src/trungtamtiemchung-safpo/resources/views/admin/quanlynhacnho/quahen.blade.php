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
    <li class="nav-item ">
        <a class="nav-link active" id="chotiem-tab" data-toggle="tab" href="#chotiem" role="tab" aria-controls="chotiem" aria-selected="true">Nhắc nhở tiêm chủng</a>
    </li>
</ul>
<div class="tab-content" id="loginTabContent">
    <div class="tab-pane fade show active" id="chotiem" role="tabpanel" aria-labelledby="chotiem-tab">
        <h2 class="text-primary">DANH SÁCH MŨI TIÊM CẦN NHẮC NHỞ</h2>
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
                @if ($tiemleqhs->isEmpty())
                    <tr>
                        <td colspan="9" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                    </tr>
                @else
                    @php
                        $i = 1; 
                    @endphp
                    @foreach($tiemleqhs as $dschotiem)
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
                                <a href="#" class="btn btn-primary btn-sm mb-2 btn-capnhat-ngaytiem" style="width: 140px;" data-madk-goi="{{ $dschotiem->madk_goi }}">Cập nhật ngày tiêm</a><br>
                                <a style="width: 140px;" href="{{ url('/Admin/huymuitiem/' . $dschotiem->madk_goi . '/'. $dschotiem->makh) }}" onclick="return confirm('Xác nhận hủy')" class="btn btn-danger btn-sm">
                                    Hủy mũi tiêm
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <!-- <!-- Modal cập nhật ngày tiêm -->
        <div class="modal fade" id="modalCapNhatNgayTiem" tabindex="-1" aria-labelledby="modalCapNhatNgayTiemLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCapNhatNgayTiemLabel" style="color: blue; font-weight:bold">Cập nhật ngày tiêm</h5>
                        <button type="button" class="btn-Close" data-bs-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formCapNhatNgayTiem" method="POST" action="{{ url('/Admin/capnhatngaytiem') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="madk_goi_input" name="madk_goi"> <!-- Input hidden để lưu madk_goi -->
                            <div class="form-group">
                                <label for="ngaytiem">Ngày tiêm mới:</label>
                                <input type="date" class="form-control" id="ngaytiem" name="ngaytiem" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <h2 class="text-primary">DANH SÁCH GÓI TIÊM CẦN NHẮC NHỞ</h2>
        <table id="tabledsgoitiem" class="table dataTable-table" style="width: 100%; ">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã kh</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày sinh</th>
                    <th>Số điện thoại</th>
                    <th>Tên gói</th>
                    <th>Ngày tiêm mong muốn</th>
                    <th>Thao tác</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if ($goitiemqhs->isEmpty())
                    <tr>
                        <td colspan="9" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                    </tr>
                @else
                    @php
                        $i = 1; 
                    @endphp
                    @foreach($goitiemqhs as $goitiemqh)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $goitiemqh->makh }}</td>
                            <td>{{ $goitiemqh->tenkh }}</td>
                            <td>{{ \Carbon\Carbon::parse( $goitiemqh->ngaysinhkh )->format('d/m/Y') }}</td>
                            <td>{{ $goitiemqh->sdtkh }}</td>
                            <td>{{ $goitiemqh->tengoi }}</td>
                            <td>{{ \Carbon\Carbon::parse( $goitiemqh->ngaytiemmongmuon )->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ url('/Admin/huygoi/' . $goitiemqh->madk_goi . '/'. $goitiemqh->makh) }}" onclick="return confirm('Xác nhận hủy')" class="btn btn-primary btn-sm">
                                    Hủy gói
                                </a>
                                
                            </td>
                            <td><a href="#"><i>Chi tiết</i></a></td>
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
        initializeDataTable('tabletatca');
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
    $(document).ready(function() {
        // Khi nhấn vào nút Cập nhật ngày tiêm
        $('#tablelstiem').on('click', '.btn-capnhat-ngaytiem', function() {
            var row = $(this).closest('tr');
            var madk_goi = $(this).data('madk-goi'); // Lấy madk_goi từ thuộc tính data-madk-goi của nút đã nhấn
            
            // Đưa thông tin vào modal
            $('#madk_goi_input').val(madk_goi);

            // Cập nhật giá trị min date và max date cho input ngày tiêm
            var currentDate = new Date();
            var maxDate = new Date();
            maxDate.setDate(currentDate.getDate() + 10); // max date là ngày hiện tại cộng thêm 10 ngày
            $('#ngaytiem').attr('min', currentDate.toISOString().slice(0,10)); // gắn min date là ngày hiện tại
            $('#ngaytiem').attr('max', maxDate.toISOString().slice(0,10)); // gắn max date là ngày hiện tại + 10 ngày

            // Hiển thị modal
            $('#modalCapNhatNgayTiem').modal('show');
        });
    });
</script>
</body>
</html>
