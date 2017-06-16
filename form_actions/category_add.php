<?php
require_once '../core/init.php';
if(input::exists()){
    $validate = new validate();
		$validation = $validate->check($_POST, array(
			'Category-Name' => array(
				'required' => true,
				'unique' => 'category,category_name'
			)
    ));
    if($validation->passed()){
        $db=DB::getInstance();
        if($db->insert('category',array(
        'category_name' => input::get('Category-Name')
        ))){
            session::flash('category_add_success','Category has been added successfully');
            redirect::to('../pages/category_add.php');
        }
    }
    else{
        $validation->addFlash('category_add_failed');
        redirect::to('../pages/category_add.php');
    }
}
?>
