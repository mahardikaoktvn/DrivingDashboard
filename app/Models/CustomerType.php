<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    protected $table = 'golf_fnb.customer_type';
    protected $fillable = ['id_tcust','code_tcust','cust_type','player','log_uid_ins','log_uid_upd','log_ts_ins','log_ts_upd','sort_order'];
}
