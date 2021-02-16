<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Provinces;
use App\Regencies;
use App\Districts;
use App\Villages;

use App\User;
use App\Gedung;
use App\Alamat;
use App\Lantai;
use App\Rak;
use App\Perangkat;
use App\Port;
use Session;
use DB;
use PDF;

class CariDataController extends Controller
{

    public function search(Request $request)
	{
		if (Session::get('role') == '1')
        {
            $id = Session::get('id');
	        $user = User::find($id);
	        $g = Gedung::all();

	        $gedung = DB::table('tbl_gedung')
            ->join('tbl_alamat', 'tbl_gedung.kode_alamat', '=', 'tbl_alamat.kode_alamat')
            ->join('provinces', 'provinces.id', '=', 'tbl_alamat.provinsi')
            ->join('regencies', 'regencies.id', '=', 'tbl_alamat.kota')
            ->join('districts', 'districts.id', '=', 'tbl_alamat.kecamatan')
            ->join('villages', 'villages.id', '=', 'tbl_alamat.kelurahan')
            ->select('tbl_gedung.*', 'tbl_alamat.*', 'provinces.name_prov', 'regencies.name_kab', 'districts.name_kec', 'villages.name_kel')
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_gedung.id_gedung', '=', $request->nama_gedung)
            ->get();

            $lantai = DB::table('tbl_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_lantai.id_gedung')
            ->select('tbl_lantai.*', 'tbl_gedung.nama_gedung')
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_lantai.id_lantai', '=', $request->nama_lantai)
            ->get();

            $rak = DB::table('tbl_rak')
            ->join('tbl_lantai', 'tbl_rak.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_rak.id_gedung')
            ->select('tbl_rak.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai')
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_rak.id_rak', '=', $request->nama_rak)
            ->get();

            $perangkat = DB::table('tbl_perangkat')
            ->join('tbl_jenis', 'tbl_perangkat.id_jenis', '=', 'tbl_jenis.id')
            ->join('tbl_rak', 'tbl_rak.id_rak', '=', 'tbl_perangkat.id_rak')
            ->join('tbl_lantai', 'tbl_perangkat.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_perangkat.id_gedung')
            ->select('tbl_perangkat.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai', 'tbl_rak.nama_rak', 'tbl_jenis.nama')
            ->where('tbl_perangkat.deleted_at', null)
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_perangkat.id_perangkat', '=', $request->nama_perangkat)
            ->get();

            $port = DB::table('tbl_port')
            ->join('tbl_perangkat', 'tbl_perangkat.id_perangkat', '=', 'tbl_port.id_perangkat')
            ->join('tbl_jenis', 'tbl_perangkat.id_jenis', '=', 'tbl_jenis.id')
            ->join('tbl_rak', 'tbl_rak.id_rak', '=', 'tbl_port.id_rak')
            ->join('tbl_lantai', 'tbl_port.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->select('tbl_port.*', 'tbl_perangkat.nama_perangkat', 'tbl_rak.nama_rak', 'tbl_lantai.nama_lantai', 'tbl_jenis.nama')
            ->where('tbl_port.deleted_at', null)
            ->where('tbl_perangkat.deleted_at', null)
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_jenis.deleted_at', null)
             ->where('tbl_perangkat.id_perangkat', '=', $request->nama_perangkat)
            ->paginate(10);

	        return view('admin.cari_data.cari', ['gedung' => $gedung, 'perangkat' => $perangkat, 'lantai' => $lantai], ['user' => $user, 'g' => $g, 'rak' => $rak, 'port' => $port]);     
     
        } else {
     
            return redirect("/home"); 
        }
	}
	public function user_search(Request $request)
	{
		if (Session::get('role') == '2')
        {
            $id = Session::get('id');
	        $user = User::find($id);
	        $g = Gedung::all();

	        $gedung = DB::table('tbl_gedung')
            ->join('tbl_alamat', 'tbl_gedung.kode_alamat', '=', 'tbl_alamat.kode_alamat')
            ->join('provinces', 'provinces.id', '=', 'tbl_alamat.provinsi')
            ->join('regencies', 'regencies.id', '=', 'tbl_alamat.kota')
            ->join('districts', 'districts.id', '=', 'tbl_alamat.kecamatan')
            ->join('villages', 'villages.id', '=', 'tbl_alamat.kelurahan')
            ->select('tbl_gedung.*', 'tbl_alamat.*', 'provinces.name_prov', 'regencies.name_kab', 'districts.name_kec', 'villages.name_kel')
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_gedung.id_gedung', '=', $request->nama_gedung)
            ->get();

            $lantai = DB::table('tbl_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_lantai.id_gedung')
            ->select('tbl_lantai.*', 'tbl_gedung.nama_gedung')
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_lantai.id_lantai', '=', $request->nama_lantai)
            ->get();

            $rak = DB::table('tbl_rak')
            ->join('tbl_lantai', 'tbl_rak.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_rak.id_gedung')
            ->select('tbl_rak.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai')
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_rak.id_rak', '=', $request->nama_rak)
            ->get();

            $perangkat = DB::table('tbl_perangkat')
            ->join('tbl_jenis', 'tbl_perangkat.id_jenis', '=', 'tbl_jenis.id')
            ->join('tbl_rak', 'tbl_rak.id_rak', '=', 'tbl_perangkat.id_rak')
            ->join('tbl_lantai', 'tbl_perangkat.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_perangkat.id_gedung')
            ->select('tbl_perangkat.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai', 'tbl_rak.nama_rak', 'tbl_jenis.nama')
            ->where('tbl_perangkat.deleted_at', null)
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_perangkat.id_perangkat', '=', $request->nama_perangkat)
            ->get();

            $port = DB::table('tbl_port')
            ->join('tbl_perangkat', 'tbl_perangkat.id_perangkat', '=', 'tbl_port.id_perangkat')
            ->join('tbl_jenis', 'tbl_perangkat.id_jenis', '=', 'tbl_jenis.id')
            ->join('tbl_rak', 'tbl_rak.id_rak', '=', 'tbl_port.id_rak')
            ->join('tbl_lantai', 'tbl_port.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->select('tbl_port.*', 'tbl_perangkat.nama_perangkat', 'tbl_rak.nama_rak', 'tbl_lantai.nama_lantai', 'tbl_jenis.nama')
            ->where('tbl_port.deleted_at', null)
            ->where('tbl_perangkat.deleted_at', null)
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_jenis.deleted_at', null)
             ->where('tbl_perangkat.id_perangkat', '=', $request->nama_perangkat)
            ->paginate(10);

	        return view('user.cari', ['gedung' => $gedung, 'perangkat' => $perangkat, 'lantai' => $lantai], ['user' => $user, 'g' => $g, 'rak' => $rak, 'port' => $port]);     
     
        } else {
     
            return redirect("/home"); 
        }
	}

	public function print($id_gedung, $id_lantai, $id_rak, $id_perangkat)
	{
		if (Session::get('role') == '1')
        {
            $id = Session::get('id');
	        $user = User::find($id);
	        $g = Gedung::all();

	        $gedung = DB::table('tbl_gedung')
            ->join('tbl_alamat', 'tbl_gedung.kode_alamat', '=', 'tbl_alamat.kode_alamat')
            ->join('provinces', 'provinces.id', '=', 'tbl_alamat.provinsi')
            ->join('regencies', 'regencies.id', '=', 'tbl_alamat.kota')
            ->join('districts', 'districts.id', '=', 'tbl_alamat.kecamatan')
            ->join('villages', 'villages.id', '=', 'tbl_alamat.kelurahan')
            ->select('tbl_gedung.*', 'tbl_alamat.*', 'provinces.name_prov', 'regencies.name_kab', 'districts.name_kec', 'villages.name_kel')
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_gedung.id_gedung', '=', $id_gedung)
            ->get();

            $lantai = DB::table('tbl_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_lantai.id_gedung')
            ->select('tbl_lantai.*', 'tbl_gedung.nama_gedung')
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_lantai.id_lantai', '=', $id_lantai)
            ->get();

            $rak = DB::table('tbl_rak')
            ->join('tbl_lantai', 'tbl_rak.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_rak.id_gedung')
            ->select('tbl_rak.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai')
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_rak.id_rak', '=', $id_rak)
            ->get();

            $perangkat = DB::table('tbl_perangkat')
            ->join('tbl_jenis', 'tbl_perangkat.id_jenis', '=', 'tbl_jenis.id')
            ->join('tbl_rak', 'tbl_rak.id_rak', '=', 'tbl_perangkat.id_rak')
            ->join('tbl_lantai', 'tbl_perangkat.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_perangkat.id_gedung')
            ->select('tbl_perangkat.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai', 'tbl_rak.nama_rak', 'tbl_jenis.nama')
            ->where('tbl_perangkat.deleted_at', null)
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_perangkat.id_perangkat', '=', $id_perangkat)
            ->get();

            $port = DB::table('tbl_port')
            ->join('tbl_perangkat', 'tbl_perangkat.id_perangkat', '=', 'tbl_port.id_perangkat')
            ->join('tbl_jenis', 'tbl_perangkat.id_jenis', '=', 'tbl_jenis.id')
            ->join('tbl_rak', 'tbl_rak.id_rak', '=', 'tbl_port.id_rak')
            ->join('tbl_lantai', 'tbl_port.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->select('tbl_port.*', 'tbl_perangkat.nama_perangkat', 'tbl_rak.nama_rak', 'tbl_lantai.nama_lantai', 'tbl_jenis.nama')
            ->where('tbl_port.deleted_at', null)
            ->where('tbl_perangkat.deleted_at', null)
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_jenis.deleted_at', null)
            ->where('tbl_perangkat.id_perangkat', '=', $id_perangkat)
            ->get();

            return view('admin.cari_data.print-pdf', ['gedung' => $gedung, 'perangkat' => $perangkat, 'lantai' => $lantai], ['user' => $user, 'g' => $g, 'rak' => $rak, 'port' => $port]);

	        // $pdf = PDF::loadview('admin.cari_data.print-pdf', ['gedung' => $gedung, 'perangkat' => $perangkat, 'lantai' => $lantai], ['user' => $user, 'g' => $g, 'rak' => $rak, 'port' => $port]); 
	        // set_time_limit(300);
	        // // return $pdf->download('laporan_perangkat_'.date('Y-m-d_H-i').'.pdf');
	        // return $pdf->stream();    
     
        } else {
     
            return redirect("/home"); 
        }
	}

	public function user_print($id_gedung, $id_lantai, $id_rak, $id_perangkat)
	{
		if (Session::get('role') == '2')
        {
            $id = Session::get('id');
	        $user = User::find($id);
	        $g = Gedung::all();

	        $gedung = DB::table('tbl_gedung')
            ->join('tbl_alamat', 'tbl_gedung.kode_alamat', '=', 'tbl_alamat.kode_alamat')
            ->join('provinces', 'provinces.id', '=', 'tbl_alamat.provinsi')
            ->join('regencies', 'regencies.id', '=', 'tbl_alamat.kota')
            ->join('districts', 'districts.id', '=', 'tbl_alamat.kecamatan')
            ->join('villages', 'villages.id', '=', 'tbl_alamat.kelurahan')
            ->select('tbl_gedung.*', 'tbl_alamat.*', 'provinces.name_prov', 'regencies.name_kab', 'districts.name_kec', 'villages.name_kel')
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_gedung.id_gedung', '=', $id_gedung)
            ->get();

            $lantai = DB::table('tbl_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_lantai.id_gedung')
            ->select('tbl_lantai.*', 'tbl_gedung.nama_gedung')
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_lantai.id_lantai', '=', $id_lantai)
            ->get();

            $rak = DB::table('tbl_rak')
            ->join('tbl_lantai', 'tbl_rak.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_rak.id_gedung')
            ->select('tbl_rak.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai')
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_rak.id_rak', '=', $id_rak)
            ->get();

            $perangkat = DB::table('tbl_perangkat')
            ->join('tbl_jenis', 'tbl_perangkat.id_jenis', '=', 'tbl_jenis.id')
            ->join('tbl_rak', 'tbl_rak.id_rak', '=', 'tbl_perangkat.id_rak')
            ->join('tbl_lantai', 'tbl_perangkat.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_perangkat.id_gedung')
            ->select('tbl_perangkat.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai', 'tbl_rak.nama_rak', 'tbl_jenis.nama')
            ->where('tbl_perangkat.deleted_at', null)
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->where('tbl_perangkat.id_perangkat', '=', $id_perangkat)
            ->get();

            $port = DB::table('tbl_port')
            ->join('tbl_perangkat', 'tbl_perangkat.id_perangkat', '=', 'tbl_port.id_perangkat')
            ->join('tbl_jenis', 'tbl_perangkat.id_jenis', '=', 'tbl_jenis.id')
            ->join('tbl_rak', 'tbl_rak.id_rak', '=', 'tbl_port.id_rak')
            ->join('tbl_lantai', 'tbl_port.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->select('tbl_port.*', 'tbl_perangkat.nama_perangkat', 'tbl_rak.nama_rak', 'tbl_lantai.nama_lantai', 'tbl_jenis.nama')
            ->where('tbl_port.deleted_at', null)
            ->where('tbl_perangkat.deleted_at', null)
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_jenis.deleted_at', null)
            ->where('tbl_perangkat.id_perangkat', '=', $id_perangkat)
            ->get();

            return view('user.print-pdf', ['gedung' => $gedung, 'perangkat' => $perangkat, 'lantai' => $lantai], ['user' => $user, 'g' => $g, 'rak' => $rak, 'port' => $port]);

	        // $pdf = PDF::loadview('admin.cari_data.print-pdf', ['gedung' => $gedung, 'perangkat' => $perangkat, 'lantai' => $lantai], ['user' => $user, 'g' => $g, 'rak' => $rak, 'port' => $port]); 
	        // set_time_limit(300);
	        // // return $pdf->download('laporan_perangkat_'.date('Y-m-d_H-i').'.pdf');
	        // return $pdf->stream();    
     
        } else {
     
            return redirect("/home"); 
        }
	}

    public function lantai(){
      $id_gedung = Input::get('id_gedung');
      $lantai = Lantai::where('id_gedung', '=', $id_gedung)->get();
      return response()->json($lantai);
    }

    public function rak(){
      $id_lantai = Input::get('id_lantai');
      $rak = Rak::where('id_lantai', '=', $id_lantai)->get();
      return response()->json($rak);
    }

    public function perangkat(){
      $id_rak = Input::get('id_rak');
      $perangkat = Perangkat::where('id_rak', '=', $id_rak)->get();
      return response()->json($perangkat);
    }

}
