<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class lichhenkhController extends Controller
{
    public function show_lichhenkh(){
        try {            
            $vcles = DB::connection('mysql')->table('dangky_goi')
                ->where('dangky_goi.trangthaidk', "Đã xác nhận")
                ->where('dangky_goi.trangthaigoitiem', "Chưa tiêm")
                ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                ->join('chitietlstiem_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
                ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
                ->join('goivaccine', 'goivaccine.magoi', '=', 'dangky_goi.magoi')
                ->where('goivaccine.loaigoi', 1)
                ->where('chitietlstiem_goi.trangthaitiem', "Chưa tiêm")
                ->select('vaccine.*', 'khachhang.*', 'dangky_goi.*', 'chitietlstiem_goi.*')
                ->get();

            $vcgois = DB::connection('mysql')->table('goivaccine')
                ->join('chitietgoivc', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                ->join('vaccine', 'chitietgoivc.mavc', '=', 'vaccine.mavc')
                ->join('dangky_goi', 'dangky_goi.magoi', '=', 'goivaccine.magoi')
                ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                ->where('goivaccine.loaigoi', 2)
                ->where('dangky_goi.trangthaidk', "Đã xác nhận")
                ->where('dangky_goi.trangthaigoitiem', "Chưa tiêm")
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

            return view('nhanvien.dichvu.lichhenkh', compact('vcles', 'vcgois'));
        } catch (\Exception $e) {
            $vcles = collect();
            $vcgois = collect();
            return view('nhanvien.dichvu.lichhenkh', compact('vcles', 'vcgois'));
        }
    }
}
