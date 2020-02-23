<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class country_master extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'country_master';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'country_id';

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
    protected $fillable = ['sortname', 'name', 'phonecode', 'status'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['created_at', 'updated_at'];


}
