<?php

use App\Http\Controllers\adminthongkeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\xldangnhapController;
use App\Http\Controllers\bannerController;
use App\Http\Controllers\nccController;
use App\Http\Controllers\dmbenhController;
use App\Http\Controllers\khachhangController;
use App\Http\Controllers\nhomtuoiController;
use App\Http\Controllers\nhanvienController;
use App\Http\Controllers\vaccineController;
use App\Http\Controllers\tinhthanhController;
use App\Http\Controllers\goivcController;
use App\Http\Controllers\ajaxController;
use App\Http\Controllers\datlichtiemController;
use App\Http\Controllers\dssanphamController;
use App\Http\Controllers\lichhenkhController;
use App\Http\Controllers\nv_khachhangController;
use App\Http\Controllers\nv_nhacnhoController;
use App\Http\Controllers\nv_vaccineController;
use App\Http\Controllers\nv_thongkeController;
use App\Http\Controllers\nv_tiemchungController;
use App\Http\Controllers\nv_ttcnController;
use App\Http\Controllers\VNpay;
use App\Http\Controllers\thongtinkhController;
use App\Http\Controllers\xllichtiemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/Trang-chu', function () {
    return view('index');
});
Route::get('/Admin', function () {
    return view('admin/index_admin');
});

Route::get('/Nhanvien', function () {
    return view('nhanvien/index_nv');
});

Route::get('/Dang-nhap', function () {
    return view('dangnhap');
});



Route::prefix('Gioi-thieu')->group(function () {
    Route::get('/Lich-su-phat-trien', function () {
        return view('gioithieu/lichsuhinhthanhvaphattrien');
    });
    Route::get('/Chinh-sach-bao-mat-thong-tin', function () {
        return view('gioithieu/chinhsachbaomatthongtin');
    });
    Route::get('/Dieu-khoan-su-dung', function () {
        return view('gioithieu/dieukhoansudung');
    });
    Route::get('/Quy-trinh-tiem-chung', function () {
        return view('gioithieu/quytrinhtiemchung');
    });
});

Route::prefix('Tu-van-tiem-chung')->group(function () {
    Route::get('/Truoc-khi-tiem', function () {
        return view('tuvantiemchung/truockhitiem');
    });
    Route::get('/Sau-khi-tiem', function () {
        return view('tuvantiemchung/saukhitiem');
    });
});

Route::prefix('Lich-tiem-chung')->group(function () {
    Route::get('/Tre-so-sinh', function () {
        return view('lichtiemchung/tresosinh');
    });
    Route::get('/Tre-nho', function () {
        return view('lichtiemchung/trenho');
    });
    Route::get('/Nhom-tre', function () {
        return view('lichtiemchung/nhomtre');
    });
    Route::get('/Nguoi-truong-thanh', function () {
        return view('lichtiemchung/nguoitruongthanh');
    });
    Route::get('/Nhom-dac-biet', function () {
        return view('lichtiemchung/dacbiet');
    });

});
Route::get('/Lien-he', function () {
    return view('lienhe/lienhe');
});

Route::get('/Tin-tuc', function () {
    return view('tintuc/tintuc');
});
Route::get('/post/{mabaiviet}', [PostController::class, 'show']);

Route::get('/Dat-lich-tiem', function () {
    return view('datlichtiem/datlichtiem');
});

Route::prefix('Admin')->group(function () {
    Route::get('/Quan-ly-bai-viet', function () {
        return view('admin/quanlybaiviet/dangbaiviet');
    });
    Route::get('/Quan-ly-bai-viet', [PostController::class, 'show_benh']);
    Route::get('/Quan-ly-banner', [bannerController::class, 'showbanner']);

    //nhà cung cấp
    Route::get('/Quan-ly-nha-cung-cap', [nccController::class, 'showncc']);
    Route::post('/themncc', [nccController::class, 'themncc']);
    Route::get('/xoanhacungcap/{mancc}', [nccController::class, 'xoanhacungcap']);

    //danh mục bệnh
    Route::get('/Danh-muc-benh-nhom-benh', [dmbenhController::class, 'showdmbenh']);
    Route::post('/thembenh', [dmbenhController::class, 'thembenh']);
    Route::get('/xoadmbenh/{mabenh}', [dmbenhController::class, 'xoadmbenh']);
    Route::post('/themfilebenh', [dmbenhController::class, 'themfilebenh']);

    //nhóm tuổi
    Route::get('/Nhom-tuoi', [nhomtuoiController::class, 'shownhomtuoi']);
    Route::post('/themnhomtuoi', [nhomtuoiController::class, 'themnhomtuoi']);
    Route::get('/xoanhomtuoi/{manhomtuoi}', [nhomtuoiController::class, 'xoanhomtuoi']);

    //nhân viên
    Route::get('/Danh-sach-nhan-vien', [nhanvienController::class, 'shownhanvien']);
    Route::post('/themnhanvien', [nhanvienController::class, 'themnhanvien']);
    Route::get('/xoanhanvien/{manhanvien}', [nhanvienController::class, 'xoanhanvien']);
    Route::get('/Danh-sach-TK-nhan-vien', [nhanvienController::class, 'showtknhanvien']);
    Route::get('/resetmk/{manhanvien}', [nhanvienController::class, 'resetmk']);

    //vaccine
    Route::get('/Danh-sach-vaccine', [vaccineController::class, 'showvaccine']);
    Route::post('/themvaccine', [vaccineController::class, 'themvaccine']);
    Route::get('/xoavaccine/{mavc}', [vaccineController::class, 'xoavaccine']);
    Route::get('/getBenhNhomBenh', 'dmbenhController@getBenhNhomBenh');

    //gói vaccine
    Route::get('/Danh-sach-goi-vaccine', [goivcController::class, 'showgoivc']);
    Route::post('/themgoivaccine', [goivcController::class, 'themGoiVaccine']);

    //khách hàng
    Route::get('/Danh-sach-khach-hang', [khachhangController::class, 'showkhachhang']);
    Route::post('/themkhachhang', [khachhangController::class, 'themkhachhang']);

    //Dịch vụ
    Route::get('/Dang-ky-tiem', function () {
        return view('admin/dichvu/taolichtiem');
    });
    Route::get('/Dang-ky-tiem', [khachhangController::class, 'dsmakh']);
    Route::post('/themkh_dk', [datlichtiemController::class, 'datlichtiem']);
    Route::get('/Lich-tiem-cho-xn', [datlichtiemController::class, 'show_lichtiemchoxn']);
    Route::get('/Lich-tiem-da-xn', [datlichtiemController::class, 'show_lichtiemdaxn']);
    
    Route::get('/xntiem/{madk_goi}/{mavc}', [datlichtiemController::class, 'xntiem']);
    Route::get('/Quan-ly-lich-tiem', [datlichtiemController::class, 'show_quanlylichtiem']);
    //xác nhận đăng ký
    Route::get('/xngoidk/{madk_goi}', [xllichtiemController::class, 'xngoidk']);
    Route::get('/gettongtien/{madk_goi}', [xllichtiemController::class, 'getTongTien']);
    //từ chối đk
    Route::post('/tuchoigoidk', [xllichtiemController::class, 'tuchoigoidk']);

    //ajax
    Route::get('/ajax_ctgoitiem', [ajaxController::class, 'ajax_ctgoitiem']);

    //thống kê
    Route::get('/thongkemuitiem', [adminthongkeController::class, 'getVaccineStatistics']);
    Route::get('/doanhthu', [adminthongkeController::class, 'getDoanhthu']);
    Route::get('/gioitinh', [adminthongkeController::class, 'getgioitinh']);
    Route::get('/vaccinethang', [adminthongkeController::class, 'getvaccinetheothang']);
    Route::get('/getdkhuy', [adminthongkeController::class, 'getdkhuy']);
    
});

//Nhân viên
Route::prefix('Nhanvien')->group(function () {
    //thông tin nhân viên
    Route::get('/Thong-tin-nhan-vien', [nv_ttcnController::class, 'show_ttnv']);
    Route::post('/capnhattnv', [nv_ttcnController::class, 'capnhatttnv']);

    //khách hàng
    Route::get('/Danh-sach-khach-hang', [nv_khachhangController::class, 'showkhachhang']);
    Route::post('/themkhachhang', [nv_khachhangController::class, 'themkhachhang']);

    //Dịch vụ
    Route::get('/Dang-ky-tiem', function () {
        return view('nhanvien/dichvu/taolichtiem');
    });
    Route::get('/Dang-ky-tiem', [nv_khachhangController::class, 'dsmakh']);
    Route::post('/themkh_dk', [datlichtiemController::class, 'datlichtiem']);

    //vaccine
    Route::get('/Danh-sach-vaccine', [nv_vaccineController::class, 'showvaccine']);

    //nhắc nhở
    Route::get('/Nhac-nho-den-hen', [nv_nhacnhoController::class, 'showdsvaccinenn']);
    Route::get('/nhacnhotiem/{madk_goi}/{mavc}/{makh}', [nv_nhacnhoController::class, 'guismsnhacnho']);
    Route::get('/nhacnhogoi/{madk_goi}/{makh}', [nv_nhacnhoController::class, 'guismsnhacnhogoi']);

    //quá hẹn
    Route::get('/Nhac-nho-qua-hen', [nv_nhacnhoController::class, 'lichtiemquahen']);

    //Tiêm chủng
    Route::get('/Tiem-chung', [nv_vaccineController::class, 'showvaccinetc']);
    Route::get('/tiemchung/{madk_goi}', [nv_tiemchungController::class, 'tiemchung']);
    Route::get('/get-ttkhachhang/{maKhachHang}', [nv_khachhangController::class, 'getttkhachhang']);
    Route::get('get-vaccines/{maGoiTiem}', [nv_vaccineController::class, 'getVaccines']);

    //xác nhận đăng ký
    Route::get('/Lich-tiem-cho-xn', [nv_vaccineController::class, 'show_lichtiemchoxn']);
    Route::get('/xngoidk/{madk_goi}', [xllichtiemController::class, 'xngoidk']);
    Route::get('/gettongtien/{madk_goi}', [xllichtiemController::class, 'getTongTien']);
    Route::get('/xndentiem/{madk_goi}', [xllichtiemController::class, 'xndentiem']);

    //từ chối đk
    Route::post('/tuchoigoidk', [xllichtiemController::class, 'tuchoigoidk']);
    Route::get('/huymuitiem/{madk_goi}/{makh}', [nv_nhacnhoController::class, 'huymuitiemle']);

    //xác nhận lịch hẹn đến tiêm
    Route::get('/Lich-hen', [lichhenkhController::class, 'show_lichhenkh']);

    //tất cả lịch tiêm
    Route::get('/Tat-ca-lich-tiem', [nv_nhacnhoController::class, 'tatcalichtiem']);
    //cập nhật ngày tiêm
    Route::post('/capnhatngaytiem', [nv_nhacnhoController::class, 'capNhatNgayTiem']);

    //thống kê
    Route::get('/thongkemuitiem', [nv_thongkeController::class, 'getVaccineStatistics']);
    Route::get('/doanhthu', [nv_thongkeController::class, 'getDoanhthu']);
    Route::get('/gioitinh', [nv_thongkeController::class, 'getgioitinh']);
    Route::get('/vaccinethang', [nv_thongkeController::class, 'getvaccinetheothang']);
    Route::get('/getdkhuy', [nv_thongkeController::class, 'getdkhuy']);
});

//Bài viết
Route::post('/dangbaiviet', [PostController::class, 'store']);
Route::get('/xoabaiviet/{mabaiviet}', [PostController::class, 'xoabaiviet']);
//Banner
Route::post('/Quan-ly-banner', [bannerController::class, 'showbanner']);
Route::post('/thembanner', [bannerController::class, 'thembanner']);
Route::get('/xoabanner/{mabanner}', [bannerController::class, 'xoabanner']);

//Danh sách sản phẩm
Route::get('/Danh-sach-san-pham', [dssanphamController::class, 'dssanpham']);
Route::get('/ct-vaccine/{mavc}', [dssanphamController::class, 'showctvaccine']);
Route::get('/Danh-sach-goi-tiem', [dssanphamController::class, 'dsgoivaccine']);

Route::post('/dangnhaptk', [xldangnhapController::class, 'dangnhaptk']);
Route::get('/thoat', [xldangnhapController::class, 'Logout']);

//Tỉnh thành
Route::get('/tinhtp', [tinhthanhController::class, 'gettinhtp']);
Route::get('/quanhuyen', [tinhthanhController::class, 'getquanhuyen']);
Route::get('/xaphuong', [tinhthanhController::class, 'getxaphuong']);

Route::get('/dsnhomtuoi', [vaccineController::class, 'dsnhomtuoi']);
Route::get('/dsnhomtuoigoi', [goivcController::class, 'dsnhomtuoi']);
Route::get('/dsvaccine', [goivcController::class, 'dsvaccine']);
Route::get('/vaccine', [goivcController::class, 'vaccine']);


//lấy danh sách cho đặt lịch tiêm
Route::get('/vaccine_tuoi', [ajaxController::class, 'dsvaccine']);
Route::get('/Dat-lich-tiem', [ajaxController::class, 'getAgeGroups']);
Route::get('/dstuoi', [ajaxController::class, 'dsnhomtuoi']);
Route::get('/ajax_vaccine', [ajaxController::class, 'ajax_vaccine']);
Route::get('/ajax_goivaccine', [ajaxController::class, 'ajax_goivaccine']);
Route::post('/dangkytiem_onl', [VNpay::class, 'VNP']);
// web.php
Route::get('/payment/callback', [VNpay::class, 'callback'])->name('payment.callback');

Route::post('/dangkytiem_onl_ctk', [VNpay::class, 'VNP']);

//xóa session
Route::post('/forgetsession', [ajaxController::class, 'quensession']);

//khách hàng
Route::get('/thongtinkh', [thongtinkhController::class, 'show_thongtinkh']);
Route::post('/capnhattkh', [thongtinkhController::class, 'capnhattkh']);
Route::get('/lstiemchung', [thongtinkhController::class, 'lichsutiem']);