<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;
use App\Gedung;
use App\Lantai;
use App\Rak;
use App\Perangkat;
use App\JenisPerangkat;
use App\Port;
use Session;
use DB;

class PerangkatController extends Controller
{
    public function index()
    {	
    	if (Session::get('role') == '1')
        {
            $id = Session::get('id');
	        $user = User::find($id);

	        $gedung = Gedung::all();
	        $lantai = Lantai::all();
	        $rak = Rak::all();
	        $jenis = JenisPerangkat::all();
	        $g = Gedung::all();

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
            ->paginate(10);

	        return view('admin.perangkat.perangkat', ['perangkat' => $perangkat, 'rak' => $rak, 'jenis' => $jenis], ['user' => $user, 'gedung' => $gedung, 'lantai' => $lantai, 'g' => $g]);     
     
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

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'nama_gedung' => 'required',
            'nama_lantai' => 'required',
            'nama_rak' => 'required',
            'nama_jenis' => 'required',
            'nama_perangkat' => 'required'
        ]);

        $perangkat = Perangkat::create([
        	'id_gedung' => $request->nama_gedung,
            'id_lantai' => $request->nama_lantai,
            'id_rak' => $request->nama_rak,
            'id_jenis' => $request->nama_jenis,
            'nama_perangkat' => $request->nama_perangkat,
        ]);
 
        return back()->withStatus(__('Device successfully added.'));
    }

    public function update($id_perangkat, Request $data)
    {
    	$this->validate($data, [
    		'nama_gedung' => 'required',
            'nama_lantai' => 'required',
            'nama_rak' => 'required',
            'nama_jenis' => 'required',
            'nama_perangkat' => 'required'
        ]);

        $lantai = DB::table('tbl_perangkat')
            ->where('id_perangkat', '=', $id_perangkat)
            ->update(['id_gedung' => $data->nama_gedung,'id_lantai' => $data->nama_lantai,'id_rak' => $data->nama_rak,'id_jenis' => $data->nama_jenis, 'nama_perangkat' => $data->nama_perangkat]);
            
        return back()->withStatus(__('Device successfully updated.'));
    }

    // hapus sementara
	public function delete($id_perangkat)
	{
		$perangkat = DB::table('tbl_perangkat')
                ->where('id_perangkat', '=', $id_perangkat)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);

        $port = DB::table('tbl_port')
                ->where('id_perangkat', '=', $id_perangkat)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);
	 
	    return back()->withStatus(__('Device successfully deleted.'));
	}

    // menampilkan data perangkat yang sudah dihapus
	public function trash()
	{
		if (Session::get('role') == '1')
        {
            $id = Session::get('id');
	        $user = User::find($id);

	        $g = Gedung::all();
    		// mengampil data perangkat yang sudah dihapus
    		$perangkat = DB::table('tbl_perangkat')
            ->join('tbl_jenis', 'tbl_perangkat.id_jenis', '=', 'tbl_jenis.id')
            ->join('tbl_rak', 'tbl_rak.id_rak', '=', 'tbl_perangkat.id_rak')
            ->join('tbl_lantai', 'tbl_perangkat.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_perangkat.id_gedung')
            ->select('tbl_perangkat.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai', 'tbl_rak.nama_rak', 'tbl_jenis.nama')
            ->where('tbl_perangkat.deleted_at', '!=', null)
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)

            ->get();

    		return view('admin.perangkat.perangkat-trash', ['perangkat' => $perangkat], ['user' => $user, 'g' => $g]);
     
        } else {
     
            return redirect("/home"); 
        }
	}

	 // restore data perangkat yang dihapus
	public function kembalikan($id_perangkat, $id_rak)
	{
		$rak = DB::table('tbl_rak')
                ->where('id_rak', '=', $id_rak)
                ->get();
        foreach ($rak as $key => $value) {
        	if ($value->deleted_at != NULL) {
	        	return back()->withStatusFail(__('Rack not available.'));
	        } else {
	        	$perangkat = Perangkat::onlyTrashed()->where('id_perangkat',$id_perangkat);
		    	$perangkat->restore();
		    	return back()->withStatus(__('Device successfully restored.'));
	        }
        }
	}

	// hapus permanen
	public function hapus_permanen($id_perangkat)
	{
    	// hapus permanen data perangkat
    	$perangkat = Perangkat::onlyTrashed()->where('id_perangkat',$id_perangkat);
    	$perangkat->forceDelete();

    	$port = Port::onlyTrashed()->where('id_perangkat',$id_perangkat);
    	$port->forceDelete();
 
    	return back()->withStatus(__('Device successfully deleted permanently.'));
	}
}
