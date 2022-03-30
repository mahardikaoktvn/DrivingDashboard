<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'golf_fnb.reservation';
    protected $fillable = ['id_reserv','id_tyreserv','id_course','id_holes','no_reserv','no_reserv_daily','date_booking','status_reserv','update_time','log_uid_ins','log_uid_upd','log_ts_ins','log_ts_upd','counterprint_startslip','counterprint_bill','id_program','type_reserv','course_name','holes_name','program_name'];
}
