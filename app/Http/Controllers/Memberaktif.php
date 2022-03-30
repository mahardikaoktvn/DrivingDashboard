<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Memberaktif extends Controller
{
    // member aktif
    function active_member(Request $request){
        $this->validate($request, [
            'startDate'  =>  'required|date',
            'endDate'    =>  'required|date|after_or_equal:start_date'
        ]);

        $member = DB::select("select a.nama, count(a.amount) as jumlah from (
                            select od.name_customer as nama, count(coalesce(ol.dpp_orderlist,0)) as amount 
                            from golf_fnb.order_list ol
                            left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                            inner join master_ma.ware wr on wr.wno=ol.wno
                            inner join master_ma.deppro dp on wr.dept_code = dp.code
                            where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and ol.name LIKE '%Member'
                            group by ol.code_item, nama ,ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                            order by nama asc
                            ) as a

                            group by nama
                            order by count(a.amount) desc
                            fetch first 10 rows only");

        return view('layouts.main', compact('member'));
    }
}
