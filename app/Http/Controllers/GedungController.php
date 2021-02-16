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

use Carbon;

class GedungController extends Controller
{
    public function index()
    {	
    	if (Session::get('role') == '1')
        {
            $id = Session::get('id');
	        $user = User::find($id);

            $g = Gedung::all();

            $gedung = DB::table('tbl_gedung')
            ->join('tbl_alamat', 'tbl_gedung.kode_alamat', '=', 'tbl_alamat.kode_alamat')
            ->join('regencies', 'regencies.id', '=', 'tbl_alamat.kota')
            ->select('tbl_gedung.*', 'regencies.name_kab')
            ->where('tbl_gedung.deleted_at', null)
            ->paginate(10);

	        return view('admin.gedung', ['gedung' => $gedung, 'g' => $g], ['user' => $user]);     
     
        } else {
     
            return redirect("/home"); 
        }
    }

    public function user_index()
    {   
        if (Session::get('role') == '2')
        {
            $id = Session::get('id');
            $user = User::find($id);

            $g = Gedung::all();

            $gedung = DB::table('tbl_gedung')
            ->join('tbl_alamat', 'tbl_gedung.kode_alamat', '=', 'tbl_alamat.kode_alamat')
            ->join('regencies', 'regencies.id', '=', 'tbl_alamat.kota')
            ->select('tbl_gedung.*', 'regencies.name_kab')
            ->where('tbl_gedung.deleted_at', null)
            ->paginate(10);

            return view('user.gedung', ['gedung' => $gedung, 'g' => $g], ['user' => $user]);     
     
        } else {
     
            return redirect("/home"); 
        }
    }


    public function add()
    {   
        if (Session::get('role') == '1')
        {
            $id = Session::get('id');
            $user = User::find($id);

            $provincies = Provinces::all();
            $g = Gedung::all();

            $tahun = date('Y');
            $nomor = "-";
            $kode = DB::table('tbl_alamat')
             ->whereYear('created_at', '=', $tahun)
             ->max('kode_alamat');

            $kodealm = $kode;

            $nosch = (int) substr($kodealm, 3, 5);

            $nosch++;
            $char1 = "ALM";
            $newalm = $char1 . sprintf("%05s", $nosch) . '-' . Date('Y');

            return view('admin.tambah_gedung', ['user' => $user], ['provincies' => $provincies, 'kode' => $newalm, 'g' => $g]);     
     
        } else {
     
            return redirect("/home"); 
        }
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            // 'gambar' => 'required|file|image|mimes:jpeg,png,jpg|max:8192',
        ]);
 
        // menyimpan data file yang diupload ke variabel $file
        // $file = $request->file('gambar');
 
        // $nama_file = time()."_".$file->getClientOriginalName();
 
        //         // isi dengan nama folder tempat kemana file diupload
        // $tujuan_upload = 'data_file';
        // $file->move($tujuan_upload,$nama_file);
 
        Gedung::create([
            'nama_gedung' => $request->name,
            'koordinat' => $request->koordinat,
            'kontak' => $request->telepon,
            'nama_kontak' => $request->nama_kontak,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'kunci' => $request->kunci,
            // 'gambar' => $nama_file,
            'kode_alamat' => $request->kode_alamat,
        ]);
        Alamat::create([
            'kode_alamat' => $request->kode_alamat,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'kode_pos' => $request->kode_pos,
        ]);
 
        return back()->withStatus(__('Building successfully added.'));
    }

    public function upload($id_gedung, Request $request){
        $this->validate($request, [
            'name' => 'required',
            'gambar' => 'required|file|image|mimes:jpeg,png,jpg|max:8192',
        ]);
 
        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('gambar');
 
        $nama_file = time()."_".$file->getClientOriginalName();
 
                // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'data_file';
        $file->move($tujuan_upload,$nama_file);
        
        $upload = DB::table('tbl_gedung')
            ->where('id_gedung', '=', $id_gedung)
            ->update(['nama_gedung' => $request->name, 'gambar' => $nama_file]);
 
        return back()->withStatus(__('Image successfully uploaded.'));
    }

    public function regencies(){
      $provinces_id = Input::get('province_id');
      $regencies = Regencies::where('province_id', '=', $provinces_id)->get();
      return response()->json($regencies);
    }

    public function districts(){
      $regencies_id = Input::get('regencies_id');
      $districts = Districts::where('regency_id', '=', $regencies_id)->get();
      return response()->json($districts);
    }

    public function villages(){
      $districts_id = Input::get('districts_id');
      $villages = Villages::where('district_id', '=', $districts_id)->get();
      return response()->json($villages);
    }

    public function provName(){
      $provinces_id = Input::get('province_id');
      $prov = Provinces::where('id', '=', $provinces_id)->get();
      return response()->json($prov);
    }

    public function cityName(){
      $regencies_id = Input::get('regencies_id');
      $city = Regencies::where('id', '=', $regencies_id)->get();
      return response()->json($city);
    }

    public function kecName(){
      $districts_id = Input::get('districts_id');
      $kec = Districts::where('id', '=', $districts_id)->get();
      return response()->json($kec);
    }

    public function kelName(){
      $villages_id = Input::get('villages_id');
      $kel = Villages::where('id', '=', $villages_id)->get();
      return response()->json($kel);
    }

    public function edit($id_gedung)
    {   
        if (Session::get('role') == '1')
        {
            $id = Session::get('id');
            $user = User::find($id);

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

            $provinsi = Provinces::All();
            $kota = Regencies::All();
            $kecamatan = Districts::All();
            $kelurahan = Villages::All();
            $g = Gedung::all();

            return view('admin.edit_gedung', ['gedung' => $gedung, 'provinsi' => $provinsi, 'kota' => $kota, 'kecamatan' => $kecamatan, 'kelurahan' => $kelurahan], ['user' => $user, 'g' => $g]);     
     
        } else {
     
            return redirect("/home"); 
        }
    }

    public function update($id_gedung, Request $data)
    {
        $this->validate($data, [
            'name' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
        ]);

        $gedung = DB::table('tbl_gedung')
            ->where('id_gedung', '=', $id_gedung)
            ->update(['nama_gedung' => $data->name, 'koordinat' => $data->koordinat, 'kontak' => $data->telepon, 'nama_kontak' => $data->nama_kontak, 'jam_buka' => $data->jam_buka, 'jam_tutup' => $data->jam_tutup, 'kunci' => $data->kunci, 'kode_alamat' => $data->kode_alamat]);
        $alamat = DB::table('tbl_alamat')
            ->where('kode_alamat', '=', $data->kode_alamat)
            ->update(['alamat' => $data->alamat, 'provinsi' => $data->provinsi, 'kota' => $data->kota, 'kecamatan' => $data->kecamatan, 'kelurahan' => $data->kelurahan, 'kode_pos' => $data->kode_pos]);
            
        return redirect("/admin/gedung")->withStatus(__('Building successfully updated.'));
    }

    // hapus sementara
    public function delete($id_gedung)
    {
        $gedung = DB::table('tbl_gedung')
                ->where('id_gedung', '=', $id_gedung)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);

        $lantai = DB::table('tbl_lantai')
                ->where('id_gedung', '=', $id_gedung)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);

        $rak = DB::table('tbl_rak')
                ->where('id_gedung', '=', $id_gedung)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);

        $perangkat = DB::table('tbl_perangkat')
                ->where('id_gedung', '=', $id_gedung)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);

        $port = DB::table('tbl_port')
                ->where('id_gedung', '=', $id_gedung)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => NOW()]);
     
        return back()->withStatus(__('Building successfully deleted.'));
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
            $gedung = DB::table('tbl_gedung')
            ->join('tbl_alamat', 'tbl_gedung.kode_alamat', '=', 'tbl_alamat.kode_alamat')
            ->join('regencies', 'regencies.id', '=', 'tbl_alamat.kota')
            ->select('tbl_gedung.*', 'regencies.name_kab')
            ->where('tbl_gedung.deleted_at', '!=', null)
            ->get();

            return view('admin.gedung-trash', ['gedung' => $gedung, 'g' => $g], ['user' => $user]);
     
        } else {
     
            return redirect("/home"); 
        }
    }

     // restore data gedung yang dihapus
    public function kembalikan($id_gedung)
    {
        $gedung = Gedung::onlyTrashed()->where('id_gedung',$id_gedung);
        $gedung->restore();
        
        return back()->withStatus(__('Building successfully restored.'));
    }

    // hapus permanen
    public function hapus_permanen($id_gedung)
    {
        // hapus permanen data gedung
        $gedung = Gedung::onlyTrashed()->where('id_gedung',$id_gedung);
        $gedung->forceDelete();

        $lantai = Lantai::onlyTrashed()->where('id_gedung',$id_gedung);
        $lantai->forceDelete();

        $rak = Rak::onlyTrashed()->where('id_gedung',$id_gedung);
        $rak->forceDelete();

        $perangkat = Perangkat::onlyTrashed()->where('id_gedung',$id_gedung);
        $perangkat->forceDelete();

        $port = Port::onlyTrashed()->where('id_gedung',$id_gedung);
        $port->forceDelete();
 
        return back()->withStatus(__('Building successfully deleted permanently.'));
    }

}
