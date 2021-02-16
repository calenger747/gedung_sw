<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alamat extends Model
{
	use SoftDeletes;

		protected $table = "tbl_alamat";

		protected $fillable = [
        	 'kode_alamat', 'alamat', 'provinsi', 'kota', 'kecamatan', 'kelurahan', 'kode_pos',
    	];

    protected $dates = ['deleted_at'];

    public function gedung()
    {
    	return $this->hasOne('App\Gedung', 'kode_alamat', 'id');
    }

}
