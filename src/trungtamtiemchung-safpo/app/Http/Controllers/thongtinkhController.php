<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class thongtinkhController extends Controller
{
    public function show_thongtinkh(){
        if(session("khachhang")){
            $khachhangs = DB::table('khachhang')->where("makh", session("khachhang"))->get();    
            return view('thongtinkhachhang.thongtinkh', compact('khachhangs'));
        }
    }

    public function capnhattkh(request $request){
        $makh = $request->input('makh');
        $data = [
            'tenkh' => $request->input('tenkh'),
            'gioitinh' => $request->input('gioitinh'),
            'ngaysinhkh' => $request->input('ngaysinh'),
            'sdtkh' => $request->input('sdtkh'),
            'emailkh' => $request->input('emailkh'),
            'diachikh' => $request->input('diachi'),
            'ten_nglh' => $request->input('ten_nglh'),
            'quanhevoikh' => $request->input('quanhevoikh'),
        ];

        // Update data in database using query builder
        DB::table('khachhang')->where('makh', $makh)->update($data);
        
        // Redirect về trang gốc hoặc hiển thị thông báo thành công
        return redirect()->back()->with('success', "Cập nhật thành công!");
    }
    public function lichsutiem(){
        if(session("khachhang")){
            $makh = session("khachhang");
        
            $lstiems = DB::table('dangky_goi')
                    ->join('chitietlstiem_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
                    ->join('vaccine', 'chitietlstiem_goi.mavc', '=', 'vaccine.mavc')
                    ->where('dangky_goi.makh', $makh)
                    ->select('chitietlstiem_goi.*', 'vaccine.*', 'dangky_goi.*')
                    ->get();
            return view('thongtinkhachhang.lichsutiemchung', compact('lstiems'));
        }
    }
}
