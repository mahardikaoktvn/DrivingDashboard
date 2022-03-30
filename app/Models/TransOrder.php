<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransOrder extends Model
{
    protected $table = 'golf_fnb.trans_order';
    protected $fillable = ['id_torder','id_ref','no_trorder','date_torder','total_amount','log_uid_ins','log_uid_upd','log_ts_ins','log_ts_upd','trans_status','status'];
}
