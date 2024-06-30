<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
class xllichtiemController extends Controller
{
    public function tuchoigoidk(Request $request)
    {
        $madk_goi = $request->madk_goi;
        // Lấy dữ liệu từ request
        $lidotuchoi = $request->input('lidotuchoi');
        
        if($request->input('hoantien') == 0){
            $hoantien = "Không hoàn tiền";
        }else{
            $hoantien = "Đã hoàn tiền";
        }
        DB::table('dangky_goi')
            ->where('madk_goi', $madk_goi)
            ->update(['trangthaidk' => 'Đã hủy',
                      'ghichu' =>$lidotuchoi,
                      'trangthaithanhtoan' => $hoantien,
                      'trangthaigoitiem' => "Không hoàn thành",
                      'nhanvien_xacnhandk' => session("manhanvien"),
                    ]);
        
        $lstiem = DB::connection('mysql')->table('chitietlstiem_goi')
            ->where('chitietlstiem_goi.madk_goi', $madk_goi)
            ->join('dangky_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
            ->join('goivaccine', 'goivaccine.magoi', '=', 'dangky_goi.magoi')
            ->where('goivaccine.loaigoi', 1)
            ->select('chitietlstiem_goi.*')
            ->first();
        
        if(!empty($lstiem)){
            DB::connection('mysql')->table('chitietlstiem_goi')->where('madk_goi', $madk_goi)->delete();
        }

        $ttkh = DB::table('dangky_goi')
            ->where('madk_goi', $madk_goi)
            ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
            ->first();

        $phoneNumber = '+84' . substr($ttkh->sdtkh, 1);
        $message = "Lịch tiêm của quý khách đã bị hủy! \nLý do: ". $lidotuchoi . "\nMọi khiếu nại vui lòng liên hệ: 0294 650 8508 \nTrân trọng!";

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

        return redirect()->back()->with('success', "Đã hủy!");
    }

    public function xngoidk($madk_goi){
        $ttgoi = DB::table('dangky_goi')
                ->where('madk_goi', $madk_goi)
                ->join('goivaccine', 'goivaccine.magoi', '=', 'dangky_goi.magoi')
                ->join('chitietgoivc', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
                ->join('vaccine', 'chitietgoivc.mavc', '=', 'vaccine.mavc')
                ->where('goivaccine.loaigoi', 2)
                ->select(
                    'goivaccine.loaigoi',
                    'dangky_goi.madk_goi',
                    'goivaccine.magoi',
                    'goivaccine.tengoi',
                    'goivaccine.loaigoi',
                    'goivaccine.uudai',
                    'goivaccine.datcoc',
                    'dangky_goi.ngaytiemmongmuon',
                    DB::raw('COUNT(chitietgoivc.mavc) AS soluongvaccine'),
                    DB::raw('SUM(chitietgoivc.soluongmuitiem) AS soluongmuitiem'),
                    DB::raw('SUM(vaccine.gia * chitietgoivc.soluongmuitiem) AS tonggiatien')
                )
                ->groupBy(
                    'goivaccine.loaigoi',
                    'dangky_goi.madk_goi',
                    'goivaccine.magoi',
                    'goivaccine.tengoi',
                    'goivaccine.loaigoi',
                    'goivaccine.uudai',
                    'goivaccine.datcoc',
                    'dangky_goi.ngaytiemmongmuon'
                )
                ->first(); 
        if($ttgoi){
            DB::table('dangky_goi')
                ->where('madk_goi', $madk_goi)
                ->update(['trangthaidk' => 'Đã xác nhận',
                        'trangthaithanhtoan' => "Đã thanh toán",
                        'nhanvien_xacnhandk' => session("manhanvien"),
                        'sotiendathanhtoan' => ($ttgoi->tonggiatien * (1 - $ttgoi->uudai/100)),
                        ]);
        }else{
            DB::table('dangky_goi')
                ->where('madk_goi', $madk_goi)
                ->update(['trangthaidk' => 'Đã xác nhận',
                        'trangthaithanhtoan' => "Đã thanh toán",
                        'nhanvien_xacnhandk' => session("manhanvien"),
                        ]);
        }

        DB::table('dangky_goi')
            ->where('madk_goi', $madk_goi)
            ->update(['trangthaidk' => 'Đã xác nhận',
                      'trangthaithanhtoan' => "Đã thanh toán",
                      'nhanvien_xacnhandk' => session("manhanvien"),
                    ]);

        $ttkh = DB::table('dangky_goi')
            ->where('madk_goi', $madk_goi)
            ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
            ->first();

        $phoneNumber = '+84' . substr($ttkh->sdtkh, 1);
        $message = "Lịch đăng ký tiêm chủng của quý khách đã được xác nhận bởi trung tâm. Quý khách vui lòng truy cập vào hệ thống để có thể theo dõi lịch tiêm và đến trung tâm đúng hẹn. \nTrân trọng!";

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
        return redirect()->back()->with('success', "Đã xác nhận!");
    }

    public function getTongTien($madk_goi) {
        // Query to fetch data from database based on $madk_goi
        $goiTiems = DB::table('dangky_goi')
            ->where('madk_goi', $madk_goi)
            ->join('goivaccine', 'goivaccine.magoi', '=', 'dangky_goi.magoi')
            ->join('chitietgoivc', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
            ->join('vaccine', 'chitietgoivc.mavc', '=', 'vaccine.mavc')
            ->where('goivaccine.loaigoi', 2) // Assuming loaigoi is used to filter packages
            ->select(
                'goivaccine.loaigoi',
                'dangky_goi.madk_goi',
                'goivaccine.magoi',
                'goivaccine.tengoi',
                'goivaccine.loaigoi',
                'goivaccine.uudai',
                'goivaccine.datcoc',
                'dangky_goi.ngaytiemmongmuon',
                DB::raw('COUNT(chitietgoivc.mavc) AS soluongvaccine'),
                DB::raw('SUM(chitietgoivc.soluongmuitiem) AS soluongmuitiem'),
                DB::raw('SUM(vaccine.gia * chitietgoivc.soluongmuitiem) AS tonggiatien')
            )
            ->groupBy(
                'goivaccine.loaigoi',
                'dangky_goi.madk_goi',
                'goivaccine.magoi',
                'goivaccine.tengoi',
                'goivaccine.loaigoi',
                'goivaccine.uudai',
                'goivaccine.datcoc',
                'dangky_goi.ngaytiemmongmuon'
            )
            ->first(); // Fetch the first result
    
        // Calculate derived values
        $tongtien = $goiTiems->tonggiatien;
        $giauudai = $tongtien * (1 - $goiTiems->uudai/100);
        $tiencoc = $goiTiems->datcoc;
        $tienthanhtoan = ($tongtien * (1 - $goiTiems->uudai/100)) - $tiencoc;
    
        // Format and return JSON response
        return response()->json([
            'tongtien' => number_format($tongtien, 0, ',', '.'),
            'giauudai' => number_format($giauudai, 0, ',', '.'),
            'tiencoc' => number_format($tiencoc, 0, ',', '.'),
            'tienthanhtoan' => number_format($tienthanhtoan, 0, ',', '.'),
        ]);
    }

    public function xndentiem($madk_goi){
        DB::table('chitietlstiem_goi')
        ->where('madk_goi', $madk_goi)
        ->update(['trangthaitiem' => 'Chờ tiêm']);
        return redirect()->back()->with('success', "Đã xác nhận!");
    }
    
}
