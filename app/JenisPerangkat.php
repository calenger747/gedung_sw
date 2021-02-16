<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisPerangkat extends Model
{
	use SoftDeletes;

    	protected $table = "tbl_jenis";

    	protected $fillable = [
        	'nama'
    	];

    protected $dates = ['deleted_at'];

}
