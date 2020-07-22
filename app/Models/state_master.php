<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class state_master extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'state_master';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'state_id';

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
    protected $fillable = ['name', 'country_id', 'status'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['created_at', 'updated_at'];

    /*
    * author : Tejas Soni
    * list_all - get record by id table : state_master records    
    * @param  - None        
    * @return : array of all list records
    */
    public function get_recordby_Id($id = "")
    {
        $data = self::select('*')->where('country_id', $id)->get();
        if (!empty($data)) {
            $data = $data->toArray();
        }
        return $data;
    }
}
