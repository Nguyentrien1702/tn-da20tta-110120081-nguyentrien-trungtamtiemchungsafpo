<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
class SMSController extends Controller
{
    public function sendSMS()
    {
        $users = DB::table('chitietlstiem_goi AS clg')
                    ->join('dangky_goi AS dg', 'clg.madk_goi', '=', 'dg.madk_goi')
                    ->join('khachhang AS kh', 'dg.makh', '=', 'kh.makh')
                    ->join('vaccine AS v', 'clg.mavc', '=', 'v.mavc')
                    ->select('dangky_goi.*', 'khachhang.*')
                    ->whereDate('clg.ngaytiemdukien', '=', now()->addDay())
                    ->get();
        foreach ($users as $user) {
            // Xử lý mỗi user ở đây
            $maDangKy = $user->dangkyGoi->madk_goi;
            $tenKhachHang = $user->dangkyGoi->khachHang->tenkh;
            // Và các thông tin khác của user

            // Ví dụ in ra một số thông tin
            echo "Mã đăng ký: $maDangKy - Tên khách hàng: $tenKhachHang<br>";
        }
        $phoneNumber =0000;
        $message ="......";
        $infobipApiKey = 'ee50969b3a4232afe3074cb93d7c7ffa-433ff75b-26f9-491f-968a-ce6d33e6d8db';
        $infobipSender = '+447491163443';

        $client = new Client();

        try {
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

            $responseData = json_decode($response->getBody(), true);

            return response()->json(['success' => true, 'message' => 'Gửi tin nhắn thành công!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gửi tin nhắn thất bại: ' . $e->getMessage()]);
        }
    }
}
