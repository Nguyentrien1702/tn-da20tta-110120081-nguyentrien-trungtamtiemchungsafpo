<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use GuzzleHttp\Client;
class VNpay extends Controller
{
    public function VNP(Request $request)
    {
        try {
            if(session("khachhang")){
                // Validate dữ liệu nhập vào từ form
                $validatedData = $request->validate([
                    'vaccinegoi' => 'nullable|string',
                    'vaccinele' => 'nullable|string',
                    'ngaytiemmongmuon' =>'required|date',
                ]);
            }else{
                // Validate dữ liệu nhập vào từ form
                $validatedData = $request->validate([
                    'tennguoitiem' => 'required|string',
                    'ngaysinhnguoitiem' => 'required|date',
                    'gioitinh' => 'required|string',
                    'matp' => 'required|string',
                    'maqh' => 'required|string',
                    'maxp' => 'required|string',
                    'diachi' => 'required|string',
                    'tennguoilh' => 'required|string',
                    'moiqhnguoitiem' => 'required|string',
                    'sodienthoai' => 'required|string',
                    'email' => 'nullable|string',
                    'vaccinegoi' => 'nullable|string',
                    'vaccinele' => 'nullable|string',
                    'ngaytiemmongmuon' =>'required|date',
                ]);  
            }

            if (array_key_exists('vaccinele', $validatedData) && filled($validatedData['vaccinele'])) {
                $dsvaccine = DB::connection('mysql')->table('vaccine')
                ->where('vaccine.mavc', $validatedData['vaccinele'])
                ->where('goivaccine.loaigoi', 1)
                ->where('vaccine.soluong', '>', 0)
                ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
                ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                ->select('goivaccine.*', 'vaccine.*')
                ->first();

                if ($dsvaccine){
                    $tongtien = $dsvaccine->gia;
                }
            }

            if (array_key_exists('vaccinegoi', $validatedData) && filled($validatedData['vaccinegoi'])) {
                $goivaccines = DB::connection('mysql')->table('goivaccine')
                ->where('goivaccine.magoi', $validatedData['vaccinegoi'])
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
                $tongtien = $goivaccines->datcoc;
            }

            $vnp_TxnRef = time() . '_' . rand(1000, 9999);
            
            // Thông tin đơn hàng
            $vnp_OrderInfo = 'Thanh toán đơn hàng';
            $vnp_OrderType = 'billpayment';
        
            // Lấy tổng tiền từ giỏ hàng
            $totalAmount = $tongtien;
            $vnp_Amount = $totalAmount * 100;
        
            // Thông tin thanh toán
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
                
            // Định nghĩa $vnp_TmnCode và $vnp_HashSecret
            $vnp_TmnCode = "OW2FUUD4";
            $vnp_HashSecret = "MC3ZGAW8QQY0WJIFECEYVDUAL4X8QI5X"; 
        
            // Kiểm tra và gán giá trị cho các tham số thanh toán
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay", 
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => "http://127.0.0.1:8000/payment/callback", // Đặt giá trị chính xác từ VNPAY
                "vnp_TxnRef" => $vnp_TxnRef,
            );
        
            // Sắp xếp các tham số để tạo chuỗi hash
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
        
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }
        
            // Tạo URL thanh toán
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // Đặt giá trị chính xác từ VNPAY
            $vnp_Url = $vnp_Url . "?" . $query;
        
            // Tạo mã băm bảo mật
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $request->session()->put('validatedData', $validatedData);
            // Chuyển hướng người dùng đến VNPAY để thanh toán
            return redirect()->away($vnp_Url);
            
        } catch (\Exception $e) {
            // Xử lý lỗi và trả về thông báo lỗi
            return redirect()->back()->with(['error' => 'Có lỗi xảy ra trong quá trình chuẩn bị thanh toán. Vui lòng thử lại sau.']);
        }
    }
    public function callback(Request $request)
    {
        try {
            // Lấy dữ liệu callback từ VNPay
            $vnp_SecureHash = $request->vnp_SecureHash;
            $inputData = $request->all();
            unset($inputData['vnp_SecureHashType']);
            unset($inputData['vnp_SecureHash']);

            // Sắp xếp dữ liệu theo key
            ksort($inputData);

            // Tạo chuỗi dữ liệu để tính toán lại hash
            $query = http_build_query($inputData);
            $vnp_HashSecret = 'MC3ZGAW8QQY0WJIFECEYVDUAL4X8QI5X'; // Thay bằng khóa bí mật của bạn
            $vnpSecureHash = md5($vnp_HashSecret . '&' . $query);

            // Xử lý thanh toán thành công
            $responseCode = $request->vnp_ResponseCode;
            if ($responseCode == '00') {
                // Lấy thông tin giao dịch từ callback
                $transactionInfo = [
                    'transaction_id' => $request->vnp_TransactionNo,
                    'amount' => $request->vnp_Amount / 100, // Chia lại để lấy giá trị thực (đã nhân 100 khi tạo đơn)
                    'payment_date' => $request->vnp_PayDate,
                    'bank_code' => $request->vnp_BankCode,
                    'order_info' => $request->vnp_OrderInfo,
                    // Các thông tin khác cần thiết
                ];
                // Lấy validatedData từ session
                $validatedData = session('validatedData');
                if(session("khachhang")){
                    VNpay::datlichtiem_onl_ctk($request);
                }else{
                    VNpay::datlichtiem_onl($request);
                }
                

                // Log lại thông tin giao dịch thành công và thông tin từ datlichtiem_onl
                Log::info('Payment success: ' . json_encode($transactionInfo));

                // Trả về kết quả thành công cho VNPay
                return redirect()->away('http://127.0.0.1:8000/Dat-lich-tiem')->with('success', 'THÀNH CÔNG!');
            } else {
                // Xử lý thanh toán thất bại
                return redirect()->away('http://127.0.0.1:8000/Dat-lich-tiem')->with('error', 'Lỗi!');
            }
        } catch (\Exception $e) {
            // Xử lý khi có lỗi xảy ra
            return redirect()->away('http://127.0.0.1:8000/Dat-lich-tiem')->with('error', 'Lỗi!');
        }
    }
    public function datlichtiem_onl(Request $request){
        try {
            $validatedData = $request->session()->get('validatedData');
             
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

                $khachhang = DB::table('khachhang')->insert($data);
                $sdt = $validatedData['sodienthoai'];
                $noidungtn = "Quý khách vừa đăng ký tiêm chủng thành công tại trung tâm SAFPO Trà Vinh. \n Quý khách được cung cấp mã khách hàng và mật khẩu để có thể theo dõi và tra cứu lịch tiêm là:\nMKH: ".$newkhCode."\nMK: " .$newkhCode."@ \nTrân trọng!";
                $this->sms($sdt, $noidungtn);
                if($khachhang){
                    // Hàm tạo mã ngẫu nhiên
                    function generateRandomCode() {
                        return str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
                    }
                    $makh = $newkhCode;
                    $madk_goi = "";
                    do {
                        $randomCode = generateRandomCode();
                        $madk_goi = "HDDK" . $randomCode;
                        // Kiểm tra xem mã đăng ký đã tồn tại trong cơ sở dữ liệu hay chưa
                        $exists = DB::table('dangky_goi')->where('madk_goi', $madk_goi)->exists();
                    } while ($exists);
                    $data_dk = [
                        'ngaydk' => Carbon::now()->toDateString(),
                        'trangthaidk' => "Chờ xác nhận",
                        'hinhthucdk' => "Online",
                        'makh' => $makh,
                        'trangthaigoitiem' => "Chưa tiêm",
                        'trangthaithanhtoan' => "Đã thanh toán",
                        'ngaytiemmongmuon' => $validatedData['ngaytiemmongmuon'],
                        'hinhthucthanhtoan' => "Online",
                        'ngaythanhtoan' => Carbon::now()->toDateString(),
                    ];
                    // Kiểm tra và xử lý vaccinele nếu tồn tại
                    if (array_key_exists('vaccinele', $validatedData) && filled($validatedData['vaccinele'])) {
                        $vaccinele = $validatedData['vaccinele'];
                        $dsvaccine = DB::connection('mysql')->table('vaccine')
                            ->where('vaccine.mavc', $vaccinele)
                            ->where('goivaccine.loaigoi', 1)
                            ->where('vaccine.soluong', '>', 0)
                            ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
                            ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                            ->select('goivaccine.*', 'vaccine.*')
                            ->first();

                        if ($dsvaccine){
                            $data_dk['madk_goi'] = $madk_goi;
                            $tongtien = $dsvaccine->gia;
                            $data_dk['tongtien'] = $tongtien;
                            $data_dk['sotiendathanhtoan'] = $tongtien;
                            $data_dk['magoi'] = $dsvaccine->magoi;

                            // Insert dữ liệu vào bảng dangky_goi
                            DB::table('dangky_goi')->insert($data_dk);

                            // Xử lý chi tiết lịch tiêm gói vaccine lẻ
                            $muitiem = DB::connection('mysql')->table('khachhang')
                                ->join('dangky_goi', 'dangky_goi.makh', '=', 'khachhang.makh')
                                ->join('chitietlstiem_goi', 'chitietlstiem_goi.madk_goi', '=', 'dangky_goi.madk_goi')
                                ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
                                ->where('khachhang.makh', $newkhCode)
                                ->where('vaccine.mavc', $vaccinele)
                                ->where('chitietlstiem_goi.trangthaitiem', 'Đã tiêm')
                                ->count();

                            if ($muitiem == 0) {
                                $mtiem = "Mũi 1";
                            } else {
                                $mtiem = "Mũi " . ($muitiem + 1);
                            }

                            // Dữ liệu cho bảng chitietlstiem_goi
                            $dataChiTietLSTiem = [
                                'madk_goi' => $madk_goi,
                                'mavc' => $vaccinele,
                                'ngaytiemdukien' => $validatedData['ngaytiemmongmuon'],
                                'trangthaitiem' => "Chưa tiêm",
                                'muitiem' => $mtiem,
                            ];

                            // Insert dữ liệu vào bảng chitietlstiem_goi
                            DB::table('chitietlstiem_goi')->insert($dataChiTietLSTiem);

                            // Cập nhật số lượng vaccine còn lại
                            $soluongvc = $dsvaccine->soluong - 1;
                            DB::table('vaccine')
                                ->where('mavc', $vaccinele)
                                ->update(['soluong' => $soluongvc]);
                        }
                    }
                    if (array_key_exists('vaccinegoi', $validatedData) && filled($validatedData['vaccinegoi'])) {
                        if($validatedData['vaccinegoi'] != ""){
                            $goivaccines = DB::connection('mysql')->table('goivaccine')
                                ->where('goivaccine.magoi', $validatedData['vaccinegoi'])
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
                            $data_dk['sotiendathanhtoan'] = $goivaccines->datcoc;
                            $data_dk['magoi'] = $validatedData['vaccinegoi'];
                            DB::table('dangky_goi')->insert($data_dk);

                        }
                    }
                }
            }catch (\Exception $e) {
                // Xử lý khi có lỗi khác xảy ra
                return redirect()->back()->with('error', $e->getMessage());
            }

        } catch (\Exception $e) {
            // Xử lý lỗi và trả về thông báo lỗi
            return redirect()->back()->with(['error' => 'Có lỗi xảy ra trong quá trình chuẩn bị thanh toán. Vui lòng thử lại sau.']);
        }
    }

    public function datlichtiem_onl_ctk(Request $request){
        try {
            $validatedData = $request->session()->get('validatedData');
            $request->session()->forget('validatedData');
            // Hàm tạo mã ngẫu nhiên
            function generateRandomCode() {
                return str_pad(random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
            }
            $makh = session("khachhang");
            $madk_goi = "";
            do {
                $randomCode = generateRandomCode();
                $madk_goi = "HDDK" . $randomCode;
                // Kiểm tra xem mã đăng ký đã tồn tại trong cơ sở dữ liệu hay chưa
                $exists = DB::table('dangky_goi')->where('madk_goi', $madk_goi)->exists();
            } while ($exists);
            $data_dk = [
                'ngaydk' => Carbon::now()->toDateString(),
                'trangthaidk' => "Chờ xác nhận",
                'hinhthucdk' => "Online",
                'makh' => $makh,
                'trangthaigoitiem' => "Chưa tiêm",
                'ngaytiemmongmuon' => $validatedData['ngaytiemmongmuon'],
                'hinhthucthanhtoan' => "Online",
                'ngaythanhtoan' => Carbon::now()->toDateString(),
            ];
            // Kiểm tra và xử lý vaccinele nếu tồn tại
            if (array_key_exists('vaccinele', $validatedData) && filled($validatedData['vaccinele'])) {
                $vaccinele = $validatedData['vaccinele'];
                $dsvaccine = DB::connection('mysql')->table('vaccine')
                    ->where('vaccine.mavc', $vaccinele)
                    ->where('goivaccine.loaigoi', 1)
                    ->where('vaccine.soluong', '>', 0)
                    ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
                    ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                    ->select('goivaccine.*', 'vaccine.*')
                    ->first();

                if ($dsvaccine){
                    $data_dk['madk_goi'] = $madk_goi;
                    $tongtien = $dsvaccine->gia;
                    $data_dk['tongtien'] = $tongtien;
                    $data_dk['sotiendathanhtoan'] = $tongtien;
                    $data_dk['magoi'] = $dsvaccine->magoi;
                    $data_dk['trangthaithanhtoan'] = "Đã thanh toán";

                    // Insert dữ liệu vào bảng dangky_goi
                    DB::table('dangky_goi')->insert($data_dk);

                    // Xử lý chi tiết lịch tiêm gói vaccine lẻ
                    $muitiem = DB::connection('mysql')->table('khachhang')
                        ->join('dangky_goi', 'dangky_goi.makh', '=', 'khachhang.makh')
                        ->join('chitietlstiem_goi', 'chitietlstiem_goi.madk_goi', '=', 'dangky_goi.madk_goi')
                        ->join('vaccine', 'vaccine.mavc', '=', 'chitietlstiem_goi.mavc')
                        ->where('khachhang.makh', $makh)
                        ->where('vaccine.mavc', $vaccinele)
                        ->count();

                    if ($muitiem == 0) {
                        $mtiem = "Mũi 1";
                    } else {
                        $mtiem = "Mũi " . ($muitiem + 1);
                    }

                    // Dữ liệu cho bảng chitietlstiem_goi
                    $dataChiTietLSTiem = [
                        'madk_goi' => $madk_goi,
                        'mavc' => $vaccinele,
                        'ngaytiemdukien' => $validatedData['ngaytiemmongmuon'],
                        'trangthaitiem' => "Chưa tiêm",
                        'muitiem' => $mtiem,
                    ];

                    // Insert dữ liệu vào bảng chitietlstiem_goi
                    DB::table('chitietlstiem_goi')->insert($dataChiTietLSTiem);

                    // Cập nhật số lượng vaccine còn lại
                    $soluongvc = $dsvaccine->soluong - 1;
                    DB::table('vaccine')
                        ->where('mavc', $vaccinele)
                        ->update(['soluong' => $soluongvc]);
                }
            }
            if (array_key_exists('vaccinegoi', $validatedData) && filled($validatedData['vaccinegoi'])) {
                if($validatedData['vaccinegoi'] != ""){
                    $goivaccines = DB::connection('mysql')->table('goivaccine')
                        ->where('goivaccine.magoi', $validatedData['vaccinegoi'])
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
                    $data_dk['sotiendathanhtoan'] = $goivaccines->datcoc;
                    $data_dk['magoi'] = $validatedData['vaccinegoi'];
                    $data_dk['trangthaithanhtoan'] = "Đã đặt cọc";
                    DB::table('dangky_goi')->insert($data_dk);

                }
            }
        }catch (\Exception $e) {
            // Xử lý khi có lỗi khác xảy ra
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function sms($sdt, $tinnhan):void{
        $phoneNumber = '+84' . substr($sdt, 1);
        $message = $tinnhan;

        $infobipApiKey = 'ee50969b3a4232afe3074cb93d7c7ffa-433ff75b-26f9-491f-968a-ce6d33e6d8db';
        $infobipSender = '+447491163443';

        $client = new Client();

        $response = $client->post('https://8gq2k9.api.infobip.com/sms/1/text/single', [
            'headers' => [
                'Authorization' => 'App ' . $infobipApiKey,
            ],
            'json' => [
                'from' => $infobipSender,
                'to' => $phoneNumber,
                'text' => $message,
            ],
        ]);
    }
}