<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class adminthongkeController extends Controller
{
   
    public function getVaccineStatistics()
    {
        $soluongmuitiem = DB::table('chitietlstiem_goi')
            ->join('vaccine', 'chitietlstiem_goi.mavc', '=', 'vaccine.mavc')
            ->select('vaccine.tenvc', DB::raw('count(*) as total'))
            ->groupBy('vaccine.tenvc')
            ->get();

        return response()->json($soluongmuitiem);
    }

    public function getDoanhthu()
    {
        $doanhthu = DB::table('dangky_goi')
            ->where('trangthaithanhtoan', 'Đã thanh toán') // Chỉ tính những đăng ký đã thanh toán
            ->sum('tongtien');

        $slmuitiemdatiem = DB::table('chitietlstiem_goi')->where('trangthaitiem', 'Đã tiêm')->count();
        $goidk_huy = DB::table('dangky_goi')->where('trangthaidk', 'Đã hủy')->count();

        return response()->json(['doanhthu' => $doanhthu, 'slmuitiemdatiem'=> $slmuitiemdatiem, 'goidk_huy' => $goidk_huy]);
    }
    public function getgioitinh()
    {
        // Query để lấy số lượng khách hàng theo từng giới tính
        $genderCounts = DB::table('khachhang')
            ->select(DB::raw('gioitinh, COUNT(*) as count'))
            ->groupBy('gioitinh')
            ->get();

        // Chuyển dữ liệu sang dạng mảng để sử dụng trong biểu đồ
        $data = [];
        foreach ($genderCounts as $row) {
            $data[] = [$row->gioitinh, (int)$row->count];
        }

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($data);
    }

    public function getvaccinetheothang()
    {
        // Truy vấn cơ sở dữ liệu để lấy số lượng mũi tiêm theo từng tháng
        $vaccinationData = DB::table('chitietlstiem_goi')
            ->where('trangthaitiem', 'Đã tiêm')
            ->select(DB::raw('YEAR(ngaytiemthucte) as year, MONTH(ngaytiemthucte) as month, COUNT(*) as total'))
            ->groupBy(DB::raw('YEAR(ngaytiemthucte), MONTH(ngaytiemthucte)'))
            ->get();

        // Chuẩn bị dữ liệu cho biểu đồ
        $data = [
            'months' => [],
            'totals' => [],
        ];

        foreach ($vaccinationData as $item) {
            $data['months'][] = $item->year . '-' . sprintf("%02d", $item->month);
            $data['totals'][] = $item->total;
        }

        return response()->json($data);
    }
    public function getVaccineRegistrationData()
    {
        // Lấy dữ liệu đăng ký gói vaccine theo tháng
        $registeredData = DB::table('dangky_goi')->selectRaw('YEAR(ngaydk) as year, MONTH(ngaydk) as month, COUNT(*) as total')
            ->where('trangthaidk', 'Đã xác nhận')
            ->groupBy(DB::raw('YEAR(ngaydk), MONTH(ngaydk)'))
            ->get();

        // Lấy dữ liệu hủy gói vaccine theo tháng
        $cancelledData = DB::table('dangky_goi')->selectRaw('YEAR(ngaydk) as year, MONTH(ngaydk) as month, COUNT(*) as total')
            ->where('trangthaidk', 'Đã hủy')
            ->groupBy(DB::raw('YEAR(ngaydk), MONTH(ngaydk)'))
            ->get();

        return response()->json([
            'registeredData' => $registeredData,
            'cancelledData' => $cancelledData,
        ]);
    }
    public function getdkhuy()
    {
        // Truy vấn SQL để lấy số lượng gói vaccine đăng ký và hủy theo tháng
        $data = DB::table('dangky_goi')
            ->selectRaw('MONTH(ngaydk) AS thang, 
                         SUM(CASE WHEN trangthaidk = "Đã xác nhận" THEN 1 ELSE 0 END) AS dangky, 
                         SUM(CASE WHEN trangthaidk = "Đã hủy" THEN 1 ELSE 0 END) AS huy')
            ->groupBy(DB::raw('MONTH(ngaydk)'))
            ->orderBy(DB::raw('MONTH(ngaydk)'))
            ->get();

        return response()->json($data);
    }
}
