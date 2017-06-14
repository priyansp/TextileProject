<?php
class report{
			private $_db;
			
			
	public function __construct(){
	$this->_db=DB::getInstance();
	}
	
	
	public function view_report($con_id,$product,$from,$to,$status){
		//echo $con_id;
		//echo $product;
		//echo $from;
		//echo $to;
			$flag = 0;
		 if(isset($status) && !empty($status)){
			 //print_r($status);
			 $flag = 1;
			 $html1 = "and";
		 for($i=0;$i< sizeof($status);$i++){
			 $html1.=" status.status = '".$status[$i] ."'";
			 if(sizeof($status) >1 && $i < sizeof($status)-1){
					$html1.=" or";
			 }
				
		 }
		 }else{
			 $html1 = " ";
		 }
		 
		if($con_id !== "" && $product ==="" && $from=== ""&& $to ===""){
		//echo "select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where orders.consignee_id = '$con_id' $html1;";
		$result = $this->_db->query_assoc("select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where orders.consignee_id = '$con_id' $html1;");
		$result = $result->results();
		return $result;
		}else if( $con_id !== "" && $product !=="" && $from=== ""&& $to ===""){
		
		
		$result = $this->_db->query_assoc("select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where consignee_id = '$con_id' and upno = '$product' $html1;");
		$result = $result->results();
		return $result;
		
		}else if($con_id !== "" && $product !=="" && $from !== ""&& $to ===""){
		
		
		$result = $this->_db->query_assoc("select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where consignee_id = '$con_id' and upno = '$product' and date = '$from' $html1;");
		$result = $result->results();
		return $result;
		
		}else if($con_id !== "" && $product !=="" && $from !== ""&& $to !==""){
		
		
		//echo '4';
		$result = $this->_db->query_assoc("select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where consignee_id = '$con_id' and upno = '$product' and date between '$from' and '$to' $html1;");
		$result = $result->results();
		return $result;
		
		}else if($con_id === "" && $product !=="" && $from === ""&& $to ===""){
		
		
		//echo '5';
		$result = $this->_db->query_assoc("select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where upno = '$product' $html1;");
		$result = $result->results();
		return $result;
		}else if($con_id === "" && $product ==="" && $from !== ""&& $to ===""){
		
		
		//echo '6';
		$result = $this->_db->query_assoc("select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where  date = '$from' $html1;");
		$result = $result->results();
		return $result;
		
		}else if($con_id === "" && $product ==="" && $from !== ""&& $to !==""){
		
		
		//echo '7';
		$result = $this->_db->query_assoc("select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where date between '$from' and '$to' $html1;");
		$result = $result->results();
		return $result;
		
		}else if($con_id !== "" && $product ==="" && $from !== ""&& $to !==""){
		
		
		//echo '8';
		$result = $this->_db->query_assoc("select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where consignee_id = '$con_id' and date between '$from' and '$to' $html1;");
		$result = $result->results();
		return $result;
		
		}else if($con_id === "" && $product !=="" && $from !== ""&& $to !==""){
		
		
		//echo '9';
		$result = $this->_db->query_assoc("select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where upno = '$product' and date between '$from' and '$to' $html1;");
		$result = $result->results();
		return $result;
		
		}else if($con_id !== "" && $product ==="" && $from !== ""&& $to ===""){
		
		
		//echo '10';
		$result = $this->_db->query_assoc("select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where consignee_id = '$con_id' and date = '$from' $html1;");
		$result = $result->results();
		return $result;
		
		}else if($con_id === "" && $product !=="" && $from !== ""&& $to ===""){
		
		
		//echo '11';
		$result = $this->_db->query_assoc("select orders.id,orders.consignee_id,orders.date,orders.upno,orders.qty,orders.qty_remaining,status.status from orders inner join status on orders.status  = status.id where upno = '$product' and date = '$from' $html1;");
		$result = $result->results();
		return $result;
		
		}
	
	
	}
	
	
	public function view_table($result){
	
	
	$html="<table  class='table table-hover table-responsive' id='search-result-table'><th>ID</th><th>Consignee ID</th><th>Date</th>
		<th>Status</th><th>Upno</th><th>Qty</th><th>Qty remaining</th><th>Qty delivered</th>";
		for($x=0;$x<sizeof($result);$x++){
			$html.="<tr>";
				$html.="<td>P".$result[$x]["id"]."</td>";
				$html.="<td>".$result[$x]["consignee_id"]."</td>";
				$html.="<td>".$result[$x]["date"]."</td>";
				$html.="<td>".$result[$x]["status"]."</td>";
				$html.="<td>".$result[$x]["upno"]."</td>";
				$html.="<td>".$result[$x]["qty"]."</td>";
				$html.="<td>".$result[$x]["qty_remaining"]."</td>";
				$del = $result[$x]["qty"] - $result[$x]["qty_remaining"];
				$html.="<td>".$del."</td>";
				$html.="<tr>";
		}
		$html.="</table>";
		if(sizeof($result)==0){
			$html="<h4 class='text-center'>No Records Found...</h4>";
		}
		echo $html;
	
	
	
	}
	
	
	
}
	
	
	
?>