<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'golf_fnb.customers';
    protected $fillable = ['id_customer','id_tcust','id_mbrplay','ref_member','folio','fname','lname','address','mobile_phone','email','folio_open','log_uid_ins','log_uid_upd','log_ts_ins','log_ts_upd','cust_type','birthdate'];
}
