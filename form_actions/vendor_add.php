<?php
require_once '../core/init.php';
if(input::exists()){
    $validate = new validate();
		$validation = $validate->check($_POST, array(
			'Vendor-Name' => array(
				'required' => true,
				'unique' => 'vendors,vendor_name'
			)
    ));
    if($validation->passed()){
        $db=DB::getInstance();
        if($db->insert('vendors',array(
        'vendor_name' => input::get('Vendor-Name'),
        'phone_number' => input::get('Phone'),
        'email' => input::get('Email'),
        'address' => input::get('Address'),
        'details' => input::get('Details'),
        ))){
            session::flash('vendor_add_success','Vendor has been added successfully');
            redirect::to('../pages/vendor_add.php');
        }
    }
    else{
        $validation->addFlash('vendor_add_failed');
        redirect::to('../pages/vendor_add.php');
    }
}
?>
