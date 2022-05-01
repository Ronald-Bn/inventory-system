<?php include 'db_connect.php';

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM sales_list where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k => $val){
		$$k = $val;
	}

	$inv = $conn->query("SELECT * FROM inventory where type=2 and form_id=".$_GET['id']);

}

?>
<div class="container-fluid">
	<div class="col-lg-12 pt-4">
		<div class="card">
			<div class="card-header">
				<h2><b>Insert Item</b></h2>
			</div>
			<div class="card-body">
				<form action="" id="save-defective">
					<input type="hidden" name="id">
					<div class="col-md-12">
						<div class="row">
							<div class="form-group col-md-5">
								<label class="control-label">Clerk</label>
								<select name="customer_id" class="custom-select browser-default select2">
									
								<?php 
								$customer = $conn->query("SELECT * FROM customer_list order by name asc");
								while($row=$customer->fetch_assoc()):
								?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
								<?php endwhile; ?>
								</select>
							</div>
						</div>
						<hr>
						<div class="row mb-3">
								<div class="col-md-4">
									<label class="control-label">Product</label>
									<select name="product" id="product" class="custom-select browser-default select2">
										<option value=""></option>
									<?php 
									$cat = $conn->query("SELECT * FROM category_list order by name asc");
										while($row=$cat->fetch_assoc()):
											$cat_arr[$row['id']] = $row['name'];
										endwhile;
									$product = $conn->query("SELECT * FROM product_list  order by name asc");
									while($row=$product->fetch_assoc()):
										$prod[$row['id']] = $row;
									?>
										<option value="<?php echo $row['sku'].'|'. $row['id'] .'|'. $row['name'] ?> " data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>"><?php echo $row['name'] . ' | ' . $row['sku'] ?></option>
									<?php endwhile; ?>
									</select>
								</div>
								<div class="col-md-2">
									<label class="control-label">Qty</label>
									<input type="number" class="form-control text-right" name="qty" id="qty">
								</div>
                                <div class="col-md-4">
									<label class="control-label">Date Purchase (MM/DD/YYYY)</label>
									<input type="text" class="form-control text-left" name="date_purchase">
								</div>
                                <div class="col-md-10">
									<label class="control-label">Remarks</label>
									<input type="text" class="form-control text-left" style="text-transform:uppercase" name="remarks">
								</div>
								<div class="col-md-12">
									<label class="control-label">&nbsp</label>
									<button class="btn btn-block btn-sm btn-primary"><i class="fa fa-plus"></i> Save</button>
								</div>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>
</div>
<script>
		$('#save-defective').submit(function(e){
			e.preventDefault()
			start_load()
			if($('#qty').val() == ''){
			alert_toast("Please complete the fields first",'danger');
			end_load();
			return false;
		}
			$.ajax({
			url:'ajax.php?action=save_defective',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					alert_toast("Something, Wrong")
					end_load();
					return false;
				}
			}
		})
	})
</script>