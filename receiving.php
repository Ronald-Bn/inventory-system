<?php include 'db_connect.php' ?>
<div class="container-fluid">
	<div class="col-lg-12 pt-4">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
				<div class="card-header">
						<div class="row">
							<div class="col-6"><h2><b>Stock In</b></h2></div>
							<div class="col-6">
								<button class="col-md-2 float-right btn btn-primary btn-sm active" id="print-stockin">Print <i class="fa fa-print"></i></button>
								<button class="col-md-4 float-right btn btn-primary btn-sm" id="new_receiving">New Stock <i class="fa fa-plus"></i></button></div>
						</div>
					</div>
					<div class="card-body"  id="print_stockin">
						<table class="table table-bordered" id="tblInventories">
							<thead>
								<th class="wborder text-center">#</th>
								<th class="wborder text-center">Date</th>
								<th class="wborder text-center">Reference #</th>
								<th class="wborder text-center">Supplier</th>
								<th class="wborder text-center hide-table">Action</th>
							</thead>
							<tbody>
							<?php 
								$supplier = $conn->query("SELECT * FROM supplier_list order by supplier_name asc");
								while($row=$supplier->fetch_assoc()):
									$sup_arr[$row['id']] = $row['supplier_name'];
								endwhile;
								$i = 1;
								$receiving = $conn->query("SELECT * FROM receiving_list r order by date(date_added) desc");
								while($row=$receiving->fetch_assoc()):
							?>
								<tr>
									<td class="wborder text-center"><?php echo $i++ ?></td>
									<td class="wborder txt-cen"><?php echo date("m/d/Y",strtotime($row['date_added'])) ?></td>
									<td class="wborder txt-cen"><?php echo $row['ref_no'] ?></td>
									<td class="wborder"><?php echo isset($sup_arr[$row['supplier_id']])? $sup_arr[$row['supplier_id']] :'N/A' ?></td>
									<td class="wborder text-center hide-table">
										<a class="btn btn-sm btn-primary" href="index.php?page=manage_receiving&id=<?php echo $row['id'] ?>">Edit</a>
										<a class="btn btn-sm btn-danger" href="#remove_modal"  data-toggle="modal" data-item-id="<?php echo $row['id'] ?>">Delete</a>
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

<div class="modal" id="remove_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Confirmation</b></h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      		</div>
      	<div class="modal-body">
			  <form action="" id="delete-stockin">
				  <input type="text" name="id" id="id" class="col-md-12"/>
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
	$('#remove_modal').on('show.bs.modal', function(e) {
    var bookId = $(e.relatedTarget).data('item-id');
    $(e.currentTarget).find('input[name="id"]').val(bookId);
	});
	
	$('table').dataTable()
	$('#new_receiving').click(function(){
		location.href = "index.php?page=manage_receiving"
	})
	$('#delete-stockin').submit(function(e){
			e.preventDefault()
			start_load()
			$.ajax({
			url:'ajax.php?action=delete_receiving',
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

	$('#print-stockin').click(function(){
		var _html = $('#print_stockin').clone();
		var newWindow = window.open("","_blank","menubar=no,scrollbars=yes,resizable=yes,width=900,height=700");
		newWindow.document.write('<html><head><title></title><link rel="stylesheet" type="text/css" href="styles.css"></head><body>');
		newWindow.document.write('<h2>STOCK IN REPORT</h2>')
		newWindow.document.write(_html.html())
		newWindow.document.write('</body></html>');
		setTimeout(function(){;newWindow.print();}, 500);
		setTimeout(function(){;newWindow.close();}, 1500);
	})
</script>