<?php
require '../includes/header.php';
if(!$user->checkAccess("ledger")){
    redirect::to("login.php");
}
if(input::exists('get')){
$db = DB::getInstance();
$vendor_id=input::get('vendor_id');
$query="select l.* from ledger l join vendors v on v.vendor_id=l.vendor_id where v.vendor_id=${vendor_id} order by l.billed_on;";
$result=$db->query_assoc($query)->results();

$query_vendor="select vendor_name,type from vendors where vendor_id=${vendor_id};";
$vendor_name=$db->query_assoc($query_vendor)->results();
$href=$vendor_name[0]['type']==1?"ledger_purchase.php":"ledger_sale.php";
$vendor_name=$vendor_name[0]['vendor_name'];
//Generating the Table for the Search
$table_body="";
for($i=0,$sno=1;$i<count($result);$i++,$sno++){
    $reference=$result[$i]['reference'];
    $entry_type=$result[$i]['entry_type'];
    $amount=$result[$i]['amount'];
    $balance=$result[$i]['balance'];
    $bill_for=$result[$i]['bill_for'];
    $billed_on=$result[$i]['billed_on'];
    $entry="";
    if($entry_type==1 || $entry_type==4){
        $entry="Credit";
    }
    else{
        $entry="Debit";
    }
    $table_body.="<tr><td>${sno}</td><td>${reference}</td><td>${entry}</td><td>${amount}</td><td>${balance}</td><td>${bill_for}</td><td>${billed_on}</td>";
    $table_body.="</tr>";
}
?>
<div class="right_col" role="main">
    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   <div class="col-md-6">
                       <h2><b style="color:blue"><?php echo $vendor_name; ?></b></h2>   
                   </div>
                    <div class="col-md-6">
                       <div class="col-md-offset-4 col-md-4">
                            <a class="btn btn-primary btn-block" href="<?php echo $href; ?>">Back</a>
                        </div>
                        <div class="col-md-4">
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
                          <th>Reference</th>
                          <th>Credit/Debit</th>
                          <th>Amount</th>
                          <th>Balance</th>
                          <th>Bill for</th>
                          <th>Billed On</th>
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
        var vendor_name=$('b')[0].innerText;
        var filename=vendor_name+moment().format('YYYY-MM-DD')+".csv";
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
            CSV+=seperator+data[i][j];
        }
        CSV+="\n";
    }
    HEADER+="\n";
    return HEADER+CSV;
}

</script>
<?php } 
else{
    redirect::to('ledger_purchase.php');
}
?>