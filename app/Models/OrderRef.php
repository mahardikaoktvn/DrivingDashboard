<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class OrderRef extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'golf_fnb.order_ref';

    /**
     * @var array
     */
    protected $fillable = ['id_ref', 'no_ref', 'name_customer', 'num_person', 'waitress', 'table_room', 'date_ref', 'grand_total', 'grand_disc', 'grand_tax', 'cashier', 'shift', 'status_order', 'note_order', 'num_of_print', 'id_outlet', 'wno', 'employee_name', 'id_logcashier', 'status', 'processed', 'is_cust', 'pid', 'log_uid_ins', 'log_uid_upd', 'log_ts_ins', 'log_ts_upd', 'folio_no', 'id_program', 'trans_status', 'grand_in_tax', 'grand_dpp', 'tax_percent', 'disc_percent', 'name_program', 'folio_to', 'id_logcashier_paid', 'id_cost_trans', 'eventname', 'event_no', 'status_kitchen', 'status_printed', 'grand_sc', 'grand_pb1'];

}
