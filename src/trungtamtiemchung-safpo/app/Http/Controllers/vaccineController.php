<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
class vaccineController extends Controller
{
    public function showvaccine()
    {
        try {
            $nhacungcaps = DB::connection('mysql')->table('nhacungcap')->get();
            $nhombenhs = DB::connection('mysql')->table('benh_nhombenh')->get();
            $nhomtuois = DB::connection('mysql')->table('nhomtuoi')->get();
            
            $vaccines = DB::connection('mysql')->table('vaccine')
            ->join('benh_nhombenh', 'vaccine.benh_nhombenh', '=', 'benh_nhombenh.mabenh_nhombenh')
            ->join('nhacungcap', 'vaccine.mancc', '=', 'nhacungcap.mancc')
            ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
            ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
            ->where('goivaccine.loaigoi', 1)
            ->select('vaccine.*', 'benh_nhombenh.*', 'nhacungcap.*')
            ->get();

            return view('admin.quanlyvaccine.vaccine', compact('vaccines', 'nhacungcaps', 'nhombenhs', 'nhomtuois'));
        } catch (\Exception $e) {
            $vaccines = collect();
            return view('admin.quanlyvaccine.vaccine', compact('vaccines'));
        }
    }

    public function dsnhomtuoi(Request $request){
        $mavc = $request->query('mavc');
        $dsnhomtuoi = DB::connection('mysql')->table('vaccine')
            ->where('vaccine.mavc', $mavc)
            ->where('goivaccine.loaigoi', 1)
            ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
            ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
            ->join('chitiettuoi_goivc', 'chitiettuoi_goivc.magoi', '=', 'goivaccine.magoi')
            ->join('nhomtuoi', 'nhomtuoi.manhomtuoi', '=', 'chitiettuoi_goivc.manhomtuoi')
            ->select('nhomtuoi.*')
            ->get();

        return response()->json($dsnhomtuoi);
    }
    function convertToMonths($age, $unit) {
        switch ($unit) {
            case 'giờ':
                return $age / (24 * 30); // Chuyển đổi giờ sang tháng
            case 'tuần':
                return $age * 7 / 30; // Chuyển đổi tuần sang tháng
            case 'tháng':
                return $age; // Đã là tháng, không cần chuyển đổi
            case 'tuổi':
                return $age * 12; // Chuyển đổi năm sang tháng
            default:
                throw new Exception("Đơn vị không hợp lệ.");
        }
    }
    
    function classifyAge($ageInMonths) {
        $ageInYears = $ageInMonths / 12;
        if ($ageInYears < 2) {
            return "Trẻ sơ sinh";
        } elseif ($ageInYears < 10) {
            return "Trẻ em";
        } elseif ($ageInYears < 19) {
            return "Vị thành niên";
        } else {
            return "Người lớn";
        }
    }

    public function themvaccine(Request $request){
        $validated = $request->validate([
            'hinhanhminhhoa' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mavc' => 'nullable|string',
            'tenvc' => 'required|string|max:255',
            'nuocsx' => 'required|string',
            'gia' => 'required',
            'soluong' => 'required|integer|min:0|max:10000',
            'mancc' => 'required|string',
            'benh_nhombenh' => 'required|string',
            'solieu' => 'required|integer|min:1|max:20',
            'khoangcachmuitiem' => 'required|string',
            'thongtinvc' => 'required|string'
        ]);
        $NhomTuois = $request->input('nhomtuoi', []);

        if($validated['mavc'] == ""){
            $tenVaccine = str_replace(' ', '', $validated['tenvc']);
            $length = strlen($tenVaccine);

            if ($length > 35) {
                $maVaccine = "vc".substr($tenVaccine, 0, 35);
            }else{
                $maVaccine = "vc".$tenVaccine;
            }

            $benh = DB::table('benh_nhombenh')->where('tenbenh', $validated['benh_nhombenh'])->first();

            if (!$benh) {
                // Lấy mã benh cuối cùng từ cơ sở dữ liệu
                $lastbenh = DB::table('benh_nhombenh')->orderByRaw('CONVERT(mabenh_nhombenh, UNSIGNED) DESC')->first();

                if ($lastbenh) {
                    $mabenh_nhombenh = $lastbenh->mabenh_nhombenh + 1;
                }else {
                    // Nếu không có mabenh nào trong cơ sở dữ liệu, bắt đầu từ 1
                    $mabenh_nhombenh = 1;
                }
                try{
                // Nếu bệnh không tồn tại trong cơ sở dữ liệu, thêm mới
                $benh_nhombenh = DB::table('benh_nhombenh')->insert([
                    'mabenh_nhombenh' => $mabenh_nhombenh,
                    'tenbenh' => $validated['benh_nhombenh'],
                    'mota' => "",
                ]);}
                catch(\Exception $e){
                    return redirect()->back()->with('error',    'Có lỗi xảy ra: ' . $e->getMessage());
                }
            } else {
                // Nếu bệnh đã tồn tại, lấy mã bệnh để lưu trong bảng vaccine
                $mabenh_nhombenh = $benh->mabenh_nhombenh;
            }                
            try{
                $lastgoi = DB::table('goivaccine')->orderByRaw('CONVERT(SUBSTRING(magoi, 4), UNSIGNED) DESC')->first();
    
                if ($lastgoi) {
                    $newgoiCode = (int)substr($lastgoi->magoi, 3) + 1;
                    $newgoiCode = "goi" . $newgoiCode;
                } else {
                    // Nếu không có magoi nào trong cơ sở dữ liệu, bắt đầu từ 1
                    $newgoiCode = "goi1";
                }
                $loaigoi = 1;
                $data_goi = [
                    'magoi' => $newgoiCode,
                    'loaigoi' => $loaigoi,
                ];
                DB::table('goivaccine')->insert($data_goi);

                foreach ($NhomTuois as $manhomtuoi) {
                    DB::table('chitiettuoi_goivc')->insert(['manhomtuoi' => $manhomtuoi, 'magoi' => $newgoiCode]);
                }

                $gia = str_replace('.', '', $validated['gia']);
                
                try{
                    $data_vc = [
                        'mavc' => $maVaccine,
                        'tenvc' => $validated['tenvc'],
                        'nuocsx' => $validated['nuocsx'],
                        'gia' => $gia,
                        'soluong' => $validated['soluong'],
                        'mancc' => $validated['mancc'],
                        'benh_nhombenh' => $mabenh_nhombenh,
                        'solieu' => $validated['solieu'],
                        'khoangcachmuitiem' => $validated['khoangcachmuitiem'],
                        'thongtinvc' => $validated['thongtinvc'],
                        'trangthaivc' => 1,
                    ];
                    // Handle file upload
                    if ($request->hasFile('hinhanhminhhoa')) {
                        $image = $request->file('hinhanhminhhoa');
                        $imageName = date('Ymd_His').'.'.$image->getClientOriginalExtension();
                        $image->move(public_path('images/hinhanhvaccine'), $imageName);
                        $data_vc['hinhanhvc'] = 'images/hinhanhvaccine/'.$imageName;
                    }
                    try{
                        DB::table('vaccine')->insert($data_vc);
                    }
                    catch (\Exception $e) {
                        // Xử lý lỗi khác
                        return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage()); 
                    }
                }
                catch (\Exception $e) {
                    // Xử lý lỗi khác
                    return redirect()->back()->with('error',    'Có lỗi xảy ra: ' . $e->getMessage()); // 500 Internal Server Error
                }
                $data_ctgoi = [
                    'magoi' => $newgoiCode,
                    'mavc' => $maVaccine,
                    'soluongmuitiem' => 1,
                ];
                DB::table('chitietgoivc')->insert($data_ctgoi);
                return redirect()->back()->with('success', 'Thêm vaccine thành công!');
            }catch (Exception $e) {
                return redirect()->back()->with('error',    'Có lỗi xảy ra: ' . $e->getMessage());
            }

        }else{
            $benh = DB::table('benh_nhombenh')->where('tenbenh', $validated['benh_nhombenh'])->first();

            if (!$benh) {
                // Lấy mã benh cuối cùng từ cơ sở dữ liệu
                $lastbenh = DB::table('benh_nhombenh')->orderByRaw('CONVERT(mabenh_nhombenh, UNSIGNED) DESC')->first();

                if ($lastbenh) {
                    $mabenh_nhombenh = $lastbenh->mabenh_nhombenh + 1;
                }else {
                    // Nếu không có mabenh nào trong cơ sở dữ liệu, bắt đầu từ 1
                    $mabenh_nhombenh = 1;
                }
                try{
                // Nếu bệnh không tồn tại trong cơ sở dữ liệu, thêm mới
                $benh_nhombenh = DB::table('benh_nhombenh')->insert([
                    'mabenh_nhombenh' => $mabenh_nhombenh,
                    'tenbenh' => $validated['benh_nhombenh'],
                    'mota' => "",
                ]);}
                catch(\Exception $e){
                    return redirect()->back()->with('error',    'Có lỗi xảy ra: ' . $e->getMessage());
                }
            } else {
                // Nếu bệnh đã tồn tại, lấy mã bệnh để lưu trong bảng vaccine
                $mabenh_nhombenh = $benh->mabenh_nhombenh;
            }
            try {
                
                
                $gia = str_replace('.', '', $validated['gia']);
                try{
                    $data_vc = [
                        'tenvc' => $validated['tenvc'],
                        'nuocsx' => $validated['nuocsx'],
                        'gia' => $gia,
                        'soluong' => $validated['soluong'],
                        'mancc' => $validated['mancc'],
                        'benh_nhombenh' => $mabenh_nhombenh,
                        'solieu' => $validated['solieu'],
                        'khoangcachmuitiem' => $validated['khoangcachmuitiem'],
                        'thongtinvc' => $validated['thongtinvc'],
                    ];
                    // Get current hinhanhvc from the database
                    $currentHinhanhvc = DB::table('vaccine')->where('mavc', $validated['mavc'])->value('hinhanhvc');
                    $filename = basename($currentHinhanhvc);
                    // Handle file upload
                    if ($request->hasFile('hinhanhminhhoa')) {
                        
                        // Check if the new image is different from the current image
                        if ($filename !== $validated['hinhanhminhhoa']->getClientOriginalName()) {
                            $image = $request->file('hinhanhminhhoa');
                            $imageName = date('Ymd_His').'.'.$image->getClientOriginalExtension();
                            $imagePath = 'images/hinhanhvaccine/'.$imageName;
                            // Move the new image
                            $image->move(public_path('images/hinhanhvaccine'), $imageName);
                            $data_vc['hinhanhvc'] = $imagePath;
                        }
                    }
                    DB::table('vaccine')->where('mavc', $validated['mavc'])->update($data_vc);}
                catch (\Exception $e) {
                    // Xử lý lỗi khác
                    return redirect()->back()->with('error',    'Có lỗi xảy ra: ' . $e->getMessage()); // 500 Internal Server Error
                }
                try{
                    $vaccines = DB::table('vaccine')
                    ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
                    ->join('goivaccine', function($join) {
                        $join->on('goivaccine.magoi', '=', 'chitietgoivc.magoi')
                            ->where('goivaccine.loaigoi', 1);
                    })
                    ->where('vaccine.mavc', $validated['mavc'])
                    ->select('vaccine.*', 'goivaccine.*')
                    ->first();
                    
                    $magoi = $vaccines->magoi;
                    DB::table('chitiettuoi_goivc')->where('magoi', $magoi)->delete();
                    foreach ($NhomTuois as $manhomtuoi) {
                        DB::table('chitiettuoi_goivc')->insert(['manhomtuoi' => $manhomtuoi, 'magoi' => $magoi]);
                    }
                }catch (Exception $e) {
                    return redirect()->back()->with('error',    'Có lỗi xảy ra: ' . $e->getMessage());
                }
                return redirect()->back()->with('success', 'Cập nhật vaccine thành công!');

            } catch (Exception $e) {
                return redirect()->back()->with('error',    'Có lỗi xảy ra: ' . $e->getMessage());
            }    

        }
    }

    public function xoavaccine($mavc){
        DB::table('vaccine')->where('mavc', $mavc)->update(['trangthaivc' => 0]);
        return redirect()->back()->with('success', "Xóa thành công!");
    }
}
