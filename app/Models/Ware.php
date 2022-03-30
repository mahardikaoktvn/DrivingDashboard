<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ware extends Model
{
    protected $table = 'master_ma.ware';
    protected $fillable = ['no','wno','dsc','last_updated','last_userid','dept_code','dept_code_item','arcashier','ware_group','complementary'];
}
