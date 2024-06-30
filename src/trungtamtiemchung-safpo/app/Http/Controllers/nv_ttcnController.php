<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class nv_ttcnController extends Controller
{
    public function show_ttnv(){
        $nhanviens = DB::table('nhanvien')
            ->join('vaitro', 'vaitro.mavaitro', '=', 'nhanvien.mavaitro')
            ->where('nhanvien.manv', session('manhanvien'))
            ->select('nhanvien.*', 'vaitro.*')
            ->get()
            ->map(function($nhanvien) {
                $nhanvien->ngaybdlamviec = Carbon::parse($nhanvien->ngaybdlamviec)->format('d/m/Y');
                return $nhanvien;
            });
        return view('nhanvien.thongtincanhan.thongtinnv', compact('nhanviens'));
    }
    public function capnhatttnv(request $request){
        $manv = $request->input('manv');
        $data = [
            'tennv' => $request->input('tennv'),
            'gioitinh' => $request->input('gioitinh'),
            'ngaysinhnv' => $request->input('ngaysinh'),
            'sdtnv' => $request->input('sdtnv'),
            'emailnv' => $request->input('emailnv'),
            'diachinv' => $request->input('diachi'),
        ];

        // Update data in database using query builder
        DB::table('nhanvien')->where('manv', $manv)->update($data);
        
        // Redirect về trang gốc hoặc hiển thị thông báo thành công
        return redirect()->back()->with('success', "Cập nhật thành công!");
    }
}
