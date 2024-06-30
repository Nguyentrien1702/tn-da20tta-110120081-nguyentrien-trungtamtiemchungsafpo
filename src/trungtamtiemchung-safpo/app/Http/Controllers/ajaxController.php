<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
class ajaxController extends Controller
{
    public function getAgeGroups()
    {
        // Sử dụng DB facade để truy vấn dữ liệu từ cơ sở dữ liệu
        $ageGroups = DB::table('nhomtuoi')
                     ->select('nhomtuoi.*')
                     ->get();

        $goivaccines = DB::connection('mysql')->table('goivaccine')
                ->join('chitietgoivc', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                ->join('vaccine', 'chitietgoivc.mavc', '=', 'vaccine.mavc')
                ->join('chitiettuoi_goivc', 'chitiettuoi_goivc.magoi', '=', 'goivaccine.magoi')
                ->join('nhomtuoi', 'nhomtuoi.manhomtuoi', '=', 'chitiettuoi_goivc.manhomtuoi')
                ->select(
                    'goivaccine.magoi', 
                    'goivaccine.tengoi', 
                    'goivaccine.mota',
                    'goivaccine.loaigoi',
                    'goivaccine.uudai',
                    'goivaccine.datcoc',
                    'nhomtuoi.manhomtuoi',
                    DB::raw('COUNT(chitietgoivc.mavc) AS soluongvaccine'), 
                    DB::raw('SUM(chitietgoivc.soluongmuitiem) AS soluongmuitiem'),
                    DB::raw('SUM(vaccine.gia * chitietgoivc.soluongmuitiem) AS tonggiatien')
                )
                ->where('vaccine.soluong', '>', 0)
                ->where('goivaccine.loaigoi', 2)
                ->groupBy(
                    'goivaccine.magoi', 
                    'goivaccine.tengoi', 
                    'goivaccine.mota',
                    'goivaccine.loaigoi',
                    'goivaccine.uudai',
                    'goivaccine.datcoc',
                    'nhomtuoi.manhomtuoi',
                )
                ->get();

            $dsvaccines = DB::connection('mysql')->table('vaccine')
                ->join('benh_nhombenh', 'vaccine.benh_nhombenh', '=', 'benh_nhombenh.mabenh_nhombenh')
                ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
                ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                ->join('chitiettuoi_goivc', 'chitiettuoi_goivc.magoi', '=', 'goivaccine.magoi')
                ->join('nhomtuoi', 'nhomtuoi.manhomtuoi', '=', 'chitiettuoi_goivc.manhomtuoi')
                ->where('goivaccine.loaigoi', 1)
                ->select('nhomtuoi.*', 'vaccine.*', 'goivaccine.*', 'benh_nhombenh.*')
                ->get();

            if (session('khachhang')) {
                try {
                    $khachhangs = DB::table('khachhang')->where('makh', session('khachhang'))->get();
                } catch (\Exception $e) {
                    $khachhangs = collect(); 
                }
            } else {
                $khachhangs = DB::table('khachhang')->get(); 
            }
        return view('datlichtiem.datlichtiem', compact('ageGroups', 'goivaccines', 'dsvaccines', 'khachhangs'));
    }

    public function dsvaccine(Request $request){
        // Lấy age_group_id từ query string
        $ageGroupId = $request->query('age_group_id');

        // Kiểm tra nếu age_group_id không tồn tại
        if (!$ageGroupId) {
            return response()->json([], 400); // Trả về lỗi 400 Bad Request nếu thiếu tham số
        }

        // Sử dụng DB facade để truy vấn dữ liệu từ cơ sở dữ liệu
        $vaccines = DB::table('vaccine')
                    ->join('benh_nhombenh', 'vaccine.benh_nhombenh', '=', 'benh_nhombenh.mabenh_nhombenh')
                    ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
                    ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                    ->join('chitiettuoi_goivc', 'chitiettuoi_goivc.magoi', '=', 'goivaccine.magoi')
                    ->join('nhomtuoi', 'nhomtuoi.manhomtuoi', '=', 'chitiettuoi_goivc.manhomtuoi')
                    ->where('chitiettuoi_goivc.manhomtuoi', $ageGroupId)
                    ->where('goivaccine.loaigoi', 1)
                    ->select('vaccine.*')
                    ->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($vaccines);
    }

    public function dsnhomtuoi(){
        $dsnhomtuois = DB::table('nhomtuoi')
                     ->select('nhomtuoi.*')
                     ->get();
        return response()->json($dsnhomtuois);
    }

    public function ajax_vaccine(Request $request){
        // Lấy mavc từ query string
        $mavc = $request->query('mavc');

        // Kiểm tra nếu không tồn tại
        if (!$mavc) {
            return response()->json([], 400); // Trả về lỗi 400 Bad Request nếu thiếu tham số
        }

        // Sử dụng DB facade để truy vấn dữ liệu từ cơ sở dữ liệu
        $vaccines = DB::table('vaccine')
                    ->where('vaccine.mavc', $mavc)
                    ->select('vaccine.*')
                    ->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($vaccines);
    }

    public function ajax_goivaccine(Request $request){
        // Lấy mavc từ query string
        $magoi = $request->query('magoi');

        // Kiểm tra nếu không tồn tại
        if (!$magoi) {
            return response()->json([], 400); // Trả về lỗi 400 Bad Request nếu thiếu tham số
        }

        // Sử dụng DB facade để truy vấn dữ liệu từ cơ sở dữ liệu
        $goivaccines = DB::connection('mysql')->table('goivaccine')
                    ->where('goivaccine.magoi', $magoi)
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
                    ->groupBy(
                        'goivaccine.magoi', 
                        'goivaccine.tengoi', 
                        'goivaccine.mota',
                        'goivaccine.loaigoi',
                        'goivaccine.uudai',
                        'goivaccine.datcoc',
                    )
                    ->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($goivaccines);
    }

    public function ajax_ctgoitiem(Request $request){
        // Lấy mavc từ query string
        $madk_goi = $request->query('madk_goi');
        $ctgoitiem = DB::connection('mysql')->table('dangky_goi')
            ->where('madk_goi', $madk_goi)
            ->join('goivaccine', 'goivaccine.magoi', '=', 'dangky_goi.magoi')
            ->join('chitietgoivc', 'chitietgoivc.magoi', '=', 'goivaccine.magoi')
            ->join('vaccine', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
            ->where('goivaccine.loaigoi', 2)
            ->select('vaccine.*', 'goivaccine.*', 'dangky_goi.*')
            ->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($ctgoitiem);
    }

    public function quensession(Request $request){
        $request->session()->forget('success');
    }
}
