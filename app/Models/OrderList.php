<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    protected $table = 'golf_fnb.order_list';
    protected $fillable = ['id_ref','id_item','qty','price','tax_orderlist','disc_orderlist','subtotal','note_item','unit_id','unit_code','processed','log_uid_ins','log_uid_upd','log_ts_ins','log_ts_upd','wno','code_item','name','in_tax_orderlist','catno','dpp_orderlist','tax_status','disc_status','sale_code','tax_percent','disc_percent','no_urut','row_id','status_item','txtcoupon','iscouponused','iswestern','is_cancel'];
}
