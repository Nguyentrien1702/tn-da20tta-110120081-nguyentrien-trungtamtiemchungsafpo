<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;
class nv_nhacnhoController extends Controller
{
    public function showdsvaccinenn(){
        $ngayMai = Carbon::tomorrow()->toDateString();

        $dschotiems = DB::connection('mysql')->table('chitietlstiem_goi')
            ->join('dangky_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
            ->join('vaccine', 'chitietlstiem_goi.mavc', '=', 'vaccine.mavc')
            ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
            ->where('chitietlstiem_goi.trangthaitiem', "Chưa tiêm")
            ->whereDate('chitietlstiem_goi.ngaytiemdukien', '=', $ngayMai)
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
            ->where('goivaccine.loaigoi', 2)
            ->whereDate('dangky_goi.ngaytiemmongmuon', '=', $ngayMai)
            ->select(
                'khachhang.makh',
                'khachhang.tenkh',
                'khachhang.ngaysinhkh',
                'khachhang.sdtkh',
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
                'khachhang.sdtkh',
                'goivaccine.loaigoi',
                'dangky_goi.madk_goi',
                'goivaccine.magoi',
                'goivaccine.tengoi',
                'goivaccine.uudai',
                'goivaccine.datcoc',
                'dangky_goi.ngaytiemmongmuon'
            )
            ->havingRaw('soluongdatiem = 0')
            ->get();

        return view('nhanvien.quanlynhacnho.denhen', compact('dschotiems', 'dsgoitiems', 'goiTiems'));
    }

    public function guismsnhacnho($madk_goi, $mavc, $makh){
        $khachhang = DB::table('khachhang')
                ->where('makh', $makh)
                ->select('khachhang.*')
                ->first();
        $ngayMai = Carbon::tomorrow()->format('j-n-Y');
        $sdt = $khachhang->sdtkh;
        $noidungtn = "Trung tâm safpo xin gửi thông báo đến quý khách. Quý khách hàng có lịch tiêm chủng vào ngày ". $ngayMai . ". Vui lòng đến trung tâm đúng hẹn để được tiêm chủng đúng thời gian. \nTrân trọng!";

        $this->sms($sdt, $noidungtn);
        return redirect()->back()->with('success', "Đã gửi!");
    }

    public function guismsnhacnhogoi($madk_goi, $makh){
        $khachhang = DB::table('khachhang')
                ->where('makh', $makh)
                ->select('khachhang.*')
                ->first();
        $ngayMai = Carbon::tomorrow()->format('j-n-Y');
        $sdt = $khachhang->sdtkh;
        $noidungtn = "Trung tâm safpo xin gửi thông báo đến quý khách. Quý khách hàng có đăng ký gói vaccine tại trung tâm. Vui lòng đến trung tâm vào ngày ". $ngayMai . " để tiến hành thanh toán và được hướng dẫn tiêm chủng đúng thời gian. \nTrân trọng!";

        $this->sms($sdt, $noidungtn);
        return redirect()->back()->with('success', "Đã gửi!");
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

    public function lichtiemquahen(){
        try{
            $tiemleqhs = DB::table('chitietlstiem_goi')
                        ->join('vaccine', 'chitietlstiem_goi.mavc', '=', 'vaccine.mavc')
                        ->join('dangky_goi', 'dangky_goi.madk_goi', '=', 'chitietlstiem_goi.madk_goi')
                        ->join('khachhang', 'dangky_goi.makh', '=', 'khachhang.makh')
                        ->where('dangky_goi.trangthaigoitiem', 'Chưa tiêm')
                        ->whereDate('chitietlstiem_goi.ngaytiemdukien', '<', DB::raw('CURDATE()'))
                        ->select('chitietlstiem_goi.*', 'vaccine.*', 'khachhang.*')
                        ->get();

            $goitiemqhs = DB::table('dangky_goi')
                    ->join('goivaccine', 'dangky_goi.magoi', '=', 'goivaccine.magoi')
                    ->join('khachhang', 'dangky_goi.makh', '=', 'khachhang.makh')
                    ->where('goivaccine.loaigoi', 2)
                    ->where(function($query) {
                        $query->where('dangky_goi.trangthaithanhtoan', 'Đã đặt cọc')
                            ->orWhere('dangky_goi.trangthaithanhtoan', 'Đã thanh toán');
                    })
                    ->whereDate('dangky_goi.ngaytiemmongmuon', '<=', now())
                    ->where('dangky_goi.trangthaigoitiem', 'Chưa tiêm')
                    ->select('dangky_goi.*', 'goivaccine.*', 'khachhang.*')
                    ->get();

            return view('nhanvien.quanlynhacnho.quahen', compact('tiemleqhs', 'goitiemqhs'));
        } catch (\Exception $e) {
            $tiemleqhs = collect();
            $goitiemqhs = collect();
            return view('nhanvien.quanlynhacnho.quahen', compact('tiemleqhs', 'goitiemqhs'));
        }
    }

    public function huymuitiemle($madk_goi, $makh){
        $huyle = DB::table('dangky_goi')
                ->join('chitietlstiem_goi', 'chitietlstiem_goi.madk_goi', '=', 'dangky_goi.madk_goi')
                ->join('khachhang', 'khachhang.makh', '=', 'dangky_goi.makh')
                ->where('dangky_goi.makh', $makh)
                ->where('dangky_goi.madk_goi', $madk_goi)
                ->update(['chitietlstiem_goi.trangthaitiem' => 'Đã hủy',
                    'dangky_goi.trangthaidk' => "Đã hủy",
                    'dangky_goi.trangthaigoitiem' => "Không hoàn thành",
                    'dangky_goi.ghichu' => "Quá hẹn",
                ]);
        $khachhang = DB::table('khachhang')
            ->where('makh', $makh)
            ->select('khachhang.*')
            ->first();
        $sdt = $khachhang->sdtkh;
        $noidungtn = "Trung tâm SAFPO xin thông báo đến quý khách hàng. Gói tiêm của quý khách đã được hủy bởi hệ thống.\nLí do: Quá hẹn ngày tiêm\nTrân trọng!";
        $this->sms($sdt, $noidungtn);
        return redirect()->back()->with('success', "Đã hủy!");
    }

    public function tatcalichtiem(){
        $tatcalichtiems = DB::table('chitietlstiem_goi as ctg')
            ->join('dangky_goi as dk', 'ctg.madk_goi', '=', 'dk.madk_goi')
            ->join('vaccine as v', 'ctg.mavc', '=', 'v.mavc')
            ->select(
                'dk.makh',
                'ctg.ngaytiemdukien',
                DB::raw('COUNT(*) as soluongvc'),
                DB::raw('GROUP_CONCAT(v.mavc SEPARATOR ", ") as ds_mavaccine'),
                DB::raw('GROUP_CONCAT(v.tenvc SEPARATOR ", ") as ds_tenvaccine'),
                'dk.trangthaidk',
                'ctg.trangthaitiem'
            )
            ->groupBy('dk.makh', 'ctg.ngaytiemdukien', 'dk.trangthaidk', 'ctg.trangthaitiem')
            ->get();

        return view('nhanvien.tatcalichtiem.tatcalichtiem', compact('tatcalichtiems'));
    }

    public function capNhatNgayTiem(Request $request)
    {
        $madk_goi = $request->input('madk_goi');
        $ngaytiem = $request->input('ngaytiem');

        $capnhatngaytiem = DB::connection('mysql')->table('chitietlstiem_goi')
                ->where("madk_goi", $madk_goi)
                ->update(['ngaytiemdukien'=> $ngaytiem]);

        return redirect()->back()->with('success', 'Cập nhật ngày tiêm thành công.');
    }
}
