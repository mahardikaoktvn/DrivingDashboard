<?php
// need to simplify query
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use DatePeriod;
use DateInterval;
class OmzetController extends Controller

{
    function getDayPeriod($startDate, $endDate)
    {
        $array = array();
        $period = new DatePeriod(
        new DateTime($startDate),
        new DateInterval('P1D'),
        new DateTime($endDate)
        );

        foreach ($period as $date) {
            $array[] = $date->format('Y-m-d');
        }
        return $array;
    }

    function getMonthPeriod($startDate, $endDate)
    {
        $array = array();
        $period = new DatePeriod(
        new DateTime($startDate),
        new DateInterval('P1M'),
        new DateTime($endDate)
        );

        foreach ($period as $date) {
            $array[] = $date->format('Y-m');
        }
        return $array;
    }


    function formatOmzet($period, $data)
    {
        $array = array();
        for ($i = 0; $i < count($period); $i++) {
            $array[$i]['tanggal'] = $period[$i];
            $array[$i]['jumlah'] = 0;
            for ($j = 0; $j < count($data); $j++) {
                if ($period[$i] == $data[$j]['tanggal']) {
                    $array[$i]['jumlah'] = $data[$j]['jumlah'];
                }
            }
        }

        return $array;
    }

    // omzet ytd
    function ytd_omzet(Request $request){
        $this->validate($request, [
            'startDate'  =>  'required|date',
            'endDate'    =>  'required|date|after_or_equal:start_date'
        ]);

        $member = DB::select("select to_char(a.tanggal, 'YYYY') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('year', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and (ol.name LIKE '%Member' or ol.name LIKE '%member')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");

        $guest = DB::select("select to_char(a.tanggal, 'YYYY') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('year', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and (ol.name LIKE '%Guest' or ol.name LIKE '%guest')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");
                        
        $total = DB::select("select to_char(a.tanggal, 'YYYY') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('year', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and (ol.name LIKE '%Member' or ol.name LIKE '%Guest' or ol.name LIKE '%member' or ol.name LIKE '%guest')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");
                    
        return response()->json([
            'member' => $member,
            'guest' => $guest,
            'total' => $total,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    // omzet mtd
    function mtd_omzet(Request $request){
        $this->validate($request, [
            'startDate'  =>  'required|date',
            'endDate'    =>  'required|date|after_or_equal:start_date'
        ]);

        $member = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and ol.name LIKE '%Member'
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");

        $guest = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and ol.name LIKE '%Guest'
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");
                        
        $total = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and (ol.name LIKE '%Member' or ol.name LIKE '%Guest')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");
                    
        return response()->json([
            'member' => $member,
            'guest' => $guest,
            'total' => $total,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    //omzet tdy
    function tdy_omzet(Request $request){
        $this->validate($request, [
            'startDate'  =>  'required|date',
            'endDate'    =>  'required|date|after_or_equal:start_date'
        ]);
    
        $member = DB::select("select a.tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('day', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and ol.name LIKE '%Member'
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a
    
                        group by a.tanggal
                        order by a.tanggal asc");
    
        $guest = DB::select("select a.tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('day', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and ol.name LIKE '%Guest'
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a
    
                        group by a.tanggal
                        order by a.tanggal asc");
                        
        $total = DB::select("select a.tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('day', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and (ol.name LIKE '%Member' or ol.name LIKE '%Guest')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a
    
                        group by a.tanggal
                        order by a.tanggal asc");
                    
        return response()->json([
            'member' => $member,
            'guest' => $guest,
            'total' => $total,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    function ytd_omzet_zt(Request $request){
        $this->validate($request, [
            'startDate'  =>  'required|date',
            'endDate'    =>  'required|date|after_or_equal:start_date'
        ]);

        $zt1 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('year', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '05:00:00.000000' and '12:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");

        $zt2 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('year', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '12:00:00.000001' and '16:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");


        $zt3 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('year', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '16:00:00.000001' and '20:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");
    
        $total = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('year', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '05:00:00.000000' and '20:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");

        return response()->json([
            'zt1' => $zt1,
            'zt2' => $zt2,
            'zt3' => $zt3,
            'total' => $total,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    //omzet mtd zt
    function mtd_omzet_zt(Request $request){
        $this->validate($request, [
            'startDate'  =>  'required|date',
            'endDate'    =>  'required|date|after_or_equal:start_date'
        ]);

        $zt1 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '05:00:00.000000' and '12:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");

        $zt2 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '12:00:00.000001' and '16:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");


        $zt3 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '16:00:00.000001' and '20:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");
    
        $total = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '05:00:00.000000' and '20:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");

        return response()->json([
            'zt1' => $zt1,
            'zt2' => $zt2,
            'zt3' => $zt3,
            'total' => $total,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    //omzet today zt
    function tdy_omzet_zt(Request $request){
        $this->validate($request, [
            'startDate'  =>  'required|date',
            'endDate'    =>  'required|date|after_or_equal:start_date'
        ]);

        $zt1 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('day', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '05:00:00.000000' and '12:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");

        $zt2 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('day', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '12:00:00.000001' and '16:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");


        $zt3 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('day', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '16:00:00.000001' and '20:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");
    
        $total = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('day', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '05:00:00.000000' and '20:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");

        return response()->json([
            'zt1' => $zt1,
            'zt2' => $zt2,
            'zt3' => $zt3,
            'total' => $total,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    // omzet bulanan zt
    function monthly_zt(Request $request){
        $this->validate($request, [
            'startDate'  =>  'required|date',
            'endDate'    =>  'required|date|after_or_equal:start_date'
        ]);

        $zt1 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '05:00:00.000000' and '12:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");

        $zt2 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '12:00:00.000001' and '16:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");


        $zt3 = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '16:00:00.000001' and '20:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");
    
        $total = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                        select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                        from golf_fnb.order_list ol
                        left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                        inner join master_ma.ware wr on wr.wno=ol.wno
                        inner join master_ma.deppro dp on wr.dept_code = dp.code
                        where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' AND (cast(od.date_ref as time) between '05:00:00.000000' and '20:00:00.000000')
                        group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                        order by tanggal asc
                        ) as a

                        group by a.tanggal
                        order by a.tanggal asc");
                        
        $period = $this->getMonthPeriod($request->startDate, $request->endDate);
        $zt1 = $this->formatOmzet($period, json_decode(json_encode($zt1), true));
        $zt2 = $this->formatOmzet($period, json_decode(json_encode($zt2), true));
        $zt3 = $this->formatOmzet($period, json_decode(json_encode($zt3), true));
        $total = $this->formatOmzet($period, json_decode(json_encode($total), true));

        return response()->json([
            'zt1' => $zt1,
            'zt2' => $zt2,
            'zt3' => $zt3,
            'total' => $total,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    // omzet bulanan ZT1
    function monthly_zt1(Request $request){
        $this->validate($request, [
            'startDate'  =>  'required|date',
            'endDate'    =>  'required|date|after_or_equal:start_date'
        ]);

        $member = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                            select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                            from golf_fnb.order_list ol
                            left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                            inner join master_ma.ware wr on wr.wno=ol.wno
                            inner join master_ma.deppro dp on wr.dept_code = dp.code
                            where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= date('$request->startDate') and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and ol.name LIKE '%Member' AND (cast(od.date_ref as time) between '05:00:00.000000' and '12:00:00.000000')
                            group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                            order by tanggal asc
                            ) as a

                            group by a.tanggal
                            order by a.tanggal asc");

        $guest = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                            select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                            from golf_fnb.order_list ol
                            left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                            inner join master_ma.ware wr on wr.wno=ol.wno
                            inner join master_ma.deppro dp on wr.dept_code = dp.code
                            where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and ol.name LIKE '%Guest' AND (cast(od.date_ref as time) between '05:00:00.000000' and '12:00:00.000000')
                            group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                            order by tanggal asc
                            ) as a

                            group by a.tanggal
                            order by a.tanggal asc");

        $total = DB::select("select to_char(a.tanggal, 'YYYY-MM') as tanggal, sum(a.amount) as jumlah from (
                            select date_trunc('month', od.date_ref) as tanggal, sum(coalesce(ol.dpp_orderlist,0)) as amount 
                            from golf_fnb.order_list ol
                            left join golf_fnb.order_ref od on od.id_ref=ol.id_ref
                            inner join master_ma.ware wr on wr.wno=ol.wno
                            inner join master_ma.deppro dp on wr.dept_code = dp.code
                            where od.trans_status='CLOSE' and coalesce(od.status,'') != 'CANCELED' and coalesce(od.status,'')='' and date(od.date_ref) >= '$request->startDate' and date(od.date_ref) <= '$request->endDate' and dp.code='420' AND wr.wno='03' and (ol.name LIKE '%Member' or ol.name LIKE '%Guest') AND (cast(od.date_ref as time) between '05:00:00.000000' and '12:00:00.000000')
                            group by ol.code_item, tanggal, ol.name, ol.wno, ol.price, coalesce(ol.unit_code,''), wr.ware_group
                            order by tanggal asc
                            ) as a

                            group by a.tanggal
                            order by a.tanggal asc");
        
        $period = $this->getMonthPeriod($request->startDate, $request->endDate);
        $member = $this->formatOmzet($period, json_decode(json_encode($member), true));
        $guest = $this->formatOmzet($period, json_decode(json_encode($guest), true));
        $total = $this->formatOmzet($period, json_decode(json_encode($total), true));
                    
        return response()->json([
            'period' => $period,
            'member' => $member,
            'guest' => $guest,
            'total' => $total,
        ], 200, [], JSON_PRETTY_PRINT);
    }

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

        return response()->json([         
            'member' => $member,
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
