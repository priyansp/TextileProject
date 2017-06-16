<?php
require_once '../core/init.php';
if(input::exists()){
    $validate = new validate();
		$validation = $validate->check($_POST, array(
			'Product-Name' => array(
				'required' => true,
				'unique' => 'product,product_name'
			),
            'Category' => array(
				'shouldnt_match' =>'not_selected',
			)
    ));
    if($validation->passed()){
        $db=DB::getInstance();
        if($db->insert('product',array(
        'product_name' => input::get('Product-Name'),
        'category_id' => input::get('Category'),
            
        ))){
            session::flash('product_add_success','Product has been added successfully');
            redirect::to('../pages/product_add.php');
        }
    }
    else{
        $validation->addFlash('product_add_failed');
        redirect::to('../pages/product_add.php');
    }
}
?>
