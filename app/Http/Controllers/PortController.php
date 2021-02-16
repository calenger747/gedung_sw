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

class PortController extends Controller
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
	        $perangkat = Perangkat::all();
	        $g = Gedung::all();

            $port = DB::table('tbl_port')
            ->join('tbl_perangkat', 'tbl_perangkat.id_perangkat', '=', 'tbl_port.id_perangkat')
            ->join('tbl_rak', 'tbl_rak.id_rak', '=', 'tbl_port.id_rak')
            ->join('tbl_lantai', 'tbl_port.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_port.id_gedung')
            ->select('tbl_port.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai', 'tbl_rak.nama_rak', 'tbl_perangkat.nama_perangkat')
            ->where('tbl_port.deleted_at', null)
            ->where('tbl_perangkat.deleted_at', null)
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->paginate(10);

	        return view('admin.port.port', ['port' => $port, 'rak' => $rak, 'perangkat' => $perangkat], ['user' => $user, 'gedung' => $gedung, 'lantai' => $lantai, 'g' => $g]);     
     
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

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'nama_gedung' => 'required',
            'nama_lantai' => 'required',
            'nama_rak' => 'required',
            'nama_perangkat' => 'required',
            'nama_port' => 'required',
            'keterangan' => 'required'
        ]);

        $nama_gedung = $request->nama_gedung;
        $nama_lantai = $request->nama_lantai;
        $nama_rak = $request->nama_rak;
        $nama_perangkat = $request->nama_perangkat;
        $nama_port = $request->nama_port;
        $keterangan = $request->keterangan;
        	
        $port = new Port;
		$port->id_gedung = $nama_gedung;
	    $port->id_lantai = $nama_lantai;
	    $port->id_rak= $nama_rak;
		$port->id_perangkat = $nama_perangkat;
	    $port->nama_port = $nama_port;
	    $port->keterangan = $keterangan;
	    $port->save();
 
        return back()->withStatus(__('Port successfully added.'));
    }

    public function update($id_port, Request $data)
    {
    	$this->validate($data, [
    		'nama_gedung' => 'required',
            'nama_lantai' => 'required',
            'nama_rak' => 'required',
            'nama_perangkat' => 'required',
            'nama_port' => 'required',
            'keterangan' => 'required'
        ]);

        $lantai = DB::table('tbl_port')
            ->where('id_port', '=', $id_port)
            ->update(['id_gedung' => $data->nama_gedung,'id_lantai' => $data->nama_lantai,'id_rak' => $data->nama_rak,'id_perangkat' => $data->nama_perangkat, 'nama_port' => $data->nama_port, 'keterangan' => $data->keterangan]);
            
        return back()->withStatus(__('Port successfully updated.'));
    }

    // hapus sementara
	public function delete($id_port)
	{
		$port = DB::table('tbl_port')
                ->where('id_port', '=', $id_port)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);
	 
	    return back()->withStatus(__('Port successfully deleted.'));
	}

    // menampilkan data port yang sudah dihapus
	public function trash()
	{
		if (Session::get('role') == '1')
        {
            $id = Session::get('id');
	        $user = User::find($id);

	        $g = Gedung::all();
    		// mengampil data port yang sudah dihapus
    		$port = DB::table('tbl_port')
            ->join('tbl_perangkat', 'tbl_perangkat.id_perangkat', '=', 'tbl_port.id_perangkat')
            ->join('tbl_rak', 'tbl_rak.id_rak', '=', 'tbl_port.id_rak')
            ->join('tbl_lantai', 'tbl_port.id_lantai', '=', 'tbl_lantai.id_lantai')
            ->join('tbl_gedung', 'tbl_gedung.id_gedung', '=', 'tbl_port.id_gedung')
            ->select('tbl_port.*', 'tbl_gedung.nama_gedung', 'tbl_lantai.nama_lantai', 'tbl_rak.nama_rak', 'tbl_perangkat.nama_perangkat')
            ->where('tbl_port.deleted_at', '!=', null)
            ->where('tbl_perangkat.deleted_at', null)
            ->where('tbl_rak.deleted_at', null)
            ->where('tbl_lantai.deleted_at', null)
            ->where('tbl_gedung.deleted_at', null)
            ->get();

    		return view('admin.port.port-trash', ['port' => $port], ['user' => $user, 'g' => $g]);
     
        } else {
     
            return redirect("/home"); 
        }
	}

	 // restore data port yang dihapus
	public function kembalikan($id_port, $id_perangkat)
	{
		$perangkat = DB::table('tbl_perangkat')
                ->where('id_perangkat', '=', $id_perangkat)
                ->get();
        foreach ($perangkat as $key => $value) {
        	if ($value->deleted_at != NULL) {
	        	return back()->withStatusFail(__('Device not available.'));
	        } else {
	        	$port = Port::onlyTrashed()->where('id_port',$id_port);
		    	$port->restore();
		    	return back()->withStatus(__('Port successfully restored.'));
	        }
        }
	}

	// hapus permanen
	public function hapus_permanen($id_port)
	{
    	// hapus permanen data Port
    	$port = Port::onlyTrashed()->where('id_port',$id_port);
    	$port->forceDelete();
 
    	return back()->withStatus(__('Port successfully deleted permanently.'));
	}
}
