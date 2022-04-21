<?php include 'db_connect.php' ?>

<div class="container-fluid" >
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12 pt-4">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-6"><h2><b>Inventory</b></h2></div>
							<div class="col-6"><button class="col-md-2 float-right btn btn-primary btn-sm active" id="print-inventory">Print <i class="fa fa-print"> </i></button></div>
						</div>
					</div>
					<div class="card-body" id="print_inventory">
						<table class="table table-collapse">
							<thead>
								<th class="wborder text-center">#</th>
								<th class="wborder text-center">Product Name</th>
								<th class="wborder text-center">Stock In</th>
								<th class="wborder text-center">Stock Out</th>
								<th class="wborder text-center">Stock Available</th>
								<th class="wborder text-center">Expiration Date</th>
							</thead>
							<tbody>
							<?php 
								$i = 1;
								$product = $conn->query("SELECT * FROM product_list r order by name asc");
								while($row=$product->fetch_assoc()):
								$inn = $conn->query("SELECT sum(qty) as inn FROM inventory where type = 1 and product_id = ".$row['id']);
								$inn = $inn && $inn->num_rows > 0 ? $inn->fetch_array()['inn'] : 0;
								$out = $conn->query("SELECT sum(qty) as `out` FROM inventory where type = 2 and product_id = ".$row['id']);
								$out = $out && $out->num_rows > 0 ? $out->fetch_array()['out'] : 0;
								$available = $inn - $out;
							?>
								<tr>
									<td class="wborder text-center"> <?php echo $i++ ?> </td>
									<td class="wborder"> <?php echo $row['name'] ?> </td>
									<td class="wborder text-right"> <?php echo $inn ?> </td>
									<td class="wborder text-right"> <?php echo $out ?> </td>
									<td class="wborder text-right"> <?php echo $available ?> </td>
									<td class="wborder text-right"> <?php echo $row['description'] ?> </td>
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
	$('#new_receiving').click(function(){
		location.href = "index.php?page=manage_receiving"
	})
	$('.delete_receiving').click(function(){
		_conf("Are you sure to delete this data?","delete_receiving",[$(this).attr('data-id')])
	})
	function delete_receiving($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_receiving',
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
	$('#print-inventory').click(function(){
		var _html = $('#print_inventory').clone();
		var newWindow = window.open("","_blank","menubar=no,scrollbars=yes,resizable=yes,width=900,height=700");
		newWindow.document.write('<html><head><title></title><link rel="stylesheet" type="text/css" href="styles.css"></head><body>');
		newWindow.document.write('<h2>Inventory Reports</h2>')
		newWindow.document.write(_html.html())
		newWindow.document.write('</body></html>');
		setTimeout(function(){;newWindow.print();}, 500);
		setTimeout(function(){;newWindow.close();}, 1500);
		
	})
</script>