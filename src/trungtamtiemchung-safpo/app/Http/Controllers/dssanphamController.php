<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class dssanphamController extends Controller
{
    public function dssanpham(){
        try {            
            $vaccines = DB::connection('mysql')->table('vaccine')
            ->join('benh_nhombenh', 'vaccine.benh_nhombenh', '=', 'benh_nhombenh.mabenh_nhombenh')
            ->join('nhacungcap', 'vaccine.mancc', '=', 'nhacungcap.mancc')
            ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
            ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
            ->where('goivaccine.loaigoi', 1)
            ->select('vaccine.*', 'benh_nhombenh.*', 'nhacungcap.*')
            ->paginate(12);

            return view('sanpham.dsvaccine', compact('vaccines'));
        } catch (\Exception $e) {
            $vaccines = collect();
            return view('sanpham.dsvaccine', compact('vaccines'));
        }
    }

    public function dsgoivaccine(){
        try {            
            $dsgoivaccines = DB::table('vaccine')
            ->join('benh_nhombenh', 'benh_nhombenh.mabenh_nhombenh', '=', 'vaccine.benh_nhombenh')
            ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
            ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
            ->select('vaccine.*', 'chitietgoivc.*', 'benh_nhombenh.*')
            ->get();

            $goivcs= DB::connection('mysql')->table('goivaccine')
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
                ->paginate(5);

            return view('sanpham.dsgoivaccine', compact('dsgoivaccines', 'goivcs'));
        } catch (\Exception $e) {
            $dsgoivaccines = collect();
            return view('sanpham.dsgoivaccine', compact('dsgoivaccines', 'goivcs'));
        }
    }

    public function showctvaccine($mavc)
    {
        $ctvaccine = DB::connection('mysql')->table('vaccine')
            ->where('vaccine.mavc', $mavc)
            ->where('goivaccine.loaigoi', 1)
            ->join('benh_nhombenh', 'vaccine.benh_nhombenh', '=', 'benh_nhombenh.mabenh_nhombenh')
            ->join('nhacungcap', 'vaccine.mancc', '=', 'nhacungcap.mancc')
            ->join('chitietgoivc', 'vaccine.mavc', '=', 'chitietgoivc.mavc')
            ->join('goivaccine', 'goivaccine.magoi', '=', 'chitietgoivc.magoi')
            ->select('vaccine.*', 'benh_nhombenh.*')
            ->first();
        return view('sanpham/chitietsanpham', compact('ctvaccine'))->with('ctvaccine', $ctvaccine);
    }
}
