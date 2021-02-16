<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;
use App\Gedung;
use App\Lantai;
use App\Rak;
use App\Perangkat;
use App\Port;
use Session;
use DB;

class RakController extends Controller
{
    public function index()
    {	
    	if (Session::get('role') == '1')
        {
            $id = Session::get('id');
	        $user = User::find($id);

	        $gedung = Gedung::all();
	        $g = Gedung::all();
	        $lantai = Lantai::all();

            $rak = DB::table('tbl_rak')
            ->join('tbl_lantai', 'tbl_rak.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_rak.id_gedung')
            ->select('tbl_rak.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai')
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->paginate(10);

	        return view('admin.rak.rak', ['rak' => $rak], ['user' => $user, 'gedung' => $gedung, 'lantai' => $lantai, 'g' => $g]);     
     
        } else {
     
            return redirect("/home"); 
        }
    }

    public function lantai(){
      $id_gedung = Input::get('id_gedung');
      $lantai = Lantai::where('id_gedung', '=', $id_gedung)->get();
      return response()->json($lantai);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'nama_gedung' => 'required',
            'nama_lantai' => 'required',
            'nama_rak' => 'required'
        ]);

        Rak::create([
        	'id_gedung' => $request->nama_gedung,
            'id_lantai' => $request->nama_lantai,
            'nama_rak' => $request->nama_rak,
        ]);
 
        return back()->withStatus(__('Rack successfully added.'));
    }

    public function update($id_rak, Request $data)
    {
    	$this->validate($data, [
    		'nama_gedung' => 'required',
            'nama_lantai' => 'required',
            'nama_rak' => 'required'
        ]);

        $lantai = DB::table('tbl_rak')
            ->where('id_rak', '=', $id_rak)
            ->update(['id_gedung' => $data->nama_gedung,'id_lantai' => $data->nama_lantai, 'nama_rak' => $data->nama_rak]);
            
        return back()->withStatus(__('Rack successfully updated.'));
    }

    // hapus sementara
	public function delete($id_rak)
	{
		$rak = DB::table('tbl_rak')
                ->where('id_rak', '=', $id_rak)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);

		$perangkat = DB::table('tbl_perangkat')
                ->where('id_rak', '=', $id_rak)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);

        $port = DB::table('tbl_port')
                ->where('id_rak', '=', $id_rak)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);
	 
	    return back()->withStatus(__('Rack successfully deleted.'));
	}

    // menampilkan data rak yang sudah dihapus
	public function trash()
	{
		if (Session::get('role') == '1')
        {
            $id = Session::get('id');
	        $user = User::find($id);

	        $g = Gedung::all();
    		// mengampil data rak yang sudah dihapus
    		$rak = DB::table('tbl_rak')
            ->join('tbl_lantai', 'tbl_rak.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_rak.id_gedung')
            ->select('tbl_rak.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai')
            ->where('tbl_rak.deleted_at', '!=', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)

            ->get();

    		return view('admin.rak.rak-trash', ['rak' => $rak], ['user' => $user, 'g' => $g]);
     
        } else {
     
            return redirect("/home"); 
        }
	}

	 // restore data rak yang dihapus
	public function kembalikan($id_rak, $id_lantai)
	{
		$lantai = DB::table('tbl_lantai')
                ->where('id_lantai', '=', $id_lantai)
                ->get();
        foreach ($lantai as $key => $value) {
        	if ($value->deleted_at != NULL) {
	        	return back()->withStatusFail(__('Floor not available.'));
	        } else {
	        	$rak = Rak::onlyTrashed()->where('id_rak',$id_rak);
		    	$rak->restore();
		    	return back()->withStatus(__('Rack successfully restored.'));
	        }
        }
	}

	// hapus permanen
	public function hapus_permanen($id_rak)
	{
    	// hapus permanen data rak
    	$rak = Rak::onlyTrashed()->where('id_rak',$id_rak);
    	$rak->forceDelete();

    	$perangkat = Perangkat::onlyTrashed()->where('id_rak',$id_rak);
    	$perangkat->forceDelete();

    	$port = Port::onlyTrashed()->where('id_rak',$id_rak);
    	$port->forceDelete();
 
    	return back()->withStatus(__('Rack successfully deleted permanently.'));
	}
}
