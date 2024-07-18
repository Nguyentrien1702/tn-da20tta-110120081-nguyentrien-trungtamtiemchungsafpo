        @include("menu/header")
        <link rel="stylesheet" href="{{ asset('css/khachhang/lichsu.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            .form-check-input[type="radio"] {
                width: 15px;
                height: 15px;
                margin-right: 5px; /* Khoảng cách giữa radio button và nội dung */
            }

            /* Thiết lập kiểu hiển thị của radio button */
            .radio-custom {
                display: inline-block;
                width: 20px;
                height: 20px;
                border: 2px solid #000; /* Màu và độ dày của viền */
                border-radius: 50%; /* Để tạo hình tròn */
                margin-right: 5px; /* Khoảng cách giữa radio button và nội dung */
                
            }
            .loaidk{
                padding: 10px;
                font-weight: bold;
                border: 1px solid gray;
                border-radius: 3px;
                background-color: white;
                width: 150px;
            }
            .loaidk:hover{
                color: blue;
                border: 1px solid blue;
            }
            .active{
                background-color: #00BFFF;
            }
            .btn-datlich{
                padding: 15px;
                width: 30%;
                font-size: large;
            }
            .card.selected {
                border-color: blue; /* Màu border khi radio được chọn */
            }
            .card:hover{
                border-color: blue;
            }
            .card-text{
                font-size: 12px;
                margin-top: 10px 0px !important;
                padding: 0px 0px;
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 4;
                -webkit-box-orient: vertical;
            }
            /* Hiệu ứng modal */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes scaleIn {
                from {
                    transform: scale(0.5);
                }
                to {
                    transform: scale(1);
                }
            }

            /* Hiệu ứng modal */
            #successModal .modal-dialog {
                transform: translate(0, -50%);
                transition: transform 0.3s ease-out;
            }

            #successModal.fade.show .modal-dialog {
                transform: translate(0, 0);
            }

            #successModal .modal-dialog.modal-dialog-centered {
                max-width: 400px;
                animation: scaleIn 0.3s ease-out;
            }

            #successModal .modal-content {
                opacity: 0;
                animation: fadeIn 0.3s ease-out;
            }

            #successModal.fade.show .modal-content {
                opacity: 1;
            }
            #successModal {
                background-color: rgba(128, 128, 128, 0.8); /* Đặt nền màu xám cho khu vực bên ngoài modal */
            }
            hr{
                margin: 0px 0px;
            }
            
        </style>
@php
    use Carbon\Carbon;
@endphp
    <div class="content-body">
        <section class="body row">
            <section class="content_left col-md-9 mt-4">
                <div>
                    <b style="margin: 0px 0px;">Đặt lịch tiêm</b>
                </div>
                <section class="title">
                    <hr style="margin: 0px 0px;">
                    @if(session('success'))
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var successMessage = "{{ session('success') }}";
                            var successMessageElement = document.getElementById('successMessage');
                            var successModal = document.getElementById('successModal');
                            var successImage = document.getElementById('suc_err');

                            successMessageElement.textContent = successMessage;
                            successImage.src = "{{ asset('images/success.png') }}";
                            successModal.classList.add('show');
                            successModal.style.display = 'block';
                            document.body.classList.add('modal-open');
                            fetch('/forgetsession', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            });
                        });
                    </script>
                    @endif
                    @if(session('error'))
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var errorMessage = "{{ session('error') }}";
                            var successMessageElement = document.getElementById('successMessage');
                            var successModal = document.getElementById('successModal');
                            var successImage = document.getElementById('suc_err');

                            successMessageElement.textContent = errorMessage;
                            successMessageElement.style.color = 'red';
                            successImage.src = "{{ asset('images/error.png') }}";
                            successModal.classList.add('show');
                            successModal.style.display = 'block';
                            document.body.classList.add('modal-open');
                        });
                    </script>
                    @endif
                    <div id="successModal" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content" style="height: 250px; width: 300px;">
                                
                                <div class="modal-body" style="text-align: center;">
                                    <img id="suc_err" src="{{ asset('images/success.png') }}" alt="" style="width: 100px; height: 100px">
                                    <p id="successMessage" style="text-align: center; font-size: 20px; color: green; font-weight: bold; text-transform: uppercase;">Thành công</p>
                                    <button class="btn btn-primary" onclick="okmodal()">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h1 class="font-weight-bold text-primary">ĐĂNG KÝ TIÊM CHỦNG</h1>
                    <p><i>
                        Đăng ký thông tin tiêm chủng để tiết kiệm thời gian khi đến làm thủ tục tại quầy Lễ tân cho
                        Quý Khách hàng, việc đăng ký thông tin tiêm chủng chưa hỗ trợ đặt lịch hẹn chính xác theo giờ.
                    </i></p>
                    <p><i>
                    <i class="text-danger">*</i>
                        Quý khách vui lòng điền đầy đủ thông tin vào các trường dưới đây. Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất. 
                        Trân trọng cảm ơn!
                    </i></p>
                </section>
                @if(!session('khachhang'))
                <div class="container mt-4 mb-5">
                    <form action="/dangkytiem_onl" id="form_dkonl" class="needs-validation" method="POST" novalidate>
                        @csrf
                        <h5 class="text-secondary">THÔNG TIN NGƯỜI TIÊM</h5>
                        <div class="row">
                            <div class="form-group col">
                                <label for="tennguoitiem" class="font-weight-bold"><i class="text-danger">*</i> Họ tên người tiêm:</label>
                                <input type="text" class="form-control" id="tennguoitiem" placeholder="Họ tên người tiêm" name="tennguoitiem" required>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Vui lòng chọn/điền</div>
                            </div>
                            <div class="form-group col">
                                <label for="ngaysinhnguoitiem" class="font-weight-bold"><i class="text-danger">*</i> Ngày sinh người tiêm:</label>
                                <input type="date" class="form-control placeholder-style" id="ngaysinhnguoitiem" placeholder="Ngày/Tháng/Năm" name="ngaysinhnguoitiem" required min="1900-01-01" max="{{ date('Y-m-d', strtotime('-1 day')) }}"  onchange="filterAgeGroups()">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Vui lòng chọn/điền</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="gioitinhnguoitiem" class="font-weight-bold mr-3"><i class="text-danger">*</i> Giới tính:</label>
                                <div class="form-check-inline">
                                    <label class="form-check-label" style="font-size: 19px;">
                                        <input type="radio" class="form-check-input" name="gioitinh" value="Nam" checked>Nam
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label" style="font-size: 19px;">
                                        <input type="radio" class="form-check-input" name="gioitinh" value="Nữ">Nữ
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div >
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="matp"class="font-weight-bold"><i class="text-danger">*</i>Tỉnh/Thành phố</label>
                                        <select class="form-control" id="matp" name="matp">
                                            <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="maqh"class="font-weight-bold"><i class="text-danger">*</i>Quận/huyện</label>
                                        <select class="form-control" id="maqh" name="maqh" disabled>
                                            <option value="">-- Chọn quận/huyện --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="maxp"class="font-weight-bold"><i class="text-danger">*</i>Phường/xã</label>
                                        <select class="form-control" id="maxp" name="maxp" disabled>
                                            <option value="">-- Chọn phường/xã --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="diachi" class="font-weight-bold"><i class="text-danger">*</i> Địa chỉ:</label>
                                <input type="text" class="form-control" id="diachi" placeholder="số nhà, tên đường" name="diachi" required>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Vui lòng chọn/điền</div>
                            </div>
                        </div>

                        <h5 class="text-secondary">THÔNG TIN NGƯỜI LIÊN HỆ</h5>
                        <div class="row">
                            <div class="form-group col">
                                <label for="tennguoilh" class="font-weight-bold"><i class="text-danger">*</i> Họ tên người liên hệ:</label>
                                <input type="text" class="form-control" id="tennguoilh" placeholder="Họ tên người liên hệ" name="tennguoilh" required>
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Vui lòng chọn/điền</div>
                            </div>
                            <div class="form-group col">
                                <label for="moiqhnguoitiem" class="font-weight-bold"><i class="text-danger">*</i> Mối quan hệ với người tiêm:</label>
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
                        <div class="row">
                            <div class="form-group col">
                                <label for="sodienthoai" class="font-weight-bold"><i class="text-danger">*</i> Số điện thoại liên hệ:</label>
                                <input type="text" class="form-control" id="sodienthoai" placeholder="Số điện thoại" name="sodienthoai" maxlength="10" required pattern="[0-9]{10}">
                                <div class="valid-feedback"></div>
                                <div class="invalid-feedback">Vui lòng chọn/điền</div>
                            </div>
                            <div class="form-group col">
                                <label for="email" class="font-weight-bold"> Địa chỉ email:</label>
                                <input type="email" class="form-control placeholder-style" id="email" placeholder="Địa chỉ email" name="email">
                            </div>
                        </div>

                        <h5 class="text-secondary">THÔNG TIN DỊCH VỤ</h5>
                        <div class="row">
                            <div class="form-group col">
                                <label for="loaivcdk" class="font-weight-bold"><i class="text-danger">*</i> Loại vaccine muốn đăng ký:</label>
                                <div class="mb-3">
                                    <button type="button" id="vaccine-goi-btn" class="loaidk" onclick="changeButtonStyle(this)">Vaccine gói</button>
                                    <button type="button" id="vaccine-le-btn" class="loaidk" onclick="changeButtonStyle(this)">Vaccine lẻ</button>
                                    
                                    <div id="nhomtuoi_goivc" style="display: none;">
                                        @foreach($ageGroups as $ageGroup)
                                            <div class="card mt-2" style="margin-left: 20px; padding: 0px 0px" id="div{{ $ageGroup->manhomtuoi }}">
                                                <div class="card-header" id="heading{{ $ageGroup->manhomtuoi }}" style="margin: 0px 0px; padding: 0px 0px">
                                                    <h2 class="mb-0">
                                                        <button onclick="changebutton(this)" id="toggleButton{{ $ageGroup->manhomtuoi }}" style="padding: 10px 10px; font-size: 16px; font-weight: bold" class="btn btn-nhomtuoi btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $ageGroup->manhomtuoi }}" aria-expanded="true" aria-controls="collapse{{ $ageGroup->manhomtuoi }}">
                                                            <i class="fas fa-chevron-right"></i> {{ $ageGroup->doituong }} 
                                                            @if($ageGroup->tuoibatdau>=0)
                                                            / {{ $ageGroup->tuoibatdau }} {{ $ageGroup->donvitinhbatdau }}
                                                                @if($ageGroup->tuoiketthuc)
                                                                - {{ $ageGroup->tuoiketthuc }} {{ $ageGroup->donvitinhketthuc }}
                                                                @else
                                                                trở lên
                                                                @endif
                                                            @endif
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapse{{ $ageGroup->manhomtuoi }}" class="collapse" aria-labelledby="heading{{ $ageGroup->manhomtuoi }}" data-parent="#nhomtuoi_goivc">
                                                <!-- Gói tiêm -->    
                                                    <div class="card-body card-goivc">
                                                        <div class="row">
                                                        @foreach($goivaccines as $goivaccine)
                                                            @if($goivaccine->manhomtuoi == $ageGroup->manhomtuoi)
                                                            @php
                                                            $index = 1;
                                                            @endphp
                                                            @if($index % 3 == 0 && $index != 0)
                                                                </div><div class="row">
                                                            @endif
                                                            <div class="col-md-4">
                                                            <div class="card" style="width: 270px; height: 180px; margin-right: 10px;">
                                                                <div class="card-body" style="padding: 5px 5px">
                                                                    <div class="form-check">
                                                                    <label style="display: inline-block;" class="form-check-label" for="dsvaccine{{$goivaccine->magoi}}{{ $ageGroup->manhomtuoi }}">
                                                                        <div>
                                                                            <input type="radio" onclick="toggleRadio(this)" name="vaccinegoi" class="form-check-input checkbox_goi" value="{{$goivaccine->magoi}}" id="dsvaccine{{$goivaccine->magoi}}{{ $ageGroup->manhomtuoi }}">
                                                                        </div>
                                                                        <div style="display: flex;">
                                                                            <div style="width: 100%;">
                                                                                <h6 class="card-title d-inline" style="font-size: 14px;">{{$goivaccine->tengoi}}</h6>
                                                                            </div>
                                                                            <div style="width: 70%;">
                                                                                <p style="color:blue;text-align: right; margin: 0px 0px; margin-right: 5px;">{{number_format($goivaccine->tonggiatien)}} đ</p>
                                                                                <p style="color:blue;text-align: right; margin: 0px 0px; margin-right: 5px; ">Số liều: {{$goivaccine->soluongmuitiem}}</p>
                                                                            </div>
                                                                        </div>
                                                                    
                                                                        <p class="card-text" style="margin-left: 0px; margin-top: 10px;">
                                                                            {{$goivaccine->tengoi}} {{$goivaccine->mota}}
                                                                        </p>
                                                                    </label>
                                                                    </div>                                                                        
                                                                </div>
                                                            </div>
                                                            </div>

                                                            @endif
                                                        @endforeach
                                                        </div>

                                                    </div>
                                                <!-- Tiêm lẻ -->
                                                    <div class="card-body card-vcle container" style="width: 100%;">
                                                    <div class="row">
                                                        @foreach($dsvaccines as $vaccine)
                                                            @if($vaccine->manhomtuoi == $ageGroup->manhomtuoi)

                                                            <div class="col-md-4">
                                                            <div class="card" style="width: 260px;; max-height: 200px; min-height:100px; margin-right: 0px 0px; margin-bottom: 20px">
                                                                <div class="card-body" style="padding: 5px 5px">
                                                                    <div class="form-check">
                                                                    <label style="display: inline-block; width: 100%; height: 100%" class="form-check-label" for="dsvaccine{{$vaccine->mavc}}{{ $ageGroup->manhomtuoi }}">
                                                                        <div>
                                                                            @if($vaccine->soluong > 0)
                                                                                <input type="radio" onclick="toggleRadio(this)" name="vaccinele" class="form-check-input checkbox_goi" value="{{$vaccine->mavc}}" id="dsvaccine{{$vaccine->mavc}}{{ $ageGroup->manhomtuoi }}">
                                                                            @else
                                                                                <input type="radio" disabled onclick="toggleRadio(this)" class="form-check-input checkbox_goi" value="{{$vaccine->mavc}}" id="dsvaccine{{$vaccine->mavc}}{{ $ageGroup->manhomtuoi }}">
                                                                            @endif
                                                                        </div>
                                                                        <div style="display: flex;">
                                                                            <div style="width: 100%;">
                                                                                <h6 class="card-title d-inline" style="font-size: 14px;">{{$vaccine->tenvc}}</h6>
                                                                            </div>
                                                                            <div style="width: 70%;">
                                                                                <p style="color:blue;text-align: right; margin: 0px 0px; margin-right: 5px;">{{number_format($vaccine->gia)}} đ</p>
                                                                            </div>
                                                                        </div>
                                                                    
                                                                        <p class="card-text" style="margin-left: 0px; margin-top: 10px;">
                                                                            {{$vaccine->tenbenh}}
                                                                        </p>
                                                                        @if($vaccine->soluong <= 0)
                                                                        <div style="text-align: right;">
                                                                            <i style="color: red">(đã hết)</i>
                                                                        </div>
                                                                        @endif
                                                                    </label>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="ngaytiemmongmuon" class="font-weight-bold"><i class="text-danger">*</i> Ngày tiêm mong muốn:</label>
                                <p><i><i class="text-danger">*</i>Lưu ý: Ngày tiêm mong muốn không quá 1 tháng kể từ ngày đăng ký!</i></p>
                                <input type="date" class="form-control placeholder-style" id="ngaytiemmongmuon" placeholder="Ngày/Tháng/Năm" name="ngaytiemmongmuon" required min="{{ date('Y-m-d') }}" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" style="width: 50%;">
                            </div>
                        </div>
                        <p><i>Các trường có dầu (<i class="text-danger">*</i>) là bắt buộc.</i></p>
                        <button type="button"  class="btn btn-danger mt-3 btn-datlich" onclick="checkAndOpenModal()"><i class="fas fa-paper-plane"></i>&nbsp;Đặt lịch ngay</button>
                    </form>
                    <!-- The Modal -->
                    <div class="modal" id="modal_xnthongtindk">
                        <div class="modal-dialog">
                        <div class="modal-content">
                        
                            <!-- Modal Header -->
                            <div class="modal-header">
                            <h4 class="modal-title" style="text-align: center; font-weight:bold; color: blue">XÁC NHẬN ĐĂNG KÝ</h4>
                            <button type="button" class="close" onclick="closeModal()" data-dismiss="modal">&times;</button>
                            </div>
                            
                            <!-- Modal body -->
                            <div class="modal-body">
                            Modal body..
                            </div>
                            <!-- <p><i class="text-danger">Lưu ý: </i></p> -->
                            <!-- Modal footer -->
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="closeModal()" data-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-primary" onclick="submitForm_luu()">Xác nhận đăng ký và thanh toán</button>
                            </div>
                            
                        </div>
                        </div>
                    </div>
                </div>
                @else
                
                <div class="container mt-4 mb-5">
                <form action="/dangkytiem_onl_ctk" id="form_dkonlctk" class="needs-validation" method="POST" novalidate>
                        @csrf
                        <h5 class="text-secondary">THÔNG TIN DỊCH VỤ</h5>
                        <div class="row">
                            <div class="form-group col">
                                <label for="loaivcdk" class="font-weight-bold"><i class="text-danger">*</i> Loại vaccine muốn đăng ký:</label>
                                <div class="mb-3">
                                    <button type="button" id="vaccine-goi-btn" class="loaidk" onclick="changeButtonStyle(this)">Vaccine gói</button>
                                    <button type="button" id="vaccine-le-btn" class="loaidk" onclick="changeButtonStyle(this)">Vaccine lẻ</button>
                                    
                                    <div id="nhomtuoi_goivc" style="display: none;">
                                    @foreach($khachhangs as $khachhang)
                                        @php
                                            $ngaySinh = Carbon::parse($khachhang->ngaysinhkh); // Chuyển đổi ngày sinh thành đối tượng Carbon
                                            $tuoiThang = $ngaySinh->diffInMonths(Carbon::now()); // Tính tổng số tháng giữa ngày sinh và ngày hiện tại
                                        @endphp
                                    @endforeach
                                        @foreach($ageGroups as $ageGroup)
                                            @if($ageGroup->donvitinhbatdau == "tuổi")
                                                @php
                                                    $dotuoi = $ageGroup->tuoibatdau * 12;
                                                @endphp
                                            @else
                                                @php
                                                    $dotuoi = $ageGroup->tuoibatdau;
                                                @endphp
                                            @endif
                                            @if ($dotuoi <= $tuoiThang)
                                            <div class="card mt-2" style="margin-left: 20px; padding: 0px 0px" id="div{{ $ageGroup->manhomtuoi }}">
                                                <div class="card-header" id="heading{{ $ageGroup->manhomtuoi }}" style="margin: 0px 0px; padding: 0px 0px">
                                                    <h2 class="mb-0">
                                                        <button onclick="changebutton(this)" id="toggleButton{{ $ageGroup->manhomtuoi }}" style="padding: 10px 10px; font-size: 16px; font-weight: bold" class="btn btn-nhomtuoi btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $ageGroup->manhomtuoi }}" aria-expanded="true" aria-controls="collapse{{ $ageGroup->manhomtuoi }}">
                                                            <i class="fas fa-chevron-right"></i> {{ $ageGroup->doituong }} 
                                                            @if($ageGroup->tuoibatdau>=0)
                                                            / {{ $ageGroup->tuoibatdau }} {{ $ageGroup->donvitinhbatdau }}
                                                                @if($ageGroup->tuoiketthuc)
                                                                - {{ $ageGroup->tuoiketthuc }} {{ $ageGroup->donvitinhketthuc }}
                                                                @else
                                                                trở lên
                                                                @endif
                                                            @endif
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapse{{ $ageGroup->manhomtuoi }}" class="collapse" aria-labelledby="heading{{ $ageGroup->manhomtuoi }}" data-parent="#nhomtuoi_goivc">
                                                <!-- Gói tiêm -->    
                                                    <div class="card-body card-goivc">
                                                        <div class="row">
                                                        @foreach($goivaccines as $goivaccine)
                                                            @if($goivaccine->manhomtuoi == $ageGroup->manhomtuoi)
                                                            @php
                                                            $index = 1;
                                                            @endphp
                                                            @if($index % 3 == 0 && $index != 0)
                                                                </div><div class="row">
                                                            @endif
                                                            <div class="col-md-4">
                                                            <div class="card" style="width: 270px; height: 180px; margin-right: 10px;">
                                                                <div class="card-body" style="padding: 5px 5px">
                                                                    <div class="form-check">
                                                                    <label style="display: inline-block;" class="form-check-label" for="dsvaccine{{$goivaccine->magoi}}{{ $ageGroup->manhomtuoi }}">
                                                                        <div>
                                                                            <input type="radio" onclick="toggleRadio(this)" name="vaccinegoi" class="form-check-input checkbox_goi" value="{{$goivaccine->magoi}}" id="dsvaccine{{$goivaccine->magoi}}{{ $ageGroup->manhomtuoi }}">
                                                                        </div>
                                                                        <div style="display: flex;">
                                                                            <div style="width: 100%;">
                                                                                <h6 class="card-title d-inline" style="font-size: 14px;">{{$goivaccine->tengoi}}</h6>
                                                                            </div>
                                                                            <div style="width: 70%;">
                                                                                <p style="color:blue;text-align: right; margin: 0px 0px; margin-right: 5px;">{{number_format($goivaccine->tonggiatien)}} đ</p>
                                                                                <p style="color:blue;text-align: right; margin: 0px 0px; margin-right: 5px; ">Số liều: {{$goivaccine->soluongmuitiem}}</p>
                                                                            </div>
                                                                        </div>
                                                                    
                                                                        <p class="card-text" style="margin-left: 0px; margin-top: 10px;">
                                                                            {{$goivaccine->tengoi}} {{$goivaccine->mota}}
                                                                        </p>
                                                                    </label>
                                                                    </div>                                                                        
                                                                </div>
                                                            </div>
                                                            </div>

                                                            @endif
                                                        @endforeach
                                                        </div>

                                                    </div>
                                                <!-- Tiêm lẻ -->
                                                    <div class="card-body card-vcle container" style="width: 100%;">
                                                    <div class="row">
                                                        @foreach($dsvaccines as $vaccine)
                                                            @if($vaccine->manhomtuoi == $ageGroup->manhomtuoi)

                                                            <div class="col-md-4">
                                                            <div class="card" style="width: 260px;; max-height: 200px; min-height:100px; margin-right: 0px 0px; margin-bottom: 20px">
                                                                <div class="card-body" style="padding: 5px 5px">
                                                                    <div class="form-check">
                                                                    <label style="display: inline-block; width: 100%; height: 100%" class="form-check-label" for="dsvaccine{{$vaccine->mavc}}{{ $ageGroup->manhomtuoi }}">
                                                                        <div>
                                                                            @if($vaccine->soluong > 0)
                                                                                <input type="radio" onclick="toggleRadio(this)" name="vaccinele" class="form-check-input checkbox_goi" value="{{$vaccine->mavc}}" id="dsvaccine{{$vaccine->mavc}}{{ $ageGroup->manhomtuoi }}">
                                                                            @else
                                                                                <input type="radio" disabled onclick="toggleRadio(this)" class="form-check-input checkbox_goi" value="{{$vaccine->mavc}}" id="dsvaccine{{$vaccine->mavc}}{{ $ageGroup->manhomtuoi }}">
                                                                            @endif
                                                                        </div>
                                                                        <div style="display: flex;">
                                                                            <div style="width: 100%;">
                                                                                <h6 class="card-title d-inline" style="font-size: 14px;">{{$vaccine->tenvc}}</h6>
                                                                            </div>
                                                                            <div style="width: 70%;">
                                                                                <p style="color:blue;text-align: right; margin: 0px 0px; margin-right: 5px;">{{number_format($vaccine->gia)}} đ</p>
                                                                            </div>
                                                                        </div>
                                                                    
                                                                        <p class="card-text" style="margin-left: 0px; margin-top: 10px;">
                                                                            {{$vaccine->tenbenh}}
                                                                        </p>
                                                                        @if($vaccine->soluong <= 0)
                                                                        <div style="text-align: right;">
                                                                            <i style="color: red">(đã hết)</i>
                                                                        </div>
                                                                        @endif
                                                                    </label>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="ngaytiemmongmuon" class="font-weight-bold"><i class="text-danger">*</i> Ngày tiêm mong muốn:</label>
                                <p><i><i class="text-danger">*</i>Lưu ý: Ngày tiêm mong muốn không quá 1 tháng kể từ ngày đăng ký!</i></p>
                                <input type="date" class="form-control placeholder-style" id="ngaytiemmongmuon" placeholder="Ngày/Tháng/Năm" name="ngaytiemmongmuon" required min="{{ date('Y-m-d') }}" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" style="width: 50%;">
                            </div>
                        </div>
                        <p><i>Các trường có dầu (<i class="text-danger">*</i>) là bắt buộc.</i></p>
                        <button type="button"  class="btn btn-danger mt-3 btn-datlich" onclick="checkAndOpenModal_ctk()"><i class="fas fa-paper-plane"></i>&nbsp;Đặt lịch ngay</button>
                    </form>
                    <!-- The Modal -->
                    <div class="modal" id="modal_xnthongtindk_ctk">
                        <div class="modal-dialog">
                        <div class="modal-content">
                        
                            <!-- Modal Header -->
                            <div class="modal-header">
                            <h4 class="modal-title" style="text-align: center; font-weight:bold; color: blue">XÁC NHẬN ĐĂNG KÝ</h4>
                            <button type="button" class="close" onclick="closeModal_ctk()" data-dismiss="modal">&times;</button>
                            </div>
                            
                            <!-- Modal body -->
                            <div class="modal-body">
                            Modal body..
                            </div>
                            <!-- <p><i class="text-danger">Lưu ý: </i></p> -->
                            <!-- Modal footer -->
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="closeModal_ctk()" data-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-primary" onclick="submitForm_luu_ctk()">Xác nhận đăng ký và thanh toán</button>
                            </div>
                            
                        </div>
                        </div>
                    </div>
                </div>
                @endif

            </section>
            <section class="content_right col-md-3 mt-4">
                @include("menu/hienthibaiviet")
            </section>
        </section>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('form_dkonlctk');

    form.addEventListener('submit', function (event) {
        // Kiểm tra xem một trong hai button đã được chọn hay chưa
        var selectedButton = document.querySelector('.loaidk.active');
        var ngaytiemmm = document.getElementById("ngaytiemmongmuon").value;
        
        if (!selectedButton) {
            alert('Vui lòng chọn loại vaccine trước khi đặt lịch.');
            event.preventDefault(); // Ngăn form được submit nếu không có button nào được chọn
            return false;
        }
        
        if (ngaytiemmm == "") {
            alert('Vui lòng chọn ngày tiêm mong muốn trước khi đặt lịch.');
            event.preventDefault(); // Ngăn form được submit nếu không có ngày tiêm mong muốn
            return false;
        }
        
        // Nếu một trong hai button đã được chọn và ngày tiêm mong muốn đã được chọn, cho phép submit form
        return false;
    });
});
    function okmodal(){
        var successModal = document.getElementById('successModal');
        successModal.classList.remove('show');
        successModal.style.display = 'none';
        document.body.classList.remove('modal-open'); // Loại bỏ lớp 'modal-open' khỏi body
    }
    function submitForm_luu(){
        $('#form_dkonl').submit();
    }
    function submitForm_luu_ctk(){
        $('#form_dkonlctk').submit();
    }
    function checkAndOpenModal() {
        if(themValidationChoForm()){
            if (submitForm()) {
                // Lấy thông tin từ form
                var tenNguoiTiem = document.getElementById('tennguoitiem').value;
                var ngaySinhNguoiTiem = document.getElementById('ngaysinhnguoitiem').value;
                var gioiTinhNguoiTiem = document.querySelector('input[name="gioitinh"]:checked').value;
                var tinhThanhPho = document.getElementById('matp').options[document.getElementById('matp').selectedIndex].text;
                var quanHuyen = document.getElementById('maqh').options[document.getElementById('maqh').selectedIndex].text;
                var phuongXa = document.getElementById('maxp').options[document.getElementById('maxp').selectedIndex].text;
                var diaChi = document.getElementById('diachi').value;
                
                var tenNguoiLienHe = document.getElementById('tennguoilh').value;
                var moiQuanHe = document.getElementById('moiqhnguoitiem').value;
                var soDienThoai = document.getElementById('sodienthoai').value;
                var email = document.getElementById('email').value;

                var ngayTiemMongMuon = (document.getElementById('ngaytiemmongmuon').value).split('-').reverse().join('-');

                // Định dạng lại ngày sinh từ YYYY-MM-DD sang DD-MM-YYYY
                var ngaySinhFormatted = ngaySinhNguoiTiem.split('-').reverse().join('-');

                // Lấy thông tin vaccine được chọn
                var vaccineChon = '';
                var giaTien = '';
                var goivaccineChon = '';
                var solieu = '';
                var giaTiengoi = '';
                var tongtien = '';
                // Kiểm tra xem vaccine gói hay lẻ đã được chọn
                var loaiVaccine = document.querySelector('.loaidk.active').id;

                // Hàm để lấy thông tin vaccine bằng AJAX 
                function fetchVaccineInfo(vaccineType) {
                    if (vaccineType === 'vaccine-goi-btn') {
                        // Nếu là vaccine gói, lấy thông tin từ radio button của vaccine gói
                        var vaccineGoiChecked = document.querySelector('input[name="vaccinegoi"]:checked');
                        if (vaccineGoiChecked) {
                            $.ajax({
                                url: `/ajax_goivaccine?magoi=${vaccineGoiChecked.value}`,
                                method: 'GET',
                                success: function(data) {
                                    data.forEach(function(goivaccine) {
                                        goivaccineChon = goivaccine.tengoi;
                                        solieu = goivaccine.soluongmuitiem;
                                        tongtien = formatCurrency(goivaccine.tonggiatien) + " VNĐ";
                                        giaTiengoi = formatCurrency(goivaccine.tonggiatien * ((100 - goivaccine.uudai)/100)) + " VNĐ";
                                        ycthanhtoan = formatCurrency(goivaccine.datcoc) + " VNĐ";
                                        updateModalContent();
                                        document.getElementById("dichvu").style.display = "none";
                                    });  
                                },
                                error: function(xhr, status, error) {
                                    console.error('Lỗi khi lấy dữ liệu vaccine:', error);
                                    // Xử lý thông báo lỗi nếu cần thiết
                                }
                            });
                        } else {
                            alert('Chưa chọn gói vaccine');
                        }
                    } else if (vaccineType === 'vaccine-le-btn') {
                        // Nếu là vaccine lẻ, lấy thông tin từ radio button của vaccine lẻ
                        var vaccineLeChecked = document.querySelector('input[name="vaccinele"]:checked');
                        if (vaccineLeChecked) {
                            $.ajax({
                                url: `/ajax_vaccine?mavc=${vaccineLeChecked.value}`,
                                method: 'GET',
                                success: function(data) {
                                    data.forEach(function(vaccine) {
                                        vaccineChon = vaccine.tenvc;
                                        giaTien = formatCurrency(vaccine.gia) + " VNĐ";
                                        ycthanhtoan = formatCurrency(vaccine.gia) + " VNĐ";
                                        updateModalContent();
                                        document.getElementById("dichvu_goi").style.display = "none";
                                    });  
                                },
                                error: function(xhr, status, error) {
                                    console.error('Lỗi khi lấy dữ liệu vaccine:', error);
                                    // Xử lý thông báo lỗi nếu cần thiết
                                }
                            });
                        } else {
                            console.error('Chưa chọn vaccine lẻ');
                        }
                    }
                }
        
                // Hàm để cập nhật nội dung của modal
                function updateModalContent() {
                    
                    var modal = document.getElementById('modal_xnthongtindk');
                    if (modal) {
                        var modalBody = modal.querySelector('.modal-body');
                        if (modalBody) {
                            modalBody.innerHTML = `
                                <p><strong>Thông tin người tiêm:</strong></p>
                                <p>Họ tên: ${tenNguoiTiem}</p>
                                <p>Ngày sinh: ${ngaySinhFormatted}</p>
                                <p>Giới tính: ${gioiTinhNguoiTiem}</p>
                                <p>Địa chỉ: ${diaChi}, ${phuongXa}, ${quanHuyen}, ${tinhThanhPho}</p>
                                <p><strong>Thông tin người liên hệ:</strong></p>
                                <p>Họ tên: ${tenNguoiLienHe}</p>
                                <p>Mối quan hệ: ${moiQuanHe}</p>
                                <p>Số điện thoại: ${soDienThoai}</p>
                                <p>Email: ${email}</p>
                                <p><strong>Thông tin dịch vụ:</strong></p>
                                <div id='dichvu'>
                                    <p>Vaccine: ${vaccineChon}</p>
                                    <p>Giá tiền: ${giaTien}</p>
                                </div>
                                <div id='dichvu_goi'>
                                    <p>Tên gói: ${goivaccineChon}</p>
                                    <p>Số liều: ${solieu}</p>
                                    <p>Tổng giá gói: ${tongtien}</p>
                                    <p>Giá gói ưu đãi: ${giaTiengoi}</p>
                                </div>
                                    <p>Ngày tiêm mong muốn: ${ngayTiemMongMuon}</p>
                                    <p>Yêu cầu thanh toán: ${ycthanhtoan}</p>
                                
                            `;
                        }
                        
                        modal.classList.add('show');
                        modal.style.display = 'block';
                        document.body.classList.add('modal-open');
                    }
                    
                }

                // Gọi hàm để lấy thông tin vaccine theo loại đã chọn
                fetchVaccineInfo(loaiVaccine);
            }
        }else{
        return false;}
    }

    function checkAndOpenModal_ctk() {
            if (submitForm_ctk()) {
                var ngayTiemMongMuon = (document.getElementById('ngaytiemmongmuon').value).split('-').reverse().join('-');

                // Lấy thông tin vaccine được chọn
                var vaccineChon = '';
                var giaTien = '';
                var goivaccineChon = '';
                var solieu = '';
                var giaTiengoi = '';
                var tongtien = '';
                // Kiểm tra xem vaccine gói hay lẻ đã được chọn
                var loaiVaccine = document.querySelector('.loaidk.active').id;

                // Hàm để lấy thông tin vaccine bằng AJAX 
                function fetchVaccineInfo(vaccineType) {
                    if (vaccineType === 'vaccine-goi-btn') {
                        // Nếu là vaccine gói, lấy thông tin từ radio button của vaccine gói
                        var vaccineGoiChecked = document.querySelector('input[name="vaccinegoi"]:checked');
                        if (vaccineGoiChecked) {
                            $.ajax({
                                url: `/ajax_goivaccine?magoi=${vaccineGoiChecked.value}`,
                                method: 'GET',
                                success: function(data) {
                                    data.forEach(function(goivaccine) {
                                        goivaccineChon = goivaccine.tengoi;
                                        solieu = goivaccine.soluongmuitiem;
                                        tongtien = formatCurrency(goivaccine.tonggiatien) + " VNĐ";
                                        giaTiengoi = formatCurrency(goivaccine.tonggiatien * ((100 - goivaccine.uudai)/100)) + " VNĐ";
                                        ycthanhtoan = formatCurrency(goivaccine.datcoc) + " VNĐ";
                                        updateModalContent_ctk();
                                        document.getElementById("dichvu").style.display = "none";
                                    });  
                                },
                                error: function(xhr, status, error) {
                                    console.error('Lỗi khi lấy dữ liệu vaccine:', error);
                                    // Xử lý thông báo lỗi nếu cần thiết
                                }
                            });
                        } else {
                            alert('Chưa chọn gói vaccine');
                        }
                    } else if (vaccineType === 'vaccine-le-btn') {
                        // Nếu là vaccine lẻ, lấy thông tin từ radio button của vaccine lẻ
                        var vaccineLeChecked = document.querySelector('input[name="vaccinele"]:checked');
                        if (vaccineLeChecked) {
                            $.ajax({
                                url: `/ajax_vaccine?mavc=${vaccineLeChecked.value}`,
                                method: 'GET',
                                success: function(data) {
                                    data.forEach(function(vaccine) {
                                        vaccineChon = vaccine.tenvc;
                                        giaTien = formatCurrency(vaccine.gia) + " VNĐ";
                                        ycthanhtoan = formatCurrency(vaccine.gia) + " VNĐ";
                                        updateModalContent_ctk();
                                        document.getElementById("dichvu_goi").style.display = "none";
                                    });  
                                },
                                error: function(xhr, status, error) {
                                    console.error('Lỗi khi lấy dữ liệu vaccine:', error);
                                    // Xử lý thông báo lỗi nếu cần thiết
                                }
                            });
                        } else {
                            console.error('Chưa chọn vaccine lẻ');
                        }
                    }
                }
        
                // Hàm để cập nhật nội dung của modal
                function updateModalContent_ctk() {
                    var modal = document.getElementById('modal_xnthongtindk_ctk');
                    if (modal) {
                        var modalBody = modal.querySelector('.modal-body');
                        if (modalBody) {
                            modalBody.innerHTML = `
                                <p><strong>Thông tin dịch vụ:</strong></p>
                                <div id='dichvu'>
                                    <p>Vaccine: ${vaccineChon}</p>
                                    <p>Giá tiền: ${giaTien}</p>
                                </div>
                                <div id='dichvu_goi'>
                                    <p>Tên gói: ${goivaccineChon}</p>
                                    <p>Số liều: ${solieu}</p>
                                    <p>Tổng giá gói: ${tongtien}</p>
                                    <p>Giá gói ưu đãi: ${giaTiengoi}</p>
                                </div>
                                    <p>Ngày tiêm mong muốn: ${ngayTiemMongMuon}</p>
                                    <p>Yêu cầu thanh toán: ${ycthanhtoan}</p>
                                
                            `;
                        }
                        
                        modal.classList.add('show');
                        modal.style.display = 'block';
                        document.body.classList.add('modal-open');
                    }
                    
                }

                // Gọi hàm để lấy thông tin vaccine theo loại đã chọn
                fetchVaccineInfo(loaiVaccine);
            }else
            {
                return false;
            }
    }


</script>
<script>
    // Hàm để định dạng lại giá tiền thành chuỗi có dấu phẩy ngăn cách hàng nghìn
function formatCurrency(amount) {
    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function closeModal() {
    var modal = document.getElementById('modal_xnthongtindk');
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
    }
}
function closeModal_ctk() {
    var modal = document.getElementById('modal_xnthongtindk_ctk');
    if (modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
    }
}

function changebutton(clickedButton) {
    var icon = clickedButton.querySelector('i'); // Lấy ra đối tượng icon trong button được click

    if (icon.classList.contains('fa-chevron-down')) {
        // Nếu icon hiện tại có class 'fa-chevron-down', thực hiện hành động khi icon là 'fa-chevron-down'
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-right');
    } else {
        // Ngược lại, thực hiện hành động khi icon không phải 'fa-chevron-down' (giả sử là 'fa-chevron-right')
        icon.classList.remove('fa-chevron-right');
        icon.classList.add('fa-chevron-down');
    }
}
// Biến toàn cục để lưu trữ ô radio đã chọn cuối cùng
let lastSelectedRadio = null;

// Hàm xử lý việc nhấp vào ô radio
function toggleRadio(radio) {
    var card = radio.closest('.card');
    // Nếu ô radio hiện tại là ô đã chọn cuối cùng
    if (radio === lastSelectedRadio) {
        card.classList.remove('selected');
        // Bỏ chọn ô radio
        radio.checked = false;
        // Đặt biến lastSelectedRadio thành null
        lastSelectedRadio = null;
    } else {
        card.classList.add('selected');
        // Cập nhật ô radio đã chọn cuối cùng
        lastSelectedRadio = radio;
    }
}
</script>
<script>
function filterAgeGroups() {
    var dob = document.getElementById("ngaysinhnguoitiem").value;
    if (dob) {
        var dobDate = new Date(dob);
        var today = new Date();
        var ageInMonths = (today.getFullYear() - dobDate.getFullYear()) * 12 + (today.getMonth() - dobDate.getMonth());
        // Make Ajax request to fetch age groups
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/dstuoi', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                var ageGroups = JSON.parse(xhr.responseText);
                
                ageGroups.forEach(function(group) {
                    var tuoibatdau = group.tuoibatdau;
                    if(group.donvitinhbatdau == "tuổi"){
                        tuoibatdau = group.tuoibatdau * 12;
                    }
                    var groupElement = document.getElementById("div" + group.manhomtuoi);
                    if (ageInMonths >= tuoibatdau) {
                        groupElement.style.display = "block";
                    } else {
                        groupElement.style.display = "none";
                    }
                });
            } else {
                console.error('Error fetching age groups:', xhr.status, xhr.statusText);
            }
        };
        
        xhr.onerror = function() {
            console.error('Request failed');
        };
        
        xhr.send();
    }
}
</script>
<Script>
    function themValidationChoForm() {
        'use strict';
        var forms = document.getElementsByClassName('needs-validation');
        
        // Biến để kiểm tra tất cả các form có hợp lệ hay không
        var tatCaFormHopLe = true;

        Array.prototype.filter.call(forms, function(form) {
            if (form.checkValidity() === false) {
                tatCaFormHopLe = false; // Đánh dấu là không hợp lệ nếu có bất kỳ form nào không hợp lệ
            }
            form.classList.add('was-validated');
        });

        // Trả về true nếu tất cả các form đều hợp lệ, ngược lại trả về false
        return tatCaFormHopLe;
    }
    function clearAllRadios() {
        var radios = document.querySelectorAll('input[type="radio"].checkbox_goi');
        radios.forEach(function(radio) {
            radio.checked = false;
        });
        lastSelectedRadio = null; // Reset the last selected radio
    }
    function changeButtonStyle(clickedButton) {
        // Lấy danh sách tất cả các nút có class 'loaidk'
        var buttons = document.querySelectorAll('.loaidk');

        // Lặp qua từng nút và loại bỏ lớp 'active' (nếu có)
        buttons.forEach(function(button) {
            button.classList.remove('active');
        });
        // Thêm lớp 'active' cho nút được click
        clickedButton.classList.add('active');
        document.getElementById("nhomtuoi_goivc").style.display = "none";
        clearAllRadios()
        
        // Hiển thị dropdown nhóm tuổi nếu Vaccine lẻ được chọn
        setTimeout(function() {
        if (clickedButton.id === 'vaccine-le-btn') {
            document.getElementById("nhomtuoi_goivc").style.display = "block";
            document.querySelectorAll(".card-goivc").forEach(function(card) {
                card.style.display = "none"; // Ẩn tất cả các card-goivc
            });
            document.querySelectorAll(".card-vcle").forEach(function(card) {
                card.style.display = "block"; // Ẩn tất cả các card-goivc
            });
        } else {
            document.getElementById("nhomtuoi_goivc").style.display = "block";
            document.querySelectorAll(".card-goivc").forEach(function(card) {
                card.style.display = "block"; // Ẩn tất cả các card-goivc
            });
            document.querySelectorAll(".card-vcle").forEach(function(card) {
                card.style.display = "none"; // Ẩn tất cả các card-goivc
            });
        }
        }, 300);
    }
    document.getElementById('sodienthoai').addEventListener('input', function (e) {
        // Loại bỏ mọi ký tự không phải số
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    function submitForm() {
        // Kiểm tra xem một trong hai button đã được chọn hay chưa
        var selectedButton = document.querySelector('.loaidk.active');
        if (!selectedButton) {
            alert('Vui lòng chọn loại vaccine trước khi đặt lịch.');
            return false; // Ngăn form được submit nếu không có button nào được chọn
        }
        if(document.getElementById("matp").value == ""){
            alert('Vui lòng nhập thông tin địa chỉ.');
            return false;
        }
        if(document.getElementById("maqh").value == ""){
            alert('Vui lòng nhập thông tin địa chỉ.');
            return false;
        }
        if(document.getElementById("maxp").value == ""){
            alert('Vui lòng nhập thông tin địa chỉ.');
            return false;
        }
        
        // Nếu một trong hai button đã được chọn, cho phép submit form
        return true;
    }

    function submitForm_ctk() {
        // Kiểm tra xem một trong hai button đã được chọn hay chưa
        var selectedButton = document.querySelector('.loaidk.active');
        var ngaytiemmm =document.getElementById("ngaytiemmongmuon").value;
        if (!selectedButton) {
            alert('Vui lòng chọn loại vaccine trước khi đặt lịch.');
            return false; // Ngăn form được submit nếu không có button nào được chọn
        }
        if (ngaytiemmm == "") {
            alert('Vui lòng chọn ngày tiêm mong muốn trước khi đặt lịch.');
            return false; // Ngăn form được submit nếu không có button nào được chọn
        }
        
        // Nếu một trong hai button đã được chọn, cho phép submit form
        return true;
    }

</Script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></Script>
<!-- js tỉnh thành -->
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
</script>
@include("menu/footer")