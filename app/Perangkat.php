<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perangkat extends Model
{
    use SoftDeletes;

		protected $table = "tbl_perangkat";

		protected $fillable = [
        	'id_gedung','id_lantai','id_rak','id_jenis','nama_perangkat'
    	];

    protected $dates = ['deleted_at'];
}
