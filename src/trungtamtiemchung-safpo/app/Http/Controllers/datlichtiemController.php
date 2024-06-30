<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
class datlichtiemController extends Controller
{
    public function showlichtiem(){
        try {
            $lichtiems = DB::connection('mysql')->table('chitietlstiem_goi')
            ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
            ->join('dangky_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
            ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
            ->where('chitietlstiem_goi.trangthaitiem', "Chờ tiêm")
            ->select('vaccine.*', 'khachhang.*', 'chitietlstiem_goi.*')
            ->get();

            return view('admin.dichvu.taolichtiem', compact('lichtiems'));
        } catch (\Exception $e) {
            $lichtiems = collect();
            return view('admin.dichvu.taolichtiem', compact('lichtiems'));
        }
    }

    public function datlichtiem(Request $request){
        try {
            // Validate dữ liệu nhập vào từ form
            $validatedData = $request->validate([
                'makh' => 'nullable|string',
                'tennguoitiem' => 'required|string',
                'ngaysinhnguoitiem' => 'required|date',
                'gioitinh' => 'required|string',
                'matp' => 'nullable|string',
                'maqh' => 'nullable|string',
                'maxp' => 'nullable|string',
                'diachi' => 'required|string',
                'tennguoilh' => 'required|string',
                'moiqhnguoitiem' => 'required|string',
                'sodienthoai' => 'required|string',
                'email' => 'nullable|string',
                'mavc' => 'nullable|array',
                'mavc.*' => 'nullable|string',
                'magoi' => 'nullable|string'
            ]);
            if($validatedData['makh'] == ""){
                try{
                // Lấy mã kh cuối cùng từ cơ sở dữ liệu
                $lastkh = DB::table('khachhang')->orderByRaw('CONVERT(SUBSTRING(makh, 8), UNSIGNED) DESC')->first();

                if ($lastkh) {
                    $newkhCode = (int)substr($lastkh->makh, 7) + 1;
                    $newkhCode = "khsafpo" . $newkhCode;
                } else {
                    // Nếu không có makh nào trong cơ sở dữ liệu, bắt đầu từ 1
                    $newkhCode = "khsafpo1";
                }
                if($validatedData['maxp'] !== null && $validatedData['maqh'] !== null && $validatedData['matp'] !== null){
                    $diachitp = DB::connection('mysql2')
                        ->table('tbl_tinhthanhpho as tp')
                        ->leftJoin('tbl_quanhuyen as qh', 'tp.matp', '=', 'qh.matp')
                        ->leftJoin('tbl_xaphuongthitran as xp', 'qh.maqh', '=', 'xp.maqh')
                        ->select('tp.name as tentp', 'qh.name as tenqh', 'xp.name as xa')
                        ->where('tp.matp', $validatedData['matp'])
                        ->where('qh.maqh', $validatedData['maqh'])
                        ->where('xp.xaid', $validatedData['maxp'])
                        ->first();

                        $diachi = $validatedData['diachi']. " - " . $diachitp->tentp . " - " . $diachitp->tenqh ." - ". $diachitp->xa;
                }else{
                    $diachi = $validatedData['diachi'];
                }
                
                $data = [
                    'tenkh' => $validatedData['tennguoitiem'],
                    'gioitinh' => $validatedData['gioitinh'],
                    'ngaysinhkh' => $validatedData['ngaysinhnguoitiem'],
                    'sdtkh' => $validatedData['sodienthoai'],
                    'emailkh' => $validatedData['email'],
                    'diachikh' => $diachi,
                    'ten_nglh' => $validatedData['tennguoilh'],
                    'quanhevoikh' => $validatedData['moiqhnguoitiem'],
                    'mavaitro' => 'vt04',
                ];
                $data['makh'] = $newkhCode;
                $matkhau = $newkhCode."@";
                $data['matkhau'] = md5($matkhau);

                DB::table('khachhang')->insert($data);
                function generateRandomCode() {
                    return str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
                }
                $makh = $newkhCode;
                $manv_nhan = session('manhanvien');
                $madk_goi = "";
                do {
                    $randomCode = generateRandomCode();
                    $madk_goi = "HDDK" . $randomCode;
                    // Kiểm tra xem mã đăng ký đã tồn tại trong cơ sở dữ liệu hay chưa
                    $exists = DB::table('dangky_goi')->where('madk_goi', $madk_goi)->exists();
                } while ($exists);
                $data_dk = [
                    'ngaydk' => Carbon::now()->toDateString(),
                    'trangthaidk' => "Đã xác nhận",
                    'hinhthucdk' => "Tại trung tâm",
                    'makh' => $makh,
                    'trangthaigoitiem' => "Chưa tiêm",
                    'nhanvien_xacnhandk' => $manv_nhan,
                    'trangthaithanhtoan' => "Đã thanh toán",
                    'hinhthucthanhtoan' => "Tại trung tâm",
                    'ngaythanhtoan' => Carbon::now()->toDateString(),
                    'ngaytiemmongmuon' => Carbon::now()->toDateString(),
                ];

                // Xử lý khi magoi không rỗng
                if ($validatedData['magoi'] != "") {
                    $goivaccines = DB::connection('mysql')->table('goivaccine')
                        ->where('goivaccine.magoi', $validatedData['magoi'])
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
                        ->first();
                        $data_dk['madk_goi'] = $madk_goi;
                        $tongtien = $goivaccines->tonggiatien*((100-$goivaccines->uudai)/100);
                        $data_dk['tongtien'] = $tongtien;
                        $data_dk['magoi'] = $validatedData['magoi'];
                        $data_dk['sotiendathanhtoan'] = $tongtien;
                        DB::table('dangky_goi')->insert($data_dk);
                    return redirect()->back()->with('success', json_encode($data_dk));
                }

                    // Kiểm tra và xử lý mảng mavc
                    if (isset($validatedData['mavc']) && is_array($validatedData['mavc'])) {
                        foreach ($validatedData['mavc'] as $vaccine) {
                            if (!is_string($vaccine) || empty($vaccine)) {
                                return redirect()->back()->withErrors(['mavc' => 'Invalid vaccine name provided.']);
                            }
                            $dsvaccine = DB::connection('mysql')->table('vaccine')
                            ->where('vaccine.mavc', $vaccine)
                            ->where('goivaccine.loaigoi', 1)
                            ->where('vaccine.soluong', '>', 0)
                            ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
                            ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                            ->select('goivaccine.*', 'vaccine.*')
                            ->first();
                            
                            $data_dk['madk_goi'] = $madk_goi;
                            $tongtien = $dsvaccine->gia;
                            $data_dk['tongtien'] = $tongtien;
                            $data_dk['magoi'] = $dsvaccine->magoi;
                            $data_dk['sotiendathanhtoan'] = $tongtien;
                            DB::table('dangky_goi')->insert($data_dk);

                            $muitiem = DB::connection('mysql')->table('khachhang')
                                ->join('dangky_goi', 'dangky_goi.makh', '=', 'khachhang.makh')
                                ->join('chitietlstiem_goi', 'chitietlstiem_goi.madk_goi', '=', 'dangky_goi.madk_goi')
                                ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
                                ->where('khachhang.makh', $makh)
                                ->where('vaccine.mavc', $vaccine)
                                ->count();
                            if($muitiem == 0){
                                $mtiem = "Mũi 1";
                            }else{
                                $mtiem = "Mũi " . $muitiem + 1;
                            }

                            $data_lstiem = [
                                'madk_goi' => $madk_goi,
                                'mavc' => $vaccine,
                                'ngaytiemdukien' => Carbon::now()->toDateString(),
                                'trangthaitiem' => "Chờ tiêm",
                                'muitiem' => $mtiem,
                            ];
                            DB::table('chitietlstiem_goi')->insert($data_lstiem);
                            $soluongvc = $dsvaccine->soluong - 1;
                            DB::table('vaccine')
                            ->where('mavc', $vaccine)  // Điều kiện để tìm bản ghi cần cập nhật, thay 'id' bằng cột phù hợp
                            ->update(['soluong' => $soluongvc]);

                            do {
                                $randomCode = generateRandomCode();
                                $madk_goi = "HDDK" . $randomCode;
                                // Kiểm tra xem mã đăng ký đã tồn tại trong cơ sở dữ liệu hay chưa
                                $exists = DB::table('dangky_goi')->where('madk_goi', $madk_goi)->exists();
                            } while ($exists);
                        }
                    }
                    return redirect()->back()->with('success', json_encode($data_dk));
                }catch (\Exception $e) {
                    // Xử lý khi có lỗi khác xảy ra
                    return redirect()->back()->with('success', $e->getMessage());
                }
            }
            else{
                // Hàm tạo mã ngẫu nhiên
                function generateRandomCode() {
                    return str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
                }
                $makh = $validatedData['makh'];
                $manv_nhan = session('manhanvien');
                $madk_goi = "";
                do {
                    $randomCode = generateRandomCode();
                    $madk_goi = "HDDK" . $randomCode;
                    // Kiểm tra xem mã đăng ký đã tồn tại trong cơ sở dữ liệu hay chưa
                    $exists = DB::table('dangky_goi')->where('madk_goi', $madk_goi)->exists();
                } while ($exists);
                $data_dk = [
                    'ngaydk' => Carbon::now()->toDateString(),
                    'trangthaidk' => "Đã xác nhận",
                    'hinhthucdk' => "Tại trung tâm",
                    'makh' => $makh,
                    'trangthaigoitiem' => "Chưa tiêm",
                    'nhanvien_xacnhandk' => $manv_nhan,
                    'trangthaithanhtoan' => "Đã thanh toán",
                    'hinhthucthanhtoan' => "Tại trung tâm",
                    'ngaythanhtoan' => Carbon::now()->toDateString(),
                    'ngaytiemmongmuon' => Carbon::now()->toDateString(),
                ];

                // Xử lý khi magoi không rỗng
                if ($validatedData['magoi'] != "") {
                    $goivaccines = DB::connection('mysql')->table('goivaccine')
                        ->where('goivaccine.magoi', $validatedData['magoi'])
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
                        ->first();
                        $data_dk['madk_goi'] = $madk_goi;
                        $tongtien = $goivaccines->tonggiatien*((100-$goivaccines->uudai)/100);
                        $data_dk['tongtien'] = $tongtien;
                        $data_dk['magoi'] = $validatedData['magoi'];
                        $data_dk['sotiendathanhtoan'] = $tongtien;
                        DB::table('dangky_goi')->insert($data_dk);
                    return redirect()->back()->with('success', json_encode($data_dk));
                }

                // Kiểm tra và xử lý mảng mavc
                if (isset($validatedData['mavc']) && is_array($validatedData['mavc'])) {
                    foreach ($validatedData['mavc'] as $vaccine) {
                        if (!is_string($vaccine) || empty($vaccine)) {
                            return redirect()->back()->withErrors(['mavc' => 'Invalid vaccine name provided.']);
                        }
                        $dsvaccine = DB::connection('mysql')->table('vaccine')
                        ->where('vaccine.mavc', $vaccine)
                        ->where('goivaccine.loaigoi', 1)
                        ->where('vaccine.soluong', '>', 0)
                        ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
                        ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                        ->select('goivaccine.*', 'vaccine.*')
                        ->first();
                        
                        $data_dk['madk_goi'] = $madk_goi;
                        $tongtien = $dsvaccine->gia;
                        $data_dk['tongtien'] = $tongtien;
                        $data_dk['magoi'] = $dsvaccine->magoi;
                        $data_dk['sotiendathanhtoan'] = $tongtien;
                        DB::table('dangky_goi')->insert($data_dk);

                        $muitiem = DB::connection('mysql')->table('khachhang')
                            ->join('dangky_goi', 'dangky_goi.makh', '=', 'khachhang.makh')
                            ->join('chitietlstiem_goi', 'chitietlstiem_goi.madk_goi', '=', 'dangky_goi.madk_goi')
                            ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
                            ->where('khachhang.makh', $makh)
                            ->where('vaccine.mavc', $vaccine)
                            ->count();
                        if($muitiem == 0){
                            $mtiem = "Mũi 1";
                        }else{
                            $mtiem = "Mũi " . $muitiem + 1;
                        }

                        $data_lstiem = [
                            'madk_goi' => $madk_goi,
                            'mavc' => $vaccine,
                            'ngaytiemdukien' => Carbon::now()->toDateString(),
                            'trangthaitiem' => "Chờ tiêm",
                            'muitiem' => $mtiem,
                        ];
                        DB::table('chitietlstiem_goi')->insert($data_lstiem);
                        $soluongvc = $dsvaccine->soluong - 1;
                        DB::table('vaccine')
                        ->where('mavc', $vaccine)  // Điều kiện để tìm bản ghi cần cập nhật, thay 'id' bằng cột phù hợp
                        ->update(['soluong' => $soluongvc]);

                        do {
                            $randomCode = generateRandomCode();
                            $madk_goi = "HDDK" . $randomCode;
                            // Kiểm tra xem mã đăng ký đã tồn tại trong cơ sở dữ liệu hay chưa
                            $exists = DB::table('dangky_goi')->where('madk_goi', $madk_goi)->exists();
                        } while ($exists);
                    }
                    return redirect()->back()->with('success', json_encode($data_dk));
                }
            }

            // Nếu validation thành công, bạn có thể xử lý dữ liệu và chuyển hướng
            return redirect()->back()->with('success', json_encode($validatedData));

        }catch (\Exception $e) {
            // Xử lý khi có lỗi khác xảy ra
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show_lichtiemchoxn(){
        try {            
            $vcles = DB::connection('mysql')->table('dangky_goi')
                ->where('dangky_goi.trangthaidk', "Chờ xác nhận")
                ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                ->join('chitietlstiem_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
                ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
                ->join('goivaccine', 'goivaccine.magoi', '=', 'dangky_goi.magoi')
                ->where('goivaccine.loaigoi', 1)
                ->select('vaccine.*', 'khachhang.*', 'dangky_goi.*')
                ->get();

                $vcgois = DB::connection('mysql')->table('goivaccine')
                ->join('chitietgoivc', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                ->join('vaccine', 'chitietgoivc.mavc', '=', 'vaccine.mavc')
                ->join('dangky_goi', 'dangky_goi.magoi', '=', 'goivaccine.magoi')
                ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                ->where('goivaccine.loaigoi', 2)
                ->where('dangky_goi.trangthaidk', 'Chờ xác nhận')
                ->select(
                    'dangky_goi.madk_goi',
                    'goivaccine.magoi',
                    'goivaccine.tengoi',
                    'goivaccine.loaigoi',
                    'goivaccine.uudai',
                    'goivaccine.datcoc',
                    'khachhang.makh',
                    'khachhang.tenkh',
                    'khachhang.ngaysinhkh',
                    'khachhang.sdtkh',
                    'khachhang.ten_nglh',
                    'khachhang.quanhevoikh',
                    'dangky_goi.ngaytiemmongmuon',
                    DB::raw('COUNT(chitietgoivc.mavc) AS soluongvaccine'),
                    DB::raw('SUM(chitietgoivc.soluongmuitiem) AS soluongmuitiem'),
                    DB::raw('SUM(vaccine.gia * chitietgoivc.soluongmuitiem) AS tonggiatien')
                )
                ->groupBy(
                    'dangky_goi.madk_goi',
                    'goivaccine.magoi',
                    'goivaccine.tengoi',
                    'goivaccine.loaigoi',
                    'goivaccine.uudai',
                    'goivaccine.datcoc',
                    'khachhang.makh',
                    'khachhang.tenkh',
                    'khachhang.ngaysinhkh',
                    'khachhang.sdtkh',
                    'khachhang.ten_nglh',
                    'khachhang.quanhevoikh',
                    'dangky_goi.ngaytiemmongmuon'
                )
                ->get();    

            return view('admin.dichvu.xacnhanlichtiem', compact('vcles', 'vcgois'));
        } catch (\Exception $e) {
            $vcles = collect();
            $vcgois = collect();
            return view('admin.dichvu.xacnhanlichtiem', compact('vcles', 'vcgois'));
        }
    }
    public function show_lichtiemdaxn(){
        try {            
            $vcles = DB::connection('mysql')->table('dangky_goi')
                ->where('dangky_goi.trangthaidk', "Đã xác nhận")
                ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                ->join('chitietlstiem_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
                ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
                ->join('goivaccine', 'goivaccine.magoi', '=', 'dangky_goi.magoi')
                ->where('goivaccine.loaigoi', 1)
                ->select('vaccine.*', 'khachhang.*', 'dangky_goi.*')
                ->get();

                $vcgois = DB::connection('mysql')->table('goivaccine')
                ->join('chitietgoivc', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                ->join('vaccine', 'chitietgoivc.mavc', '=', 'vaccine.mavc')
                ->join('dangky_goi', 'dangky_goi.magoi', '=', 'goivaccine.magoi')
                ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                ->where('goivaccine.loaigoi', 2)
                ->where('dangky_goi.trangthaidk', 'Đã xác nhận')
                ->select(
                    'dangky_goi.madk_goi',
                    'goivaccine.magoi',
                    'goivaccine.tengoi',
                    'goivaccine.loaigoi',
                    'goivaccine.uudai',
                    'goivaccine.datcoc',
                    'khachhang.tenkh',
                    'khachhang.ngaysinhkh',
                    'khachhang.sdtkh',
                    'khachhang.ten_nglh',
                    'khachhang.quanhevoikh',
                    'dangky_goi.ngaytiemmongmuon',
                    DB::raw('COUNT(chitietgoivc.mavc) AS soluongvaccine'),
                    DB::raw('SUM(chitietgoivc.soluongmuitiem) AS soluongmuitiem'),
                    DB::raw('SUM(vaccine.gia * chitietgoivc.soluongmuitiem) AS tonggiatien')
                )
                ->groupBy(
                    'dangky_goi.madk_goi',
                    'goivaccine.magoi',
                    'goivaccine.tengoi',
                    'goivaccine.loaigoi',
                    'goivaccine.uudai',
                    'goivaccine.datcoc',
                    'khachhang.tenkh',
                    'khachhang.ngaysinhkh',
                    'khachhang.sdtkh',
                    'khachhang.ten_nglh',
                    'khachhang.quanhevoikh',
                    'dangky_goi.ngaytiemmongmuon'
                )
                ->get();    

            return view('admin.dichvu.daxacnhan', compact('vcles', 'vcgois'));
        } catch (\Exception $e) {
            $vcles = collect();
            $vcgois = collect();
            return view('admin.dichvu.daxacnhan', compact('vcles', 'vcgois'));
        }
    }


    
    public function xntiem($madk_goi, $mavc){
        DB::table('chitietlstiem_goi')
            ->where('madk_goi', $madk_goi)
            ->where('mavc', $mavc)
            ->update(['trangthaitiem' => 'Đã tiêm',
                    'ngaytiemthucte' => Carbon::now()->toDateString(),
            ]);

        return redirect()->back()->with('success', "Đã xác nhận!");
    }
    
    public function show_quanlylichtiem(){  
        $dstatcas = DB::connection('mysql')->table('chitietlstiem_goi')
            ->join('dangky_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
            ->join('vaccine', 'chitietlstiem_goi.mavc', '=', 'vaccine.mavc')
            ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
            ->select('vaccine.*', 'khachhang.*', 'dangky_goi.*', 'chitietlstiem_goi.*')
            ->orderBy('chitietlstiem_goi.trangthaitiem')
            ->get();

        $dschotiems = DB::connection('mysql')->table('chitietlstiem_goi')
            ->join('dangky_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
            ->join('vaccine', 'chitietlstiem_goi.mavc', '=', 'vaccine.mavc')
            ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
            ->where('chitietlstiem_goi.trangthaitiem', "Chờ tiêm")
            ->select('vaccine.*', 'khachhang.*', 'dangky_goi.*', 'chitietlstiem_goi.*')
            ->orderBy('chitietlstiem_goi.ngaytiemdukien', 'asc')
            ->get();

        $dsgoitiems = DB::connection('mysql')->table('dangky_goi')
            ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
            ->join('goivaccine', 'goivaccine.magoi', '=', 'dangky_goi.magoi')
            ->select('goivaccine.*', 'khachhang.*', 'dangky_goi.*')
            ->where('dangky_goi.trangthaidk', "Đã xác nhận")
            ->where('dangky_goi.trangthaithanhtoan', "Đã thanh toán")
            ->where('goivaccine.loaigoi', 2)
            ->get();

        $goiTiems = DB::table('dangky_goi')
            ->join('goivaccine', 'goivaccine.magoi', '=', 'dangky_goi.magoi')
            ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
            ->join('chitietgoivc', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
            ->join('vaccine', 'chitietgoivc.mavc', '=', 'vaccine.mavc')
            ->leftJoin('chitietlstiem_goi', function($join) {
                $join->on('dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
                    ->on('vaccine.mavc', '=', 'chitietlstiem_goi.mavc');
            })
            ->where('dangky_goi.trangthaidk', "Đã xác nhận")
            ->where('dangky_goi.trangthaithanhtoan', "Đã thanh toán")
            ->where('goivaccine.loaigoi', 2)
            ->select(
                'khachhang.makh',
                'khachhang.tenkh',
                'khachhang.ngaysinhkh',
                'goivaccine.loaigoi',
                'dangky_goi.madk_goi',
                'goivaccine.magoi',
                'goivaccine.tengoi',
                'goivaccine.uudai',
                'goivaccine.datcoc',
                'dangky_goi.ngaytiemmongmuon',
                DB::raw('COUNT(chitietgoivc.mavc) AS soluongvaccine'),
                DB::raw('SUM(chitietgoivc.soluongmuitiem) AS soluongmuitiem'),
                DB::raw('SUM(vaccine.gia * chitietgoivc.soluongmuitiem) AS tonggiatien'),
                DB::raw('COALESCE(COUNT(chitietlstiem_goi.mavc), 0) AS soluongdatiem') // Số lượng vaccine đã tiêm
            )
            ->groupBy(
                'khachhang.makh',
                'khachhang.tenkh',
                'khachhang.ngaysinhkh',
                'goivaccine.loaigoi',
                'dangky_goi.madk_goi',
                'goivaccine.magoi',
                'goivaccine.tengoi',
                'goivaccine.uudai',
                'goivaccine.datcoc',
                'dangky_goi.ngaytiemmongmuon'
            )
            ->get();

        return view('admin.dichvu.dstatcalichtiem', compact('dschotiems', 'dstatcas', 'dsgoitiems', 'goiTiems'));
    }
    
}
