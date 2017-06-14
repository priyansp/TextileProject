<?php
error_reporting(E_ALL);
include 'PHPExcel/IOFactory.php';
include 'PHPExcel/Writer/Excel2007.php';
        
class Backup{
	private $_db,$_tables,
			$_result,
			$_objPHPExcel;
	
	public function __construct(){
		$this->_db=DB::getInstance();
		$this->_tables=array("consignee_master","p_master","r_master","orders");
		$this->_objPHPExcel=new PHPExcel();
		echo "<script> $('.cssload-preloader').show(); </script>";
	}
	public function set_properties($index){
		$objPHPExcel=$this->_objPHPExcel;
		$objPHPExcel->getProperties()->setCreator("Admin");
        $objPHPExcel->getProperties()->setLastModifiedBy("Admin");
        
    }
	public function get_data($index){	
	$current=$this->_tables[$index];
	$sql="SELECT * FROM {$current}";
	$this->_result=$this->_db->query_assoc($sql);
	$this->_result=$this->_db->results();
	}
	public function write_data($index){
		$arraylabel=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ","BA","BB","BC","BD");
		
		$headers=array(array("id","Consignee Id","Railway","Division","Consignee","Control Officer","Account Unit"),array("id","upno","plno","Short Description","Long Description","Rate"),array("Short Description","Long Description","Division","Control Officer"),array("id","consignee id","date","upno","qty","qty_remaining"));
		
		$keys=array(array("id","consignee_id","railway","division","consignee","control_officer","account_unit"),array("id","upno","plno","sd","ld","rate"),array("sd","ld","division","control_officer","id"),array("id","consignee_id","date","upno","qty","qty_remaining"));
		
		$objPHPExcel=$this->_objPHPExcel;
		$this->set_properties($index);
		$this->get_data($index);
		$this->_objPHPExcel->setActiveSheetIndex(0);
		$result=$this->_result;
		$num_fields=count($headers[$index]);
		
		for($k=0;$k<$num_fields;$k++){
			$cellName = $arraylabel[$k]."1";
			$objPHPExcel->getActiveSheet()->SetCellValue($cellName, $headers[$index][$k]);
		}
		
		for($i=0;$i<count($result);$i++){
			for($j=0;$j<$num_fields;$j++){
				$cellName = $arraylabel[$j].($i+2);
				$objPHPExcel->getActiveSheet()->SetCellValue($cellName,$result[$i][$keys[$index][$j]]);
			}
		}
		$current=$this->_tables[$index];
		$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $dateCreated = $date->format('D_d-m-Y_T_H.i.s');
		$filename = "backups/{$current}_".$dateCreated.".xlsx";
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($filename);
        }
		
}