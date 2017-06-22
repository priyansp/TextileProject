<?php
require_once '../core/init.php';
if(input::exists()){
    $validate = new validate();
		$validation = $validate->check($_POST, array(
			'Lot-No' => array(
				'required' => true,
			),
            'Weight' => array(
				'required' => true,
			),
            'Date' => array(
				'required' => true,
			),
            'Count' => array(
				'required' => true,
			),
            'Party' => array(
				'required' => true,
			),
            'Shade' => array(
				'required' => true,
			),
            'Profit' => array(
				'required' => true,
			),
            'Total-Price' => array(
				'required' => true,
			),
            'Per-Kg' => array(
				'required' => true,
			),
    ));
    if($validation->passed()){
        $db=DB::getInstance();
        //Getting Inputs
        $lot_no=input::get('Lot-No');
        $weight=input::get('Weight');
        $date=input::get('Date');
        $count=input::get('Count');
        $party=input::get('Party');
        $shade=input::get('Shade');
        $profit=input::get('Profit');
        $total_price=input::get('Total-Price');
        $per_kg_price=input::get('Per-Kg');
        
        $product_list=input::get('Product-List');
        $quantity_list=input::get('Quantity-List');
        $rate_list=input::get('Rate-List');
        $amount_list=input::get('Amount-List');
        $current_date=date("Y-m-d h:i:sa");
        $product_json=array();
        
        for($i=0;$i<count($product_list);$i++){
            $current_product=array();
            $current_product['product_name']=$product_list[$i];
            $current_product['quantity']=$quantity_list[$i];
            $current_product['rate']=$rate_list[$i];
            $current_product['amount']=$amount_list[$i];
            $product_json[]=$current_product;
        }
        $json=json_encode($product_json);
        
        if($db->insert('lot_details',array(
        'lot_no' => $lot_no,
        'weight' => $weight,
        'date' => $date,
        'count' =>$count,
        'party_name' =>$party,
        'shade_name' =>$shade,
        'profit' =>$profit,
        'total_price'=>$total_price,
        'per_kg_price'=>$per_kg_price,
        'products'=>$json
        ))){
        }
        
        session::flash("lot_add_success","Success!Lot Details has been added successfully");
        redirect::to('../pages/lot_add.php');
    }
    else{
        $validation->addFlash('lot_add_failed');
        redirect::to('../pages/lot_modify.php');
    }
}
?>