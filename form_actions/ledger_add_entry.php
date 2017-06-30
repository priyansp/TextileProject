<?php
require_once '../core/init.php';
if(input::exists()){
    $entry_type=input::get('Entry-Type');
    $validate = new validate();
		$validation = $validate->check($_POST, array(
			'Reference' => array(
				'required' => true,
			),
            'Amount' => array(
				'required' => true,
			),
            'Date' => array(
				'required' => true,
			),
            'Vendor' => array(
				'shouldnt_match' =>'not_selected',
			)
    ));
    if($validation->passed()){
        $db=DB::getInstance();
        
        $vendor_id=input::get('Vendor');
        $amount=input::get('Amount');
        $current_date=date("Y-m-d h:i:sa");
        $date=input::get('Date');
        $reference=input::get('Reference');
        
        $query="select * from ledger where ledger_entry_id in (select MAX(ledger_entry_id) from ledger where vendor_id=${vendor_id});";
        $result= $db->query_assoc($query);
        $last_balance=0;
        $updated_balance=0;
        if($result->count()){
            $last_row= $result->results();
            $last_balance=$last_row[0]['balance'];
        }
        if($entry_type==1||$entry_type==3){
            $updated_balance=$last_balance+$amount;
        }
        else{
            $updated_balance=$last_balance-$amount;
        }
        if($updated_balance<0){
            session::flash('ledger_entry_add_failed',"Cannot Reduce Rs.${amount} from available Rs.${last_balance}");
            if($entry_type==1 || $entry_type==2){
                redirect::to('../pages/ledger_purchase_entry.php');
            }
            else{
                redirect::to('../pages/ledger_sale_entry.php');
            }
        }
        if($db->insert('ledger',array(
            'vendor_id' => $vendor_id,
            'reference' => $reference,
            'entry_type' =>$entry_type,
            'amount' =>$amount,
            'balance' =>$updated_balance,
            'bill_for'=>$date,
            'billed_on'=>$current_date,
            ))){
                session::flash('ledger_entry_add_success','Entry has been added successfully');
                if($entry_type==1 || $entry_type==2){
                redirect::to('../pages/ledger_purchase_entry.php');
                }
                else{
                    redirect::to('../pages/ledger_sale_entry.php');
                }
        }

    }
    else{
        $validation->addFlash('ledger_entry_add_failed');
        if($entry_type==1 || $entry_type==2){
            redirect::to('../pages/ledger_purchase_entry.php');
        }
        else{
            redirect::to('../pages/ledger_sale_entry.php');
        }
    }
}
?>
