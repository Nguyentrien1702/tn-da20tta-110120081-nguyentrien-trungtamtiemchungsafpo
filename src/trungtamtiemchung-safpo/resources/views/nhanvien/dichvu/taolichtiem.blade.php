<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục vaccine</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    #themkhdk label{
        font-weight: bold;
    }
    .loaidk{
        padding: 10px !important;
        font-weight: bold !important;
        border: 1px solid gray !important;
        border-radius: 3px !important;
        background-color: white !important;
        width: 150px !important;
    }
    .loaidk:hover{
        color: blue !important;
        border: 1px solid blue !important;
    }
    .active{
        background-color: #00BFFF !important;
    }
    #tb_tongtien td {
        vertical-align: middle;
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }
    #vaccineTable {
        width: 100%;
        margin: auto;
        text-align: center;
        border-collapse: collapse;
    }
    #vaccineTable th {
        padding: 10px 10px;
        background-color: #f2f2f2;
        font-weight: bold;
        font-size: 18px;
        border-radius: 3px;
    }
    #vaccineTable th, #vaccineTable td {
        border-bottom: 1px solid #ddd;
    }
    #vaccineTable tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    #vaccineTable p{
        margin: 0px 0px;
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
@include("nhanvien/header_nv")

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
<button id="themkh_tiem" class="btn btn-primary">Thêm khách hàng</button>
<div id="div_themkh_dk" class="container mt-4 mb-5 col-md-10" style="border: 1px solid blue; padding: 20px 20px; border-radius: 5px; background-color: #ddd; display: none;">
    <h2 style="font-weight: bold; color: red; text-align: center;">ĐĂNG KÝ TIÊM</h2>    
    <form action="/Nhanvien/themkh_dk" id="themkhdk" method="POST">
    @csrf
        <h5 class="text-secondary">THÔNG TIN NGƯỜI TIÊM</h5>
        <div class="form-group col">
            <label for="makh"> Mã khàng hàng (nếu có):</label>
            <input type="text" class="form-control" id="makh" placeholder="Mã khách hàng" name="makh" style="width: 40%;" list="list_makh">
            <datalist id="list_makh">
                @foreach($dsmakhs as $dsmakh)
                    <option value="{{ $dsmakh->makh }}"  data-ten="{{ $dsmakh->tenkh }}" data-ngaysinh="{{ $dsmakh->ngaysinhkh }}" data-diachi="{{ $dsmakh->diachikh }}"
                    data-ten_nglh="{{ $dsmakh->ten_nglh }}" data-sdt="{{ $dsmakh->sdtkh }}" data-quanhe="{{ $dsmakh->quanhevoikh }}" data-email="{{ $dsmakh->emailkh }}" data-gt="{{ $dsmakh->gioitinh }}">
                @endforeach
            </datalist>
        </div>
        <div class="row mt-3">
            <div class="form-group col">
                <label for="tennguoitiem"> Họ tên người tiêm:</label>
                <input type="text" class="form-control" id="tennguoitiem" placeholder="Họ tên người tiêm" name="tennguoitiem" required>
            </div>
            <div class="form-group col">
                <label for="ngaysinhnguoitiem"> Ngày sinh người tiêm:</label>
                <input type="date" class="form-control placeholder-style" id="ngaysinhnguoitiem" placeholder="Ngày/Tháng/Năm" name="ngaysinhnguoitiem" required min="1900-01-01" max="{{ date('Y-m-d') }}"  onchange="filterAgeGroups()">
            </div>
        </div>
        <div class="row mt-3">
            <div class="form-group col">
                <label for="gioitinhnguoitiem" class="font-weight-bold mr-3"> Giới tính:</label>
                <div class="form-check-inline">
                    <label class="form-check-label" style="font-size: 18px; font-weight: normal;">&nbsp;
                        <input type="radio" id="gioitinh_nam" class="form-check-input" name="gioitinh" value="Nam" checked>&nbsp;Nam
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label" style="font-size: 18px; font-weight: normal;">&nbsp;
                        <input type="radio" id="gioitinh_nu" class="form-check-input" name="gioitinh" value="Nữ">&nbsp;Nữ
                    </label>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="matp">Tỉnh/Thành phố</label>
                        <select class="form-control" id="matp" name="matp">
                            <option value="">-- Chọn Tỉnh/Thành phố --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="maqh">Quận/huyện</label>
                        <select class="form-control" id="maqh" name="maqh" disabled>
                            <option value="">-- Chọn quận/huyện --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="maxp">Phường/xã</label>
                        <select class="form-control" id="maxp" name="maxp" disabled>
                            <option value="">-- Chọn phường/xã --</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mt-3">
                <label for="diachi"> Địa chỉ:</label>
                <input type="text" class="form-control" id="diachi" placeholder="số nhà, tên đường" name="diachi" required>
            </div>
        </div>

        <h5 class="text-secondary mt-3">THÔNG TIN NGƯỜI LIÊN HỆ</h5>
        <div class="row mt-3">
            <div class="form-group col">
                <label for="tennguoilh"> Họ tên người liên hệ:</label>
                <input type="text" class="form-control" id="tennguoilh" placeholder="Họ tên người liên hệ" name="tennguoilh" required>
            </div>
            <div class="form-group col">
                <label for="moiqhnguoitiem"> Mối quan hệ với người tiêm:</label>
                <select name="moiqhnguoitiem" id="moiqhnguoitiem" class="form-control" required>
                    <option value="Bản thân">Bản thân</option>
                    <option value="Con">Con</option>
                    <option value="Cha">Cha</option>
                    <option value="Mẹ">Mẹ</option>
                    <option value="Vợ">Vợ</option>
                    <option value="Chồng">Chồng</option>
                    <option value="Anh">Anh</option>
                    <option value="Chị">Chị</option>
                    <option value="Em">Em</option>
                    <option value="Ông">Ông</option>
                    <option value="Bà">Bà</option>
                    <option value="Họ hàng">Họ hàng</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="form-group col">
                <label for="sodienthoai"> Số điện thoại liên hệ:</label>
                <input type="text" class="form-control" id="sodienthoai" placeholder="Số điện thoại" name="sodienthoai" maxlength="10" required pattern="[0-9]{10}">
            </div>
            <div class="form-group col">
                <label for="email"> Địa chỉ email:</label>
                <input type="email" class="form-control placeholder-style" id="email" placeholder="Địa chỉ email" name="email">
            </div>
        </div>

        <h5 class="text-secondary mt-3">THÔNG TIN DỊCH VỤ</h5>
        <div class="form-group mt-3">
            <button type="button" class="btn mr-3 loaidk" id="btnGoiVaccine" onclick="changeButtonStyle(this)">Gói vaccine</button>
            <button type="button" class="btn loaidk" id="btnVaccineLe" onclick="changeButtonStyle(this)">Vaccine lẻ</button>
        </div>

        <div id="inputGoiVaccine" style="display: none;">
            <!-- Nội dung input cho Gói vaccine -->
            <div class="form-group mt-3">
                <label for="loaigoi">Chọn gói vaccine:</label>
                <input type="text" name="magoi" id="magoi" style="display: none;">
                <input type="text" class="form-control" id="loaigoi" name="loaigoi" placeholder="Chọn loại gói vaccine" list="list_goivc">
                <datalist id="list_goivc">
                    @foreach($goivaccines as $goivaccine)
                        <option value="{{ $goivaccine->magoi }}" data-tongtien="{{ $goivaccine->tonggiatien}}" data-uudai="{{ $goivaccine->uudai }}" data-display="{{ $goivaccine->tengoi }} - Số liều: {{ $goivaccine->soluongmuitiem }}">{{ $goivaccine->tengoi }}</option>
                    @endforeach
                </datalist>
            </div>
        </div>

        <div id="inputVaccineLe" style="display: none;">
            <!-- Nội dung input cho Vaccine lẻ -->
            <div class="form-group mt-3">
                <label for="tenvaccine">Chọn vaccine:</label>
                <table id="vaccineTable" class="dataTable-table mt-3" style="width: 100%; margin: auto; text-align: center;">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th style="width: 30%;">Tên Vaccine</th>
                            <th style="width: 40%;">Bệnh</th>
                            <th style="width: 10%;">Số lượng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <input type="text" name="mavc[]" id="mavc_1" style="display: none;">
                                <input type="text" autocomplete="off" class="form-control mr-2 ml-2" id="tenvaccine_1" name="tenvaccine[]" placeholder="Chọn tên vaccine" list="list_vc1">
                                <datalist id="list_vc1">
                                    @foreach($vaccines as $vaccine)
                                    @if( $vaccine->soluong > 0)
                                        <option value="{{ $vaccine->mavc }}" data-gia="{{ $vaccine->gia }}" data-benh="{{ $vaccine->tenbenh }}" data-tenvc="{{ $vaccine->tenvc }}">({{ $vaccine->soluong }}) {{ $vaccine->tenvc }} - {{ $vaccine->tenbenh }}</option>
                                    @endif
                                    @endforeach
                                </datalist>
                            </td>
                            <td>
                                <p id="benh_1"></p>
                            </td>
                            <td><p id="sluong_1"></p></td>
                            <td><button type="button" class="add_remv" onclick="addRow()">+</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div name="gia" style="text-align: right; margin-top: 20px;">
            <table id="tb_tongtien" style="width: 40%; margin-left: auto;">
                <tr>
                    <td style="text-align: left;"><h6>Tổng tiền:</h6></td>
                    <td><span id="tongtien">0</span> VNĐ</td>
                </tr>
                <tr>
                    <td style="text-align: left;"><h6>Giá ưu đãi:</h6></td>
                    <td><span id="giauudai">0</span> VNĐ</td>
                </tr>
                <tr>
                    <td style="text-align: left;"><h5>Tổng thanh toán: </h5></td>
                    <td><span id="tongtientt" style="font-size: 18px;">0</span> VNĐ</td>
                </tr>
            </table>
        </div>
        <div style="text-align: right;">
            <button onclick="return openModal()" type="submit" class="btn btn-danger mt-3 btn-datlich" style="font-size: 20px; padding: 10px 10px; width: 30%;" onclick="return submitForm()"><i class="fas fa-paper-plane"></i>&nbsp;Thanh toán</button>
        </div>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">Xác nhận thanh toán</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Bạn có chắc chắn muốn thực hiện thanh toán?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <button type="button" class="btn btn-danger" onclick="submitForm()">Xác nhận thanh toán</button>
        </div>
        </div>
    </div>
    </div>

</div>
<div>
    <!-- Bảng Danh sách lịch tiêm vaccine -->
    <h2 class="text-primary" style="font-weight: bold; text-align: center;">DANH SÁCH KHÁCH HÀNG CHỜ TIÊM CHỦNG</h2>
    <table id="tablelichtiem" class="dataTable-table" style="width: 100%; ">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã khách hàng</th>
                <th>Tên khách hàng</th>
                <th>Ngày sinh</th>
                <th>Tên vaccine</th>
                <th>Mũi tiêm</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <!-- Duyệt danh sách -->
            @if ($lichtiems->isEmpty())
            <tr>
                <td colspan="6" style="text-align: center;"><i>Không có dữ liệu.</i></td>
            </tr>
            @else
            @php
            $i = 1;
            @endphp
            @foreach($lichtiems as $lichtiem)
            <tr>
                <td>{{$i++}}</td>
                <td>{{ $lichtiem->makh }}</td>
                <td>{{ $lichtiem->tenkh }}</td>
                <td>{{ \Carbon\Carbon::parse( $lichtiem->ngaysinhkh )->format('d/m/Y')}}</td>
                <td>{{ $lichtiem->tenvc }} ({{ $lichtiem->nuocsx }})</td>
                <td>{{ $lichtiem->muitiem }}</td>
                <td style="color: green"><i>{{ $lichtiem->trangthaitiem }}</i></td>                    
                <td>
                    <button class="btn btn-danger">Hủy đăng ký</button>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@include("nhanvien/footer_nv")
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeDataTable('tablelichtiem');
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
// Hàm mở modal
function openModal() {
    // Lấy giá trị của hai input
    var loaigoiValue = document.getElementById('loaigoi').value.trim();
    var vaccineValue = document.getElementById('tenvaccine_1').value.trim();

    // Kiểm tra nếu cả hai input đều rỗng
    if (loaigoiValue === '' && vaccineValue === "") {
        // Hiển thị thông báo lỗi
        alert('Vui lòng chọn gói vaccine hoặc vaccine lẻ.');
        return false; // Ngăn chặn submit form
    }else{
        $('#confirmModal').modal('show');
        return false;
    }
    
}

// Hàm xử lý khi xác nhận thanh toán
function submitForm() {

    // Đóng modal sau khi xác nhận
    $('#confirmModal').modal('hide');

    // Thực hiện submit form
    $('#themkhdk').submit();
}
</script>
<script>
    $(document).ready(function() {
        // Xử lý khi người dùng chọn từ danh sách datalist
        $('#loaigoi').on('input', function() {
            var $magoi =document.getElementById("magoi");
            var inputValue = $(this).val();
            var option = $('#list_goivc').find('option[value="' + inputValue + '"]');
            if (option.length > 0) {
                $magoi.value =inputValue;
                // Hiển thị tên gói vaccine trong input
                $(this).val(option.data('display'));
            }
        });
    });

    $(document).ready(function() {
        // Xử lý sự kiện khi chọn mã khách hàng
        $('#makh').change(function() {
            var selectedOption = $(this).val();
            var option = $('#list_makh').find('option[value="' + selectedOption + '"]');
            
            if (option.length > 0) {
                $('#tennguoitiem').val(option.data('ten'));
                $('#ngaysinhnguoitiem').val(option.data('ngaysinh'));
                $('#diachi').val(option.data('diachi'));
                $('#tennguoilh').val(option.data('ten_nglh'));
                $('#moiqhnguoitiem').val(option.data('quanhe'));
                $('#sodienthoai').val(option.data('sdt'));
                $('#email').val(option.data('email'));
                if(option.data('gt') == "Nam"){
                    $('#gioitinh_nam').prop('checked', true);
                }else{
                    $('#gioitinh_nu').prop('checked', true);
                }
            }
        });
    });
    function changeButtonStyle(clickedButton) {
        // Lấy danh sách tất cả các nút có class 'loaidk'
        var buttons = document.querySelectorAll('.loaidk');

        // Lặp qua từng nút và loại bỏ lớp 'active' (nếu có)
        buttons.forEach(function(button) {
            button.classList.remove('active');
        });
        // Thêm lớp 'active' cho nút được click
        clickedButton.classList.add('active');
        if (clickedButton.id === 'btnVaccineLe') {
            document.getElementById("inputVaccineLe").style.display = "block";
            document.getElementById("inputGoiVaccine").style.display = "none";
            document.getElementById("loaigoi").value = "";
            document.getElementById("magoi").value = "";
        }
        else{
            document.getElementById("inputVaccineLe").style.display = "none";
            document.getElementById("inputGoiVaccine").style.display = "block";
            
            document.getElementById("mavc_1").value = "";
            document.getElementById("tenvaccine_1").value = "";
            document.getElementById("benh_1").innerText = "";
            document.getElementById("sluong_1").innerText = "";
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
        }
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
        var inputId = "tenvaccine_" + rowCount;
        
        cell2.innerHTML ='<input type="text" name="mavc[]" id="mavc_' + rowCount + '" style="display: none;">'
                            + '<input autocomplete="off" type="text" class="form-control" id="' + inputId + '" name="tenvaccine[]" placeholder="Chọn tên vaccine" list="list_vc' + rowCount + '">'
                            +'<datalist id="list_vc' + rowCount + '">'
                            +'@foreach($vaccines as $vaccine) @if( $vaccine->soluong > 0)'
                            +'        <option value="{{ $vaccine->mavc }}" data-gia="{{ $vaccine->gia }}" data-benh="{{ $vaccine->tenbenh }}" data-tenvc="{{ $vaccine->tenvc }}">{{ $vaccine->tenvc }} - {{ $vaccine->tenbenh }}</option>'
                            +'@endif    @endforeach'
                            +'</datalist>'
        cell3.innerHTML = '<p id="benh_' + rowCount + '"></p>';
        cell4.innerHTML = '<p id="sluong_' + rowCount + '"></p>';
        cell5.innerHTML = '<button type="button" class="add_remv" style="margin-right: 3px" onclick="addRow()">+</button><button type="button" class="add_remv" onclick="removeRow(this)">-</button>';
        id = "list_vc" + rowCount;
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
        updateTotalPrice();

        rowCount--; // Giảm biến đếm sau khi xóa dòng
    }
    function updateVaccineOptions(id) {
        var vaccineInputs = document.querySelectorAll("input[id^='mavc_']");

        var allDataLists = document.querySelectorAll("#" + id + " option");
        allDataLists.forEach(function(option) {
            vaccineInputs.forEach(function(input) {
                if (input.value == option.value) {
                    option.remove();
                }
            });
        });
    }
    // Event delegation for handling input change events
    document.getElementById('vaccineTable').addEventListener('change', function(event) {
        var target = event.target;
        if (target && target.matches('input[type="text"][name="tenvaccine[]"]')) {
            handleVaccineChange(target);
            updateTotalPrice();
        }
    });

    function handleVaccineChange(inputElement) {
        
        var row = inputElement.closest('tr');
        var benhElement = row.querySelector('p[id^="benh_"]');
        var sluongElement = row.querySelector('p[id^="sluong_"]');
        var mavc = row.querySelector('input[id^="mavc_"]');

        var datalist = document.getElementById(inputElement.getAttribute('list'));
        var selectedOption = Array.from(datalist.options).find(option => option.value === inputElement.value);

        if (selectedOption) {
            mavc.value =inputElement.value;
            inputElement.value = selectedOption.getAttribute('data-tenvc');
            benhElement.textContent = selectedOption.getAttribute('data-benh');
            sluongElement.textContent = '1';
        } else {
            benhElement.textContent = '';
            sluongElement.textContent = '';
            mavc.value = '';
            inputElement.value = '';
        }
    }
    function updateTotalPrice() {
        var total = 0;
        
        // Lấy ra tbody của bảng vaccineTable
        var tbody = document.getElementById("vaccineTable").getElementsByTagName('tbody')[0];
        // Lấy ra tất cả các dòng trong tbody
        var rows = tbody.getElementsByTagName('tr');

        // Duyệt qua từng dòng (bỏ qua dòng đầu tiên)
        for (var i = 0; i < rows.length; i++) {
            // Lấy tên vaccine và giá từ dữ liệu
            var vaccineInput = rows[i].querySelector('input[name="tenvaccine[]"]');
            var datalist = document.getElementById(vaccineInput.getAttribute('list'));
            var selectedOption = Array.from(datalist.options).find(option => option.getAttribute('data-tenvc') === vaccineInput.value);
            if (selectedOption) {                
                // Lấy giá từ data-gia và cộng vào tổng
                var gia = parseFloat(selectedOption.getAttribute('data-gia'));
                total += gia;
            }
        }

        // Cập nhật giá trị vào các ô tổng tiền trên giao diện
        document.getElementById("tongtien").textContent = total.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }).replace('₫', '').trim()//total.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        document.getElementById("giauudai").textContent = "0"; // Đang chưa có tính năng giảm giá, nếu có sẽ cập nhật giá trị tương ứng
        var tongtien = total;
        document.getElementById("tongtientt").textContent = tongtien.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }).replace('₫', '').trim();
    }


    $(document).ready(function() {
        // Sự kiện khi thay đổi giá trị của gói vaccine
        $('input[name="loaigoi"]').change(function() {
            var selectedGoi = $(this).val().trim(); // Lấy giá trị và xoá khoảng trắng xung quanh

            var option = $('#list_goivc option').filter(function() {
                var displayText = $(this).data('display').trim(); // Lấy giá trị data-display và xoá khoảng trắng xung quanh
                return displayText === selectedGoi;
            });

            if (option.length > 0) {
                var tongtien = parseFloat(option.data('tongtien')); // Lấy tổng tiền từ data-tongtien
                var uudai = parseFloat(option.data('uudai')); // Lấy giảm giá từ data-uudai

                // Tính giá trị sau khi áp dụng giảm giá
                var giaSauUuDai = tongtien * (1 - uudai / 100);

                // Hiển thị giá trị lên giao diện
                document.getElementById("tongtien").textContent = tongtien.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }).replace('₫', '').trim();
                document.getElementById("giauudai").textContent = (tongtien - giaSauUuDai).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }).replace('₫', '').trim();
                document.getElementById("tongtientt").textContent = giaSauUuDai.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }).replace('₫', '').trim();
            } else {
                document.getElementById("tongtien").textContent = 0;
                document.getElementById("giauudai").textContent = 0;
                document.getElementById("tongtientt").textContent = 0;
                document.getElementById("loaigoi").value = "";
                document.getElementById("magoi").value = "";
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Lấy danh sách quốc gia khi trang được tải
        $.ajax({
            url: '/tinhtp',
            method: 'GET',
            success: function(data) {
                const countrySelect = $('#matp');
                data.forEach(function(country) {
                    countrySelect.append(new Option(country.name, country.matp));
                });
            }
        });

        // Lấy danh sách tỉnh/thành phố khi một quốc gia được chọn
        $('#matp').change(function() {
            const countryId = $(this).val();
            const stateSelect = $('#maqh');
            stateSelect.html('<option value="">-- Chọn quận/huyện --</option>').prop('disabled', true);
            $('#maxp').html('<option value="">-- Chọn phường/xã --</option>').prop('disabled', true);

            if (countryId) {
                $.ajax({
                    url: `/quanhuyen?matp=${countryId}`,
                    method: 'GET',
                    success: function(data) {
                        stateSelect.prop('disabled', false);
                        data.forEach(function(state) {
                            stateSelect.append(new Option(state.name, state.maqh));
                        });
                    }
                });
            }
        });

        // Lấy danh sách quận/huyện khi một tỉnh/thành phố được chọn
        $('#maqh').change(function() {
            const stateId = $(this).val();
            const citySelect = $('#maxp');
            citySelect.html('<option value="">-- Chọn phường/xã --</option>').prop('disabled', true);

            if (stateId) {
                $.ajax({
                    url: `/xaphuong?maqh=${stateId}`,
                    method: 'GET',
                    success: function(data) {
                        citySelect.prop('disabled', false);
                        data.forEach(function(city) {
                            citySelect.append(new Option(city.name, city.xaid));
                        });
                    }
                });
            }
        });
    });
    // Bắt sự kiện click vào nút "Thêm khách hàng"
    document.getElementById('themkh_tiem').addEventListener('click', function() {
        var divThemKh = document.getElementById('div_themkh_dk');
        
        // Kiểm tra trạng thái hiển thị của div và thay đổi nếu cần
        if (divThemKh.style.display === 'none') {
            divThemKh.style.display = 'block'; // Hiển thị div khi bị ẩn
        } else {
            divThemKh.style.display = 'none'; // Ẩn div khi đã hiển thị
        }
    });
</script>
</body>
</html>