<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin khách hàng</title>
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
        .modal-dialog {
            max-width: 50% !important;
        }
    </style>
</head>
<body>
@include("menu/header")

<div id="quytrinhchuancuasafpo" class="content-body">
@if(session('success'))
    <div id="thanhcong" class="alert alert-success">{{ session('success') }}</div>
    <script>
        var dangtc = document.getElementById("thanhcong");
        setTimeout(function () {
                // Ẩn thông báo sau 2 giây
                dangtc.style.display = 'none';
            }, 5000);
    </script>
@endif
    <section class="body row">
        <section class="content_left col-md-9">
            <div>
                <a href="">Khách hàng</a>
                >
                <a href="">Lịch sử tiêm chủng</a>
            </div>
            <section class="title">
            <hr>
            </section>
            <h2 style="text-align: center; color: blue; font-weight: bold">LỊCH SỬ TIÊM CHỦNG</h2>
            <table id="tablelstiem" class="dataTable-table" style="width: 100%; ">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên vaccine</th>
                        <th>Mũi tiêm</th>
                        <th>Ngày tiêm dự kiến</th>
                        <th>Ngày tiêm thực tế</th>
                        <th>Trạng thái tiêm</th>
                        <th>Trạng thái đăng ký</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @if ($lstiems->isEmpty())
                        <tr>
                            <td colspan="6" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                        </tr>
                    @else
                        @php
                            $i = 1; 
                        @endphp
                        @foreach($lstiems as $lstiem)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $lstiem->tenvc }}</td>
                                <td>{{ $lstiem->muitiem }}</td>
                                <td>{{ \Carbon\Carbon::parse($lstiem->ngaytiemdukien)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($lstiem->ngaytiemthucte)
                                        {{  \Carbon\Carbon::parse($lstiem->ngaytiemthucte)->format('d/m/Y')  }}
                                    @endif
                                </td>
                                <td>{{ $lstiem->trangthaigoitiem }}</td>
                                <td>{{ $lstiem->trangthaidk }}</td>
                                <td><a href="#" class="view-details" data-toggle="modal" data-target="#detailsModal" data-details='@json($lstiem)' data-nhanviens="@json($nhanviens)"><i>Chi tiết</i></a></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <!-- Modal -->
            <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel" style="color: blue; font-weight: bold">CHI TIẾT LỊCH SỬ TIÊM CHỦNG</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col">
                            <p style="color: gray;">THÔNG TIN ĐĂNG KÝ</p>
                            <p><strong>Tên vaccine:</strong> <span id="detail-tenvc"></span></p>
                            <p><strong>Mũi tiêm:</strong> <span id="detail-muitiem"></span></p>
                            <p><strong>Ngày đăng ký:</strong> <span id="detail-ngaydangky"></span></p>
                            <p><strong>Ngày tiêm dự kiến:</strong> <span id="detail-ngaytiemdukien"></span></p>
                            <p><strong>Ngày tiêm thực tế:</strong> <span id="detail-ngaytiemthucte"></span></p>
                            <p><strong>Trạng thái đăng ký:</strong> <span id="detail-trangthaidk" ></span></p>
                            <div id="lidohuy"  style="display: none">
                            <p ><strong>Lí do:</strong> <span id="detail-lido" ></span></p></div>
                        </div>
                        <div class="col">
                            <p style="color: gray;">THÔNG TIN TIÊM CHỦNG</p>
                            <p><strong>Trạng thái tiêm:</strong> <span id="detail-trangthaigoitiem"></span></p>
                            <p><strong>Người tiêm:</strong> <span id="detail-nguoitiem"></span></p>

                            <p style="color: gray;">THÔNG TIN THANH TOÁN</p>
                            <p><strong>Hình thức thanh toán:</strong> <span id="detail-hinhthuctt"></span></p>
                            <p><strong>Đã thanh toán:</strong> <span id="detail-tientt"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content_right col-md-3">
            @include("menu/hienthibaiviet")
        </section>
    </section>
</div>

@include("menu/footer")
</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#detailsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var details = button.data('details');
            var nhanviens = @json($nhanviens); // Chắc chắn rằng nhanviens là một mảng được truyền từ Laravel

            $('#detail-tenvc').text(details.tenvc);
            $('#detail-muitiem').text(details.muitiem);
            $('#detail-ngaydangky').text(new Date(details.ngaydk).toLocaleDateString('vi-VN'));
            $('#detail-ngaytiemdukien').text(new Date(details.ngaytiemdukien).toLocaleDateString('vi-VN'));
            $('#detail-trangthaigoitiem').text(details.trangthaigoitiem);
            $('#detail-ngaytiemthucte').text(details.ngaytiemthucte ? new Date(details.ngaytiemthucte).toLocaleString('vi-VN') : 'Chưa có thông tin');
            
            $('#detail-trangthaidk').text(details.trangthaidk);
            $('#detail-hinhthuctt').text(details.hinhthucdk);
            $('#detail-tientt').text(formatCurrency(details.sotiendathanhtoan));
            if (details.ghichu != null && details.ghichu !== "") {
                document.getElementById('lidohuy').style.display = "block";
                $('#detail-lido').text(details.ghichu);
            }else{
                document.getElementById('lidohuy').style.display = "none";
            }
            // Tìm tên nhân viên dựa vào mã nhân viên
            var tenNhanVien = nhanviens.find(function (nv) {
                return nv.manv === details.nguoitiem;
            });

            if (tenNhanVien) {
                $('#detail-nguoitiem').text(tenNhanVien.tennv);
            } else {
                $('#detail-nguoitiem').text('Chưa có thông tin');
            }
        });
    });
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    }
</script>
