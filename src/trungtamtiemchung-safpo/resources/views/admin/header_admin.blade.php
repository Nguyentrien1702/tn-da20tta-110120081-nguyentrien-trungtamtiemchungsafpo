<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('css/css_admin/styles.css ') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.2.3/css/all.min.css" />

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="" style="font-weight: bold;">Quản lý</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">
                            @if(session('manhanvien'))
                                <div class="alert alert-success">
                                    {{ session('manhanvien') }}
                                </div>
                            @endif
                        </a></li>
                        <li><a class="dropdown-item" href="#!">Thông tin</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="{{ url('/thoat') }}">Thoát</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Trang chủ</div>
                            <a class="nav-link" href="/Admin">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Thống kê
                            </a>

                            <div class="sb-sidenav-menu-heading">Dịch vụ</div>
                            <a class="nav-link" href="{{ url('/Admin/Dang-ky-tiem') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Đăng ký tiêm
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#lichtiem" aria-expanded="false" aria-controls="lichtiem">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Quản lý đăng ký
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="lichtiem" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ url('/Admin/Lich-tiem-cho-xn') }}">Chờ xác nhận</a>
                                    <a class="nav-link" href="{{ url('/Admin/Lich-tiem-da-xn') }}">Đã xác nhận</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="{{ url('/Admin/Quan-ly-lich-tiem') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Quản lý lịch tiêm
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#nnlichtiem" aria-expanded="false" aria-controls="nnlichtiem">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Nhắc nhở lịch tiêm
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="nnlichtiem" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ url('/Admin/Nhac-nho-den-hen') }}">Sắp đến hẹn</a>
                                    <a class="nav-link" href="{{ url('/Admin/Nhac-nho-qua-hen') }}">Quá hẹn</a>
                                </nav>
                            </div>

                            <div class="sb-sidenav-menu-heading">Danh mục</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Danh mục
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ url('/Admin/Quan-ly-bai-viet') }}">Quản lý bài viết</a>
                                    <a class="nav-link" href="{{ url('/Admin/Quan-ly-banner') }}">Quản lý banner</a>
                                    <a class="nav-link" href="{{ url('/Admin/Quan-ly-nha-cung-cap') }}">Nhà cung cấp</a>
                                    <a class="nav-link" href="{{ url('/Admin/Danh-muc-benh-nhom-benh') }}">Danh mục bệnh</a>
                                    <a class="nav-link" href="{{ url('/Admin/Nhom-tuoi') }}">Nhóm tuổi</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#qlnhanvien" aria-expanded="false" aria-controls="qlnhanvien">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Quản lý nhân viên
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="qlnhanvien" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ url('/Admin/Danh-sach-nhan-vien') }}">Nhân viên</a>
                                    <a class="nav-link" href="{{ url('/Admin/Danh-sach-TK-nhan-vien') }}">Tài khoản nhân viên</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#qlvaccine" aria-expanded="false" aria-controls="qlvaccine">
                                <div class="sb-nav-link-icon"><i class="fas fa-prescription-bottle"></i></div>
                                Quản lý vaccine
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="qlvaccine" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ url('/Admin/Danh-sach-vaccine') }}">Vaccine</a>
                                    <a class="nav-link" href="{{ url('/Admin/Danh-sach-goi-vaccine') }}">Gói vaccine</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#qlkhachhang" aria-expanded="false" aria-controls="qlkhachhang">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Quản lý khách hàng
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="qlkhachhang" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ url('/Admin/Danh-sach-khach-hang') }}">Khách hàng</a>
                                    
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        SAFPO TRÀ VINH
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>