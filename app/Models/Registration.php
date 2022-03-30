<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'golf_fnb.registration';
    protected $fillable = ['id_reg','id_customer','id_reserv','no_reg','time_reg','start_play','end_play','caddie_pref','golfcar_pref','status','log_uid_ins','log_uid_upd','log_ts_ins','log_ts_upd','id_program','program_name','note_reg','event_no','is_caddi_payung','is_follower','followers'];
}
