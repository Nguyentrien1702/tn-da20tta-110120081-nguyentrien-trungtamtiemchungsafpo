<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Carbon\Carbon;

class dmbenhController extends Controller
{
    public function showdmbenh(){
        try {
            $dmbenhs = DB::table('benh_nhombenh')->select('mabenh_nhombenh', 'tenbenh', 'mota')->get();
            return view('admin.danhmucbenh.danhmucbenh', compact('dmbenhs'));
        } catch (\Exception $e) {
            $dmbenhs = collect();
            return view('admin.danhmucbenh.danhmucbenh', compact('dmbenhs'));
        }
    }
    public function thembenh(Request $request){
        $mabenh = $request->input('mabenh');
        if($mabenh == ""){
            // Lấy mã benh cuối cùng từ cơ sở dữ liệu
            $lastbenh = DB::table('benh_nhombenh')->orderByRaw('CONVERT(mabenh_nhombenh, UNSIGNED) DESC')->first();

            if ($lastbenh) {
                $newbenhCode = $lastbenh->mabenh_nhombenh + 1;
            } else {
                // Nếu không có mabenh nào trong cơ sở dữ liệu, bắt đầu từ 1
                $newbenhCode = 1;
            }
            $data = [
                'tenbenh' => $request->input('tenbenh'),
                'mota' => $request->input('motabenh'),
            ];
            $data['mabenh_nhombenh'] = $newbenhCode;

            DB::table('benh_nhombenh')->insert($data);
            // Redirect về trang gốc hoặc hiển thị thông báo thành công
            return redirect()->back()->with('success', "Thêm thành công!");
        }else{
            
            $data = [
                'tenbenh' => $request->input('tenbenh'),
                'mota' => $request->input('motabenh'),
            ];
            
            // Update data in database using query builder
            DB::table('benh_nhombenh')->where('mabenh_nhombenh', $mabenh)->update($data);
            
            // Redirect về trang gốc hoặc hiển thị thông báo thành công
            return redirect()->back()->with('success', "Cập nhật thành công!");
        }
        
    }

    public function themfilebenh(Request $request)
    {
        
        $request->validate([
            'filebenh' => 'required|mimes:xls,xlsx'
        ]);

        // Đọc file Excel
        $path = $request->file('filebenh')->getRealPath();
        $data = Excel::toCollection(null, $path);

        if($data->isEmpty()) {
            return redirect()->back()->with('error', 'File không có dữ liệu.');
        }

        // Lấy hàng đầu tiên để kiểm tra tiêu đề cột
        $headings = $data[0]->shift()->toArray();

        // Kiểm tra nếu tiêu đề không khớp với các cột yêu cầu
        if (!in_array('Danh sách bệnh', $headings)) {
            return redirect()->back()->with('error', 'File Excel không đúng định dạng.');
        }

        // Lấy mã benh cuối cùng từ cơ sở dữ liệu
        $lastbenh = DB::table('benh_nhombenh')->orderByRaw('CONVERT(mabenh_nhombenh, UNSIGNED) DESC')->first();

        if ($lastbenh) {
            $newbenhCode = $lastbenh->mabenh_nhombenh;
        } else {
            // Nếu không có mabenh nào trong cơ sở dữ liệu, bắt đầu từ 1
            $newbenhCode = 1;
        }
        // Chèn dữ liệu vào cơ sở dữ liệu
        foreach ($data[0] as $row) {
            $newbenhCode = $newbenhCode + 1;
            // Thêm logic ở đây để xử lý dữ liệu từ mỗi hàng của file Excel
            $tenbenh = $row[0]; // Tên bệnh
            // Làm tương tự cho các cột khác nếu cần

            // Sau đó chèn dữ liệu vào cơ sở dữ liệu
            DB::table('benh_nhombenh')->insert([
                'mabenh_nhombenh' => $newbenhCode,
                'tenbenh' => $tenbenh,
                // Thêm các cột khác nếu cần
            ]);
        }

        return redirect()->back()->with('success', 'Thêm thành công!');
    }

    public function xoadmbenh($mabenh)
    {
        DB::table('benh_nhombenh')->where('mabenh_nhombenh', $mabenh)->delete();
        return redirect()->back()->with('success', "Xóa thành công!");
    }
}