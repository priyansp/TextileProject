<?php
require_once 'DB.php';
require_once 'core/init.php';	

class result_process{
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
	
	public function result_using_excel_sheet($filename){
		$data = new Spreadsheet_Excel_Reader($filename);
		for($i=0;$i<count($data->sheets);$i++){
				if(count($data->sheets[$i]['cells'])>0){
					for($j=1;$j<=count($data->sheets[$i]['cells']);$j++){ 
try {
            $pdo = new PDO('mysql:host=' . config::get('mysql/host') . ';dbname=' . config::get('mysql/db'), config::get('mysql/username'), config::get('mysql/password'));
        } catch(PDOException $e) {
            die($e->getMessage());
        }
$id=$data->sheets[$i]['cells'][$j][1];
$username=$data->sheets[$i]['cells'][$j][2];
$sql = "INSERT INTO `placement`(`id`, `department`, `eligible`, `unique`, `percentage`, `category`) VALUES (55,'.$username.',100,200,85.5,'ug')";
if(!$pdo->exec($sql))
echo "fukd";
						
						}
					}
				}
		}
	}