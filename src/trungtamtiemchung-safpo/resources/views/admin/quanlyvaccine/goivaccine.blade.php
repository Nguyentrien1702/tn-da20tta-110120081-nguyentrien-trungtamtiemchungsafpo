<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục vaccine</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('backend/ckeditor_4.22.1_full_easyimage/ckeditor/ckeditor.js') }}"></script>
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
        label {
            font-weight: bold;
        }
        .edit-post {
            margin-bottom: 2px;
        }
        .modal-dialog{
            max-width: 60% !important;
        }
        #tengoi_ct{
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
        .add_remv{
            width: 30px;
            height: 30px;
            margin-right: 3px;
        }
        .slpd{
            vertical-align: middle;
            margin: 0px 0px;
        }
        .td_col5{
            font-weight: bold;
        }
        #ct_vaccine tr:nth-child(even) {
            background-color: #f2f2f2; /* Màu nền cho các dòng chẵn */
        }

        #ct_vaccine tr:nth-child(odd) {
            background-color: #ffffff; /* Màu nền cho các dòng lẻ */
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
    <button class="btn btn-primary mb-3" id="btn-themgoivaccine" data-bs-toggle="modal" data-bs-target="#Modalvaccine">Thêm gói vaccine</button>

    <div style="width: 100%; margin: auto;">
        <!-- Modal Thêm vaccine -->
        <div class="modal" id="Modalvaccine" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Header Modal -->
                    <div class="modal-header">
                        <h4 class="modal-title text-primary" style="font-weight: bold;">THÊM GÓI VACCINE</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Form Thêm/Sửa -->
                    <form id="goivaccineForm" method="POST" action="/Admin/themgoivaccine" enctype="multipart/form-data"
                        class="needs-validated">
                        @csrf
                        <div class="modal-body">
                            <input type="text" id="magoi" name="magoi" style="display: none;">
                            <div class="row">
                                <!-- Các trường dữ liệu mới -->
                                <h5 style="color: gray; text-align: left">THÔNG TIN GÓI VACCINE</h5>
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label for="tengoivc">Tên gói vaccine:</label>
                                        <input type="text" class="form-control" id="tengoivc" name="tengoivc" placeholder="Tên gói vaccine" required>
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label for="datcoc">Số tiền đặt cọc (VNĐ):</label>
                                        <input type="text" class="form-control" id="datcoc" name="datcoc" maxlength="13" onkeyup="formatCurrency(this)" placeholder="Số tiền đặt cọc" required>
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mb-3">
                                        <label for="uudai">Ưu đãi (%):</label>
                                        <input type="number" class="form-control" id="uudai" name="uudai" min="0.1" max="100" step="0.1" placeholder="Ưu đãi" required>
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Vui lòng nhập dữ liệu.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h5 style="color: gray; text-align: left">DANH SÁCH VACCINE</h5>
                                <table id="vaccineTable" class="dataTable-table" style="width: 95%; margin: auto">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên Vaccine</th>
                                            <th style="width: 20%;">Số Lượng Liều</th>
                                            <th style="width: 20%;">Số liều tiêm theo phác đồ</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                            <input type="text" class="form-control" onblur="filterVaccineOptions(this)" id="vaccine_1" placeholder="chọn vaccine" name="vaccine[1][tenvc]" list="list-vaccien1">
                                            <datalist id="list-vaccien1">
                                                @foreach($vaccines as $vaccine)
                                                    <option value="{{ $vaccine->tenvc }}"></option>
                                                @endforeach
                                            </datalist>
                                            </td>
                                            <td>
                                                <input type="number" id="slmuitiem_1"  name="vaccine[1][solieu]" class="form-control" min="1" value="1">
                                            </td>
                                            <td><p id="muitiempd_1"  class="slpd"></p></td>
                                            <td><button type="button" class="add_remv" onclick="addRow()">+</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                            <h5 style="color: gray; text-align: left; margin-top: 10px">THÔNG TIN ĐỐI TƯỢNG</h5>
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
                                        <h5 style="color: gray; text-align: left">THÔNG TIN THÊM VỀ GÓI VACCINE</h5>
                                        <textarea class="form-control" id="thongtingoivc1" name="thongtingoivc" rows="3"></textarea>
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

        <!-- Modal thông tin gói vaccine -->
        <div class="modal" id="Modalttgoivc" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Header Modal -->
                    <div class="modal-header">
                        <h4 class="modal-title text-primary" style="font-weight: bold;">THÔNG TIN CHI TIẾT GÓI VACCINE</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="margin-left: 20px; margin-right: 20px; border-radius: 5px;">
                        <h4 id="tengoi_ct" class="mb-3"></h4>
                        <table id="ct_vaccine" class="dataTable-table" style="width: 95%; margin: auto">
                            <thead>
                                <th>STT</th>
                                <th>Phòng bệnh</th>
                                <th>Tên vaccine</th>
                                <th>Nước sx</th>
                                <th>Số mũi theo phác đồ</th>
                                <th>Số mũi theo gói</th>
                            </thead>
                            <tbody>
                                <td colspan="6"></td>
                            </tbody>
                        </table>
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
        <h2 class="text-primary">DANH SÁCH GÓI VACCINE</h2>
        <table id="tablegoivaccine" class="dataTable-table" style="width: 100%; ">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên gói vaccine</th>
                    <th>Sl vaccine</th>
                    <th>Sl liều tiêm</th>
                    <th>Ưu đãi</th>
                    <th>Phí giữ trả trước <br>(VNĐ)</th>
                    <th>Giá gói (VNĐ)<br> (chưa ưu đãi)</th>
                    <th>Thao tác</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if ($goivaccines->isEmpty())
                    <tr>
                        <td colspan="8" style="text-align: center;"><i>Không có dữ liệu.</i></td>
                    </tr>
                @else
                    @php
                        $i = 1;
                    @endphp
                    @foreach($goivaccines as $goivc)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $goivc->tengoi }}</td>
                            <td>{{ $goivc->soluongvaccine }}</td>
                            <td>{{ $goivc->soluongmuitiem }}</td>
                            <td>{{ $goivc->uudai }}%</td>
                            <td>{{ number_format($goivc->datcoc, 0, ',', '.') }}</td>  
                            <td>{{ number_format($goivc->tonggiatien, 0, ',', '.') }}</td>   
                            <td>
                                <button type="button" class="btn btn-primary btn-sm edit-post" data-bs-toggle="modal"
                                    data-bs-target="#Modalvaccine" data-magoi = "{{ $goivc->magoi }}" data-tengoi="{{ $goivc->tengoi }}"
                                    data-uudai="{{ $goivc->uudai }}" data-datcoc="{{ $goivc->datcoc }}" data-mota="{{ $goivc->mota }}">
                                    <i class="fas fa-edit"></i> Sửa
                                </button>
                                <!-- <a href="{{ url('/Admin/xoavaccine', $goivc->magoi) }}"
                                    onclick="return confirm('Bạn có chắc muốn xóa không!')" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </a> -->
                            </td>
                            <td><i><a href="" data-bs-toggle="modal"
                                    data-bs-target="#Modalttgoivc" data-magoi="{{ $goivc->magoi }}" data-tengoi = "{{ $goivc->tengoi }}" data-uudai="{{ $goivc->uudai }}">Chi tiết</a></i></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            
        </table>

    </div>
    @include("admin/footer_admin")
<script>  
// Script xử lý khi DOM được tải
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btn-themgoivaccine').addEventListener('click', function(){
        document.getElementById('magoi').value = "";
        document.getElementById('tengoivc').value = "";
        document.getElementById('uudai').value = "";
        document.getElementById('datcoc').value = "";
        document.getElementById("vaccine_1").value = "";
        document.getElementById("slmuitiem_1").value = 1;
        document.getElementById("muitiempd_1").innerText = "";
        document.getElementById("thongtingoivc1").value = "";
        // Lấy tất cả các checkbox của nhóm tuổi
        var checkboxes = document.querySelectorAll('#doituong input[type="checkbox"]');
        // Duyệt qua từng checkbox và bỏ chọn
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });

        // Lấy ra tbody của bảng vaccineTable
        var tbody = document.getElementById("vaccineTable").getElementsByTagName('tbody')[0];
        // Lấy ra tất cả các dòng trong tbody
        var rows = tbody.getElementsByTagName('tr');
        // Nếu số lượng dòng lớn hơn 1 (tức là đã có dữ liệu ngoại trừ dòng đầu tiên)
        if (rows.length > 1) {
            // Bắt đầu từ dòng thứ hai, xóa tất cả các dòng
            for (var i = rows.length - 1; i > 0; i--) {
                tbody.removeChild(rows[i]);
            }
        }
        
        document.querySelector('.modal-title').innerText = 'THÊM GÓI VACCINE';
        document.querySelector('.modal-footer .btn-primary').innerText = 'Thêm';
    })
    
    // Tạo bảng dữ liệu với plugin simpleDatatables
    var myTable = document.querySelector("#tablegoivaccine");
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

document.addEventListener('DOMContentLoaded', function() {
    // Xử lý sự kiện click cho nút "Sửa"
    var editButtons = document.querySelectorAll('.edit-post');
    editButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var magoi = this.getAttribute('data-magoi');
            var tengoi = this.getAttribute('data-tengoi');
            var uudai = this.getAttribute('data-uudai');
            var datcoc = this.getAttribute('data-datcoc');
            var mota = this.getAttribute('data-mota');


            // Điền dữ liệu vào các trường input tương ứng
            document.getElementById('magoi').value = magoi;
            document.getElementById('tengoivc').value = tengoi;
            document.getElementById('uudai').value = uudai;
            document.getElementById('datcoc').value = dinhdanggia(datcoc);
            document.getElementById('thongtingoivc1').value = mota;
            // Khai báo biến nhomtuoiSelect để chọn phần tử HTML tương ứng
            var nhomtuoiSelect = $('#doituong');
            // Lấy ra tbody của bảng vaccineTable
            var tbody = document.getElementById("vaccineTable").getElementsByTagName('tbody')[0];
            // Lấy ra tất cả các dòng trong tbody
            var rows = tbody.getElementsByTagName('tr');
            // Nếu số lượng dòng lớn hơn 1 (tức là đã có dữ liệu ngoại trừ dòng đầu tiên)
            if (rows.length > 1) {
                // Bắt đầu từ dòng thứ hai, xóa tất cả các dòng
                for (var i = rows.length - 1; i > 0; i--) {
                    tbody.removeChild(rows[i]);
                }
            }
            var checkboxes = document.querySelectorAll('#doituong input[type="checkbox"]');
            // Duyệt qua từng checkbox và bỏ chọn
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            // Gọi AJAX để lấy danh sách nhóm tuổi
            $.ajax({
                url: `/dsnhomtuoigoi?magoi=${magoi}`,
                method: 'GET',
                success: function(data) {
                    data.forEach(function(nhomtuoi) {
                        // Nếu có, đánh dấu checkbox tương ứng
                        $(`#nhomtuoi${nhomtuoi.manhomtuoi}`).prop('checked', true); 
                    });
                    
                }
            });
            // Gọi AJAX để lấy danh sách vaccine
            let rowCount = 1;
            $.ajax({
                url: `/dsvaccine?magoi=${magoi}`,
                method: 'GET',
                success: function(data) {
                    data.forEach(function(vaccine) {
                        document.getElementById("vaccine_"+rowCount).value =vaccine.tenvc;
                        document.getElementById("slmuitiem_"+rowCount).value =vaccine.soluongmuitiem;
                        document.getElementById("muitiempd_"+rowCount).innerText =vaccine.solieu;
                        document.getElementById("slmuitiem_"+rowCount).max = vaccine.solieu;
                        rowCount++;
                        if (rowCount <= data.length) {
                            // Nếu đã xử lý hết tất cả dữ liệu, gọi hàm addRow()
                            addRow();
                        }
                    });
                    
                }
            });
            // Đổi tiêu đề và nút Thêm thành Cập nhật
            document.querySelector('.modal-title').innerText = 'CẬP NHẬT GÓI VACCINE';
            document.querySelector('.modal-footer .btn-primary').innerText = 'Cập nhật';
        });

        
    });
    // Sự kiện click cho các liên kết "Chi tiết"
    document.querySelectorAll('[data-bs-target="#Modalttgoivc"]').forEach(function(link) {
        link.addEventListener('click', function() {
            var tonglieu = 0;
            var tongtien = 0;
            // Lấy dữ liệu từ các thuộc tính data của liên kết
            var tengoivc = this.getAttribute('data-tengoi');
            var magoi = this.getAttribute('data-magoi');
            var uudai = this.getAttribute('data-uudai');
            // Gắn dữ liệu vào modal body
            document.getElementById('tengoi_ct').innerText = tengoivc;

            $.ajax({
                url: `/dsvaccine?magoi=${magoi}`,
                method: 'GET',
                success: function(data) {
                    // Lấy phần tử tbody của bảng
                    var tbody = document.querySelector('#ct_vaccine tbody');
                    // Xóa các hàng hiện có trong tbody
                    tbody.innerHTML = '';

                    // Duyệt qua dữ liệu trả về và thêm các hàng vào bảng
                    data.forEach(function(vaccine, index) {
                        // Tạo một hàng mới
                        var tr = document.createElement('tr');
                        
                        // Tạo các ô và thêm dữ liệu vào ô tương ứng
                        var sttCell = document.createElement('td');
                        sttCell.textContent = index + 1;
                        tr.appendChild(sttCell);

                        var phongBenhCell = document.createElement('td');
                        phongBenhCell.textContent = vaccine.tenbenh;
                        tr.appendChild(phongBenhCell);

                        var tenVaccineCell = document.createElement('td');
                        tenVaccineCell.textContent = vaccine.tenvc;
                        tr.appendChild(tenVaccineCell);

                        var nuocSxCell = document.createElement('td');
                        nuocSxCell.textContent = vaccine.nuocsx;
                        tr.appendChild(nuocSxCell);

                        var soMuiTheoPhacDoCell = document.createElement('td');
                        soMuiTheoPhacDoCell.textContent = vaccine.solieu;
                        tr.appendChild(soMuiTheoPhacDoCell);

                        var soluongmuitiemCell = document.createElement('td');
                        soluongmuitiemCell.textContent = vaccine.soluongmuitiem;
                        tr.appendChild(soluongmuitiemCell);
                        tonglieu = tonglieu + vaccine.soluongmuitiem;
                        tongtien = tongtien + (vaccine.soluongmuitiem * vaccine.gia)
                        // Thêm hàng mới vào tbody
                        tbody.appendChild(tr);
                    });
                    for (let i = 0; i < 4; i++) {
                        var additionalTr = document.createElement('tr');

                        // Tạo ô và thêm dữ liệu tương ứng cho hàng mới
                        var additionalTd = document.createElement('td');
                        var additionalTd2 = document.createElement('td');
                        additionalTd.colSpan = 5;
                        if (i === 0) 
                        {
                            additionalTd.textContent = "Tổng số liều";
                            additionalTd2.textContent = tonglieu;
                        }
                        else if (i === 1) {
                            additionalTd.textContent = "Giá gói";
                            additionalTd2.textContent = dinhdang(tongtien);
                        }
                        else if (i === 2) {
                            additionalTd.textContent = "Giá gói ưu đãi";
                            additionalTd2.textContent = dinhdang(Math.floor((tongtien - (tongtien * (uudai/100)))));
                        }
                        else if (i === 3) {
                            additionalTd.textContent = "Số tiền ưu đãi (" + uudai + "%)";
                            additionalTd2.textContent = dinhdang(Math.floor((tongtien * (uudai/100))));
                        }
                        additionalTd.classList.add('td_col5');
                        additionalTr.appendChild(additionalTd);
                        additionalTr.appendChild(additionalTd2);

                        // Thêm hàng mới vào tbody
                        tbody.appendChild(additionalTr);
                    }               
                }
            });
        });
    });
});
function dinhdang(gia) {
    return gia.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
}
function formatCurrency(input) {
    // Định dạng tiền tệ
    var currency = input.value.replace(/[^\d]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    if(currency<1){
        input.value = "";
    }else{
        // Hiển thị tiền tệ định dạng vào ô nhập
        input.value = currency;
    }        
}
function dinhdanggia(input) {
    // Định dạng tiền tệ
    var currency = input.replace(/[^\d]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    // Trả về giá trị đã định dạng
    return currency;
}


function ckeditorthongtingoivc() {
    if (CKEDITOR.instances.thongtingoivc1) {
        CKEDITOR.instances.thongtingoivc1.destroy(true);
    }
    CKEDITOR.replace('thongtingoivc1');
}

</script>
<script>
    function addRow() {
        var table = document.getElementById("vaccineTable").getElementsByTagName('tbody')[0];
        rowCount = table.rows.length;
        var newRow = table.insertRow(table.rows.length);
        
        rowCount++;
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);

        cell1.innerHTML = rowCount;

        // Define the inputId variable within the function
        var inputId = "vaccine_" + rowCount;
        
        cell2.innerHTML = '<input type="text" onblur="filterVaccineOptions(this)" class="form-control" id="' + inputId + '" placeholder="chọn vaccine" name="vaccine['+ rowCount +'][tenvc]" list="list-vaccien' + rowCount + '">'
                           + '<datalist id="list-vaccien' + rowCount + '">'
                           + '@foreach($vaccines as $vaccine)'
                           +'<option value="{{ $vaccine->tenvc }}">'
                           + '@endforeach'
                           + '</datalist>';
        cell3.innerHTML = '<input type="number" id="slmuitiem_'+ rowCount +'" name="vaccine['+ rowCount +'][solieu]" class="form-control" min="1" value="1">';
        cell4.innerHTML = '<p id="muitiempd_' + rowCount + '" class="slpd"></p>';
        cell5.innerHTML = '<button type="button" class="add_remv" style="margin-right: 3px" onclick="addRow()">+</button><button type="button" class="add_remv" onclick="removeRow(this)">-</button>';
        id = "list-vaccien" + rowCount;
        updateVaccineOptions(id);
    }
    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row); // Xóa dòng khi nút "-" được click

        // Duyệt qua tất cả các dòng và cập nhật lại số thứ tự
        var table = document.getElementById("vaccineTable").getElementsByTagName('tbody')[0];
        var rows = table.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            rows[i].cells[0].innerHTML = i + 1; // Cập nhật số thứ tự (STT)
        }

        rowCount--; // Giảm biến đếm sau khi xóa dòng
    }
    function filterVaccineOptions(input) {
        // Lấy giá trị nhập vào từ trường input
        var inputValue = input.value;

        // Lấy danh sách các lựa chọn từ datalist
        var dataList = document.getElementById(input.getAttribute('list'));
        var options = dataList.querySelectorAll('option');

        // Biến để kiểm tra xem giá trị nhập vào có khớp với bất kỳ lựa chọn nào trong danh sách không
        var matched = false;
        options.forEach(function(option) {
            if (option.value === inputValue) {
                matched = true;
                $.ajax({
                    url: `/vaccine`,
                    method: 'GET',
                    success: function(data) {
                        data.forEach(function(vaccine) {
                            if(inputValue == vaccine.tenvc){
                                // Tìm phần tử tr (dòng) chứa phần tử input
                                var tr = input.closest('tr');
                                var rowIndex = tr.rowIndex;
                                document.getElementById("muitiempd_"+rowIndex).innerText = vaccine.solieu;
                                document.getElementById('slmuitiem_'+ rowCount).max = vaccine.solieu
                            }
                        });
                        
                    }
                });
            }
        });

        // Nếu không có lựa chọn nào khớp, đặt giá trị của trường input về rỗng
        if (!matched) {
            input.value = '';
        }

    }

    function updateVaccineOptions(id) {
        var vaccineInputs = document.querySelectorAll("input[id^='vaccine_']");

        var allDataLists = document.querySelectorAll("#" + id + " option");
        allDataLists.forEach(function(option) {
            vaccineInputs.forEach(function(input) {
                if (input.value == option.value) {
                    option.remove();
                }
            });
        });
    }
</script>
</body>
</html>