<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB; // DB::enableQueryLog(); dd(DB::getQueryLog());

class missing_person extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'missing_person';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'missing_id';

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
  protected $fillable = ['missing_person_img', 'f_name', 'm_name', 'l_name', 'height', 'weight', 'gender', 'birth_date', 'age', 'address', 'country_id', 'state_id', 'city_id', 'pincode', 'missed_date', 'user_id', 'hair_id', 'eye_id', 'eye_brow_id', 'lip_id', 'jaw_id', 'skin_id', 'ear_id', 'nose_id', 'remark', 'cloth_description', 'currency_id', 'amount', 'is_found', 'status'];

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
    $data = self::select('*')->where('status', 1)->get();
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
    * list_belongsTo - get all table : missing_master and user_master records    
    * @param  - None        
    * @return : array of all list records
    */
  public function list_belongsTo()
  {
    $data = self::selectRaw('`missing_person`.`missing_id` as `missing_id`, CONCAT(missing_person.f_name," ",missing_person.l_name) AS `missing_full_name`, `missing_person`.`age` AS `age`, `missing_person`.`missing_person_img` as `missing_person_img`, DATE_FORMAT(missed_date, "%d/%m/%Y") as missing_date,CONCAT(country_master.name,", ",state_master.name,", ",city_master.name,", ",missing_person.pincode) AS `location`')
      ->selectRaw('`user_master`.`id` as `user_id`,CONCAT(user_master.f_name," ",user_master.l_name) AS `parent_full_name`,`user_master`.`mobile` as `parent_mobile`,`user_master`.`email` as `parent_email`')
      ->selectRaw('`country_master`.`country_id` as `country_id`,`country_master`.`name` as `country_name`')
      ->selectRaw('`state_master`.`country_id` as `state_id`,`state_master`.`name` as `state_name`')
      ->selectRaw('`city_master`.`city_id` as `city_id`,`city_master`.`name` as `city_name`')
      ->leftJoin('user_master', 'missing_person.user_id', '=', 'user_master.id')
      ->leftJoin('country_master', 'missing_person.country_id', '=', 'country_master.country_id')
      ->leftJoin('state_master', 'missing_person.state_id', '=', 'state_master.state_id')
      ->leftJoin('city_master', 'missing_person.city_id', '=', 'city_master.city_id')
      ->where('missing_person.status', 1)
      ->where('missing_person.is_found', 0)
      ->get();
    if (!empty($data)) {
      $data = $data->toArray();
    }
    return $data;
  }

  /*
    * author : Tejas Soni
    * list_belongsTo - get all table : missing_master and user_master records    
    * @param  - None        
    * @return : array of all list records
    */
  public function list_belongsToSearch($PostData = array())
  {
    // DB::enableQueryLog();
    $data = self::selectRaw('`missing_person`.`missing_id` as `missing_id`, CONCAT(missing_person.f_name," ",missing_person.l_name) AS `missing_full_name`, `missing_person`.`age` AS `age`, `missing_person`.`missing_person_img` as `missing_person_img`, DATE_FORMAT(missed_date, "%d/%m/%Y") as missing_date,CONCAT(country_master.name,", ",state_master.name,", ",city_master.name,", ",missing_person.pincode) AS `location`')
      ->selectRaw('`user_master`.`id` as `user_id`,CONCAT(user_master.f_name," ",user_master.l_name) AS `parent_full_name`,`user_master`.`mobile` as `parent_mobile`,`user_master`.`email` as `parent_email`')
      ->selectRaw('`country_master`.`country_id` as `country_id`,`country_master`.`name` as `country_name`')
      ->selectRaw('`state_master`.`country_id` as `state_id`,`state_master`.`name` as `state_name`')
      ->selectRaw('`city_master`.`city_id` as `city_id`,`city_master`.`name` as `city_name`')
      ->leftJoin('user_master', 'missing_person.user_id', '=', 'user_master.id')
      ->leftJoin('country_master', 'missing_person.country_id', '=', 'country_master.country_id')
      ->leftJoin('state_master', 'missing_person.state_id', '=', 'state_master.state_id')
      ->leftJoin('city_master', 'missing_person.city_id', '=', 'city_master.city_id')
      ->where('missing_person.status', 1)
      ->where('missing_person.is_found', 0);
    if (isset($PostData) && !empty($PostData)) {

      if (isset($PostData['missed_date']) && !empty($PostData['missed_date'])) {
        $data =  $data->whereBetween('missing_person.missed_date', [$PostData['missed_date']['start'], $PostData['missed_date']['end']]);
      }

      if (isset($PostData['full_name']) && !empty($PostData['full_name'])) {
        $data =  $data->where(function ($query) use ($PostData) {
          $query->where('missing_person.f_name', 'like', '%' . $PostData['full_name'] . '%')
            ->orWhere('missing_person.m_name', 'like', '%' . $PostData['full_name'] . '%')
            ->orWhere('missing_person.l_name', 'like', '%' . $PostData['full_name'] . '%');
        });
      }
      if (isset($PostData['gender']) && !empty($PostData['gender']) && $PostData['gender'] != "all") {
        $data =  $data->where('missing_person.gender', $PostData['gender']);
      }
      if (isset($PostData['age']) && !empty($PostData['age'])) {
        $data =  $data->where('missing_person.age', $PostData['age']);
      }
      if (isset($PostData['country_id']) && !empty($PostData['country_id']) && $PostData['country_id'] != "Select Country") {
        $data =  $data->where('missing_person.country_id', $PostData['country_id']);
      }
      if (isset($PostData['state_id']) && !empty($PostData['state_id']) && $PostData['state_id'] != "Select State") {
        $data =  $data->where('missing_person.state_id', $PostData['state_id']);
      }
      if (isset($PostData['city_id']) && !empty($PostData['city_id']) && $PostData['city_id'] != "Select City") {
        $data =  $data->where('missing_person.city_id', $PostData['city_id']);
      }
    }
    $data =  $data->get();
    // dd(DB::getQueryLog());
    if (!empty($data)) {
      $data = $data->toArray();
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
    * list_all - get record by id table : city_master records    
    * @param  - None        
    * @return : array of all list records
    */
  public function get_recordby_Id($id = "")
  {
    $data = self::select('*')->where('missing_id', $id)->get();
    if (!empty($data)) {
      $data = $data->toArray();
    }
    return $data;
  }

  /*
    * author : Tejas Soni
    * list_belongsTo - get all table : missing_master and user_master records    
    * @param  - None        
    * @return : array of all list records
    */
  public function list_belongsToBy_id($missing_id = "")
  {
    $data = self::selectRaw('`missing_person`.`missing_id` as `missing_id`,`missing_person`.`amount` as `amount`,`missing_person`.`age` as `missing_age`,`missing_person`.`cloth_description` as `cloth_description`,`missing_person`.`remark` as `remark`,`missing_person`.`height` as `missing_height`,`missing_person`.`weight` as `missing_weight`,`missing_person`.`pincode` as `pincode`, CONCAT(missing_person.f_name," ",missing_person.l_name) AS `missing_full_name`, `missing_person`.`age` AS `age`, `missing_person`.`missing_person_img` as `missing_person_img`, DATE_FORMAT(missed_date, "%d/%m/%Y") as missing_date,`missing_person`.`address` as `missing_address`,`missing_person`.`gender` as `missing_gender`,DATE_FORMAT(birth_date, "%d/%m/%Y") as birth_date')
      ->selectRaw('`user_master`.`id` as `user_id`,`user_master`.`address` as `parent_address`,CONCAT(user_master.f_name," ",user_master.l_name) AS `parent_full_name`,`user_master`.`mobile` as `parent_mobile`,`user_master`.`email` as `parent_email`')
      ->selectRaw('`country_master`.`country_id` as `country_id`,`country_master`.`name` as `country_name`')
      ->selectRaw('`state_master`.`country_id` as `state_id`,`state_master`.`name` as `state_name`')
      ->selectRaw('`city_master`.`city_id` as `city_id`,`city_master`.`name` as `city_name`')
      ->selectRaw('`jaw_master`.`jaw_id` as `jaw_id`,`jaw_master`.`jaw_img` as `jaw_img`')
      ->selectRaw('`skin_master`.`skin_id` as `skin_id`,`skin_master`.`skin_img` as `skin_img`')
      ->selectRaw('`ear_master`.`ear_id` as `ear_id`,`ear_master`.`ear_img` as `ear_img`')
      ->selectRaw('`hair_master`.`hair_id` as `hair_id`,`hair_master`.`hair_img` as `hair_img`')
      ->selectRaw('`nose_master`.`nose_id` as `nose_id`,`nose_master`.`nose_img` as `nose_img`')
      ->selectRaw('`eye_brow_master`.`eye_brow_id` as `eye_brow_id`,`eye_brow_master`.`eye_brow_img` as `eye_brow_img`')
      ->selectRaw('`eye_master`.`eye_id` as `eye_id`,`eye_master`.`eye_img` as `eye_img`')
      ->selectRaw('`lip_master`.`lip_id` as `lip_id`,`lip_master`.`lip_img` as `lip_img`')
      ->selectRaw('`currency_master`.`currency_id` as `currency_id`,`currency_master`.`symbol` as `symbol`')
      ->leftJoin('user_master', 'missing_person.user_id', '=', 'user_master.id')
      ->leftJoin('country_master', 'missing_person.country_id', '=', 'country_master.country_id')
      ->leftJoin('state_master', 'missing_person.state_id', '=', 'state_master.state_id')
      ->leftJoin('city_master', 'missing_person.city_id', '=', 'city_master.city_id')
      ->leftJoin('ear_master', 'missing_person.ear_id', '=', 'ear_master.ear_id')
      ->leftJoin('jaw_master', 'missing_person.jaw_id', '=', 'jaw_master.jaw_id')
      ->leftJoin('hair_master', 'missing_person.hair_id', '=', 'hair_master.hair_id')
      ->leftJoin('skin_master', 'missing_person.skin_id', '=', 'skin_master.skin_id')
      ->leftJoin('nose_master', 'missing_person.nose_id', '=', 'nose_master.nose_id')
      ->leftJoin('eye_brow_master', 'missing_person.eye_brow_id', '=', 'eye_brow_master.eye_brow_id')
      ->leftJoin('eye_master', 'missing_person.eye_id', '=', 'eye_master.eye_id')
      ->leftJoin('lip_master', 'missing_person.lip_id', '=', 'lip_master.lip_id')
      ->leftJoin('currency_master', 'missing_person.currency_id', '=', 'currency_master.currency_id')
      ->where('missing_person.missing_id', $missing_id)
      ->where('missing_person.status', 1)
      ->where('missing_person.is_found', 0)
      ->get();
    if (!empty($data)) {
      $data = $data->toArray();
    }
    return $data;
  }
}
