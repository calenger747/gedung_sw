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

class LantaiController extends Controller
{
    public function index()
    {	
    	if (Session::get('role') == '1')
        {
            $id = Session::get('id');
	        $user = User::find($id);

	        $gedung = Gedung::all();
	        $g = Gedung::all();

            $lantai = DB::table('tbl_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_lantai.id_gedung')
            ->select('tbl_lantai.*', 'tbl_gedung.nama_gedung')
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->paginate(10);

	        return view('admin.lantai.lantai', ['lantai' => $lantai], ['user' => $user, 'gedung' => $gedung, 'g' => $g]);     
     
        } else {
     
            return redirect("/home"); 
        }
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
            'nama_gedung' => 'required',
            'nama_lantai' => 'required'
        ]);

        Lantai::create([
            'id_gedung' => $request->nama_gedung,
            'nama_lantai' => $request->nama_lantai,
        ]);
 
        return back()->withStatus(__('Floor successfully added.'));
    }

    public function update($id_lantai, Request $data)
    {
    	$this->validate($data, [
            'nama_gedung' => 'required',
            'nama_lantai' => 'required'
        ]);

        $lantai = DB::table('tbl_lantai')
            ->where('id_lantai', '=', $id_lantai)
            ->update(['id_gedung' => $data->nama_gedung, 'nama_lantai' => $data->nama_lantai]);
            
        return back()->withStatus(__('Floor successfully updated.'));
    }

    // hapus sementara
	public function delete($id_lantai)
	{
		$lantai = DB::table('tbl_lantai')
                ->where('id_lantai', '=', $id_lantai)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);

		$rak = DB::table('tbl_rak')
                ->where('id_lantai', '=', $id_lantai)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);

		$perangkat = DB::table('tbl_perangkat')
                ->where('id_lantai', '=', $id_lantai)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);

        $port = DB::table('tbl_port')
                ->where('id_lantai', '=', $id_lantai)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);
	 
	    return back()->withStatus(__('Floor successfully deleted.'));
	}

    // menampilkan data rak yang sudah dihapus
	public function trash()
	{
		if (Session::get('role') == '1')
        {
            $id = Session::get('id');
	        $user = User::find($id);

	        $g = Gedung::all();
    		// mengampil data lantai yang sudah dihapus
    		$lantai = DB::table('tbl_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_lantai.id_gedung')
            ->select('tbl_lantai.*', 'tbl_gedung.nama_gedung')
            ->where('tbl_lantai.deleted_at', '!=', null)
            ->where('tbl_gedung.deleted_at', null)

            ->get();

    		return view('admin.lantai.lantai-trash', ['lantai' => $lantai], ['user' => $user, 'g' => $g]);
     
        } else {
     
            return redirect("/home"); 
        }
	}

	 // restore data lantai yang dihapus
	public function kembalikan($id_lantai, $id_gedung)
	{
		$gedung = DB::table('tbl_gedung')
                ->where('id_gedung', '=', $id_gedung)
                ->get();
        foreach ($gedung as $key => $value) {
        	if ($value->deleted_at != NULL) {
	        	return back()->withStatusFail(__('Building not available.'));
	        } else {
	        	$lantai = Lantai::onlyTrashed()->where('id_lantai',$id_lantai);
		    	$lantai->restore();
		    	return back()->withStatus(__('Floor successfully restored.'));
	        }
        }
	}

	// hapus permanen
	public function hapus_permanen($id_lantai)
	{
    	// hapus permanen data lantai
    	$lantai = Lantai::onlyTrashed()->where('id_lantai',$id_lantai);
    	$lantai->forceDelete();

    	$rak = Rak::onlyTrashed()->where('id_lantai',$id_lantai);
    	$rak->forceDelete();

    	$perangkat = Perangkat::onlyTrashed()->where('id_lantai',$id_lantai);
    	$perangkat->forceDelete();

    	$port = Port::onlyTrashed()->where('id_lantai',$id_lantai);
    	$port->forceDelete();
 
    	return back()->withStatus(__('Floor successfully deleted permanently.'));
	}
}
