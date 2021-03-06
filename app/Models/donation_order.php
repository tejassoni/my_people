<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB; // DB::enableQueryLog(); dd(DB::getQueryLog());

class donation_order extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'donation_order';

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
  protected $fillable = ['order_id', 'user_id', 'subscription_id', 'payment_id', 'payment_request_id', 'payment_method', 'payment_mode', 'payment_currency', 'qty', 'total_amount', 'payment_status', 'payment_received', 'cart_data', 'payment_date', 'bank_name', 'status'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['created_at', 'updated_at'];

  /*
    * author : Tejas Soni
    * insert_data - insert records into table : donation_order
    * @param  - array of input records // Fields will be same as table column name        
    * @return : boolean
    */
  public function insert_data($inputs)
  {
    return self::create($inputs);
  }

  /*
    * author : Tejas Soni
    * list_all - get all table : donation_order records    
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
    * list_active_all - get all table : donation_order active records    
    * @param  - None        
    * @return : array of all active list records
    */
  public function list_active_all()
  {
    $data = self::select('*')->where('status', 1)->get();
    if (!empty($data)) {
      $data = $data->toArray();
    }
    return $data;
  }

  /*
    * author : Tejas Soni
    * list_by_params - check dynamic where condition from controller table : donation_order 
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
    * update_records - update records into table : donation_order 
    * @param  - Update Array, ID to update
    * @return : boolean
    */
  public function update_records($udpate_data = array(), $where_check)
  {
    return self::where('order_id', $where_check)->update($udpate_data);
  }

  /*
    * author : Tejas Soni
    * delete_bulk_records - Delete multiple : donation_order 
    * @param  - IDs Array [1,34,5]
    * @return : boolean
    */
  public function delete_bulk_records($delete_ids = array())
  {
    return self::whereIn('order_id', $delete_ids)->delete();
  }



  /*
    * author : Tejas Soni
    * deleteRecords - Delete ID : donation_order 
    * @param  - ID
    * @return : boolean
    */
  public function deleteRecords($delete_id = "")
  {
    return self::where('order_id', $delete_id)->delete();
  }

  /*
    * author : Tejas Soni
    * getRecordById - Discount ID : donation_order 
    * @param  - ID
    * @return : get one row list object
    */
  public function getRecordById($id = "")
  {
    $data = self::selectRaw('*');
    $data->selectRaw("DATE_FORMAT(start_date, '%d/%m/%Y') as startDate, DATE_FORMAT(end_date, '%d/%m/%Y') as endDate");
    $data->where('order_id', $id);
    if (!empty($data)) {
      $data = $data->first();
    }
    return $data;
  }
}
