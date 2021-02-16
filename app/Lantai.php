<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lantai extends Model
{
    use SoftDeletes;

		protected $table = "tbl_lantai";

		protected $fillable = [
        	'id_gedung','nama_lantai'
    	];

    protected $dates = ['deleted_at'];
}
