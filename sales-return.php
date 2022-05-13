<?php include 'db_connect.php' ?>
<div class="container-fluid">
	<div class="col-lg-12 pt-4">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-6"><h2><b>Defective item</b></h2></div>
							<div class="col-6">
								<button class="col-md-2 float-right btn btn-primary btn-sm active" id="print-defective">Print <i class="fa fa-print"></i></button>
								<button class="col-md-3 float-right btn btn-primary btn-sm" id="insert_item">Insert item <i class="fa fa-plus"></i></button></div>
						</div>
					</div>
					<div class="card-body" id="print_defective">
						<table class="table table-bordered" id="tblInventories">
							<thead>
								<th class="wborder text-center">#</th>
								<th class="wborder text-center">Product</th>
								<th class="wborder text-center">Qty</th>
								<th class="wborder text-center">Date</th>
								<th class="wborder text-center">Date Purchase</th>
                                <th class="wborder text-center">Remarks</th>
								<th class="wborder text-center hide-table">Action</th>
							</thead>
							<tbody>
							<?php 
								$customer = $conn->query("SELECT * FROM customer_list order by name asc");
								while($row=$customer->fetch_assoc()):
									$cus_arr[$row['id']] = $row['name'];
								endwhile;
									$cus_arr[0] = "GUEST";

								$i = 1;
								$sales = $conn->query("SELECT * FROM defective_list  order by date_updated desc");
								while($row=$sales->fetch_assoc()):
							?>
								<tr>
									<td class="wborder text-center"><?php echo $i++ ?></td>
									<td class="wborder"><?php echo $row['product_name']?></td>
									<td class="wborder text-right"><?php echo $row['qty']?></td>
									<td class="wborder text-right"><?php echo date("m/d/Y",strtotime($row['date_updated'])) ?></td>
									<td class="wborder text-right"><?php echo $row['date_purchase']?></td>
									<td class="wborder text-center"><?php echo $row['remarks']?></td>
									<td class="wborder text-center hide-table">
										<a class="btn btn-sm btn-primary" href="#my_modal" data-toggle="modal" data-item-id="<?php echo $row['id']?>|<?php echo $row['sku']?>|<?php echo $row['product_id']?>|<?php echo $row['product_name']?>|<?php echo $row['qty']?>|<?php echo $row['date_purchase']?>|<?php echo $row['remarks']?>">Edit</a>
										<a class="btn btn-sm btn-danger delete_sales" href="#remove_modal"  data-toggle="modal" data-item-id="<?php echo $row['id'] ?>">Delete</a>
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


<div class="modal" id="my_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	  	<h4 class="modal-title"><b>Edit Item</b></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
		  <form action="" id="save-defective">	
			<input type="hidden" name="id" value="" class="col-md-12"/>
		  <div class="col-md-12 pt-2">
			<label>SKU & Product :</label>
			<output name="product_sku"></output>
			<input type="hidden" name="product" value="" class="col-md-12" readonly="readonly"/>
		  </div>
		  <div class="col-md-12 pt-2">
			<label>Quantity</label>
			<input type="number" name="qty" value="" class="col-md-12"  name="qty"/>
		  </div>
		  <div class="col-md-12 pt-2">
			<label>Date Purchase</label>
			<input type="text" name="date_purchase" value="" class="col-md-12" name="date_purchase"/>
		  </div>
		  <div class="col-md-12 pt-2">
			<label>Remarks</label>
			<textarea class="form-control" cols="30" rows="3" value="" name="remarks"></textarea>
		  </div>
      </div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Confirm</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		</form>
    </div>
  </div>
</div>

<div class="modal" id="remove_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Confirmation</b></h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      		</div>
      	<div class="modal-body">
			  <form action="" id="delete-defective">
				  <input type="hidden" name="id" id="id" class="col-md-12"/>
				  <p>Are you sure to delete this data?</p>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Confirm</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
			</form>
    </div>
  </div>
</div>


<script>
	$('#my_modal').on('show.bs.modal', function(e) {
    var bookId = $(e.relatedTarget).data('item-id');
	const itemArray = bookId.split("|");
	$(e.currentTarget).find('output[name="product_sku"]').val(itemArray[1] + " | " + itemArray[3]);
    $(e.currentTarget).find('input[name="id"]').val(itemArray[0]);
	$(e.currentTarget).find('input[name="product"]').val(itemArray[1] + "|" + itemArray[2] + "|" +itemArray[3]);
	$(e.currentTarget).find('input[name="qty"]').val(itemArray[4]);
	$(e.currentTarget).find('input[name="date_purchase"]').val(itemArray[5]);
	$(e.currentTarget).find('textarea[name="remarks"]').val(itemArray[6]);
	});

	$('#remove_modal').on('show.bs.modal', function(e) {
    var bookId = $(e.relatedTarget).data('item-id');
    $(e.currentTarget).find('input[name="id"]').val(bookId);
	});
</script>

<script>
	$('#save-defective').submit(function(e){
			e.preventDefault()
			start_load()
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
						location.href = "index.php?page=sales-return"
					},1500)
				}else{
					alert_toast("Something, Wrong")
					end_load();
					return false;
				}
			}
		})	
	})

		$('#delete-defective').submit(function(e){
				e.preventDefault()
				start_load()
				$.ajax({
				url:'ajax.php?action=delete_defective',
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
</script>

<script>
	$('table').dataTable()
	$('#insert_item').click(function(){
		location.href = "index.php?page=defective-item"
	})

	$('#print-defective').click(function(){
		var _html = $('#print_defective').clone();
		var newWindow = window.open("","_blank","menubar=no,scrollbars=yes,resizable=yes,width=900,height=700");
		newWindow.document.write('<html><head><title></title><link rel="stylesheet" type="text/css" href="styles.css"></head><body>');
		newWindow.document.write('<h2>Defective item Report</h2>')
		newWindow.document.write(_html.html())
		newWindow.document.write('</body></html>');
		setTimeout(function(){;newWindow.print();}, 500);
		setTimeout(function(){;newWindow.close();}, 1500);
	})
</script>
