<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetilReservation extends Model
{
    protected $table = 'golf_fnb.detil_reservation';
    protected $fillable = ['code_ftime','id_tcust','id_reserv','tee_of_time','fname','surname','company','code_member','log_uid_ins','log_uid_upd','log_ts_ins','log_ts_upd'];
}
