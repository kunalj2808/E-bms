




<!DOCTYPE html>
<html>
<head>
<title>XYZ</title>
<style>
    body{
        font-family: arial, helvetica;
    }

   


.container5{
    background: #eee;
    /* width: 900px;
    margin: 0px 0 0 50px; */
    grid-template-columns: 150px 200px;
     display: grid;
     grid-template-columns: 230px 250px 300px 170px 100px;
          /* grid-template-rows:30px 30px 30px 30px 30px ; */

}

.container1{
    background: #eee;
    /* width: 900px; */
    /* margin: 0px 0 0 50px; */
    grid-template-columns: 150px 200px;
     display: grid;
     grid-template-columns: 215px 265px 300px 170px 100px;
     grid-template-rows:30px 30px 30px 30px 30px ;

}
.items1{
    background-color: white;
    padding: 5px;
    border: 1px solid black;
    }
    .items9{
        grid-row: 1/7;
        background-color: white;
          border: 1px solid black;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        
      }
      .container7{
        background :#eee;
        /* width:900px; */
        /* margin:0px 0 0 0px; */
        display:grid;
        grid-template-columns:215px 265px 300px 85.3px 85.3px 99.3px;;
        /* margin-left:50px; */
    }
    .container3{
        background: #eee;
        /* width: 900px; */
        /* margin: 0px 0 0 50px; */
        grid-template-columns: 150px 200px;
         display: grid;
         grid-template-columns: 215px 145px 120px 100.5px 68.5px 65.5px 65.5px 86.3px 83.3px 100.3px;
         grid-template-rows: 35px 35px 30px;
 
    }
    .container4{
        background: #eee;
        width: 900px;
        /* margin: 0px 0 0 50px;
        grid-template-columns: 150px 200px; */
         display: grid;
         grid-template-columns:215px 365px 135px 335px;
         grid-template-rows:30px 30px 30px ;

    }
</style>

<div class="container5">
    <div class="items items9" style="grid-row: 1/6;grid-column:1/3"><h1 style="text-align: center;">{{Auth::user()->company_name}}</h1> </div>
     <div class="items items1" style="grid-column:3/4">REPORTING MONTH</div>
    <div class="items items1" style="grid-column:4/6;">{{ \Carbon\Carbon::createFromFormat('Y-m', $bill->reporting_month)->format('Y - F') }}</div>
     <div class="items items1" style="font-size:13px;grid-column:3/4">TOTAL AMOUNT PAYABLE TILL DUE DATE</div>
    <div class="items items1">{{$bill->bill_date}}</div>
    <div class="items items1">{{round($calculation->total_energy_bill)}}</div>
    <div class="items items1" style="font-size:13px;grid-column:3/4">TOTAL AMOUNT PAYABLE AFTER DUE DATE</div>
    <div class="items items1">{{$bill->bill_due_date}}</div>
    <div class="items items1">{{round($calculation->total_energy_bill + $calculation->lateFees)}}</div>  
    
</div>



<div class="container1">
    <div class="items items9" style="grid-row: 1/5;grid-column:1/3;"><h3 style="text-align: center;">Sirol Road,Gwalior</h3></div>
    <div class="items items1" style="grid-row:1/5;">TARIFF GRID</div>
    <div class="items items1">UPTO 50</div>
    <div class="items items1">{{$general_tariff_range->upto_50}}</div>
    <div class="items items1">UPTO 50-150</div>
    <div class="items items1">{{$general_tariff_range->upto_50_150}}</div>
    <div class="items items1">UPTO 150-300</div>
    <div class="items items1">{{$general_tariff_range->upto_150_300}}</div>
    <div class="items items1">ABOVE 300</div>
    <div class="items items1">{{$general_tariff_range->above_300}}</div>
    <div class="items items1">FLAT NO.</div>
    <div class="items items1">C-203</div>
    <div class="items items1" style="grid-column:3/4">TARIFF DG</div>
    <div class="items items1" style="grid-column:4/6;">RS. {{$general_setting['tariff_dg']}}/UNIT</div>
    <div class="items items1">METER NO.</div>
    <div class="items items1"></div>
    <div class="items items1" style="font-size:13px;grid-column:3/4">SERVICE TAX ON GRID CONSUMPTION</div>
    <div class="items items1"style="grid-column:4/6;">{{$general_setting['service_tax_dg']}}%</div>
    <div class="items items1">NAME</div>
    <div class="items items1">{{$consumer_details->consumer_name}}</div>
    <div class="items items1" style="grid-column:3/4">PREVIOUS READING DATE</div>
    <div class="items items1"style="grid-column:4/6;">{{$previous_bill->bill_date}}</div>
    <div class="items items1">SUPPLY AT</div>
    <div class="items items1">{{$consumer_details->supply_at}}</div>
    <div class="items items1" style="grid-column:3/4">CURRENT READING DATE</div>
    <div class="items items1"style="grid-column:4/6;">{{$bill->bill_date}}</div>
</div>

<div class="container7">
    <div class="items items1">REMARKS</div>
    <div class="items items1">{{$consumer_details->remarks}}</div>
    <div class="items items1" >PRESCRIBED LOAD (KW) FIXED AMOUNT</div>
    <div class="items items1">5.00</div>
    <div class="items items1"></div>
    <div class="items items1">RS 0.00</div>
</div>
<div class="container3">
    <div class="items items1" style="grid-row:1/3;color:red;">COSMO VALLY</div>
    <div class="items items1" style="grid-row:1/3;color:red;">PRESENTING READING</div>
    <div class="items items1" style="grid-row:1/3;color:red;">PREVIOUS READING</div>
    <div class="items items1" style="grid-row:1/3; color:red;">consumption<br>(units)</div>
    <div class="items items1"style="grid-row:1/3;color:red;">UPTO 50(rs.)</div>
    <div class="items items1"style="grid-row:1/3;color:red;">UPTO 50-150(rs.)</div>
    <div class="items items1"style="grid-row:1/3;color:red;">UPTO 150-300(rs.)</div>
    <div class="items items1"style="grid-row:1/3;color:red;">ABOVE 300(rs.)</div>
    <div class="items items1"style="grid-row:1/3;color:red;">SERVICE TAX</div>
    <div class="items items1"style="grid-row:1/3;color:red;">TOTAL AMOUNT</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">{{$partial_readings['upto_50']}}</div>
    <div class="items items1">{{$partial_readings['upto_150']}}</div>
    <div class="items items1">{{$partial_readings['upto_300']}}</div>
    <div class="items items1">{{$partial_readings['above_300']}}</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">GRID</div>
    <div class="items items1">{{$bill->current_reading}}</div>
    <div class="items items1">{{$previous_bill->current_reading}}</div>
    <div class="items items1">{{$bill->current_reading - $previous_bill->current_reading}}</div>
    <div class="items items1">{{$result['breakdown']['upto_50']}}</div>
    <div class="items items1">{{$result['breakdown']['upto_50_150']}}</div>
    <div class="items items1">{{$result['breakdown']['upto_150_300']}}</div>
    <div class="items items1">{{$result['breakdown']['above_300']}}</div>
    <div class="items items1">0</div>
    <div class="items items1">{{$result['total_amount']}}</div>
    <div class="items items1">DG</div>
    <div class="items items1">{{$bill->tariff_dg}}</div>
    <div class="items items1">{{$previous_bill->tariff_dg}}</div>
    <div class="items items1">{{$bill->tariff_dg - $previous_bill->tariff_dg}}</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">AREA</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1"></div>
</div>
<div class="container4">
    <div class="items items1">{{$consumer_details->area}}</div>
    <div class="items items1">BILL DETAILS</div>
    <div class="items items1">AMOUNT</div>
    <div class="items items1" style="grid-row: 1/26; grid-column: 4/5; display: flex; justify-content: center; align-items: center; height: 98%;">
        <div id="imagePreview" style="display: {{ isset($general_setting->qr_image) ? 'block' : 'none' }}; width: 100%; height: 100%; text-align: center;">
            <img src="{{ asset('images/admin/' . $general_setting->qr_image) }}" alt="Preview Image" style="width: 100%; height: 100%; object-fit: contain;"/>
        </div>
    </div>
    
    <div class="items items1">ENERGY CHG GRID</div>
    <div class="items items1">{{$bill->current_reading - $previous_bill->current_reading}}</div>
    <div class="items items1">{{$result['total_amount']}}</div>
    <div class="items items1">ENERGY CHG DG</div>
    <div class="items items1">{{$bill->tariff_dg}}</div>
    <div class="items items1">{{$bill->tariff_dg * $general_setting['tariff_dg']}}</div>
    <div class="items items1">FIXED CHARGE</div>
    <div class="items items1"></div>
    <div class="items items1">{{($bill->current_reading - $previous_bill->current_reading) / 15 * 27}}</div>
    <div class="items items1">ELECTRICITY DUTY</div>
    <div class="items items1"><span style="margin-left: 35px;">{{$general_setting->electricity_upto}}</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | <span style="margin-left: 100px;">{{($bill->current_reading - $previous_bill->current_reading)-$general_setting->electricity_upto}}</span></div>
    <div class="items items1">{{$calculation->electricity_duty}}</div>
    <div class="items items1"></div>
    <div class="items items1">TOTAL ENERGY BILL AMOUNT</div>
    <div class="items items1">{{$calculation->total_reading_amount+$calculation->energy_chg_charger+$calculation->fixed_charge+$calculation->electricity_duty}}</div>
    <div class="items items1" style="grid-column: 1/3;">DUE DATE LATE PAYMENT SURCHARGE</div>
    <div class="items items1">0</div>
    <div class="items items1"></div>
    <div class="items items1">TOTAL ENERGY BILL AMOUNT AFTER DUE DATE</div>
    <div class="items items1">{{$calculation->total_reading_amount+$calculation->energy_chg_charger+$calculation->fixed_charge+$calculation->electricity_duty}}</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1">DEPOSITE AMOUNT (-)</div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1">FIXED MAINTENANCE COST</div>
    <div class="items items1"></div>
    <div class="items items1">{{$calculation->fixed_maintain_charge}}</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1"></div>
    <div class="items items1"></div>
    <div class="items items1">0</div>
    <div class="items items1">TOTAL</div>
    <div class="items items1"></div>
    <div class="items items1">{{$calculation->total_reading_amount+$calculation->energy_chg_charger+$calculation->fixed_charge+$calculation->electricity_duty+$calculation->fixed_maintain_charge}}</div>


   
   </div>
</div>
<!-- Code injected by live-server -->
<script>
    // Automatically open the print dialog when the page is loaded
    window.onload = function() {
        window.print();
    };
</script>
</body>
</html>
