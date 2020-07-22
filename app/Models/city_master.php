<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class city_master extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'city_master';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'city_id';

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
    protected $fillable = ['name', 'state_id', 'status'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['created_at', 'updated_at'];

    /*
    * author : Tejas Soni
    * list_all - get record by id table : city_master records    
    * @param  - None        
    * @return : array of all list records
    */
    public function get_recordby_Id($id = "")
    {
        $data = self::select('*')->where('state_id', $id)->get();
        if (!empty($data)) {
            $data = $data->toArray();
        }
        return $data;
    }
}
