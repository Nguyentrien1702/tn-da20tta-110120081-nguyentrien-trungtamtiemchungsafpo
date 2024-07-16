<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class nv_khachhangController extends Controller
{
    public function showkhachhang(){
        try {
            $khachhangs = DB::table('khachhang')->get();    
            return view('nhanvien.quanlykhachhang.khachhang', compact('khachhangs'));
        } catch (\Exception $e) {
            $khachhangs = collect();
            return view('nhanvien.quanlykhachhang.khachhang', compact('khachhangs'));
        }
    }

    public function themkhachhang(Request $request){
        $makh = $request->input('makh');
        if($makh == ""){
            // Lấy mã kh cuối cùng từ cơ sở dữ liệu
            $lastkh = DB::table('khachhang')->orderByRaw('CONVERT(SUBSTRING(makh, 8), UNSIGNED) DESC')->first();

            if ($lastkh) {
                $newkhCode = (int)substr($lastkh->makh, 7) + 1;
                $newkhCode = "khsafpo" . $newkhCode;
            } else {
                // Nếu không có makh nào trong cơ sở dữ liệu, bắt đầu từ 1
                $newkhCode = "khsafpo1";
            }
            $data = [
                'tenkh' => $request->input('tenkh'),
                'gioitinh' => $request->input('gioitinh'),
                'ngaysinhkh' => $request->input('ngaysinhkh'),
                'sdtkh' => $request->input('sdtkh'),
                'emailkh' => $request->input('emailkh'),
                'diachikh' => $request->input('diachikh'),
                'ten_nglh' => $request->input('ten_nglh'),
                'quanhevoikh' => $request->input('quanhevoikh'),
                'mavaitro' => 'vt04',
            ];
            $data['makh'] = $newkhCode;
            $matkhau = $newkhCode."@";
            $data['matkhau'] = md5($matkhau);

            DB::table('khachhang')->insert($data);
            // Redirect về trang gốc hoặc hiển thị thông báo thành công
            return redirect()->back()->with('success', "Thêm thành công!");
        }else{
            
            $data = [
                'tenkh' => $request->input('tenkh'),
                'gioitinh' => $request->input('gioitinh'),
                'ngaysinhkh' => $request->input('ngaysinhkh'),
                'sdtkh' => $request->input('sdtkh'),
                'emailkh' => $request->input('emailkh'),
                'diachikh' => $request->input('diachikh'),
                'ten_nglh' => $request->input('ten_nglh'),
                'quanhevoikh' => $request->input('quanhevoikh'),
            ];

            // Update data in database using query builder
            DB::table('khachhang')->where('makh', $makh)->update($data);
            
            // Redirect về trang gốc hoặc hiển thị thông báo thành công
            return redirect()->back()->with('success', "Cập nhật thành công!");
        } 
    }
    public function dsmakh(){
        $dsmakhs = DB::table('khachhang')
                     ->select('khachhang.*')
                     ->get();

        $vaccines = DB::connection('mysql')->table('vaccine')
            ->join('benh_nhombenh', 'vaccine.benh_nhombenh', '=', 'benh_nhombenh.mabenh_nhombenh')
            ->join('nhacungcap', 'vaccine.mancc', '=', 'nhacungcap.mancc')
            ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
            ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
            ->where('goivaccine.loaigoi', 1)
            ->where('vaccine.soluong', '>', 0)
            ->select('vaccine.*', 'benh_nhombenh.*', 'nhacungcap.*', 'goivaccine.*')
            ->get();

        $goivaccines = DB::connection('mysql')->table('goivaccine')
            ->join('chitietgoivc', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
            ->join('vaccine', 'chitietgoivc.mavc', '=', 'vaccine.mavc')
            ->select(
                'goivaccine.magoi', 
                'goivaccine.tengoi', 
                'goivaccine.mota',
                'goivaccine.loaigoi',
                'goivaccine.uudai',
                'goivaccine.datcoc',
                DB::raw('COUNT(chitietgoivc.mavc) AS soluongvaccine'), 
                DB::raw('SUM(chitietgoivc.soluongmuitiem) AS soluongmuitiem'),
                DB::raw('SUM(vaccine.gia * chitietgoivc.soluongmuitiem) AS tonggiatien')
            )
            ->where('goivaccine.loaigoi', 2)
            ->groupBy(
                'goivaccine.magoi', 
                'goivaccine.tengoi', 
                'goivaccine.mota',
                'goivaccine.loaigoi',
                'goivaccine.uudai',
                'goivaccine.datcoc',
            )
            ->get();
         
            $lichtiems = DB::connection('mysql')->table('chitietlstiem_goi')
                ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
                ->join('dangky_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
                ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                ->where('chitietlstiem_goi.trangthaitiem', "Chờ tiêm")
                ->select('vaccine.*', 'khachhang.*', 'chitietlstiem_goi.*')
                ->get();

        return view('nhanvien.dichvu.taolichtiem', compact('dsmakhs', 'vaccines', 'goivaccines', 'lichtiems'));
    }

    public function getttkhachhang($maKhachHang) {
        $customer = DB::connection('mysql')->table('chitietlstiem_goi')
            ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
            ->join('dangky_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
            ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
            ->where('chitietlstiem_goi.trangthaitiem', "Chờ tiêm")
            ->where('khachhang.makh', $maKhachHang)
            ->select('vaccine.*', 'khachhang.*', 'chitietlstiem_goi.*')
            ->first();
    
        return response()->json([
            'makh' => $customer->makh,
            'tenkh' => $customer->tenkh,
            'ngaysinhkh' => Carbon::parse($customer->ngaysinhkh)->format('d/m/Y'),
        ]);
    }

    public function getttdkkhachhang(Request $request)
    {
        $makh = $request->input('makh');
        // Truy vấn dữ liệu các gói tiêm của khách hàng từ database
        $details = DB::table('dangky_goi')
                    ->join('chitietlstiem_goi', 'chitietlstiem_goi.madk_goi', '=', 'dangky_goi.madk_goi')
                    ->join('vaccine', 'chitietlstiem_goi.mavc', '=', 'vaccine.mavc')
                    ->where('makh', $makh)
                    ->select('dangky_goi.*', 'vaccine.*', 'chitietlstiem_goi.*')
                    ->get();
        $nhanviens = DB::table('nhanvien')->select('nhanvien.*')->get();

        $data = [
            'details' => $details,
            'nhanviens' => $nhanviens,
        ];
    
        return response()->json($data);
    }
    public function getchitietmuitiemkh(Request $request)
    {
        $makh = $request->input('makh');
        $ngaytiem = $request->input('ngaytiem');
        // Truy vấn dữ liệu các gói tiêm của khách hàng từ database
        $details = DB::table('dangky_goi')
                    ->join('chitietlstiem_goi', 'chitietlstiem_goi.madk_goi', '=', 'dangky_goi.madk_goi')
                    ->join('vaccine', 'chitietlstiem_goi.mavc', '=', 'vaccine.mavc')
                    ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                    ->where('dangky_goi.makh', $makh)
                    ->where('chitietlstiem_goi.ngaytiemdukien', $ngaytiem)
                    ->select('dangky_goi.*', 'vaccine.*', 'chitietlstiem_goi.*', 'khachhang.*')
                    ->get();
        $nhanviens = DB::table('nhanvien')->select('nhanvien.*')->get();

        $data = [
            'details' => $details,
            'nhanviens' => $nhanviens,
        ];
    
        return response()->json($data);
    }
}
