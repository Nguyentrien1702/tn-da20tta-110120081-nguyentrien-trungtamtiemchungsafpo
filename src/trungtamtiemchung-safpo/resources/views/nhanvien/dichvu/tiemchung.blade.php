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
    #divttkhachhang{
        margin: auto;
        width: 90%;
        border: 1px solid blue;
        border-radius: 5px;
        display: none;
        background-color: khaki;
        padding: 20px 20px;
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

<div id="divttkhachhang">
    <h2 style="text-align: center; font-weight: bold;">Thông tin khách hàng</h2>
    <p><strong>Mã khách hàng:</strong> <span id="makh"> </span></p>
    <p><strong>Tên khách hàng:</strong> <span id="tenkh"> </span></p>
    <p><strong>Ngày sinh:</strong> <span id="ngaysinhkh"> </span></p>

    <h4>LỊCH SỬ TIÊM CHỦNG</h4>

    <a href="" class="btn btn-primary">Xác nhận tiêm chủng</a>
</div>

    <h2 class="text-primary">DANH SÁCH KHÁCH HÀNG CHỜ TIÊM CHỦNG</h2>
    <table id="tabletiemchung" class="dataTable-table" style="width: 100%; ">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã khách hàng</th>
                <th>Tên khách hàng</th>
                <th>Ngày sinh</th>
                <th>Tên vaccine</th>
                <th>Mũi tiêm</th>
                <th>Thao tác</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if ($dstiemchungs->isEmpty())
                <tr>
                    <td colspan="8" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                </tr>
            @else
                @php
                    $i = 1; 
                @endphp
                @foreach($dstiemchungs as $dstiemchung)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{ $dstiemchung->makh }}</td>
                        <td>{{ $dstiemchung->tenkh }}</td>
                        <td>{{ \Carbon\Carbon::parse( $dstiemchung->ngaysinhkh )->format('d/m/Y') }}</td>
                        <td>{{ $dstiemchung->tenvc }}</td>
                        <td>{{ $dstiemchung->muitiem }}</td>
                        <td>
                            <a href="{{ url('/Nhanvien/tiemchung', $dstiemchung->madk_goi) }}" onclick="return confirm('Xác nhận tiêm')" class="btn btn-primary btn-sm"  data-id="{{ $dstiemchung->makh }}">Tiêm chủng</a>
                        </td>
                        <td><a href="#"><i>Chi tiết</i></a></td>
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
                    <th>Ngày tiêm đăng ký</th>
                    <th>Số mũi đã tiêm</th>
                    <th>Số mũi còn lại</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            @if ($goiTiems->isEmpty())
                    <tr>
                        <td colspan="9" style="text-align: center;"><i>Không có dữ liệu.</i></td>
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
                            <td>{{ \Carbon\Carbon::parse( $dsgoitiem->ngaydk )->format('d/m/Y') }}</td>
                            <td>{{ $dsgoitiem->soluongdatiem }}</td>
                            <td>{{ $dsgoitiem->soluongmuitiem -  $dsgoitiem->soluongdatiem}}</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm btn-taolich" data-magoi="{{ $dsgoitiem->magoi }}">
                                    <i class="fas fa-check"></i> Tạo lịch tiêm
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
</div>

@include("nhanvien/footer_nv")
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeDataTable("tabletiemchung");
        initializeDataTable("tabledsgoitiem");
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
        initializeDataTable("tabletiemchung");

        // Thêm sự kiện click cho các nút "Tiêm chủng"
        var buttons = document.querySelectorAll('.btn-tiemchung');
        buttons.forEach(function(button) {
            button.addEventListener('click', function() {
                var maKhachHang = this.getAttribute('data-id');
                fetchCustomerInfo(maKhachHang);
            });
        });
    });

    function fetchCustomerInfo(maKhachHang) {
        fetch(`/Nhanvien/get-ttkhachhang/${maKhachHang}`)
            .then(response => response.json())
            .then(data => {
                displayCustomerInfo(data);
            })
            .catch(error => {
                console.error('Error fetching customer info:', error);
            });
    }

    function displayCustomerInfo(data) {    
        var infoDiv = document.getElementById('divttkhachhang');
        infoDiv.style.display = "block";
        document.getElementById("makh").innerText = data.makh;
        document.getElementById("tenkh").innerText = data.tenkh;
        document.getElementById("ngaysinhkh").innerText = data.ngaysinhkh;
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Thêm sự kiện click cho các nút "Tạo lịch tiêm"
    var buttons = document.querySelectorAll('.btn-taolich');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var maGoiTiem = this.getAttribute('data-magoi');
            fetchVaccineList(maGoiTiem);
        });
    });
});

function fetchVaccineList(maGoiTiem) {
    fetch(`/Nhanvien/get-vaccines/${maGoiTiem}`)
        .then(response => response.json())
        .then(data => {
            displayVaccineList(data);
        })
        .catch(error => {
            console.error('Error fetching vaccine list:', error);
        });
}

function displayVaccineList(data) {
    var lichTiemTable = document.createElement('table');
    lichTiemTable.id = 'lichTiemTable';

    var tableHeaders = `
        <thead>
            <tr>
                <th>Tên vaccine</th>
                <th>Ngày tiêm dự kiến</th>
                <th></th>
            </tr>
        </thead>
    `;

    var tableBody = '<tbody><tr><td><select id="vaccineSelect">';
    if (data.vaccines && data.vaccines.length > 0) {
        data.vaccines.forEach(function(vaccine) {
            tableBody += `<option value="${vaccine.mavc}">${vaccine.tenvc}</option>`;
        });
    } else {
        tableBody += '<option value="">Không có vaccine</option>';
    }
    tableBody += '</select></td>';
    tableBody += `<td><input type="date" id="ngayTiem"></td>`;
    tableBody += '<td><button type="button" class="btn btn-primary btn-sm btn-add-row">';
    tableBody += '<i class="fas fa-plus"></i> Thêm dòng</button></td></tr></tbody>';

    lichTiemTable.innerHTML = tableHeaders + tableBody;

    var divTaoLich = document.getElementById('divttkhachhang');
    divTaoLich.innerHTML = ''; // Xóa nội dung cũ (nếu có)
    divTaoLich.appendChild(lichTiemTable);
    divTaoLich.style.display = 'block';

    // Thêm sự kiện cho nút "Thêm dòng"
    var btnAddRow = lichTiemTable.querySelector('.btn-add-row');
    btnAddRow.addEventListener('click', function() {
        addRowToLichTiemTable();
    });
}

function addRowToLichTiemTable() {
    var tableBody = document.querySelector('#lichTiemTable tbody');
    var newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td><select id="vaccineSelect">
            <!-- Option nên được tạo bằng JavaScript từ dữ liệu API -->
        </select></td>
        <td><input type="date" id="ngayTiem"></td>
        <td><button type="button" class="btn btn-primary btn-sm btn-add-row">
            <i class="fas fa-plus"></i> Thêm dòng
        </button></td>
    `;
    tableBody.appendChild(newRow);
}
</script>
</body>
</html>
