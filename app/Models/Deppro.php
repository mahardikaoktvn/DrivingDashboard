<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deppro extends Model
{
    protected $table = 'master_ma.deppro';
    protected $fillable = ['no','code','dsc','dorp','last_userid','last_updated','prefix_code','counter','prefix_sc_spb','prefix_sc_grn','prefix_sc_ise','prefix_sc_adjic','prefix_sc_adjdc','prefix_sc_trans','prefix_pur_pr','prefix_pur_po','prefix_pur_di','prefix_pur_prt','prefix_sc_spoil','prefix_sc_konsiyasi'];
}
