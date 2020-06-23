<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB; // DB::enableQueryLog(); dd(DB::getQueryLog());

class plan_master extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'plan_master';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'plan_id';

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
  protected $fillable = ['plan_name', 'plan_alias', 'plan_description', 'status'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['created_at', 'updated_at'];

  /*
    * author : Tejas Soni
    * insert_data - insert records into table : plan_master
    * @param  - array of input records // Fields will be same as table column name        
    * @return : boolean
    */
  public function insert_data($inputs)
  {
    return self::create($inputs);
  }

  /*
    * author : Tejas Soni
    * list_all - get all table : plan_master records    
    * @param  - None        
    * @return : array of all list records
    */
  public function list_all()
  {
    $data = self::select('*')->get();
    if (!empty($data)) {
      $data = $data->toArray();
    }
    return $data;
  }

  /*
    * author : Tejas Soni
    * list_by_params - check dynamic where condition from controller table : plan_master 
    * @param  - dynamic where conditions
    * @return : array of all list records
    */
  public function list_by_params($where_params = array())
  {
    if (is_array($where_params) && !empty($where_params)) {
      $data = self::select('*');
      foreach ($where_params as $column_name => $column_value) {
        $data->where($column_name, $column_value);
      }
    } else {
      $data = self::select('*')->get();
    }
    if (!empty($data)) {
      $data = $data->get();
    }
    return $data;
  }

  /*
    * author : Tejas Soni
    * update_records - update records into table : plan_master 
    * @param  - Update Array, ID to update
    * @return : boolean
    */
  public function update_records($udpate_data = array(), $where_check)
  {
    return self::where('plan_id', $where_check)->update($udpate_data);
  }

  /*
    * author : Tejas Soni
    * delete_bulk_records - Delete multiple : plan_master 
    * @param  - IDs Array [1,34,5]
    * @return : boolean
    */
  public function delete_bulk_records($delete_ids = array())
  {
    return self::whereIn('plan_id', $delete_ids)->delete();
  }



  /*
    * author : Tejas Soni
    * deleteRecords - Delete ID : plan_master 
    * @param  - ID
    * @return : boolean
    */
  public function deleteRecords($delete_id = "")
  {
    return self::where('plan_id', $delete_id)->delete();
  }
}
