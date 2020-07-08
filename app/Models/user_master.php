<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB; // DB::enableQueryLog(); dd(DB::getQueryLog());

class user_master extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'user_master';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'id';

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
  protected $fillable = ['f_name', 'm_name', 'l_name', 'address', 'mobile', 'email', 'role_id', 'subscription_id', 'password', 'user_img', 'status'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['created_at', 'updated_at'];

  /*
    * author : Tejas Soni
    * insert_data - insert records into table : user_master
    * @param  - array of input records // Fields will be same as table column name        
    * @return : boolean
    */
  public function insert_data($inputs)
  {
    return self::create($inputs);
  }

  /*
    * author : Tejas Soni
    * list_all - get all table : user_master records    
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
    * list_all - get all table : user_master, role_master, subscription records    
    * @param  - None        
    * @return : array of all list records
    */
  public function list_all_join()
  {
    $data = self::selectRaw('`user_master`.`id` as `user_id`, CONCAT(`user_master`.`f_name`, " ", `user_master`.`l_name`) AS `full_name`, `user_master`.`address` AS `address`, `user_master`.`email` AS `email`, `user_master`.`mobile` AS `mobile`,`user_master`.`user_img` AS `user_img`,`user_master`.`status` AS `status`')
      ->selectRaw('`role_master`.`role_id` as `role_id`,`role_master`.`role_name` as `role_name`')
      ->selectRaw('`subscription_master`.`sub_id` as `sub_id`,`subscription_master`.`sub_name` as `sub_name`')
      ->leftJoin('role_master', 'user_master.role_id', '=', 'role_master.role_id')
      ->leftJoin('subscription_master', 'user_master.subscription_id', '=', 'subscription_master.sub_id')
      ->get();
    if (!empty($data)) {
      $data = $data->toArray();
    }
    return $data;
  }

  /*
    * author : Tejas Soni
    * list_by_params - check dynamic where condition from controller table : user_master 
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
    * update_records - update records into table : user_master 
    * @param  - Update Array, ID to update
    * @return : boolean
    */
  public function update_records($udpate_data = array(), $where_check)
  {
    return self::where('id', $where_check)->update($udpate_data);
  }

  /*
    * author : Tejas Soni
    * delete_bulk_records - Delete multiple : user_master 
    * @param  - IDs Array [1,34,5]
    * @return : boolean
    */
  public function delete_bulk_records($delete_ids = array())
  {
    return self::whereIn('id', $delete_ids)->delete();
  }



  /*
    * author : Tejas Soni
    * deleteRecords - Delete ID : user_master 
    * @param  - ID
    * @return : boolean
    */
  public function deleteRecords($delete_id = "")
  {
    return self::where('id', $delete_id)->delete();
  }
}
