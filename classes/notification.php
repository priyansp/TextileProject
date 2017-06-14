<?php
class notification{
			private $_db;
			
			
	public function __construct(){
	$this->_db=DB::getInstance();
	}
	
	
	
	public function con_notify($username,$page){
	$num_rec_per_page=10;
	$start_from = ($page-1) * $num_rec_per_page;

	$result_count = $this->_db->query_assoc("select * from notify where `receiver` = '$username' order by date desc;");
	$total_records = $result_count->rcount();
	$total_pages = ceil($total_records / $num_rec_per_page); 

	//$html =  "<p>Page NO: ". $page." ";
	//$html.= " Total record: ".$total_records." ";
	$html="";
	if($total_records > $num_rec_per_page){
		$html.="<div style='margin-left:20px'><ul style='display:inline-block'class='pagination'>";
		if($page-1 > 0){
		$html.= "<li><a href='con_notification.php?page=".$t1=$page-1 ."'>Previous</a> </li>";  
		}
		for ($i=1; $i<=$total_pages; $i++) { 
            $html.= "<li";
			if($page==$i){
				$html.=" class='active'";
			}
			$html.="><a href='con_notification.php?page=".$i."'>".$i."</a> </li>"; 
		} 
		if($page != $total_pages){
		$html.= "<li><a href='con_notification.php?page=".$t2=$page+1 ."'>Next</a> </li>";
		}
		$html.="</ul></div>";
	}


	
	if($result = $this->_db->query_assoc("select * from notify where `receiver` = '$username' order by date desc LIMIT $start_from, $num_rec_per_page;")){
		$cont = $result->count();
		$result=$result->results();
		if($cont > 0){
		//$html.= " showing from : ". $stot = $start_from+1 ." To : ". $tot =  $start_from + $cont. "</p>";
		}
		$html.="<form action='note_action.php' method='post'>
		<div class='col-md-4 col-md-offset-2'>
		<select class='form-control' name = 'note_action'>
		<option value='readed'>Make marked as readed</option>
		<option value='unreaded'>Make marked as unreaded</option>
		<option value='delete_all'>Delete all marked items</option>
		</select>
		</div>
		<div class='col-md-4'>
		<input type='submit' value='Do' class='btn btn-primary btn-block' name='notify_action' /></div></br>
		<table class='table margin-top ' id='search-result-table'><th>Mark</th><th>product id</th><th>Sender</th><th>Date</th><th>Message</th><th>View notification</th>";
		
		for($x=0;$x<sizeof($result);$x++){
			$html.="<tr";
			    if($result[$x]['read_status'] === '0'){
				$html.= " class='noread'";
				}else{
				$html.=" class='read'";
				}
				$html.=">";
				$html.="<td><input name='mark[]' type = 'checkbox' value =".$result[$x]['id']." /></td>";
				$html.="<td>".$result[$x]['order_id']."</td>";
				$html.="<td>".$result[$x]["sender"]."</td>";
				$html.="<td>".$result[$x]["date"]."</td>";
				$msg = $result[$x]["msg"];
				$msg = substr($msg,0,15);
				$html.="<td>".$msg."...</td>";
				$html.='<td><a  href="" data-note="'.$result[$x]["id"].'"data-order="'.$result[$x]["order_id"].'">View</a></td>';
			 $html.="<tr>";
		}
		$html.="</table></form>";
		if(sizeof($result)==0){
			$html="<h3 class='text-center'>No Notifications</h3>";
		}
		
		echo $html;
	}
	
	
	}
	
	
	public function con_myorders($id,$page){
		
	$num_rec_per_page=10;
	$start_from = ($page-1) * $num_rec_per_page;

	$result_count = $this->_db->query_assoc("SELECT orders.*,status.status FROM orders inner join status on orders.status  = status.id and orders.consignee_id = '$id' order by orders.id desc;");
	$total_records = $result_count->rcount();
	$total_pages = ceil($total_records / $num_rec_per_page); 

	//$html =  "<p>Page NO: ". $page." ";
	//$html.= " Total record: ".$total_records." ";




		$status1 = $this->_db->query_assoc("SELECT orders.*,status.status FROM orders inner join status on orders.status  = status.id and orders.consignee_id = '$id' order by orders.id desc LIMIT $start_from, $num_rec_per_page; ;");
		$cont = $status1->count();
		
		if($cont > 0){
		//$html.= " showing from : ". $stot = $start_from+1 ." To : ". $tot =  $start_from + $cont. "</p>";
		}
		$html="";
		$result=$status1->results();
		if($total_records > $num_rec_per_page){
		$html="<div style='margin-left:20px'><ul style='display:inline-block'class='pagination'>";
		if($page-1 > 0){
		$html.= "<li><a href='con_myorders.php?page=".$t1=$page-1 ."'>Previous</a></li> ";  
		}
		for ($i=1; $i<=$total_pages; $i++) { 
            $html.= "<li";
			if($page==$i){
				$html.=" class='active'";
			}
			$html.="><a href='con_myorders.php?page=".$i."'>".$i."</a> </li>"; 
		} 
		if($page != $total_pages){
		$html.= "<li><a href='con_myorders.php?page=".$t2=$page+1 ."'>Next</a> </li>";
		}
		}
		$html.="</ul></div>";
		$html.="<table class='table table-hover'><th>Purchase ID</th>
		<th>UPNO</th><th>Date</th><th>Qty requested</th><th>Qty yet to delivered</th><th>Qty delivered</th><th>Status</th><th>View report</th><th>Cancel order</th>";
	
		for($x=0;$x<sizeof($result);$x++){
			$html.="<tr>";
				$p_id = 'P'.$result[$x]["id"];
				$html.="<td><a class='purchase_id' data-pid=\"".$result[$x]["id"]."\" data-cid=\"".$result[$x]['consignee_id']."\">".$p_id."</a></td>";
				$html.="<td>".$result[$x]['upno']."</td>";
				$html.="<td>".$result[$x]["date"]."</td>";
				$html.="<td>".$result[$x]["qty"]."</td>";
				$html.="<td>".$result[$x]["qty_remaining"]."</td>";
				$del = $result[$x]["qty"] - $result[$x]["qty_remaining"];
				$html.="<td>".$del."</td>";
				$html.="<td>".$result[$x]["status"]."</td>";
				$html.="<td><a class='view-indent' data-pid='".$result[$x]["id"]."'>view</a></td>";
				
				if($result[$x]["status"] == 'Waiting for acknowlegement'){
				$html.="<td><a class='cancel' href ='cancel_order.php?id=". $result[$x]["id"] ."&action=cancel&page=".$page."'>Cancel Order</a></td>";
				}else if($result[$x]["status"] == 'On process'){
				$html.="<td><a class='cancel' href ='cancel_order.php?id=". $result[$x]["id"] ."&action=request&page=".$page."'>Request Cancellation</a></td>";
				}else{
				$html.= "<td>Order can not be cancelled</td>";
				}
				
			 $html.="<tr>";
		}
		$html.="</table>";
		if(sizeof($result)<=0)
		{
			$html="<h3 class='text-center'>No Records Found</h3>";
		}
		
		
		echo $html;

	
	
	}
	
	
	
}

?>