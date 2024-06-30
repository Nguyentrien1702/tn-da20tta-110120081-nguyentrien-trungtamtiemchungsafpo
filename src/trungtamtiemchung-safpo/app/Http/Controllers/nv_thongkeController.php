<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class nv_thongkeController extends Controller
{
    public function getVaccineStatistics()
    {
        $soluongmuitiem = DB::table('chitietlstiem_goi')
            ->join('vaccine', 'chitietlstiem_goi.mavc', '=', 'vaccine.mavc')
            ->where('chitietlstiem_goi.trangthaitiem', "Đã tiêm")
            ->select('vaccine.tenvc', DB::raw('count(*) as total'))
            ->groupBy('vaccine.tenvc')
            ->get();

        return response()->json($soluongmuitiem);
    }

    public function getDoanhthu()
    {
        $month = Carbon::now()->month; // Lấy tháng hiện tại
        $year = Carbon::now()->year; // Lấy năm hiện tại
        $doanhthu = DB::table('dangky_goi')
            ->where('trangthaithanhtoan', 'Đã thanh toán') // Chỉ tính những đăng ký đã thanh toán
            ->whereMonth('ngaydk', $month) // Lọc theo tháng hiện tại
            ->whereYear('ngaydk', $year) // Lọc theo năm hiện tại
            ->sum('sotiendathanhtoan');

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
        // Truy vấn cơ sở dữ liệu để lấy số lượng mũi tiêm theo từng ngày
            $vaccinationData = DB::table('chitietlstiem_goi')
                ->where('trangthaitiem', 'Đã tiêm')
                ->select(DB::raw('DATE(ngaytiemthucte) as date, COUNT(*) as total'))
                ->groupBy(DB::raw('DATE(ngaytiemthucte)'))
                ->get();

            // Chuẩn bị dữ liệu cho biểu đồ
            $data = [
                'dates' => [],
                'totals' => [],
            ];

            foreach ($vaccinationData as $item) {
            $data['dates'][] = $item->date; // Thêm ngày vào mảng dates
            $data['totals'][] = $item->total; // Thêm số lượng mũi tiêm vào mảng totals
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
        // Truy vấn SQL để lấy số lượng gói vaccine đăng ký và hủy theo ngày
        $data = DB::table('dangky_goi')
        ->selectRaw('DATE(ngaydk) AS ngay, 
                    SUM(CASE WHEN trangthaidk = "Đã xác nhận" THEN 1 ELSE 0 END) AS dangky, 
                    SUM(CASE WHEN trangthaidk = "Đã hủy" THEN 1 ELSE 0 END) AS huy')
        ->groupBy(DB::raw('DATE(ngaydk)'))
        ->orderBy(DB::raw('DATE(ngaydk)'))
        ->get();

        return response()->json($data);
    }
}
