<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class xldangnhapController extends Controller
{
    public function dangnhaptk(Request $request){
        $request->validate([
            'txtmadangnhap' => 'required',
            'txtmatkhau' => 'required',
        ]);
        
        $madangnhap = $request->input('txtmadangnhap');
        $matkhau = $request->input('txtmatkhau');
        $kh_nv = substr($madangnhap, 0, 2);
        if($kh_nv == "Ad" || $kh_nv == "nv"){
            $nhanvien = DB::table('nhanvien')->where('manv', $madangnhap)->where('trangthaihoatdong', 1)->first();
            
            if ($nhanvien) {
                $matkhaudb = $nhanvien->matkhau;
                if(md5($matkhau) == $matkhaudb){
                    $mavaitro = $nhanvien->mavaitro;
                    $vaitro = DB::table('vaitro')->where('mavaitro', $mavaitro)->first();
                
                    if ($vaitro) {
                        $tenVaiTro = $vaitro->vaitro;
                        if($tenVaiTro == "Admin"){
                            session(['manhanvien' => $madangnhap]);
                            return redirect()->intended('/Admin');
                        }elseif($tenVaiTro == "Bác sĩ" || $tenVaiTro == "Y tá"){
                            session(['manhanvien' => $madangnhap]);
                            session(['vaitro' => $tenVaiTro]);
                            return redirect()->intended('/Nhanvien');
                        }
                    }
                }else{
                    return back()->withErrors([
                        'email' => 'sai mật khẩu',
                    ]);
                }
            }else{
                return back()->withErrors([
                    'email' => 'Tài khoản không tồn tại',
                ]);
            }
        }elseif($kh_nv == "kh"){
            $khachhang = DB::table('khachhang')->where('makh', $madangnhap)->first();
            if ($khachhang) {
                $matkhaudb = $khachhang->matkhau;
                if(md5($matkhau) == $matkhaudb){
                    session(['khachhang' => $madangnhap]);
                    return redirect()->intended('/');
                }
                else{
                    return back()->withErrors([
                        'email' => 'sai mật khẩu',
                    ]);
                }
            }else{
                return back()->withErrors([
                    'email' => 'Tài khoản không tồn tại',
                ]);
            }
        }
        
        
    }

    public function Logout(){
        if(session("manhanvien")){
            session()->forget('manhanvien');
        }else{
            session()->forget('khachhang');
        }

        if(session("vaitro")){
            session()->forget('vaitro');
        }
        
        return redirect()->intended('/');
    }
}
