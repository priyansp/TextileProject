<?php
require '../includes/header.php';
if(!$user->checkAccess("vendor_view")){
    redirect::to("login.php");
}
$db = DB::getInstance();

$vendors = $db->query_assoc("select * from vendors order by type,vendor_name;");
$vendors = $vendors->results();


//Generating the Table for the Search
$table_body="";
for($i=0,$sno=1;$i<count($vendors);$i++,$sno++){
    $vendor_name=$vendors[$i]['vendor_name'];
    $phone=$vendors[$i]['phone_number'];
    $type=$vendors[$i]['type']==1?"Purchase":"Sales";
    $email=$vendors[$i]['email'];
    $address=$vendors[$i]['address'];
    $details=$vendors[$i]['details'];
    $gstn=$vendors[$i]['gstn'];
    $table_body.="<tr ";
    $table_body.="><td>${sno}</td><td>${vendor_name}</td><td>${type}</td><td>${phone}</td><td>${email}</td><td>${address}</td><td>${details}</td><td>${gstn}</td>";
    $table_body.="</tr>";
}
?>
<div class="right_col" role="main">
    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   <div class="col-md-6">
                        <h2>Vendor Details</h2>   
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
                          <th>Vendor</th>
                          <th>Type</th>
                          <th>Phone</th>
                          <th>Email</th>
                          <th>Address</th>
                          <th>Details</th>
                          <th>GSTN</th>
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
        var filename="Vendors"+moment().format('YYYY-MM-DD')+".csv";
        var blobURL = window.URL.createObjectURL(blob);
        $('#download_link').attr("download",filename).attr("href",blobURL);
        $('#download_link')[0].click();
    });
});

function makeCSV(data,header){
    var CSV="";
    var seperator=",";
    var HEADER="";
    for(var i=0;i<header.length;i++){
        HEADER+=header[i].innerHTML+seperator;
    }
    for(var i=0;i<data.length;i++) {
        CSV+=i+1;
        for(var j=1;j<data[i].length;j++){
            var mod_string=data[i][j].replace(/(\r\n|\r|\n)/g," ");
            mod_string=mod_string.replace(/,/g,";");
            CSV+=seperator+mod_string;
        }
        CSV+="\n";
    }
  console.log(data[0][5]);
    HEADER+="\n";
    return HEADER+CSV;
}

</script>