<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_category"){
	$save = $crud->save_category();
	if($save)
		echo $save;
}
if($action == "delete_category"){
	$save = $crud->delete_category();
	if($save)
		echo $save;
}

if($action == "save_supplier"){
	$save = $crud->save_supplier();
	if($save)
		echo $save;
}
if($action == "delete_supplier"){
	$save = $crud->delete_supplier();
	if($save)
		echo $save;
}
if($action == "save_product"){
	$save = $crud->save_product();
	if($save)
		echo $save;
}

if($action == "edit_product"){
	$save = $crud->edit_product();
	if($save)
		echo $save;
}

if($action == "delete_product"){
	$save = $crud->delete_product();
	if($save)
		echo $save;
}

if($action == "save_customer"){
	$save = $crud->save_customer();
	if($save)
		echo $save;
}
if($action == "delete_customer"){
	$save = $crud->delete_customer();
	if($save)
		echo $save;
}

//save-defective
if($action == "save_defective"){
	$save = $crud->save_defective();
	if($save)
		echo $save;
}

//edit-defective
if($action == "edit_defective"){
	$save = $crud->edit_defective();
	if($save)
		echo $save;
}

//delete-defective
if($action == "delete_defective"){
	$save = $crud->delete_defective();
	if($save)
		echo $save;
}

//save-stock-in
if($action == "save_stockin"){
	$save = $crud->save_stockin();
	if($save)
		echo $save;
}

//edit-stock-in
if($action == "edit_stockin"){
	$save = $crud->edit_stockin();
	if($save)
		echo $save;
}

//delete-stock-in
if($action == "delete_stockin"){
	$save = $crud->delete_stockin();
	if($save)
		echo $save;
}

//save-stock-out 
if($action == "save_stockout"){
	$save = $crud->save_stockout();
	if($save)
		echo $save;
}

//edit-stock-out
if($action == "edit_stockout"){
	$save = $crud->edit_stockout();
	if($save)
		echo $save;
}

//delete-stock-out
if($action == "delete_stockout"){
	$save = $crud->delete_stockout();
	if($save)
		echo $save;
}

//restart attempts
if($action == "restart_attempts"){
	$save = $crud->restart_attempts();
	if($save)
		echo $save;
}






