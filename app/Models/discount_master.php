<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB; // DB::enableQueryLog(); dd(DB::getQueryLog());

class discount_master extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'discount_master';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'discount_id';

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
  protected $fillable = ['discount_name', 'discount_description', 'discount_type', 'amount', 'is_discount_validity', 'start_date', 'end_date', 'status'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['created_at', 'updated_at'];

  /*
    * author : Tejas Soni
    * insert_data - insert records into table : discount_master
    * @param  - array of input records // Fields will be same as table column name        
    * @return : boolean
    */
  public function insert_data($inputs)
  {
    return self::create($inputs);
  }

  /*
    * author : Tejas Soni
    * list_all - get all table : discount_master records    
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
    * list_active_all - get all table : discount_master active records    
    * @param  - None        
    * @return : array of all active list records
    */
    public function list_active_all()
    {
      $data = self::select('*')->where('status',1)->get();
      if (!empty($data)) {
        $data = $data->toArray();
      }
      return $data;
    }

  /*
    * author : Tejas Soni
    * list_by_params - check dynamic where condition from controller table : discount_master 
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
    * update_records - update records into table : discount_master 
    * @param  - Update Array, ID to update
    * @return : boolean
    */
  public function update_records($udpate_data = array(), $where_check)
  {
    return self::where('discount_id', $where_check)->update($udpate_data);
  }

  /*
    * author : Tejas Soni
    * delete_bulk_records - Delete multiple : discount_master 
    * @param  - IDs Array [1,34,5]
    * @return : boolean
    */
  public function delete_bulk_records($delete_ids = array())
  {
    return self::whereIn('discount_id', $delete_ids)->delete();
  }



  /*
    * author : Tejas Soni
    * deleteRecords - Delete ID : discount_master 
    * @param  - ID
    * @return : boolean
    */
  public function deleteRecords($delete_id = "")
  {
    return self::where('discount_id', $delete_id)->delete();
  }

  /*
    * author : Tejas Soni
    * getRecordById - Discount ID : discount_master 
    * @param  - ID
    * @return : get one row list object
    */
  public function getRecordById($id = "")
  {
    $data = self::selectRaw('*');
    $data->selectRaw("DATE_FORMAT(start_date, '%d/%m/%Y') as startDate, DATE_FORMAT(end_date, '%d/%m/%Y') as endDate");
    $data->where('discount_id', $id);
    if (!empty($data)) {
      $data = $data->first();
    }
    return $data;
  }
}
