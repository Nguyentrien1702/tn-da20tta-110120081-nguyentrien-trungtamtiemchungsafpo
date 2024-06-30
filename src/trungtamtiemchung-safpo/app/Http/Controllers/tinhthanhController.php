<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class tinhthanhController extends Controller
{
    public function gettinhtp()
    {
        $tinhthanhphos = DB::connection('mysql2')->table('tbl_tinhthanhpho')->get();
        return response()->json($tinhthanhphos);
    }

    public function getquanhuyen(Request $request)
    {
        $matp = $request->query('matp');
        $quanhuyen = DB::connection('mysql2')->table('tbl_quanhuyen')->where('matp', $matp)->get();
        return response()->json($quanhuyen);
    }

    public function getxaphuong(Request $request)
    {
        $maqh = $request->query('maqh');
        $xaphuongs = DB::connection('mysql2')->table('tbl_xaphuongthitran')->where('maqh', $maqh)->get();
        return response()->json($xaphuongs);
    }
}
