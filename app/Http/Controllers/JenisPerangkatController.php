<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\JenisPerangkat;
use App\User;
use App\Gedung;
use Session;

class JenisPerangkatController extends Controller
{
    public function index()
    {	
    	if (Session::get('role') == '1')
        {
            $id = Session::get('id');
	        $user = User::find($id);

            $g = Gedung::all();
	        $jenis = JenisPerangkat::paginate(10);
    		return view('admin.master.jenis-perangkat', ['jenis' => $jenis], ['user' => $user, 'g' => $g]);
     
        } else {
     
            return redirect("/home"); 
        }
    }

    //Tambah Perangkat
    public function store(Request $request)
    {
    	$this->validate($request,[
    		'nama' => 'required'
    	]);
 
        JenisPerangkat::create([
    		'nama' => $request->nama
    	]);
 
    	return back()->withStatus(__('Device successfully created.'));
    }

    //Edit Perangkat
    public function update($id, Request $request)
	{
	    $this->validate($request,[
		   'nama' => 'required'
	    ]);
	 
	    $jenis = JenisPerangkat::find($id);
	    $jenis->nama = $request->nama;
	    $jenis->save();
	    return back()->withStatus(__('Device successfully updated.'));
	}

    // hapus sementara
	public function hapus($id)
	{
	    $jenis = JenisPerangkat::find($id);
	    $jenis->delete();
	 
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
    		$jenis = JenisPerangkat::onlyTrashed()->get();
    		return view('admin.master.jenis-trash', ['jenis' => $jenis], ['user' => $user, 'g' => $g]);
     
        } else {
     
            return redirect("/home"); 
        }
	}

	 // restore data perangkat yang dihapus
	public function kembalikan($id)
	{
    	$jenis = JenisPerangkat::onlyTrashed()->where('id',$id);
    	$jenis->restore();
    	return back()->withStatus(__('Device successfully restored.'));
	}

	// restore semua data perangkat yang sudah dihapus
	public function kembalikan_semua()
	{
    		
    	$jenis = JenisPerangkat::onlyTrashed();
    	$jenis->restore();
 
    	return back()->withStatus(__('Device successfully restored.'));
	}

	// hapus permanen
	public function hapus_permanen($id)
	{
    	// hapus permanen data perangkat
    	$jenis = JenisPerangkat::onlyTrashed()->where('id',$id);
    	$jenis->forceDelete();
 
    	return back()->withStatus(__('Device successfully deleted permanently.'));
	}

	// hapus permanen semua perangkat yang sudah dihapus
	public function hapus_permanen_semua()
	{
    	// hapus permanen semua data perangkat yang sudah dihapus
    	$jenis = JenisPerangkat::onlyTrashed();
    	$jenis->forceDelete();
 
    	return back()->withStatus(__('Device successfully deleted permanently.'));
	}
}
