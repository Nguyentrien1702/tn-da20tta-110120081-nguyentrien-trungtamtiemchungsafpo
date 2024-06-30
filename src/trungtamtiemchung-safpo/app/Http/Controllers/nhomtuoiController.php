<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class nhomtuoiController extends Controller
{
    public function shownhomtuoi(){
        try {
            $nhomtuois = DB::table('nhomtuoi')->select('manhomtuoi', 'tuoibatdau', 'tuoiketthuc', 'donvitinhbatdau', 'donvitinhketthuc', 'doituong')->get();
            return view('admin.nhomtuoi.nhomtuoi', compact('nhomtuois'));
        } catch (\Exception $e) {
            $nhomtuois = collect();
            return view('admin.nhomtuoi.nhomtuoi', compact('nhomtuois'));
        }
    }

    public function themnhomtuoi(Request $request){
        $manhomtuoi = $request->input('manhomtuoi');
        if($request->input('tuoiketthuc') == "" ){
            
            $tuoiketthuc = "";
            $dvketthuc = "";
        }else{
            
            $tuoiketthuc = $request->input('tuoiketthuc');
            $dvketthuc =$request->input('donvitinhketthuc');
        }
        if($request->input('tuoibatdau') == ""){
            $tuoibatdau = "";
            $dvbatdau = "";
        }else{
            $tuoibatdau = $request->input('tuoibatdau');
            $dvbatdau = $request->input('donvitinhbatdau');
        }
        $data = [
            'tuoibatdau' => $tuoibatdau,
            'tuoiketthuc' => $tuoiketthuc,
            'donvitinhbatdau' => $dvbatdau,
            'donvitinhketthuc' => $dvketthuc,
            'doituong' => $request->input('doituong'),
        ];

        if($manhomtuoi == ""){
            // Lấy mã nhóm tuổi cuối cùng từ cơ sở dữ liệu
            $lastNhomTuoi = DB::table('nhomtuoi')->orderByRaw('CONVERT(SUBSTRING(manhomtuoi, 3), UNSIGNED) DESC')->first();

            if ($lastNhomTuoi) {
                $newNhomTuoiCode = (int)substr($lastNhomTuoi->manhomtuoi, 2) + 1;
                $newNhomTuoiCode = "nt" . $newNhomTuoiCode;
            } else {
                // Nếu không có manhomtuoi nào trong cơ sở dữ liệu, bắt đầu từ 1
                $newNhomTuoiCode = "nt1";
            }

            $data['manhomtuoi'] = $newNhomTuoiCode;
            DB::table('nhomtuoi')->insert($data);

            // Redirect về trang gốc hoặc hiển thị thông báo thành công
            return redirect()->back()->with('success', "Thêm thành công!");
        } else {
            // Update data in database using query builder
            DB::table('nhomtuoi')->where('manhomtuoi', $manhomtuoi)->update($data);

            // Redirect về trang gốc hoặc hiển thị thông báo thành công
            return redirect()->back()->with('success', "Cập nhật thành công!");
        }
    }

    public function xoanhomtuoi($manhomtuoi)
    {
        DB::table('nhomtuoi')->where('manhomtuoi', $manhomtuoi)->delete();
        return redirect()->back()->with('success', "Xóa thành công!");
    }

}
