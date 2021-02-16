<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rak extends Model
{
    use SoftDeletes;

		protected $table = "tbl_rak";

		protected $fillable = [
        	'id_gedung','id_lantai','nama_rak'
    	];

    protected $dates = ['deleted_at'];
}
