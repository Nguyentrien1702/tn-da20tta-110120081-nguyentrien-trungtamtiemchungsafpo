<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class nv_vaccineController extends Controller
{
    public function showvaccine()
    {
        try {
            $nhacungcaps = DB::connection('mysql')->table('nhacungcap')->get();
            $nhombenhs = DB::connection('mysql')->table('benh_nhombenh')->get();
            $nhomtuois = DB::connection('mysql')->table('nhomtuoi')->get();
            
            $vaccines = DB::connection('mysql')->table('vaccine')
            ->join('benh_nhombenh', 'vaccine.benh_nhombenh', '=', 'benh_nhombenh.mabenh_nhombenh')
            ->join('nhacungcap', 'vaccine.mancc', '=', 'nhacungcap.mancc')
            ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
            ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
            ->where('goivaccine.loaigoi', 1)
            ->select('vaccine.*', 'benh_nhombenh.*', 'nhacungcap.*')
            ->get();

            return view('nhanvien.quanlyvaccine.vaccine', compact('vaccines', 'nhacungcaps', 'nhombenhs', 'nhomtuois'));
        } catch (\Exception $e) {
            $vaccines = collect();
            return view('nhanvien.quanlyvaccine.vaccine', compact('vaccines'));
        }
    }
    public function showvaccinetc()
    {
        try {            
            $dstiemchungs = DB::connection('mysql')->table('chitietlstiem_goi')
                    ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
                    ->join('dangky_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
                    ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                    ->where('chitietlstiem_goi.trangthaitiem', "Chờ tiêm")
                    ->select('vaccine.*', 'khachhang.*', 'chitietlstiem_goi.*')
                    ->get();

            $goiTiems = DB::table('dangky_goi')
                    ->join('goivaccine', 'goivaccine.magoi', '=', 'dangky_goi.magoi')
                    ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                    ->join('chitietgoivc', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                    ->join('vaccine', 'chitietgoivc.mavc', '=', 'vaccine.mavc')
                    ->leftJoin('chitietlstiem_goi', function($join) {
                        $join->on('dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
                            ->on('vaccine.mavc', '=', 'chitietlstiem_goi.mavc');
                    })
                    ->where('dangky_goi.trangthaidk', "Đã xác nhận")
                    ->where('dangky_goi.trangthaithanhtoan', "Đã thanh toán")
                    ->where('goivaccine.loaigoi', 2)
                    ->select(
                        'khachhang.makh',
                        'khachhang.tenkh',
                        'khachhang.ngaysinhkh',
                        'goivaccine.loaigoi',
                        'dangky_goi.madk_goi',
                        'goivaccine.magoi',
                        'goivaccine.tengoi',
                        'goivaccine.uudai',
                        'goivaccine.datcoc',
                        'dangky_goi.ngaytiemmongmuon',
                        'dangky_goi.ngaydk',
                        DB::raw('COUNT(chitietgoivc.mavc) AS soluongvaccine'),
                        DB::raw('SUM(chitietgoivc.soluongmuitiem) AS soluongmuitiem'),
                        DB::raw('SUM(vaccine.gia * chitietgoivc.soluongmuitiem) AS tonggiatien'),
                        DB::raw('COALESCE(COUNT(chitietlstiem_goi.mavc), 0) AS soluongdatiem') // Số lượng vaccine đã tiêm
                    )
                    ->groupBy(
                        'khachhang.makh',
                        'khachhang.tenkh',
                        'khachhang.ngaysinhkh',
                        'goivaccine.loaigoi',
                        'dangky_goi.madk_goi',
                        'goivaccine.magoi',
                        'goivaccine.tengoi',
                        'goivaccine.uudai',
                        'goivaccine.datcoc',
                        'dangky_goi.ngaytiemmongmuon',
                        'dangky_goi.ngaydk',
                    )
                    ->get();

            return view('nhanvien.dichvu.tiemchung', compact('dstiemchungs', 'goiTiems'));
        } catch (\Exception $e) {
            $dstiemchungs = collect();
            $goiTiems = collect();
            return view('nhanvien.dichvu.tiemchung', compact('dstiemchungs', 'goiTiems'));
        }
    }
    public function getVaccines($maGoiTiem)
    {
        // Lấy danh sách vaccines từ mã gói tiêm
        $vaccines = DB::table('vaccine')
                        ->select('vaccine.*')
                        ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
                        ->join('goivaccine', 'chitietgoivc.magoi', '=', 'goivaccine.magoi')
                        ->where('goivaccine.magoi', $maGoiTiem)
                        ->get();

        return response()->json($vaccines);
    }
    public function show_lichtiemchoxn(){
        try {            
            $vcles = DB::connection('mysql')->table('dangky_goi')
                ->where('dangky_goi.trangthaidk', "Chờ xác nhận")
                ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                ->join('chitietlstiem_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
                ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
                ->join('goivaccine', 'goivaccine.magoi', '=', 'dangky_goi.magoi')
                ->where('goivaccine.loaigoi', 1)
                ->select('vaccine.*', 'khachhang.*', 'dangky_goi.*')
                ->get();

                $vcgois = DB::connection('mysql')->table('goivaccine')
                ->join('chitietgoivc', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                ->join('vaccine', 'chitietgoivc.mavc', '=', 'vaccine.mavc')
                ->join('dangky_goi', 'dangky_goi.magoi', '=', 'goivaccine.magoi')
                ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                ->where('goivaccine.loaigoi', 2)
                ->where('dangky_goi.trangthaidk', 'Chờ xác nhận')
                ->select(
                    'dangky_goi.madk_goi',
                    'goivaccine.magoi',
                    'goivaccine.tengoi',
                    'goivaccine.loaigoi',
                    'goivaccine.uudai',
                    'goivaccine.datcoc',
                    'khachhang.makh',
                    'khachhang.tenkh',
                    'khachhang.ngaysinhkh',
                    'khachhang.sdtkh',
                    'khachhang.ten_nglh',
                    'khachhang.quanhevoikh',
                    'dangky_goi.ngaytiemmongmuon',
                    DB::raw('COUNT(chitietgoivc.mavc) AS soluongvaccine'),
                    DB::raw('SUM(chitietgoivc.soluongmuitiem) AS soluongmuitiem'),
                    DB::raw('SUM(vaccine.gia * chitietgoivc.soluongmuitiem) AS tonggiatien')
                )
                ->groupBy(
                    'dangky_goi.madk_goi',
                    'goivaccine.magoi',
                    'goivaccine.tengoi',
                    'goivaccine.loaigoi',
                    'goivaccine.uudai',
                    'goivaccine.datcoc',
                    'khachhang.makh',
                    'khachhang.tenkh',
                    'khachhang.ngaysinhkh',
                    'khachhang.sdtkh',
                    'khachhang.ten_nglh',
                    'khachhang.quanhevoikh',
                    'dangky_goi.ngaytiemmongmuon'
                )
                ->get();    

            return view('nhanvien.dichvu.xacnhangoidk', compact('vcles', 'vcgois'));
        } catch (\Exception $e) {
            $vcles = collect();
            $vcgois = collect();
            return view('nhanvien.dichvu.xacnhangoidk', compact('vcles', 'vcgois'));
        }
    }

    
}
