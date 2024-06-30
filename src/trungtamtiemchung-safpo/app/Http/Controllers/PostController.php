<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PostController extends Controller
{
    public function store(Request $request)
    {
        $mabaiviet = $request->input('mabaiviet');
        if($mabaiviet == ""){
            try{
                $mabenh = "";
                $benh = DB::table('benh_nhombenh')->where('tenbenh', $request->input('mabenh'))->first();
                $mabenh = $benh->mabenh_nhombenh;
                // Prepare data to insert
                $data = [
                    'mabaiviet' => Carbon::now()->format('YmdHis'),
                    'ngaydangtai' => Carbon::now()->toDateString(),
                    'tenbaiviet' => $request->input('tenbaiviet'),
                    'loaibaiviet' => $request->input('loaibaiviet'),
                    'mabenh_nhombenh' => $mabenh,
                    'motabaiviet' => $request->input('motabaiviet'),
                    'noidungbaiviet' => $request->input('noidungbaiviet'),
                ];

                // Handle file upload
                if ($request->hasFile('hinhanhminhhoa')) {
                    $image = $request->file('hinhanhminhhoa');
                    $imageName = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('images/baiviet'), $imageName);
                    $data['hinhanhminhhoa'] = 'images/baiviet/'.$imageName;
                }

                // Insert data into database using query builder
                DB::table('baiviet')->insert($data);
                
                // Redirect về trang gốc hoặc hiển thị thông báo thành công
                return redirect()->back()->with('success', "Đăng tải thành công!");
            }catch(\Exception $e) {
                // Xử lý lỗi khác
                return redirect()->back()->with('success',    'Có lỗi xảy ra: ' . $e->getMessage()); // 500 Internal Server Error
            }
        }else{
            $benh = DB::table('benh_nhombenh')->where('tenbenh', $request->input('mabenh'))->first();
            $mabenh = $benh->mabenh_nhombenh;
            $data = [
                'ngaydangtai' => Carbon::now()->toDateString(),
                'tenbaiviet' => $request->input('tenbaiviet'),
                'loaibaiviet' => $request->input('loaibaiviet'),
                'mabenh_nhombenh' => $mabenh,
                'motabaiviet' => $request->input('motabaiviet'),
                'noidungbaiviet' => $request->input('noidungbaiviet'),
            ];
            
            // Handle file upload
            if ($request->hasFile('hinhanhminhhoa')) {
                $image = $request->file('hinhanhminhhoa');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/baiviet'), $imageName);
                $data['hinhanhminhhoa'] = 'images/baiviet/'.$imageName;
            }
            
            // Update data in database using query builder
            DB::table('baiviet')->where('mabaiviet', $mabaiviet)->update($data);
            
            // Redirect về trang gốc hoặc hiển thị thông báo thành công
            return redirect()->back()->with('success', "Cập nhật thành công!");
        }
        
    }

    public function show_benh(){
        $nhombenhs = DB::connection('mysql')->table('benh_nhombenh')->get();
        return view('admin.quanlybaiviet.dangbaiviet', compact('nhombenhs'));
    }
    public function show($mabaiviet)
    {
        // Truy vấn và lấy thông tin của bài viết có mabaiviet tương ứng từ cơ sở dữ liệu
        $post = DB::table('baiviet')->where('mabaiviet', $mabaiviet)->first();
        $post->ngaydangtai = Carbon::parse($post->ngaydangtai)->format('d/m/Y');
        // Trả về view hiển thị nội dung của bài viết với dữ liệu tương ứng
        return view('tintuc/baiviet', compact('post'))->with('post', $post);
    }

    public function xoabaiviet($mabaiviet)
    {
        $post = DB::table('baiviet')->where('mabaiviet', $mabaiviet)->first();
        if ($post) {
            // Lấy đường dẫn hình ảnh từ cơ sở dữ liệu
            $imagePath = public_path($post->hinhanhminhhoa);
    
            // Kiểm tra xem tệp có tồn tại không và xóa tệp
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            DB::table('baiviet')->where('mabaiviet', $mabaiviet)->delete();
            return redirect()->back()->with('success', "Xóa thành công!");
        }
    }
}
