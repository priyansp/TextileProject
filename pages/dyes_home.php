<?php
require '../includes/header.php';
?>
<div class="right_col" role="main">
    <div class="row">
         <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Consumption</h2>
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
                    <h2>Addition</h2>
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
            $.post('../rest_calls/get_consumptions.php',{
                    Date:moment().subtract(1,'day').format('YYYY-MM-DD'),
                    Type:0
                },function(data){
                    data=JSON.parse(data);
                    initialiseChart($('#consumption_chart'),data,$('#consumption_message'));
                });
            $.post('../rest_calls/get_consumptions.php',{
                    Date:moment().subtract(1,'day').format('YYYY-MM-DD'),
                    Type:1
                },function(data){
                    data=JSON.parse(data);
                    initialiseChart($('#addition_chart'),data,$('#addition_message'));
            });
        });        
    
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
        
</script>