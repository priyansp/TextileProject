<?php
require_once '../core/init.php';
if(input::exists()){
    print_r($_POST);
    $validate = new validate();
		$validation = $validate->check($_POST, array(
			'Date' => array(
				'required' => true,
			)
    ));
    if($validation->passed()){
        $db=DB::getInstance();
        $type=input::get('Type');
        $date=input::get('Date');
        $vendor_list=input::get('Vendor-List');
        $product_list=input::get('Product-List');
        $quantity_list=input::get('Quantity-List');
        if($type){
            //Adding Stock 
            for($iterator=0;$iterator<count($vendor_list);$iterator++){
                $query="select * from dyes_stock where vendor_id = ${vendor_list[$iterator]} and product_id=${product_list[$iterator]};";
                
                $is_present = $db->query_assoc($query);
                
                $row_count=$is_present->rcount();
                
                if($row_count){
                    $present_row=$is_present->first();
                    $updated_quantity=$present_row['quantity']+$quantity_list[$iterator];
                    if($db->update_any('dyes_stock','stock_id',$present_row['stock_id'],array(
                    'quantity' => $updated_quantity,
                    ))){
                        //Adding a row in the history table
                        if($db->insert('dyes_history',array(
                        'stock_id' => $present_row['stock_id'],
                        'quantity' => $quantity_list[$iterator],
                        'type' =>$type,
                        'date' =>$date,
                        ))){
                        }
                    }
                }
                else{
                    if($db->insert('dyes_stock',array(
                    'vendor_id' => $vendor_list[$iterator],
                    'product_id' => $product_list[$iterator],
                    'quantity' =>$quantity_list[$iterator],
                    ))){
                        $inserted_row=$db->query_assoc($query);
                        
                        $inserted_row=$inserted_row->first();
                        //Adding a row in the history table
                        if($db->insert('dyes_history',array(
                        'stock_id' => $inserted_row['stock_id'],
                        'quantity' => $quantity_list[$iterator],
                        'type' =>$type,
                        'date' =>$date,
                        ))){
                        }
                    }
                }   
            }
        }
        else{
            for($iterator=0;$iterator<count($vendor_list);$iterator++){
                
                $query="select * from dyes_stock where vendor_id = ${vendor_list[$iterator]} and product_id=${product_list[$iterator]};";
                
                $is_present = $db->query_assoc($query);
                $row_count=$is_present->rcount();
                if($row_count){
                    if($quantity_list[$iterator]){
                        $present_row=$is_present->first();
                        if($present_row['quantity']>=$quantity_list[$iterator]){
                            $updated_quantity=$present_row['quantity']-$quantity_list[$iterator];
                            if($db->update_any('dyes_stock','stock_id',$present_row['stock_id'],array(
                            'quantity' => $updated_quantity,
                            ))){
                                if($db->insert('dyes_history',array(
                                'stock_id' => $present_row['stock_id'],
                                'quantity' => $quantity_list[$iterator],
                                'type' =>$type,
                                'date' =>$date,
                                ))){
                                }
                            }
                        }
                    }
                }
            }
        }
        session::flash("dyes_modify_success","Success!Stock has been updated successfully");
        redirect::to('../pages/dyes_modify.php');
    }
    else{
        die("validation failed");
        $validation->addFlash('dyes_modify_failed');
        redirect::to('../pages/dyes_modify.php');
    }
}
?>