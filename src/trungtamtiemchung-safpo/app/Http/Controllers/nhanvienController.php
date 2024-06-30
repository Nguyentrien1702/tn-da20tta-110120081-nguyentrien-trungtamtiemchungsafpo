<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class nhanvienController extends Controller
{
    public function shownhanvien(){
        try {
            $nhanviens = DB::table('nhanvien')
            ->select('manv', 'tennv', 'ngaysinhnv', 'gioitinh', 'sdtnv', 'emailnv', 'diachinv', 'ngaybdlamviec', 'mavaitro')
            ->whereNotIn('manv', ['Admin'])
            ->where('trangthaihoatdong', '!=', 0)
            ->get();
            return view('admin.nhanvien.quanlynhanvien', compact('nhanviens'));
        } catch (\Exception $e) {
            $nhanviens = collect();
            return view('admin.nhanvien.quanlynhanvien', compact('nhanviens'));
        }
    }

    public function showtknhanvien(){
        try {
            $nhanviens = DB::table('nhanvien')
            ->select('manv', 'tennv', 'matkhau')
            ->whereNotIn('manv', ['Admin'])
            ->where('trangthaihoatdong', '!=', 0)
            ->get();    
            return view('admin.nhanvien.taikhoannv', compact('nhanviens'));
        } catch (\Exception $e) {
            $nhanviens = collect();
            return view('admin.nhanvien.taikhoannv', compact('nhanviens'));
        }
    }

    public function resetmk($manv){
        $matkhau = $manv."@";

        DB::table('nhanvien')->where('manv', $manv)->update(['matkhau' => md5($matkhau)]);
        return redirect()->back()->with('success', "Reset mật khẩu thành công!");
    }

    public function themnhanvien(Request $request){
        $manv = $request->input('manv');
        if($manv == ""){
            // Lấy mã nv cuối cùng từ cơ sở dữ liệu
            $lastnv = DB::table('nhanvien')->orderByRaw('CONVERT(SUBSTRING(manv, 8), UNSIGNED) DESC')->first();

            if ($lastnv) {
                $newnvCode = (int)substr($lastnv->manv, 7) + 1;
                $newnvCode = "nvsafpo" . $newnvCode;
            } else {
                // Nếu không có manv nào trong cơ sở dữ liệu, bắt đầu từ 1
                $newnvCode = "nvsafpo1";
            }
            $data = [
                'tennv' => $request->input('tennv'),
                'gioitinh' => $request->input('gioitinh'),
                'sdtnv' => $request->input('sdtnv'),
                'emailnv' => $request->input('emailnv'),
                'diachinv' => $request->input('diachinv'),
                'ngaysinhnv' => $request->input('ngaysinhnv'),
                'ngaybdlamviec' => $request->input('ngaybdlamviec'),
                'mavaitro' => $request->input('mavaitro'),
            ];
            $data['manv'] = $newnvCode;
            $data['trangthaihoatdong'] = 1;
            $matkhau = $newnvCode."@";
            $data['matkhau'] = md5($matkhau);

            DB::table('nhanvien')->insert($data);
            // Redirect về trang gốc hoặc hiển thị thông báo thành công
            return redirect()->back()->with('success', "Thêm thành công!");
        }else{
            
            $data = [
                'tennv' => $request->input('tennv'),
                'gioitinh' => $request->input('gioitinh'),
                'sdtnv' => $request->input('sdtnv'),
                'emailnv' => $request->input('emailnv'),
                'diachinv' => $request->input('diachinv'),
                'ngaysinhnv' => $request->input('ngaysinhnv'),
                'ngaybdlamviec' => $request->input('ngaybdlamviec'),
                'mavaitro' => $request->input('mavaitro'),
            ];

            // Update data in database using query builder
            DB::table('nhanvien')->where('manv', $manv)->update($data);
            
            // Redirect về trang gốc hoặc hiển thị thông báo thành công
            return redirect()->back()->with('success', "Cập nhật thành công!");
        } 
    }

    public function xoanhanvien($manv)
    {
        DB::table('nhanvien')->where('manv', $manv)->update(['trangthaihoatdong' => 0]);
        return redirect()->back()->with('success', "Xóa thành công!");
    }
}
