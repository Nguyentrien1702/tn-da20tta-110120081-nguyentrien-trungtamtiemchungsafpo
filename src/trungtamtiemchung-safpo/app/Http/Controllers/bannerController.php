<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class bannerController extends Controller
{
    public function showbanner(){
        try {
            $banners = DB::table('banner')->select('mabanner', 'hinhanh', 'ngaydangbanner')->get();

            return view('admin.banner.quanlybanner', compact('banners'));
        } catch (\Exception $e) {
            $banners = collect();
            return view('admin.banner.quanlybanner', compact('banners'));
        }
    }
    
    public function thembanner(Request $request){
        // Validate request
        $request->validate([
            'hinhanhbanner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Lấy mã banner cuối cùng từ cơ sở dữ liệu
        $lastBanner = DB::table('banner')->orderByRaw('CONVERT(mabanner, UNSIGNED) DESC')->first();
    
        // Tạo mã banner mới bằng cách cộng thêm 1 vào mã banner cuối cùng
        $newBannerCode = $lastBanner ? $lastBanner->mabanner + 1 : 1;
    
        // Xử lý tệp ảnh nếu người dùng đã chọn
        if ($request->hasFile('hinhanhbanner')) {
            $image = $request->file('hinhanhbanner');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/banner'), $imageName);
            $data['hinhanh'] = 'images/banner/'.$imageName;
        }
    
        // Thêm mã banner mới vào cơ sở dữ liệu
        $data['mabanner'] = $newBannerCode;
        $data['ngaydangbanner'] = Carbon::now()->toDateString();
        DB::table('banner')->insert($data);
        
        // Redirect về trang gốc hoặc hiển thị thông báo thành công
        return redirect()->back()->with('success', "Đăng tải thành công!");
    }

    public function xoabanner($mabanner)
    {
        // Lấy thông tin banner cần xóa
        $banner = DB::table('banner')->where('mabanner', $mabanner)->first();
        
        if ($banner) {
            // Lấy đường dẫn hình ảnh từ cơ sở dữ liệu
            $imagePath = public_path($banner->hinhanh);

            // Kiểm tra xem tệp có tồn tại không và xóa tệp
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Xóa bản ghi từ cơ sở dữ liệu
            DB::table('banner')->where('mabanner', $mabanner)->delete();
            
            return redirect()->back()->with('success', "Xóa thành công!");
        }

    }
}
