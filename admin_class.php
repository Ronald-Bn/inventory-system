<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;
	
	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}

	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM user_info where email = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			// $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
			// $this->db->query("UPDATE cart set user_id = '".$_SESSION['login_user_id']."' where client_ip ='$ip' ");
				return 1;
		}else{
			return 3;
		}
	}

	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		$data  .= ",attempts = 0 ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = " first_name = '$first_name' ";
		$data .= ", last_name = '$last_name' ";
		$data .= ", mobile = '$mobile' ";
		$data .= ", address = '$address' ";
		$data .= ", email = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM user_info where email = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO user_info set ".$data);
		if($save){
			$login = $this->login2();
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data." where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO category_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE category_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM category_list where id = ".$id);
		if($delete)
			return 1;
	}
	
	function save_supplier(){
		extract($_POST);
		$data = " supplier_name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO supplier_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE supplier_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_supplier(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM supplier_list where id = ".$id);
		if($delete)
			return 1;
	}
	function save_product(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", sku = '$sku' ";
		$data .= ", category_id = '$category_id' ";
		$data .= ", description = '$description' ";
		$data .= ", price = '$price' ";
		$data .= ", remarks = '$remarks' ";

		if(empty($id)){
			$save = $this->db->query("INSERT INTO product_list set ".$data);
		}
		if($save){
			return 1;
		}
	}

	function edit_product(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", sku = '$sku' ";
		$data .= ", category_id = '$category_id' ";
		$data .= ", description = '$description' ";
		$data .= ", price = '$price' ";
		$data .= ", remarks = '$remarks' ";

		if(!empty($id)){
			$save = $this->db->query("UPDATE product_list set ".$data." where id=".$id);
		}else{
			return 3;
		}
		if($save){
			return 2;
		}
	}

	function delete_product(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM product_list where id = ".$id);
		if($delete)
			return 1;
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}

	function save_customer(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO customer_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE customer_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_customer(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM customer_list where id = ".$id);
		if($delete)
			return 1;
	}

	//Save Defective
	function save_defective(){
		extract($_POST);

		$inn = $this->db->query("SELECT sum(qty) as inn FROM inventory where type = 1 and product_id = ".$product_id);
		$inn = $inn && $inn->num_rows > 0 ? $inn->fetch_array()['inn'] : 0;
		$out = $this->db->query("SELECT sum(qty) as `out` FROM inventory where type = 2 and product_id = ".$product_id);
		$out = $out && $out->num_rows > 0 ? $out->fetch_array()['out'] : 0;
		$available = $inn - $out;

		$check = $available - $qty;
		if($check < 0){
			return 2;
		}else{
			$ref_no = sprintf("%'.08d\n", $ref_no);
			$i = 1;
	
			while($i == 1){
				$chk = $this->db->query("SELECT * FROM inventory where ref_no ='$ref_no'")->num_rows;
				if($chk > 0){
					$ref_no = mt_rand(1,99999999);
					$ref_no = sprintf("%'.08d\n", $ref_no);
				}else{
					$i=0;
				}
			}
				$text = strtoupper($remarks);
				$data = " id = '$id' ";
				$data .= ", product_id = '$product_id' ";
				$data .= ", qty = '$qty' ";
				$data .= ", type = '3' ";
				$data .= ", stock_from = 'defective' ";
				$data .= ", ref_no = '$ref_no' ";
				$data .= ", remarks = '$text' ";
				$data .= ", date_purchase = '$date_purchase' ";
	
				$save2 = $this->db->query("INSERT INTO inventory set ".$data);
				
			if(isset($save2)){
				return 1;
			}
		}
	}

	//Edit Defective
	function edit_defective(){
		extract($_POST);

		$inn = $this->db->query("SELECT sum(qty) as inn FROM inventory where type = 1 and product_id = ".$product_id);
		$inn = $inn && $inn->num_rows > 0 ? $inn->fetch_array()['inn'] : 0;
		$out = $this->db->query("SELECT sum(qty) as `out` FROM inventory where type = 2 and product_id = ".$product_id);
		$out = $out && $out->num_rows > 0 ? $out->fetch_array()['out'] : 0;
		$available = $inn - $out;

		$check = $available - $qty;
		if($check < 0){
			return 2;
		}
		
		
		if(!empty($id)){

				$data = " id = '$id' ";
				if(!empty($product_id) ){
					$data .= ", product_id = '$product_id' ";
				}

				$text = strtoupper($remarks);
				$data .= ", qty = '$qty' ";
				$data .= ", type = '3' ";
				$data .= ", stock_from = 'defective' ";
				$data .= ", ref_no = '$ref_no' ";
				$data .= ", remarks = '$text' ";
				$data .= ", date_purchase = '$date_purchase' ";
	
				$save2 = $this->db->query("UPDATE inventory set ".$data." where id=".$id);
				
			if(isset($save2)){
				return 1;
			}
		}
	}

	//Delete Defective
	function delete_defective(){
		extract($_POST);
		$del1 = $this->db->query("DELETE FROM inventory where type = 3 and id = $id ");
		if($del1)
			return 1;
	}

	//Save Stock In
	function save_stockin(){
		extract($_POST);
		
		if(empty($id)){
			$ref_no = sprintf("%'.08d\n", $ref_no);
			$i = 1;
	
			while($i == 1){
				$chk = $this->db->query("SELECT * FROM inventory where ref_no ='$ref_no'")->num_rows;
				if($chk > 0){
					$ref_no = mt_rand(1,99999999);
					$ref_no = sprintf("%'.08d\n", $ref_no);
				}else{
					$i=0;
				}
			}
				$data = " id = '$id' ";
				$data .= ", supplier_id = '$supplier_id' ";
				$data .= ", product_id = '$product_id' ";
				$data .= ", qty = '$qty' ";
				$data .= ", type = '1' ";
				$data .= ", stock_from = 'stockin' ";
				$data .= ", ref_no = '$ref_no' ";
				$data .= ", date_expiration = '$date_expiration' ";

				$save2 = $this->db->query("INSERT INTO inventory set ".$data);
				
			if(isset($save2)){
				return 1;
			}
		}
	}

	//Edit Stock In
	function edit_stockin(){
		extract($_POST);
		
		if(!empty($id)){

				$data = " id = '$id' ";
				if(!empty($supplier_id) ){
					$data .= ", supplier_id = '$supplier_id' ";
				}
				if(!empty($product_id) ){
					$data .= ", product_id = '$product_id' ";
				}
				$data .= ", qty = '$qty' ";
				$data .= ", type = '1' ";
				$data .= ", stock_from = 'stockin' ";
				$data .= ", ref_no = '$ref_no' ";
				$data .= ", date_expiration = '$date_expiration' ";

	
				$save2 = $this->db->query("UPDATE inventory set ".$data." where id=".$id);
				
			if(isset($save2)){
				return 1;
			}
		}
	}

	function delete_stockin(){
		extract($_POST);
		$del2 = $this->db->query("DELETE FROM inventory where type = 1 and id = $id ");
		if($del2)
			return 1;
	}


	//Save Stock Out
	function save_stockout(){
		extract($_POST);
	
		$inn = $this->db->query("SELECT sum(qty) as inn FROM inventory where type = 1 and product_id = ".$product_id);
		$inn = $inn && $inn->num_rows > 0 ? $inn->fetch_array()['inn'] : 0;
		$out = $this->db->query("SELECT sum(qty) as `out` FROM inventory where type = 2 and product_id = ".$product_id);
		$out = $out && $out->num_rows > 0 ? $out->fetch_array()['out'] : 0;
		$available = $inn - $out;

		$check = $available - $qty;
		if($check < 0){
			return 2;
		}else{
			$ref_no = sprintf("%'.08d\n", $ref_no);
			$i = 1;
	
			while($i == 1){
				$chk = $this->db->query("SELECT * FROM inventory where ref_no ='$ref_no'")->num_rows;
				if($chk > 0){
					$ref_no = mt_rand(1,99999999);
					$ref_no = sprintf("%'.08d\n", $ref_no);
				}else{
					$i=0;
				}
			}
				$data = " id = '$id' ";
				$data .= ", users_id = '$users_id' ";
				$data .= ", product_id = '$product_id' ";
				$data .= ", qty = '$qty' ";
				$data .= ", type = '2' ";
				$data .= ", stock_from = 'stockout' ";
				$data .= ", ref_no = '$ref_no' ";
	
				$save2 = $this->db->query("INSERT INTO inventory set ".$data);
				
			if(isset($save2)){
				return 1;
			}
		}
	}

	//Edit Stock Out
	function edit_stockout(){
		extract($_POST);

		if(!empty($id)){

				$data = " id = '$id' ";
				if(!empty($users_id) ){
					$data .= ", users_id = '$users_id' ";
				}
				if(!empty($product_id) ){
					$data .= ", product_id = '$product_id' ";
				}
				$data .= ", qty = '$qty' ";
				$data .= ", type = '2' ";
				$data .= ", stock_from = 'stockout' ";
				$data .= ", ref_no = '$ref_no' ";
				
				$save2 = $this->db->query("UPDATE inventory set ".$data." where id=".$id);
				
			if(isset($save2)){
				return 1;
			}
		}
	}

	//Delete Stock Out
	function delete_stockout(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM inventory where type = 2 and id = $id ");
		if($delete){
			return 1;
		}
	}

}