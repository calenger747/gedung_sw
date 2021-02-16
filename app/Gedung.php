<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gedung extends Model
{
	use SoftDeletes;

		protected $table = "tbl_gedung";

		protected $fillable = [
        	'nama_gedung', 'koordinat', 'kontak', 'nama_kontak', 'jam_buka', 'jam_tutup', 'kunci', 'gambar', 'kode_alamat'
    	];

    protected $dates = ['deleted_at'];

    public function alamat()
    {
    	return $this->belongsTo('App\Alamat', 'kode_alamat', 'kode_alamat');
    }
}
