<?php include 'db_connect.php' ?>
<?php include 'modal.php' ?>
<div class="container-fluid">
	<div class="col-lg-12 pt-4">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
				<div class="card-header">
						<div class="row">
							<div class="col-6"><h2><b>Stock Out</b></h2></div>
							<div class="col-6">
							<button class="col-md-2 float-right btn btn-primary btn-sm active" id="print-stockout">Print <i class="fa fa-print"></i></button>
							<button class="col-md-4 float-right btn btn-primary btn-sm" href="#insert_modal_stock_out"  data-toggle="modal">New Stock <i class="fa fa-plus"></i></button></div>
						</div>
					</div>	
					<div class="card-body" id="print_stockout">
						<table class="table table-bordered" id="tblInventories">
							<thead>
								<th class="wborder text-center">#</th>
								<th class="wborder text-center">Product</th>
								<th class="wborder text-center">Qty</th>
								<th class="wborder text-center">Date</th>
								<th class="wborder text-center">Reference #</th>
								<th class="wborder text-center">Clerk</th>
								<th class="wborder text-center hide-table">Action</th>
							</thead>
							<tbody>
							<?php 
								$users = $conn->query("SELECT * FROM users order by name asc");
								while($row=$users->fetch_assoc()):
									$users_arr[$row['id']] = $row['name'];
								endwhile;
									$users_arr[0] = "GUEST";

								$product = $conn->query("SELECT * FROM product_list order by name asc");
								while($row=$product->fetch_assoc()):
									$pro_arr[$row['id']] = $row['name'];
								endwhile;

								$i = 1;
								$sales = $conn->query("SELECT * FROM `inventory` WHERE type= 2 ORDER BY `date_updated` DESC");
								while($row=$sales->fetch_assoc()):
							?>
								<tr>
									<td class="wborder text-center"><?php echo $i++ ?></td>
									<td class="wborder txt-cen"><?php echo isset($pro_arr[$row['product_id']]) ? $pro_arr[$row['product_id']] :'N/A' ?></td>
									<td class="wborder txt-cen"><?php echo $row['qty'] ?></td>
									<td class="wborder txt-cen"><?php echo date("m/d/Y",strtotime($row['date_updated'])) ?></td>
									<td class="wborder txt-cen"><?php echo $row['ref_no'] ?></td>
									<td class="wborder txt-cen"><?php echo isset($users_arr[$row['users_id']])? $users_arr[$row['users_id']] :'N/A' ?></td>
									<td class="wborder text-center hide-table">
									<a class="btn btn-sm btn-primary" href="#edit_modal_stock_out"  data-toggle="modal" data-item-id="<?php echo $row['id'] ?>" data-users-id="<?php echo $users_arr[$row['users_id']] ?>" data-product-id="<?php echo $pro_arr[$row['product_id']] ?>" data-qty-id="<?php echo $row['qty'] ?>" data-ref-id="<?php echo $row['ref_no'] ?>">Edit</a>
										<a class="btn btn-sm btn-danger" href="#remove_stock_out_modal"  data-toggle="modal" data-item-id="<?php echo $row['id'] ?>">Delete</a>
									</td>
								</tr>
							<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('.select2').select2({
	 	placeholder:"Please select here",
	 	width:"100%"
	})

	$('#remove_stock_out_modal').on('show.bs.modal', function(e) {
    var bookId = $(e.relatedTarget).data('item-id');
    $(e.currentTarget).find('input[name="id"]').val(bookId);
	});

	$('#edit_modal_stock_out').on('show.bs.modal', function(e) {
    var item_Id = $(e.relatedTarget).data('item-id');
	var users_Id = $(e.relatedTarget).data('users-id');
	var product_Id = $(e.relatedTarget).data('product-id');
	var qty_Id = $(e.relatedTarget).data('qty-id');
	var ref_Id = $(e.relatedTarget).data('ref-id');
	$('.users').select2({
	 	placeholder: users_Id,
	 	width:"100%"
	})
	$('.product').select2({
	 	placeholder: product_Id,
	 	width:"100%"
	})
    $(e.currentTarget).find('input[name="id"]').val(item_Id);
	$(e.currentTarget).find('input[name="qty"]').val(qty_Id);
	$(e.currentTarget).find('input[name="ref_no"]').val(ref_Id);
	});
	
	$('table').dataTable()
	$('#delete-stockout').submit(function(e){
			e.preventDefault()
			start_load()
			$.ajax({
			url:'ajax.php?action=delete_stockout',
			data: new FormData($(this)[0]),
			cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					alert_toast("Something wrong",'danger')
				}
			}
		})	
	})

	
	$('#save-stockout').submit(function(e){
			e.preventDefault()
			start_load()

			var product = $('#product').val(),
			qty = $('#qty').val(),
			users = $('#users').val();

			if(product == '' || qty == '' || users ==''){
				end_load()
				alert_toast("Please complete the fields first",'danger')
				return false;
			}
			$.ajax({
			url:'ajax.php?action=save_stockout',
		    method	: 'POST',
		    data: $(this).serialize(),
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.href = "index.php?page=stock-out"
					},1500)
				}
				if(resp==2){
					end_load()
					alert_toast("Product quantity is greater than available stock.",'danger')
				}
			}
		})	
	})

	$('#edit-stockout').submit(function(e){
			e.preventDefault()
			start_load()
			var qty = $('#qty').val();

			if(qty == ''){
				end_load()
				alert_toast("Quantity field is empty",'danger')
				return false;
			}
			$.ajax({
			url:'ajax.php?action=edit_stockout',
		    method	: 'POST',
		    data: $(this).serialize(),
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.href = "index.php?page=stock-out"
					},1500)
				}
			}
		})	
	})

	$('#print-stockout').click(function(){
		var _html = $('#print_stockout').clone();
		var newWindow = window.open("","_blank","menubar=no,scrollbars=yes,resizable=yes,width=900,height=700");
		newWindow.document.write('<html><head><title></title><link rel="stylesheet" type="text/css" href="styles.css"></head><body>');
		newWindow.document.write('<h2>Stock Out Report</h2>')
		newWindow.document.write(_html.html())
		newWindow.document.write('</body></html>');
		setTimeout(function(){;newWindow.print();}, 500);
		setTimeout(function(){;newWindow.close();}, 1500);
	})
	
</script>