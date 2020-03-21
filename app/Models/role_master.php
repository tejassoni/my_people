<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class role_master extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role_master';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'role_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_name', 'role_alias', 'role_description','status'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['created_at', 'updated_at'];


    public function insert_data($inputs) {
		return self::create($inputs);
	}

}
