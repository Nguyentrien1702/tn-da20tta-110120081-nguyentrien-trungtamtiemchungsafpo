<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin khách hàng</title>
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
                <a href="">Thông tin cá nhân</a>
            </div>
            <section class="title">
            <hr>
            </section>
            <h2 style="text-align: center; color: blue; font-weight: bold">THÔNG TIN KHÁCH HÀNG</h2>
            <form action="/capnhattkh" method="POST">
            @csrf
                @foreach($khachhangs as $khachhang)
                <h5>THÔNG TIN CÁ NHÂN</h5>
                    <div class="form-group" style="width: 50%;">
                        <label for="makh" class="font-weight-bold"> Mã khách hàng:</label>
                        <input type="text" class="form-control placeholder-style" id="makh" name="makh" value="{{$khachhang->makh}}" readonly>
                    </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="tenkh" class="font-weight-bold">Họ tên khách hàng:</label>
                        <input type="text" class="form-control placeholder-style" id="tenkh" placeholder="Họ tên khách hàng" name="tenkh" value="{{$khachhang->tenkh}}" required>
                    </div>
                    <div class="form-group col">
                        <label for="ngaysinh" class="font-weight-bold">Ngày sinh:</label>
                        <input type="date" class="form-control placeholder-style" id="ngaysinh" placeholder="Ngày sinh" name="ngaysinh" value="{{$khachhang->ngaysinhkh}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="makh" class="font-weight-bold"> Giới tính:</label>
                        <div class="form-check form-check-inline" style="margin-left: 10px;">
                            <input class="form-check-input" type="radio" id="gioitinh_nam" name="gioitinh" value="Nam" {{ $khachhang->gioitinh == 'Nam' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gioitinh_nam">Nam</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="gioitinh_nu" name="gioitinh" value="Nữ" {{ $khachhang->gioitinh == 'Nữ' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gioitinh_nu">Nữ</label>
                        </div>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label for="diachi" class="font-weight-bold">Địa chỉ:</label>
                    <input type="text" class="form-control placeholder-style" id="diachi" name="diachi" value="{{$khachhang->diachikh}}" required>
                </div>
                <hr class="mt-3 mb-3">
                <h5>THÔNG TIN LIÊN HỆ</h5>
                <div class="row">
                    <div class="form-group mb-3 col">
                        <label for="ten_nglh" class="font-weight-bold">Tên người liên hệ:</label>
                        <input type="text" class="form-control" id="ten_nglh" name="ten_nglh" placeholder="Tên người liên hệ" required value="{{$khachhang->ten_nglh}}">
                    </div>
                    @php
                        $quanHeOptions = [
                            'Bản thân', 'Con', 'Cha', 'Mẹ', 'Vợ', 'Chồng',
                            'Anh', 'Chị', 'Em', 'Ông', 'Bà', 'Họ hàng'
                        ];
                    @endphp

                    <div class="form-group mb-3 col">
                        <label for="quanhevoikh" class="font-weight-bold">Quan hệ với khách hàng:</label>
                        <select name="quanhevoikh" id="quanhevoikh" class="form-control">
                            @foreach ($quanHeOptions as $option)
                                <option value="{{ $option }}" {{ $khachhang->quanhevoikh == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-3 col">
                        <label for="emailkh" class="font-weight-bold">Email:</label>
                        <input type="email" class="form-control" id="emailkh" name="emailkh" placeholder="Email khách hàng" value="{{$khachhang->emailkh}}">
                    </div>
                    <div class="form-group mb-3 col" >
                        <label for="sdtkh" class="font-weight-bold">Số điện thoại:</label>
                        <input type="text" class="form-control" id="sdtkh" name="sdtkh" required maxlength="10" pattern="[0-9]{10}" placeholder="Số điện thoại" value="{{$khachhang->sdtkh}}">
                    </div>
                </div>
               @endforeach 
               <div style="text-align: right;">
                <button type="submit" class="btn btn-danger mt-3 mr-5" style="font-size: 18px; font-weight: bold; padding: 10px 10px;">Cập nhật thông tin</button>
                </div>
            </form>
        </section>
        <section class="content_right col-md-3">
            @include("menu/hienthibaiviet")
        </section>
    </section>
</div>

@include("menu/footer")
</body>
</html>
