<?php
require '../includes/header.php';
if(!$user->checkAccess("ledger")){
    redirect::to("login.php");
}
$db = DB::getInstance();
$current_month=date('n');
$previous_months;
$monthly_totals;
for($i=5,$j=0;$i>=0;$i--,$j++){
    $previous_months[]=date('My',mktime(0,0,0,$current_month-$i,1,2017));
    $monthly_totals[$previous_months[$j]]=0;
}
$six_month_earlier=date('Y-m-d',mktime(0,0,0,$current_month-5,1,2017));
//Here the year is not a problem and will be adjusted accordingly
$query="select created.vendor_name,
MAX(CASE
WHEN created.billed_for='${previous_months[0]}' THEN created.total
END) AS '${previous_months[0]}',
MAX(CASE
WHEN created.billed_for='${previous_months[1]}' THEN created.total
END) AS '${previous_months[1]}',
MAX(CASE
WHEN created.billed_for='${previous_months[2]}' THEN created.total
END) AS '${previous_months[2]}',
MAX(CASE
WHEN created.billed_for='${previous_months[3]}' THEN created.total
END) AS '${previous_months[3]}',
MAX(CASE
WHEN created.billed_for='${previous_months[4]}' THEN created.total
END) AS '${previous_months[4]}',
MAX(CASE
WHEN created.billed_for='${previous_months[5]}' THEN created.total
END) AS '${previous_months[5]}'
from (select v.vendor_name,SUM(CASE WHEN l.entry_type ='1' THEN l.amount WHEN l.entry_type='2' THEN -l.amount END)as total,
DATE_FORMAT(l.bill_for,'%b%y') as billed_for from ledger l right join vendors v on l.vendor_id=v.vendor_id 
where v.type=1 and (l.bill_for >='${six_month_earlier}' or l.bill_for IS NULL) 
group by v.vendor_id,billed_for order by v.vendor_name,STR_TO_DATE(billed_for,'%b%y')) created group by created.vendor_name;";

$result=$db->query_assoc($query)->results();
//Generating the Table for the Search

$total_query="select v.vendor_name,l.balance,v.vendor_id from vendors v left join ledger l on v.vendor_id=l.vendor_id where (l.ledger_entry_id IS NULL or l.ledger_entry_id in (select MAX(ledger_entry_id) from ledger group by vendor_id)) and v.type=1 order by v.vendor_name;";

$totals_result=$db->query_assoc($total_query)->results();
$table_body="";
$total_cost="";
$overall_total=0;
for($i=0,$sno=1;$i<count($result);$i++,$sno++){
    $vendor_name=$result[$i]['vendor_name'];
    $vendor_id=$totals_result[$i]['vendor_id'];
    $monthly_values="";
    $six_month_total=0;
    foreach($previous_months as $now){
        $current_value=$result[$i][$now]?$result[$i][$now]:0;
        $six_month_total+=$current_value;
        $monthly_totals[$now]+=$current_value;//Storing the month wise totals
        $monthly_values.="<td>${current_value}</td>";
    }
    $vendor_total=$totals_result[$i]['balance']?$totals_result[$i]['balance']:0;// getting vendor_total from table
    $overall_total+=$vendor_total;
    $add_class="";
    $link="view_vendor_ledger.php?vendor_id=${vendor_id}";
    if($six_month_total<$vendor_total){
        $add_class.="class='make_red'";
    }
    $table_body.="<tr ${add_class} ><td>${sno}</td><td><a style='text-decoration:underline;' href='${link}'>${vendor_name}</a></td>".$monthly_values."<td>$vendor_total</td>";
    $table_body.="</tr>";
}
$table_body.="<tr><td>${sno}</td><td>Total</td>";
foreach($previous_months as $now){
    $current_month_total=$monthly_totals[$now];
    $table_body.="<td>$current_month_total</td>";
}
$table_body.="<td>${overall_total}</td></tr>";
?>
<div class="right_col" role="main">
    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   <div class="col-md-6">
                        <h2>Purchase Ledger</h2>   
                   </div>
                    <div class="col-md-6">
                        <div class="col-md-offset-8 col-md-4">
                            <button class="btn btn-warning btn-block" id="download_button">Download</button>
                            <a href="" id="download_link" style="display:none">Download Link</a>    
                        </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" id="table_div">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Vendor Name</th>
                          <?php
                            foreach ($previous_months as $now){
                                echo "<th>${now}</th>";
                            }
                          ?>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            echo $table_body;
                          ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
    </div>
</div>
<?php
require '../includes/footer.php';
?>
<script>
$(document).ready(function(){
    
    $('body').on("click","#download_button",function(){
        var data= $("#datatable").dataTable()._('tr', {"filter": "applied"});
        var table = $('#datatable').DataTable();
        var headers=table.columns().header();
        var csv=makeCSV(data,headers);
        window.URL = window.URL || window.webkiURL;
        var blob = new Blob([csv]);
        var filename="purchase_ledger_"+moment().format('YYYY-MM-DD')+".csv";
        var blobURL = window.URL.createObjectURL(blob);
        $('#download_link').attr("download",filename).attr("href",blobURL);
        $('#download_link')[0].click();
    });
});

function makeCSV(data,header){
    var CSV="";
    var seperator=",";
    var HEADER="";
    var FOOTER="";
    for(var i=0;i<header.length;i++){
        HEADER+=header[i].innerHTML+seperator;
    }
    for(var i=0;i<data.length;i++) {
        CSV+=i+1;
        for(var j=1;j<data[i].length;j++){
            if(j==1 && i!=data.length-1){
                data[i][j]=$(data[i][j])[0].innerText;
            }
            CSV+=seperator+data[i][j];
        }
        CSV+="\n";
    }
    HEADER+="\n";
    return HEADER+CSV;
}
</script>