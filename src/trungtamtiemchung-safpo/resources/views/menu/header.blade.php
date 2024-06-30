<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/menu.css ') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css ') }}">
    <style>
        /* Custom dropdown styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            
            min-width: 300px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            width: 100%;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body>
    <div>
        <div id="header">
            <div>
                <div id="menu-top" class="container-menu">
                    <nav class="menu-top">
                        <a href="" id="logo">
                                <img src="{{ asset('images/logo.png') }}" alt="logo">
                        </a>
                        <h5>PHÒNG TIÊM CHỦNG SAFPO TRÀ VINH</h5>
                        <ul>
                            <li>
                                <a href="https://maps.app.goo.gl/39XCg4Bfmooe12xR7" target="_blank">
                                    <i class="fas fa-map-marker-alt"></i> &nbsp; Tìm trung tâm
                                </a>
                            </li>
                            <li class="dropdown">
                            @if(session('khachhang'))
                                <a href="{{ url('/Dat-lich-tiem') }}">
                                    <i class="far fa-calendar-alt"></i> &nbsp; Đặt lịch tiêm
                                </a>
                            @else
                                <a href="javascript:void(0)">
                                    <i class="far fa-calendar-alt"></i> &nbsp; Đặt lịch tiêm
                                </a>
                                <div class="dropdown-content">
                                    <a href="{{ url('/Dang-nhap') }}">Đã từng tiêm tại trung tâm</a>
                                    <a href="{{ url('/Dat-lich-tiem') }}">Chưa từng tiêm tại trung tâm</a>
                                </div>
                            @endif
                                
                            </li>
                            <li id="hotline-mocua">
                                <a href="" class="hotline">
                                    Hotline: 0294 650 8508
                                    <p class="mocua">Mở cửa 7h30-17h00/T2-CN</p>
                                </a>
                                
                            </li>
                        </ul>
                    </nav>
                </div>
                <hr>
                <div id="menu-content" class="container-menu">
                    <nav>
                        <ul id="main-menu">
                            <li id="trangchu"><a href="{{ url('/Trang-chu') }}">Trang chủ</a></li>
                            <li id="gioithieu"><a href="">Giới thiệu</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ url('/Gioi-thieu/Lich-su-phat-trien') }}">Lịch sử hình thành và phát triển</a></li>
                                    <li><a href="">Giá trị cốt lõi</a></li>
                                    <li><a href="{{ url('/Gioi-thieu/Chinh-sach-bao-mat-thong-tin') }}">Chính sách bảo mật thông tin</a></li>
                                    <li><a href="{{ url('/Gioi-thieu/Dieu-khoan-su-dung') }}">Điều khoản sử dụng</a></li>
                                    <li><a href="{{ url('/Gioi-thieu/Quy-trinh-tiem-chung') }}">Quy trình chuẩn của Safpo</a></li>
                                </ul>
                            </li>
                            <li id="sanpham"><a href="{{ url('/Danh-sach-san-pham') }}">Sản phẩm</a></li>
                            <li id="lichtiemchung"><a href="">Lịch tiêm chủng</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ url('/Lich-tiem-chung/Tre-so-sinh') }}">Trẻ sơ sinh (24 giờ - 18 tháng)</a></li>
                                    <li><a href="{{ url('/Lich-tiem-chung/Tre-nho') }}">Nhóm trẻ nhỏ (19 tháng - 6 tuổi)</a></li>
                                    <li><a href="{{ url('/Lich-tiem-chung/Nhom-tre') }}">Nhóm trẻ (7 - 18 tuổi)</a></li>
                                    <li><a href="{{ url('/Lich-tiem-chung/Nguoi-truong-thanh') }}">Nhóm người trưởng thành (19 tuổi trở lên)</a></li>
                                    <li><a href="{{ url('/Lich-tiem-chung/Nhom-dac-biet') }}">Nhóm đặc biệt</a></li>
                                </ul>                        
                            </li>
                            <li id="tuvantiemchung"><a href="">Tư vấn tiêm chủng</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ url('/Tu-van-tiem-chung/Truoc-khi-tiem') }}">Những điều cần biết trước khi chủng ngừa</a></li>
                                    <li><a href="{{ url('/Tu-van-tiem-chung/Sau-khi-tiem') }}">Những điều cần biết sau khi chủng ngừa</a></li>
                                    </ul>
                            </li>
                            <li id="goitiem"><a href="{{ url('/Danh-sach-goi-tiem') }}">Gói tiêm</a></li>
                            <li id="tintuc"><a href="{{ url('/Tin-tuc') }}">Tin tức</a></li>
                            <li id="lienhe"><a href="{{ url('/Lien-he') }}">Liên hệ</a></li>
                            @if(session('khachhang'))
                            <li id="thongtin"><a href="">Thông tin</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ url('/thongtinkh') }}">Thông tin cá nhân</a></li>
                                    <li><a href="{{ url('/lstiemchung') }}">Lịch sử tiêm chủng</a></li>
                                    <li><a href="{{ url('') }}">Quên mật khẩu</a></li>
                                    <li><a href="{{ url('/thoat') }}">Thoát</a></li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div id="content" class="container-menu">