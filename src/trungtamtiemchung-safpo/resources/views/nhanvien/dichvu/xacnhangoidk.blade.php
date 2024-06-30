<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch tiêm chờ xác nhận</title>
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
    .xn_tc{
        width: 100px;
    }
    #tablethanhtoan tr, #tablethanhtoan td{
        border: none !important;
        
    }
    #tablethanhtoan .tieude{
        width: 50%;
        height: 50px;
        text-align: left !important;
        font-size: 18px;
        color: blue;
    }
    #tablethanhtoan .phantu{
        text-align: left !important;
        font-size: 18px;
        font-weight: bold;
    }
</style>
</head>
<body>
@include("Nhanvien/header_nv")

<div class="mb-5" style="width: 100%; margin: auto">
@if(session('success'))
    <div id="success" class="alert alert-success">{{ session('success') }}</div>
    <script>
        var dangtc = document.getElementById("success");
        setTimeout(function () {
                // Ẩn thông báo sau 2 giây
                dangtc.style.display = 'none';
            }, 5000);
    </script>
@endif
<ul class="nav nav-tabs" id="loginTab" role="tablist" style="font-weight: bold;">
    <li class="nav-item">
        <a class="nav-link active" id="vcle-tab" data-toggle="tab" href="#vcle" role="tab" aria-controls="vcle" aria-selected="true">Vaccine lẻ</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="vcgoi-tab" data-toggle="tab" href="#vcgoi" role="tab" aria-controls="vcgoi" aria-selected="false">Gói vaccine</a>
    </li>
</ul>
<div class="tab-content" id="loginTabContent">
    <div class="tab-pane fade show active" id="vcle" role="tabpanel" aria-labelledby="vcle-tab">
        <h2 class="text-primary">DANH SÁCH LỊCH TIÊM CHỜ XÁC NHẬN</h2>
        <table id="tablexnlichtiem" class="dataTable-table" style="width: 100%; ">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã khách hàng</th>
                    <th>Tên người tiêm</th>
                    <th>Ngày sinh</th>
                    <th>Số điện thoại</th>
                    <th>Tên vaccine</th>
                    <th>Ngày tiêm mong muốn</th>
                    <th id="tt">Thao tác</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if ($vcles->isEmpty())
                    <tr>
                        <td colspan="9" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                    </tr>
                @else
                    @php
                        $i = 1; 
                    @endphp
                    @foreach($vcles as $vcle)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $vcle->makh }}</td>
                            <td>{{ $vcle->tenkh }}</td>
                            <td>{{ \Carbon\Carbon::parse( $vcle->ngaysinhkh )->format('d/m/Y') }}</td>
                            <td>{{ $vcle->sdtkh }}</td>
                            <td>{{ $vcle->tenvc }}</td>
                            <td>{{ \Carbon\Carbon::parse($vcle->ngaytiemmongmuon )->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ url('/Nhanvien/xngoidk', $vcle->madk_goi) }}" onclick="return confirm('Xác nhận đã thanh toán và đăng ký!')" class="btn btn-primary btn-sm">
                                    <i class="fas fa-check"></i> Xác nhận
                                </a>
                                <a href="javascript:void(0)" onclick="openmodaltuchoi('{{ $vcle->madk_goi }}')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-times"></i> Từ chối
                                </a>
                            </td>
                            <td><a href=""><i>Chi tiết</i></a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

<div class="modal fade" id="modaltuchoi" tabindex="-1" aria-labelledby="modaltuchoiLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltuchoiLabel">Lý do từ chối</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="rejectionForm" method="POST" action="/Nhanvien/tuchoigoidk">
                @csrf
                    <div class="form-group">
                        <label for="lidotuchoi">Lý do từ chối</label>
                        <textarea class="form-control" id="lidotuchoi" name="lidotuchoi" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="hoantien">Hoàn tiền</label>
                        <select class="form-control" id="hoantien" name="hoantien">
                            <option value="0">Không hoàn tiền</option>
                            <option value="1">Hoàn tiền</option>
                        </select>
                    </div>
                    <input type="hidden" id="madk_goi" name="madk_goi">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-danger" id="confirmRejection">Xác nhận từ chối</button>
            </div>
        </form>
        </div>
    </div>
</div>

    <div class="tab-pane fade" id="vcgoi" role="tabpanel" aria-labelledby="vcgoi-tab">
    <h2 class="text-primary">DANH SÁCH GÓI TIÊM CHỜ XÁC NHẬN</h2>
        <table id="tablexnlichtiem" class="dataTable-table" style="width: 100%; ">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã khách hàng</th>
                    <th>Tên người tiêm</th>
                    <th>Ngày sinh</th>
                    <th>Số điện thoại</th>
                    <th>Tên gói</th>
                    <th>Số liều vc</th>
                    <th>Ngày tiêm mong muốn</th>
                    <th>Số tiền cần thanh toán</th>
                    <th id="tt">Thao tác</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if ($vcgois->isEmpty())
                    <tr>
                        <td colspan="10" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                    </tr>
                @else
                    @php
                        $i = 1; 
                    @endphp
                    @foreach($vcgois as $vcgoi)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $vcgoi->makh }}</td>
                            <td>{{ $vcgoi->tenkh }}</td>
                            <td>{{ \Carbon\Carbon::parse( $vcgoi->ngaysinhkh )->format('d/m/Y') }}</td>
                            <td>{{ $vcgoi->sdtkh }}</td>
                            <td>{{ $vcgoi->tengoi }}</td>
                            <td>{{ $vcgoi->soluongmuitiem }}</td>
                            <td>{{ \Carbon\Carbon::parse( $vcgoi->ngaytiemmongmuon )->format('d/m/Y') }}</td>
                            <td>{{ number_format(($vcgoi->tonggiatien * (1 - $vcgoi->uudai/100)) - $vcgoi->datcoc, 0, ',', '.') }}</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm mb-2 xn_tc" onclick="openModal('{{ $vcgoi->madk_goi }}')">
                                    <i class="fas fa-check"></i> Xác nhận
                                </a><br>
                                <a href="javascript:void(0)" onclick="openmodaltuchoi('{{ $vcgoi->madk_goi }}')" class="btn btn-danger btn-sm xn_tc">
                                    <i class="fas fa-times"></i> Từ chối
                                </a>
                            </td>
                            <td><a href=""><i>Chi tiết</i></a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="modal fade" id="modalxacnhan" tabindex="-1" aria-labelledby="modalxacnhanLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modalxacnhanLabel" style="color: #DC143C; font-weight: bold">YÊU CẦU THANH TOÁN</h3>
                        <button type="button" class="btn-close"onclick="closeModal()">
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="madk">
                        <table style="width: 100%; border-collapse: collapse; border: none;" id="tablethanhtoan">
                            <tr style="border-bottom: 1px solid #000 !important;">
                                <td class="tieude"><b>Tổng tiền: </b></td>
                                <td class="phantu"><span id="tongtien"></span> VNĐ</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #000 !important;">
                                <td class="tieude"><b>Giá ưu đãi: </b></td>
                                <td class="phantu"><span id="giauudai"></span> VNĐ</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #000 !important;">
                                <td class="tieude"><b>Đã đặt cọc: </b></td>
                                <td class="phantu"><span id="tiencoc"></span> VNĐ</td>
                            </tr>
                            <tr>
                                <td class="tieude"><b>Tổng tiền thanh toán: </b></td>
                                <td class="phantu"><span id="tienthanhtoan"></span> VNĐ</td>
                            </tr>
                        </table>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button class="btn btn-danger" onclick="xacnhan()">Xác nhận thanh toán</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@include("Nhanvien/footer_nv")
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myTable = document.querySelector("#tablexnlichtiem");
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
    });
</script>
<script>
    function openModal(id) {
        document.getElementById("madk").value =id;
        $.ajax({
            url: '/Nhanvien/gettongtien/' + id, // API endpoint or route to fetch data from server
            type: 'GET',
            success: function(response) {
                // Handle successful response from server
                $('#tongtien').text(response.tongtien); // Set total amount in modal
                $('#giauudai').text(response.giauudai);
                $('#tiencoc').text(response.tiencoc); // Set deposit amount in modal
                $('#tienthanhtoan').text(response.tienthanhtoan); // Set total payment amount in modal
                // Show the modal
                $('#modalxacnhan').modal('show');
            },
            error: function(error) {
                // Handle errors from server (if needed)
                console.error('Error fetching data from server:', error);
            }
        });
    }
    function xacnhan(){
        $madk_goi =document.getElementById("madk").value;
        closeModal();
        $.ajax({
            url: '/Nhanvien/xngoidk/' + $madk_goi, // API endpoint or route to fetch data from server
            type: 'GET',
            success: function(response) {
                location.reload();
            },
            error: function(error) {
                // Handle errors from server (if needed)
                console.error('Error fetching data from server:', error);
            }
        });
    }
// Hàm đóng modal
    function closeModal() {
        $('#modalxacnhan').modal('hide');
    }
    function openmodaltuchoi(id) {
        document.getElementById('madk_goi').value = id;
        $('#modaltuchoi').modal('show');
    }

    document.getElementById('confirmRejection').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var id = document.getElementById('madk_goi').value;
        var lidotuchoi = document.getElementById('lidotuchoi').value;
        var hoantien = document.getElementById('hoantien').value;

        if (!lidotuchoi.trim()) {
            alert('Vui lòng nhập lý do từ chối.');
            return;
        }
        $('#rejectionForm').submit();
    });
</script>

</body>
</html>
