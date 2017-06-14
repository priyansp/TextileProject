<?php
require_once 'DB.php';
require_once 'core/init.php';	
require_once 'classes/PHPExcel/IOFactory.php';
class admin_process{
	private $_db,
			$_validate,
			$_sql;
	public function __construct(){
	$this->_db=DB::getInstance();
	$this->_validate=new validate();
	}
	public function getValidate(){
		return $this->validate;
	}
	
	public function add_user_using_excel_sheet($inputFileName){
	
				try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
for ($row = 2; $row <= $highestRow; $row++){ 
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
	
    print_r($rowData);
	//  Insert row data array into your database of choice here

						$salt = hash::salt(32);
						$user=new user();	
						try{
						$user->create(array(
						'username' => $rowData[0][0],
						'password' => hash::make('skcet123',$salt),
						'salt' => $salt,
						'name' => $rowData[0][1],
						'joined' => date('Y-m-d H:i:s'),
						'group' => $rowData[0][2],
						'designation' =>$rowData[0][3],
						'user_type' =>$rowData[0][4],
						'phone' => $rowData[0][5],
						'mail' => $rowData[0][6]
						));
				}catch(Exception $e){
				die($e->getMessage());
			}
	
	
	}

		
	
		/*
		$data = new Spreadsheet_Excel_Reader($filename);
		for($i=0;$i<count($data->sheets);$i++){
				if(count($data->sheets[$i]['cells'])>0){
					for($j=1;$j<=count($data->sheets[$i]['cells']);$j++){ 
						$this->_validate->check($data->sheets[$i]['cells'][$j], array(
						1=> array(
						'required' => true,
						'min' => 2,
						'max' => 20,
						'unique' => 'users'
						)));
						$salt = hash::salt(32);
						$user=new user();	
						try{
					$user->create(array(
						'username' => $data->sheets[$i]['cells'][$j][1],
						'password' => hash::make('skcet123',$salt),
						'salt' => $salt,
						'name' => $data->sheets[$i]['cells'][$j][2],
						'joined' => date('Y-m-d H:i:s'),
						'group' => $data->sheets[$i]['cells'][$j][3],
						'designation' =>$data->sheets[$i]['cells'][$j][4],
						'user_type' =>$data->sheets[$i]['cells'][$j][5],
						'phone' => $data->sheets[$i]['cells'][$j][6],
						'mail' => $data->sheets[$i]['cells'][$j][7]
						));
					//session::flash('home','your registeration is successful! ur are free to login!');
					//redirect::to('index.php');
				}catch(Exception $e){
				die($e->getMessage());
			}
						}
					}
				}
				
		*/		
		session::flash('home','your registeration is successful! ur are free to login!');
		redirect::to('index.php');
		
		}


	
	public function add_product_using_excel_sheet($inputFileName){
	
	
	//$inputFileName = './sampleData/example1.xls';

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
for ($row = 2; $row <= $highestRow; $row++){ 
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
	
    print_r($rowData);
	//  Insert row data array into your database of choice here

		$user=new user();
						try{
						$user->create_table('p_master',array(
						'upno' => $rowData[0][0],
						'plno' => $rowData[0][1],
						'sd' => $rowData[0][2],
						'ld' => $rowData[0][3],
						'rate' => $rowData[0][4]
						));
				}catch(Exception $e){
				die($e->getMessage());
			}
	
	
	}
	
	
	
	/*
	$data = new Spreadsheet_Excel_Reader($filename);
		for($i=0;$i<count($data->sheets);$i++){
				if(count($data->sheets[$i]['cells'])>0){
					for($j=1;$j<=count($data->sheets[$i]['cells']);$j++){ 
						echo $data->sheets[$i]['cells'][$j][1];
						$user=new user();
						try{
						$user->create_table('p_master',array(
						'upno' => $data->sheets[$i]['cells'][$j][1],
						'plno' => $data->sheets[$i]['cells'][$j][2],
						'sd' => $data->sheets[$i]['cells'][$j][3],
						'ld' =>$data->sheets[$i]['cells'][$j][4],
						'rate' =>$data->sheets[$i]['cells'][$j][5]
						));
				}catch(Exception $e){
				die($e->getMessage());
			}
						}
					}
				}
				
				*/
				
				session::flash('product','your products has been added successfully!');
				redirect::to('product_master_multiple.php');
		
		
		}
		
			
	public function add_railway_using_excel_sheet($inputFileName){
	
	
	try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
for ($row = 2; $row <= $highestRow; $row++){ 
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
	
    print_r($rowData);
	//  Insert row data array into your database of choice here

		$user=new user();
						try{
						$user->create_table('r_master',array(
						'sd' => $rowData[0][0],
						'ld' => $rowData[0][1],
						'division' => $rowData[0][2],
						'control_officer' => $rowData[0][3]
						));
				}catch(Exception $e){
				die($e->getMessage());
			}
	
	
	}
	
	
	/*	
	$data = new Spreadsheet_Excel_Reader($filename);
		for($i=0;$i<count($data->sheets);$i++){
				if(count($data->sheets[$i]['cells'])>0){
					for($j=1;$j<=count($data->sheets[$i]['cells']);$j++){ 
						echo $data->sheets[$i]['cells'][$j][1];
						$user=new user();
						try{
						$user->create_table('r_master',array(
						'sd' => $data->sheets[$i]['cells'][$j][1],
						'ld' =>$data->sheets[$i]['cells'][$j][2],
						'division' =>$data->sheets[$i]['cells'][$j][3],
						'control_officer' =>$data->sheets[$i]['cells'][$j][4]
						));
				}catch(Exception $e){
				die($e->getMessage());
			}
						}
					}
				}
				
				
				*/
				
				session::flash('railway','your railways has been added successfully!');
				redirect::to('railway_master_multiple.php');
		}

		
	public function add_consignee_using_excel_sheet($filename){
		
	$data = new Spreadsheet_Excel_Reader($filename);
					$salt = hash::salt(32);
					$con_id = $user->consignee_id_gen($data->sheets[$i]['cells'][$j][3]);
					$con_id = 'CONS'.$con_id;
					$passlow = strtolower($con_id);
	
		for($i=0;$i<count($data->sheets);$i++){
				if(count($data->sheets[$i]['cells'])>0){
					for($j=1;$j<=count($data->sheets[$i]['cells']);$j++){ 
						echo $data->sheets[$i]['cells'][$j][1];
						$user=new user();
						try{
						
						$user->create(array(
						'username' => $con_id,
						'password' => hash::make($passlow,$salt),
						'salt' => $salt,
						'name' => $data->sheets[$i]['cells'][$j][3],
						'joined' => date('Y-m-d H:i:s'),
						'group' => 4,
						'phone' => $data->sheets[$i]['cells'][$j][6],
						'mail' => input::get('mail'),
						'user_type'=> $data->sheets[$i]['cells'][$j][7],
						'activation' => 1
						));
						
						
						
						$user->create_table('consignee_master',array(
						'railway' => $data->sheets[$i]['cells'][$j][1],
						'division' =>$data->sheets[$i]['cells'][$j][2],
						'consignee' =>$data->sheets[$i]['cells'][$j][3],
						'control_officer' =>$data->sheets[$i]['cells'][$j][4],
						'account_unit' =>$data->sheets[$i]['cells'][$j][5]
						
						
						
						
						));
				}catch(Exception $e){
				die($e->getMessage());
			}
						}
					}
				}
				session::flash('consignee','your consignees has been added successfully!');
				redirect::to('consignee_master.php');
		}

		
		public function add_demand_using_excel_sheet($filename){
		
		$data = new Spreadsheet_Excel_Reader($filename);
		for($i=0;$i<count($data->sheets);$i++){
				if(count($data->sheets[$i]['cells'])>0){
					for($j=1;$j<=count($data->sheets[$i]['cells']);$j++){ 
						echo $data->sheets[$i]['cells'][$j][1];
						$user=new user();
						try{
						$user->create_table('demand',array(
						'irno' => $data->sheets[$i]['cells'][$j][1],
						'irdt' =>$data->sheets[$i]['cells'][$j][2],
						'sono' =>$data->sheets[$i]['cells'][$j][3],
						'sodate' =>$data->sheets[$i]['cells'][$j][4],
						'upno' =>$data->sheets[$i]['cells'][$j][5],
						'indlr' =>$data->sheets[$i]['cells'][$j][6],
						'inddt' =>$data->sheets[$i]['cells'][$j][7],
						'indqty' =>$data->sheets[$i]['cells'][$j][8],
						'unit' =>$data->sheets[$i]['cells'][$j][9],
						'diun' =>$data->sheets[$i]['cells'][$j][10],
						'consig' =>$data->sheets[$i]['cells'][$j][11],
						'cooffcr' =>$data->sheets[$i]['cells'][$j][12],
						'alloc' =>$data->sheets[$i]['cells'][$j][13],
						'acvt' =>$data->sheets[$i]['cells'][$j][14]
						));
				}catch(Exception $e){
				die($e->getMessage());
			}
						}
					}
				}
				session::flash('demand','your demands has been added successfully!');
				redirect::to('demand.php');
		}


	public function add_rate_using_excel_sheet($filename){
		
	$data = new Spreadsheet_Excel_Reader($filename);
		for($i=0;$i<count($data->sheets);$i++){
				if(count($data->sheets[$i]['cells'])>0){
					for($j=1;$j<=count($data->sheets[$i]['cells']);$j++){ 
						echo $data->sheets[$i]['cells'][$j][1];
						$user=new user();
						try{
						$user->create_table('rate',array(
						'upno' => $data->sheets[$i]['cells'][$j][1],
						'sd' =>$data->sheets[$i]['cells'][$j][2],
						'plno' =>$data->sheets[$i]['cells'][$j][3],
						'pending' =>$data->sheets[$i]['cells'][$j][4],
						'rate' =>$data->sheets[$i]['cells'][$j][5],
						'sc_for_current' =>$data->sheets[$i]['cells'][$j][6],
						'sc_for_next' =>$data->sheets[$i]['cells'][$j][7],
						'outcome' =>$data->sheets[$i]['cells'][$j][8],
						));
				}catch(Exception $e){
				die($e->getMessage());
			}
						}
					}
				}
				session::flash('rate','your rate has been added successfully!');
				redirect::to('rate_schedule.php');
		}

		
	public function list_consignee_request(){
		
		
			$this->_db->query_assoc("SELECT * FROM users where activation = 0 and user_type = 'consignee'");
	
		$result=$this->_db->results();
		$html="<table class='table table-hover' id='search-result-table'><th>USERNAME</th><th>NAME</th><th>USER TYPE</th>
		<th>PHONE</th><th>MAIL</th><th>APPROVE</th><th>REJECT</th>";
		for($x=0;$x<sizeof($result);$x++){
			$html.="<tr>";
				$html.="<td><a class='profile' data-toggle='modal' data-target='#myModal' href=".$result[$x]['username'].">".$result[$x]['username']."</a></td>";
				$html.="<td>".$result[$x]["name"]."</td>";
				$html.="<td>".$result[$x]["user_type"]."</td>";
				$html.="<td>".$result[$x]["phone"]."</td>";
				$html.="<td>".$result[$x]["mail"]."</td>";
				$html.='<td><a class="anchor delete" href="approve_consignee.php?username='.$result[$x]['username'].'"><i class="glyphicon glyphicon-ok"></a>';
				$html.='<td><a class="anchor delete" href="approve_consignee.php?delete='.$result[$x]['username'].'"><i class="glyphicon glyphicon-remove-circle"></a>';
			 $html.="<tr>";
		}
		$html.="</table>";
		if(sizeof($result)==0)
		{
			$html="<h4 class='text-center'>No Pending Request</h4>";
		}
		echo $html;
	}	
		
		
	public function list_users($type,$name){
		
		if($type=="name"){
			$this->_db->query_assoc("SELECT * FROM users where name LIKE '{$name}%'");
		}
		else if($type=="designation")
		{
			$this->_db->query_assoc("SELECT * FROM users where user_type='{$name}'");
		}
		$result=$this->_db->results();
		$html="<table class='table table-hover' id='search-result-table'><th>ID</th><th>USERNAME</th><th>USER TYPE</th>
		<th>PHONE</th><th>MAIL</th><th>DELETE</th><th>EDIT</th>";
		for($x=0;$x<sizeof($result);$x++){
			$html.="<tr>";
				$html.="<td>".$result[$x]["id"]."</td>";
				$html.="<td>".$result[$x]["name"]."</td>";
				$html.="<td>".$result[$x]["user_type"]."</td>";
				$html.="<td>".$result[$x]["phone"]."</td>";
				$html.="<td>".$result[$x]["mail"]."</td>";
				$html.='<td><a class="anchor delete" href="'.$result[$x]['id'].'"><i class="glyphicon glyphicon-trash"></a>';
				$html.='<td><a class="anchor edit" href="edit_profile.php?id='.$result[$x]['id'].'"><i class="glyphicon glyphicon-edit"></a>';
			 $html.="<tr>";
		}
		$html.="</table>";
		echo $html;
	}
	
	public function list_product($type,$name){
		if($type=="upno"){
		
			$this->_db->query_assoc("SELECT * FROM p_master where upno LIKE '{$name}%'");
		}
		else if($type=="plno")
		{
			$this->_db->query_assoc("SELECT * FROM p_master where plno LIKE '{$name}%'");
		}
		$result=$this->_db->results();
		$html="<table class='table table-hover' id='search-result-table'><th>UPNO</th><th>PLNO</th>
		<th>SHORT</th><th>LONG</th><th>RATE</th><th>DELETE</th><th>EDIT</th>";
		for($x=0;$x<sizeof($result);$x++){
			$html.="<tr>";
				$html.="<td>".$result[$x]["upno"]."</td>";
				$html.="<td>".$result[$x]["plno"]."</td>";
				$html.="<td>".$result[$x]["sd"]."</td>";
				$html.="<td>".$result[$x]["ld"]."</td>";
				$html.="<td>".$result[$x]["rate"]."</td>";
				$html.='<td><a class="anchor delete" href="'.$result[$x]['upno'].'"><i class="glyphicon glyphicon-trash"></a>';
				$html.='<td><a class="anchor edit" href="edit_product.php?id='.$result[$x]['upno'].'"><i class="glyphicon glyphicon-edit"></a>';
			 $html.="<tr>";
		}
		if(sizeof($result)==0){
			$html="<h4 class='text-center'>No Records Found</h4>";
		}
		$html.="</table>";
		echo $html;
	}
	
	public function list_railway($type,$name){
		if($type=="division"){
		
			$this->_db->query_assoc("SELECT * FROM r_master where division LIKE '{$name}%'");
		}
		else if($type=="control_officer")
		{
			$this->_db->query_assoc("SELECT * FROM r_master where control_officer LIKE '{$name}%'");
		}
		$result=$this->_db->results();
		$html="<table class='table table-hover' id='search-result-table'><th>sd</th><th>ls</th>
		<th>division</th><th>control_officer</th><th>DELETE</th><th>EDIT</th>";
		for($x=0;$x<sizeof($result);$x++){
			$html.="<tr>";
				$html.="<td>".$result[$x]["sd"]."</td>";
				$html.="<td>".$result[$x]["ld"]."</td>";
				$html.="<td>".$result[$x]["division"]."</td>";
				$html.="<td>".$result[$x]["control_officer"]."</td>";
				$html.='<td><a class="anchor delete" href="'.$result[$x]['id'].'"><i class="glyphicon glyphicon-trash"></a>';
				$html.='<td><a class="anchor edit" href="edit_railway.php?id='.$result[$x]['id'].'"><i class="glyphicon glyphicon-edit"></a>';
			 $html.="<tr>";
		}
		$html.="</table>";
		echo $html;
	}
	
	
	
	public function list_demand($type,$name){
		if($type=="irno"){
		
			$this->_db->query_assoc("SELECT * FROM demand where irno LIKE '{$name}%'");
		}
		else if($type=="sodate")
		{
			$this->_db->query_assoc("SELECT * FROM demand where sodate LIKE '{$name}%'");
		}
		$result=$this->_db->results();
		$html="<table class='table table-hover' id='search-result-table'><th>irno</th><th>irdt</th>
		<th>sono</th><th>sodate</th><th>upno</th><th>indlr</th><th>inddt</th><th>indqty</th><th>unit</th><th>diun</th><th>consig</th><th>cooffcr</th><th>alloc</th><th>acvt</th><th>DELETE</th><th>EDIT</th>";
		for($x=0;$x<sizeof($result);$x++){
			$html.="<tr>";
				$html.="<td>".$result[$x]["irno"]."</td>";
				$html.="<td>".$result[$x]["irdt"]."</td>";
				$html.="<td>".$result[$x]["sono"]."</td>";
				$html.="<td>".$result[$x]["sodate"]."</td>";
				$html.="<td>".$result[$x]["upno"]."</td>";
				$html.="<td>".$result[$x]["indlr"]."</td>";
				$html.="<td>".$result[$x]["inddt"]."</td>";
				$html.="<td>".$result[$x]["indqty"]."</td>";
				$html.="<td>".$result[$x]["unit"]."</td>";
				$html.="<td>".$result[$x]["diun"]."</td>";
				$html.="<td>".$result[$x]["consig"]."</td>";
				$html.="<td>".$result[$x]["cooffcr"]."</td>";
				$html.="<td>".$result[$x]["alloc"]."</td>";
				$html.="<td>".$result[$x]["acvt"]."</td>";
				$html.='<td><a class="anchor delete" href="'.$result[$x]['id'].'"><i class="glyphicon glyphicon-edit"></a>';
				$html.='<td><a class="anchor edit" href="edit_rate.php?id='.$result[$x]['id'].'"><i class="glyphicon glyphicon-edit"></a>';
			 $html.="<tr>";
		}
		$html.="</table>";
		echo $html;
	}
	
	
	public function list_consignee($type,$name){
		if($type=="division"){
		
			$this->_db->query_assoc("SELECT * FROM consignee_master where division LIKE '{$name}%'");
		}
		else if($type=="control_officer")
		{
			$this->_db->query_assoc("SELECT * FROM consignee_master where control_officer LIKE '{$name}%'");
		}
		$result=$this->_db->results();
		$html="<table class='table table-hover' id='search-result-table'><th>Railway</th><th>Division</th>
		<th>Consignee</th><th>control officer</th><th>account unit</th><th>DELETE</th><th>EDIT</th>";
		for($x=0;$x<sizeof($result);$x++){
			$html.="<tr>";
				$html.="<td>".$result[$x]["railway"]."</td>";
				$html.="<td>".$result[$x]["division"]."</td>";
				$html.="<td>".$result[$x]["consignee"]."</td>";
				$html.="<td>".$result[$x]["control_officer"]."</td>";
				$html.="<td>".$result[$x]["account_unit"]."</td>";
				$html.='<td><a class="anchor delete" href="'.$result[$x]['id'].'"><i class="glyphicon glyphicon-trash"></a>';
				$html.='<td><a class="anchor edit" href="edit_consignee.php?id='.$result[$x]['id'].'"><i class="glyphicon glyphicon-edit"></a>';
			 $html.="<tr>";
		}
		$html.="</table>";
		echo $html;
	}
	
	
	public function list_rate($type,$name){
		if($type=="rate"){
		
			$this->_db->query_assoc("SELECT * FROM rate where rate LIKE '{$name}%'");
		}
		else if($type=="upno")
		{
			$this->_db->query_assoc("SELECT * FROM rate where upno LIKE '{$name}%'");
		}
		$result=$this->_db->results();
		$html="<table class='table table-hover' id='search-result-table'><th>upno</th><th>sd</th>
		<th>plno</th><th>pending demand</th><th>rate</th><th>schedule for current</th><th>schedule for next</th><th>anticipated outcome</th><th>Delete</th><th>Edit</th>";
		for($x=0;$x<sizeof($result);$x++){
			$html.="<tr>";
				$html.="<td>".$result[$x]["upno"]."</td>";
				$html.="<td>".$result[$x]["sd"]."</td>";
				$html.="<td>".$result[$x]["plno"]."</td>";
				$html.="<td>".$result[$x]["pending_demand"]."</td>";
				$html.="<td>".$result[$x]["rate"]."</td>";
				$html.="<td>".$result[$x]["sc_for_current"]."</td>";
				$html.="<td>".$result[$x]["sc_for_next"]."</td>";
				$html.="<td>".$result[$x]["outcome"]."</td>";
				$html.='<td><a class="anchor delete" href="'.$result[$x]['id'].'"><i class="glyphicon glyphicon-trash"></a>';
				$html.='<td><a class="anchor edit" href="edit_rate.php?id='.$result[$x]['id'].'"><i class="glyphicon glyphicon-edit"></a>';
			 $html.="<tr>";
		}
		$html.="</table>";
		echo $html;
	}
	
	
	public function delete_rate($id){
		$this->_db->delete("rate",array('id','=',$id));
	}
	
	public function delete_demand($id){
		$this->_db->delete("demand",array('id','=',$id));
	}
	
	public function delete_consignee($id){
		$this->_db->delete("consignee_master",array('id','=',$id));
	}
	
	public function delete_railway($id){
		$this->_db->delete("r_master",array('id','=',$id));
	}
	
	public function delete_product($upno){
		echo $upno; 
		$this->_db->delete("p_master",array('upno','=',$upno));
	}
	public function get_product($upno){
		$result=$this->_db->get("p_master",array('upno','=',$upno));
		echo json_encode($result->first());
	}
	public function delete_user($id){
		$this->_db->delete("users",array('id','=',$id));
	}
	public function get_user($id){
		$this->_db->get("users",array('id','=',$id));
	}
	
	public function upload_pics() {
	
    $maxsize = 10000000; //set to approx 10 MB
	
    
        //check whether file is uploaded with HTTP POST
        if(isset($_FILES['userfile']['tmp_name'])) {    

            //checks size of uploaded image on server side
            if( $_FILES['userfile']['size'] < $maxsize) {  
  
               //checks whether uploaded file is of image type
              //if(strpos(mime_content_type($_FILES['userfile']['tmp_name']),"image")===0) {
    //             $finfo = finfo_open(FILEINFO_MIME_TYPE);
                //if(strpos(finfo_file($finfo, $_FILES['userfile']['tmp_name']),"image")===0) {    

                    // prepare the image for insertion
                    $imgData =addslashes (file_get_contents($_FILES['userfile']['tmp_name']));

                    // put the image in the db...
                    // database connection

                    // our sql query
                    $sql = "INSERT INTO products
                    (picture, pic_name)
                    VALUES
                    ('{$imgData}', '{$_FILES['userfile']['name']}');";

                    // insert the image
					$pic_name = $_FILES['userfile']['name'];
					if($this->_db->query($sql)){
                    $id = $this->_db->query_assoc("select id from products where pic_name = '$pic_name' order by id desc limit 1;");
					$id = $id->results();
					
					$msg = $id[0]['id'];
					}
                    
                //}
                //else
                  //$msg="error";
            }
             else {
                // if the file is not less than the maximum allowed, print an error
                $msg='error_max';
                }
        }
        else
            $msg="error1";

    
    
    return $msg;
}

public function list_status($status,$page,$path){

		$num_rec_per_page=10;
		$start_from = ($page-1) * $num_rec_per_page;

		$result_count = $this->_db->query_assoc("SELECT orders.id,orders.consignee_id,orders.date,status.status FROM orders inner join status on orders.status  = status.id and orders.status = '$status';");
		$total_records = $result_count->rcount();
		
		if($total_records != 0){
		$total_pages = ceil($total_records / $num_rec_per_page); 

		//$html =  "<p>Page NO: ". ++$page." ";
		//$html.= " Total record: ".$total_records." ";
		
		$html="";
		if($total_records > $num_rec_per_page){
		$html="<div style='margin-left:20px'><ul style='display:inline-block' class='text-center pagination'>";
		if($page-1 > 0){
		$html.= "<li><a href='".$path."?page=".$t1=$page-1 ."'>Previous</a> </li>";  
		}
		for ($i=1; $i<=$total_pages; $i++) { 
            $html.= "<li";
			if($i==$page){
				$html.=" class='active'";
			}
			$html.="><a href='".$path."?page=".$i."'>".$i."</a> </li>"; 
		} 
		if($page != $total_pages){
		$html.= "<li><a href='".$path."?page=".$t2=$page+1 ."'>Next</a> </li>";
		}
		$html.="</ul></div>";
		}




		$status1 = $this->_db->query_assoc("SELECT orders.id,orders.consignee_id,orders.date,status.status FROM orders inner join status on orders.status  = status.id and orders.status = '$status' order by id desc LIMIT $start_from, $num_rec_per_page;");
		
		if($status1->count() > 0){
		//$html.= " showing from : ". $stot = $start_from+1 ." To : ". $tot = $start_from + $status1->count() . "</p>";
		}
		$result=$status1->results();
		
		$html.="<table class='table table-hover '><th>Purchase ID</th>
		<th>Consignee ID</th><th>Date</th><th>Status</th>";if($status!='6' && $status!='3'){
		$html.=	"<th>Send Acknowledgement</th>";	
		}
		if($status === '0'){
		$html.="<th>Proceed order</th>";
		$html.="<th>Reject order</th>";
		}
		$html.="<th>View Indent</th>";
		for($x=0;$x<sizeof($result);$x++){
			$html.="<tr>";
				$p_id = 'P'.$result[$x]["id"];
				$html.="<td><a class='purchase_id' data-pid='".$result[$x]["id"]."'>".$p_id."</a></td>";
				$html.="<td><a>".$result[$x]['consignee_id']."</a></td>";
				$html.="<td>".$result[$x]["date"]."</td>";
				$html.="<td>".$result[$x]["status"]."</td>";
				if($status!='6'&&$status!='3'){
				$html.="<td><a class='purchase_ack' data-pid=\"".$p_id."\" data-cid=\"".$result[$x]['consignee_id']."\" ><i class='glyphicon glyphicon-comment'></a></td>";
				}
				
				if($status === '0'){
				$html.="<td><a class='purchase_accept' data-pid=\"".$p_id."\" data-cid=\"".$result[$x]['consignee_id']."\" ><i style='color:green' class='glyphicon glyphicon-ok'></a></td>";
				$html.="<td><a class='purchase_reject' data-pid=\"".$p_id."\" data-cid=\"".$result[$x]['consignee_id']."\" ><i style='color:red' class='glyphicon glyphicon-remove'></a></td>";
				}
				$html.="<td><a class='view-indent' data-pid='".$result[$x]["id"]."'>View</a></td>";
				
			 $html.="<tr>";
		}
		$html.="</table>";
		echo $html;
		}
		else{
			echo "<center><h4>No records found</h4></center>";
		}
	}


	
	
	
	
	
	
	
	
	
	
	
	
	

}	

