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
								<button class="col-md-2 float-right btn btn-primary btn-sm active" id="print-inventory">Print <i class="fa fa-print"></i></button>
								<button class="col-md-3 float-right btn btn-primary btn-sm" id="insert_item">Insert item <i class="fa fa-plus"></i></button></div>
						</div>
					</div>
					<div class="card-body">
						<table class="table table-bordered">
							<thead>
								<th class="text-center">#</th>
								<th class="text-center">SKU</th>
								<th class="text-center">Product</th>
								<th class="text-center">Data Purchase</th>
								<th class="text-center">Quantity</th>
                                <th class="text-center">Remarks</th>
							</thead>
							<tbody>
							<?php 
								$customer = $conn->query("SELECT * FROM customer_list order by name asc");
								while($row=$customer->fetch_assoc()):
									$cus_arr[$row['id']] = $row['name'];
								endwhile;
									$cus_arr[0] = "GUEST";

								$i = 1;
								$sales = $conn->query("SELECT * FROM defective_list  order by date_purchase desc");
								while($row=$sales->fetch_assoc()):
							?>
								<tr>
									<td class="wborder text-center"><?php echo $i++ ?></td>
									<td class=""><?php echo $row['sku']?></td>
									<td class=""><?php echo $row['product_name']?></td>
									<td class="wborder text-right"><?php echo $row['date_purchase']?></td>
									<td class="text-right"><?php echo $row['qty']?></td>
									<td class="text-center"><?php echo $row['remarks']?></td>
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
	$('table').dataTable()
	$('#insert_item').click(function(){
		location.href = "index.php?page=defective-item"
	})
	$('.delete_sales').click(function(){
		_conf("Are you sure to delete this data?","delete_sales",[$(this).attr('data-id')])
	})
	function delete_sales($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_sales',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>