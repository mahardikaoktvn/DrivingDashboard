<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaidBy extends Model
{
    protected $table = 'golf_fnb.paid_by';
    protected $fillable = ['no_trans','paid_type','amount','code_no','holder','card_type','description','log_uid_ins','log_uid_upd','log_ts_ins','log_ts_upd','trans_status','ar_paid','ar_paid_cutoff','saldo_cutoff','amount_cutoff','set_bo','bank_trans','no_rek','ref_bank_trans','code_deposit'];
}
