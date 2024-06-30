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

    <h2 style="text-align: center; color: blue; font-weight: bold">THÔNG TIN NHÂN VIÊN</h2>
    <form action="/Nhanvien/capnhattnv" method="POST" style="width: 50%; margin: auto;">
    @csrf
        @foreach($nhanviens as $nhanvien)
        <div class="form-group mt-3">
            <label for="manv" style="font-weight: bold;"> Mã nhân viên:</label>
            <input type="text" class="form-control placeholder-style" id="manv" name="manv" value="{{ $nhanvien->manv }}" readonly>
        </div>
        <div class="row">
            <div class="form-group mt-3 col">
                <label for="vaitro" style="font-weight: bold;"> Vai trò:</label>
                <input type="text" class="form-control placeholder-style" id="vaitro" name="vaitro" value="{{$nhanvien->vaitro}}" readonly>
            </div>
            <div class="form-group mt-3 col">
                <label for="ngaybdlamviec" style="font-weight: bold;"> Vai trò:</label>
                <input type="text" class="form-control placeholder-style" id="ngaybdlamviec" name="ngaybdlamviec" value="{{$nhanvien->ngaybdlamviec}}" readonly>
            </div>
        </div>
        <div class="form-group mt-3">
            <label for="tennv" style="font-weight: bold;">Họ tên nhân viên:</label>
            <input type="text" class="form-control placeholder-style" id="tennv" placeholder="Họ tên" name="tennv" value="{{$nhanvien->tennv}}" required>
        </div>
        <div class="form-group mt-3">
            <label for="ngaysinh" style="font-weight: bold;">Ngày sinh:</label>
            <input type="date" class="form-control placeholder-style" id="ngaysinh" placeholder="Ngày sinh" name="ngaysinh" value="{{$nhanvien->ngaysinhnv}}" required>
        </div>
        <div class="form-group mt-3">
            <label for="gioitinh" style="font-weight: bold;"> Giới tính:</label>
            <div class="form-check form-check-inline" style="margin-left: 10px;">
                <input class="form-check-input" type="radio" id="gioitinh_nam" name="gioitinh" value="Nam" {{ $nhanvien->gioitinh == 'Nam' ? 'checked' : '' }}>
                <label class="form-check-label" for="gioitinh_nam">Nam</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="gioitinh_nu" name="gioitinh" value="Nữ" {{ $nhanvien->gioitinh == 'Nữ' ? 'checked' : '' }}>
                <label class="form-check-label" for="gioitinh_nu">Nữ</label>
            </div>
        </div>
        <div class="form-group mt-3 mb-3 col" >
            <label for="sdtnv" style="font-weight: bold;">Số điện thoại:</label>
            <input type="text" class="form-control" id="sdtnv" name="sdtnv" required maxlength="10" pattern="[0-9]{10}" placeholder="Số điện thoại" value="{{$nhanvien->sdtnv}}">
        </div>
        <div class="form-group mt-3 mb-3">
            <label for="emailnv" style="font-weight: bold;">Email:</label>
            <input type="email" class="form-control" id="emailnv" name="emailnv" placeholder="Email khách hàng" value="{{$nhanvien->emailnv}}">
        </div>
        <div class="form-group mt-3">
            <label for="diachi" style="font-weight: bold;">Địa chỉ:</label>
            <input type="text" class="form-control placeholder-style" id="diachi" name="diachi" value="{{$nhanvien->diachinv}}" required>
        </div>
        @endforeach 
        <div style="text-align: right;">
        <button type="submit" class="btn btn-danger mt-3 mr-5" style="font-size: 18px; font-weight: bold; padding: 10px 10px;">Cập nhật thông tin</button>
        </div>
    </form>

</div>

@include("nhanvien/footer_nv")
</body>
</html>
