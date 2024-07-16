<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
class goivcController extends Controller
{
    public function showgoivc()
    {
        try {
            $nhomtuois = DB::connection('mysql')->table('nhomtuoi')->get();
            $vaccines = DB::connection('mysql')->table('vaccine')->get();
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

            return view('admin.quanlyvaccine.goivaccine', compact('goivaccines', 'nhomtuois', 'vaccines'));
        } catch (\Exception $e) {
            dd($e);
            $goivaccines = collect();
            $vaccines = collect();
            $vaccines = collect();
            return view('admin.quanlyvaccine.goivaccine', compact('goivaccines', 'nhomtuois', 'vaccines'));
        }
    }
    public function dsnhomtuoi(Request $request){
        $magoi = $request->query('magoi');
        $dsnhomtuoi = DB::connection('mysql')->table('goivaccine')
            ->where('goivaccine.magoi', $magoi)
            ->join('chitiettuoi_goivc', 'chitiettuoi_goivc.magoi', '=', 'goivaccine.magoi')
            ->join('nhomtuoi', 'nhomtuoi.manhomtuoi', '=', 'chitiettuoi_goivc.manhomtuoi')
            ->select('nhomtuoi.*')
            ->get();

        return response()->json($dsnhomtuoi);
    }
    public function vaccine(){
        $vaccine = DB::connection('mysql')->table('vaccine')->get();
        return response()->json($vaccine);
    }
    public function dsvaccine(Request $request){
        $magoi = $request->query('magoi');
    
        // Sử dụng Eloquent để lấy danh sách vaccine dựa trên tên gói vaccine
        $dsvaccine = DB::table('vaccine')
        ->join('benh_nhombenh', 'benh_nhombenh.mabenh_nhombenh', '=', 'vaccine.benh_nhombenh')
        ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
        ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
        ->where('goivaccine.magoi', $magoi)
        ->select('vaccine.*', 'chitietgoivc.*', 'benh_nhombenh.*')
        ->get();
    
        // Trả về danh sách vaccine dưới dạng JSON
        return response()->json($dsvaccine);
    }

    public function ttgoivaccine(Request $request){
        $magoi = $request->query('magoi');
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
    }

    public function themGoiVaccine(Request $request)
    {
        // Validate dữ liệu nhập vào từ form
        $validatedData = $request->validate([
            'magoi' => 'nullable|string',
            'tengoivc' => 'required|string',
            'datcoc' => 'required|string',
            'uudai' => 'required|numeric',
            'vaccine' => 'required|array',
            'vaccine.*.tenvc' => 'required|string',
            'vaccine.*.solieu' => 'required|numeric',
            'thongtingoivc' => 'nullable|string'
        ]);

        if($validatedData['magoi']==""){
            try {
                DB::beginTransaction();
                $lastgoi = DB::table('goivaccine')->orderByRaw('CONVERT(SUBSTRING(magoi, 4), UNSIGNED) DESC')->first();
        
                if ($lastgoi) {
                    $newgoiCode = (int)substr($lastgoi->magoi, 3) + 1;
                    $newgoiCode = "goi" . $newgoiCode;
                } else {
                    // Nếu không có magoi nào trong cơ sở dữ liệu, bắt đầu từ 1
                    $newgoiCode = "goi1";
                }
                $loaigoi = 2;
                $datcoc = str_replace('.', '', $validatedData['datcoc']);
                $data_goi = [
                    'magoi' => $newgoiCode,
                    'tengoi' => $validatedData['tengoivc'],
                    'loaigoi' => $loaigoi,
                    'datcoc' => $datcoc,
                    'uudai' => $validatedData['uudai'],
                    'mota' => $validatedData['thongtingoivc']
                ];
                try{
                    DB::table('goivaccine')->insert($data_goi);
                }catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Đã xảy ra lỗi khi thêm gói vaccine: ' . $e->getMessage());
                }
                

                // Lưu chi tiết của gói vaccine (vaccine và số liệu tương ứng)
                foreach ($validatedData['vaccine'] as $vaccineData) {
                    // Lấy mavc tương ứng với tenvc
                    $mavc = DB::table('vaccine')
                        ->where('tenvc', $vaccineData['tenvc'])
                        ->value('mavc');
                    try{
                        DB::table('chitietgoivc')->insert([
                        'magoi' => $newgoiCode,
                        'mavc' => $mavc,
                        'soluongmuitiem' => $vaccineData['solieu'],
                        // Thêm các trường khác của chi tiết gói vaccine tùy theo yêu cầu của bạn
                        ]);
                    }catch (\Exception $e) {
                        return redirect()->back()->with('error', 'Đã xảy ra lỗi khi thêm gói vaccine: ' . $e->getMessage());
                    }
                }
                $NhomTuois = $request->input('nhomtuoi', []);
                foreach ($NhomTuois as $manhomtuoi) {
                    try{
                        DB::table('chitiettuoi_goivc')->insert(['manhomtuoi' => $manhomtuoi, 'magoi' => $newgoiCode]);
                    }catch (\Exception $e) {
                        return redirect()->back()->with('error', 'Đã xảy ra lỗi khi thêm gói vaccine: ' . $e->getMessage());
                    }
                }
                DB::commit();
                // Redirect về trang danh sách gói vaccine với thông báo thành công
                return redirect()->back()->with('success', 'Thêm gói vaccine thành công!');
            } catch (\Exception $e) {
                // Nếu có lỗi xảy ra, rollback transaction và hiển thị thông báo lỗi
                DB::rollback();
                return redirect()->back()->with('error', 'Đã xảy ra lỗi khi thêm gói vaccine: ' . $e->getMessage());
            }
        }else{
            try{
                DB::beginTransaction();
                $magoi = $validatedData['magoi'];
                $datcoc = str_replace('.', '', $validatedData['datcoc']);
                $data_goi = [
                    'tengoi' => $validatedData['tengoivc'],
                    'datcoc' => $datcoc,
                    'uudai' => $validatedData['uudai'],
                    'mota' => $validatedData['thongtingoivc']
                ];
                DB::table('goivaccine')->where('magoi', $validatedData['magoi'])->update($data_goi);
                
                DB::table('chitietgoivc')->where('magoi', $magoi)->delete();
                // Lưu chi tiết của gói vaccine (vaccine và số liệu tương ứng)
                foreach ($validatedData['vaccine'] as $vaccineData) {
                    // Lấy mavc tương ứng với tenvc
                    $mavc = DB::table('vaccine')
                        ->where('tenvc', $vaccineData['tenvc'])
                        ->value('mavc');
                    DB::table('chitietgoivc')->insert([
                        'magoi' => $magoi,
                        'mavc' => $mavc,
                        'soluongmuitiem' => $vaccineData['solieu'],
                        // Thêm các trường khác của chi tiết gói vaccine tùy theo yêu cầu của bạn
                    ]);
                }
                DB::table('chitiettuoi_goivc')->where('magoi', $magoi)->delete();
                $NhomTuois = $request->input('nhomtuoi', []);
                foreach ($NhomTuois as $manhomtuoi) {
                    DB::table('chitiettuoi_goivc')->insert(['manhomtuoi' => $manhomtuoi, 'magoi' => $magoi]);
                }
                DB::commit();
                // Redirect về trang danh sách gói vaccine với thông báo thành công
                return redirect()->back()->with('success', 'Cập nhật thành công!');
            } catch (\Exception $e) {
                // Nếu có lỗi xảy ra, rollback transaction và hiển thị thông báo lỗi
                DB::rollback();
                return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
            }
        }
        
    }
}
