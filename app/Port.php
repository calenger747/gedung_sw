<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Port extends Model
{
    use SoftDeletes;

		protected $table = "tbl_port";

		protected $fillable = [
        	'id_gedung','id_lantai','id_rak','id_perangkat','nama_port','keterangan'
    	];

    protected $dates = ['deleted_at'];
}
