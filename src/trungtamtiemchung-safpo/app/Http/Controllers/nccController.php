<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class nccController extends Controller
{
    public function showncc(){
        try {
            $nhacungcaps = DB::table('nhacungcap')->select('mancc', 'tenncc', 'sdtncc', 'emailncc', 'diachincc')->get();
            return view('admin.nhacungcap.nhacungcap', compact('nhacungcaps'));
        } catch (\Exception $e) {
            $nhacungcaps = collect();
            return view('admin.nhacungcap.nhacungcap', compact('nhacungcaps'));
        }
    }

    public function themncc(Request $request){
        $mancc = $request->input('mancc');
        if($mancc == ""){
            // Lấy mã ncc cuối cùng từ cơ sở dữ liệu
            $lastncc = DB::table('nhacungcap')->orderByRaw('CONVERT(SUBSTRING(mancc, 4), UNSIGNED) DESC')->first();

            if ($lastncc) {
                $newnccCode = (int)substr($lastncc->mancc, 3) + 1;
                $newnccCode = "ncc" . $newnccCode;
            } else {
                // Nếu không có mancc nào trong cơ sở dữ liệu, bắt đầu từ 1
                $newnccCode = "ncc1";
            }
            $data = [
                'tenncc' => $request->input('tenncc'),
                'sdtncc' => $request->input('sdtncc'),
                'emailncc' => $request->input('emailncc'),
                'diachincc' => $request->input('diachincc'),
            ];
            $data['mancc'] = $newnccCode;

            DB::table('nhacungcap')->insert($data);
            // Redirect về trang gốc hoặc hiển thị thông báo thành công
            return redirect()->back()->with('success', "Thêm thành công!");
        }else{
            
            $data = [
                'tenncc' => $request->input('tenncc'),
                'sdtncc' => $request->input('sdtncc'),
                'emailncc' => $request->input('emailncc'),
                'diachincc' => $request->input('diachincc'),
            ];
            
            // Update data in database using query builder
            DB::table('nhacungcap')->where('mancc', $mancc)->update($data);
            
            // Redirect về trang gốc hoặc hiển thị thông báo thành công
            return redirect()->back()->with('success', "Cập nhật thành công!");
        }
        
    }

    public function xoanhacungcap($mancc)
    {
        DB::table('nhacungcap')->where('mancc', $mancc)->delete();
        return redirect()->back()->with('success', "Xóa thành công!");
    }
}
