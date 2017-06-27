<?php
require '../includes/header.php';
if(!$user->checkAccess("dyes_home")){
    ob_end_clean();
    redirect::to("login.php");
}
?>
<div class="right_col" role="main">
    <div class="row">
         <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <div class="col-md-6">
                        <h2>Consumption</h2>   
                    </div>
                    <div class="col-md-6">
                        <input type="date" id="consumption_date" class="form-control"/>   
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="consumption_chart" style="width:100%; height:280px;"></div>
                    <h2 class="text-center" id="consumption_message">No Consumptions</h2>
                  </div>
                </div>
         </div>
         <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   <div class="col-md-6">
                        <h2>Addition</h2>   
                   </div>
                   <div class="col-md-6">
                        <input type="date" id="addition_date" class="form-control"/>   
                   </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="addition_chart" style="width:100%; height:280px;"></div>
                    <h2 class="text-center" id="addition_message">No Additions</h2>
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
            var today=moment().format('YYYY-MM-DD');
            $("#consumption_date,#addition_date").val(today);
            getStatus(today,0,$('#consumption_chart'),$('#consumption_message'));
            getStatus(today,1,$('#addition_chart'),$('#addition_message'));
        });        
        
        function getStatus(date,type,chart,error){
            $.post('../rest_calls/get_consumptions.php',{
                    Date:date,
                    Type:type
                },function(data){
                    data=JSON.parse(data);
                    initialiseChart(chart,data,error);
            });
        }
    
        function initialiseChart(element,data,error){
            if(data.length){
                if($(element).length){ 
                    Morris.Bar({
                      element:element,
                      data:data,
                      xkey: 'product_name',
                      ykeys: ['qty'],
                      labels: ['Quantity'],
                      barRatio: 0.4,
                      barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
                      xLabelAngle: 35,
                      hideHover: 'auto',
                      resize: true
                    });
                    $(element).show();
                    $(error).hide();
                }
            }
            else{
                $(element).hide();
                $(error).show();
            }
        }
    
        $("#consumption_date").change(function(){
            var date=$(this).val();
            $('#consumption_chart *').remove();
            getStatus(date,0,$('#consumption_chart'),$('#consumption_message'));
        });
        $("#addition_date").change(function(){
            var date=$(this).val();
            $('#addition_chart *').remove();
            getStatus(date,1,$('#addition_chart'),$('#addition_message'));
        });
        
</script>