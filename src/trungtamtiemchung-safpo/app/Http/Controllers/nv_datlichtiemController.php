<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class nv_datlichtiemController extends Controller
{
    public function showlichtiem(){
        try {
            $lichtiems = DB::connection('mysql')->table('chitietlstiem_goi')
            ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
            ->join('dangky_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
            ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
            ->where('chitietlstiem_goi.trangthaitiem', "Chờ tiêm")
            ->select('vaccine.*', 'khachhang.*', 'chitietlstiem_goi.*')
            ->get();

            return view('nhanvien.dichvu.taolichtiem', compact('lichtiems'));
        } catch (\Exception $e) {
            $lichtiems = collect();
            return view('nhanvien.dichvu.taolichtiem', compact('lichtiems'));
        }
    }
}
