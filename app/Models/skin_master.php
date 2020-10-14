<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB; // DB::enableQueryLog(); dd(DB::getQueryLog());

class skin_master extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'skin_master';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'skin_id';

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
  protected $fillable = ['skin_name', 'skin_color', 'skin_description', 'skin_img', 'status'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['created_at', 'updated_at'];

  /*
    * author : Tejas Soni
    * insert_data - insert records into table : skin_master
    * @param  - array of input records // Fields will be same as table column name        
    * @return : boolean
    */
  public function insert_data($inputs)
  {
    return self::create($inputs);
  }

  /*
    * author : Tejas Soni
    * list_all - get all table : skin_master records    
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
    * list_by_params - check dynamic where condition from controller table : skin_master 
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
    * update_records - update records into table : skin_master 
    * @param  - Update Array, ID to update
    * @return : boolean
    */
  public function update_records($udpate_data = array(), $where_check)
  {
    return self::where('skin_id', $where_check)->update($udpate_data);
  }

  /*
    * author : Tejas Soni
    * delete_bulk_records - Delete multiple : skin_master 
    * @param  - IDs Array [1,34,5]
    * @return : boolean
    */
  public function delete_bulk_records($delete_ids = array())
  {
    return self::whereIn('skin_id', $delete_ids)->delete();
  }



  /*
    * author : Tejas Soni
    * deleteRecords - Delete ID : skin_master 
    * @param  - ID
    * @return : boolean
    */
  public function deleteRecords($delete_id = "")
  {
    return self::where('skin_id', $delete_id)->delete();
  }

  /*
    * author : Tejas Soni
    * list_all - get record by id table : skin_master records    
    * @param  - None        
    * @return : array of all list records
    */
  public function get_recordby_Id($id = "")
  {
    $data = self::select('*')->where('skin_id', $id)->get();
    if (!empty($data)) {
      $data = $data->toArray();
    }
    return $data;
  }
}
