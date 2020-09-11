<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB; // DB::enableQueryLog(); dd(DB::getQueryLog());

class subscription_master extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'subscription_master';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'sub_id';

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
  protected $fillable = ['sub_name', 'sub_alias', 'plan_id', 'sub_description', 'status'];

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['created_at', 'updated_at'];


  /*
    * author : Tejas Soni
    * list_belongsTo - get all table : plan_master and discount master records    
    * @param  - None        
    * @return : array of all list records
    */
  public function list_belongsTo()
  {
    $data = self::selectRaw('`subscription_master`.`sub_id` as `sub_id`, `subscription_master`.`sub_name` AS `sub_name`, `subscription_master`.`sub_alias` AS `sub_alias`,`subscription_master`.`sub_description` AS `sub_description`, `subscription_master`.`status` AS `status`')
      ->selectRaw('`plan_master`.`plan_id` as `plan_id`,`plan_master`.`plan_name` AS `plan_name`,`plan_master`.`plan_description` AS `plan_description`,`plan_master`.`plan_amount` AS `plan_amount`')
      ->selectRaw('`discount_master`.`discount_id` as `discount_id`,`discount_master`.`discount_name` AS `discount_name`,`discount_master`.`discount_type` AS `discount_type`,`discount_master`.`amount` AS `discount_amount`,`discount_master`.`is_discount_validity` AS `is_discount_validity`,`discount_master`.`start_date` AS `discount_start_date`,`discount_master`.`end_date` AS `discount_end_date`')
      ->leftJoin('plan_master', 'subscription_master.plan_id', '=', 'plan_master.plan_id')
      ->leftJoin('discount_master', 'plan_master.discount_id', '=', 'discount_master.discount_id')
      ->get();
    if (!empty($data)) {
      $data = $data->toArray();
    }
    return $data;
  }
}
