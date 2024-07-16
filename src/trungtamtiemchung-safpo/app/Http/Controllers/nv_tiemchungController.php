<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class nv_tiemchungController extends Controller
{
    public function tiemchung($madk_goi){
        DB::table('chitietlstiem_goi')
            ->where('madk_goi', $madk_goi)
            ->update(['chitietlstiem_goi.trangthaitiem' => "Đã tiêm",
                    'ngaytiemthucte' => Carbon::now(),
                    'nguoitiem' => session('manhanvien')]);
                
        DB::table('dangky_goi')
            ->where('madk_goi', $madk_goi)
            ->update(['dangky_goi.trangthaigoitiem' =>"Đã hoàn thành"]);
        return redirect()->back()->with('success', 'Đã tiêm!');
    }
}
