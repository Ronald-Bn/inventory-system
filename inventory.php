<?php include 'db_connect.php' ?>

<div class="container-fluid" >
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12 pt-4">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-6"><h2><b>Inventory</b></h2></div>
							<div class="col-6">
							<button class="col-md-2 float-right btn btn-primary btn-sm active" id="print-inventory">Print <i class="fa fa-print"> </i></button>
							<button class="col-md-2 float-right btn btn-success btn-sm " onclick="ExportToExcel()">Export <i class="fa fa-print"> </i></button>
							</div>
						</div>
					</div>
					<div class="card-body" id="print_inventory">
						<table class="table table-collapse" id="tblInventories">
							<thead>
								<th class="wborder text-center">#</th>
								<th class="wborder text-center">Product Name</th>
								<th class="wborder text-center">Category</th>
								<th class="wborder text-center">Stock In</th>
								<th class="wborder text-center">Stock Out</th>
								<th class="wborder text-center">Defective</th>
								<th class="wborder text-center">Stock Available</th>
								<th class="wborder text-center">Expiration Date</th>
							</thead>
							<tbody>
							<?php 
								$i = 1;
								$cat = $conn->query("SELECT * FROM category_list order by name asc");
								while($row=$cat->fetch_assoc()):
									$cat_arr[$row['id']] = $row['name'];
								endwhile;
								$product = $conn->query("SELECT * FROM product_list r order by name asc");
								while($row=$product->fetch_assoc()):
								$inn = $conn->query("SELECT sum(qty) as inn FROM inventory where type = 1 and product_id = ".$row['id']);
								$inn = $inn && $inn->num_rows > 0 ? $inn->fetch_array()['inn'] : 0;
								$out = $conn->query("SELECT sum(qty) as `out` FROM inventory where type = 2 and product_id = ".$row['id']);
								$out = $out && $out->num_rows > 0 ? $out->fetch_array()['out'] : 0;
								$def = $conn->query("SELECT sum(qty) as `def` FROM defective_list where type = 3 and product_id = ".$row['id']);
								$def = $def && $def->num_rows > 0 ? $def->fetch_array()['def'] : 0;
								$available = $inn - $out;
							?>
								<tr <?php if($available < 10){
										echo "class='table-danger'";
								}else if($available > 1500){
										echo "class='table-success'";
									}else{
										echo "";
									}?>>
									<td class="wborder text-center"> <?php echo $i++ ?> </td>
									<td class="wborder"> <?php echo $row['name'] ?> </td>
									<td class="wborder text-right"> <?php echo $cat_arr[$row['category_id']] ?> </td>
									<td class="wborder text-right"> <?php echo $inn ?> </td>
									<td class="wborder text-right"> <?php echo $out ?> </td>
									<td class="wborder text-right"> <?php echo $def ?> </td>
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
	const a = new Date();
	var monthly = parseInt(a.getMonth()) + 1;
	var ddate = "-" + a.getFullYear().toString() + "-" + a.getDate().toString() + "-" + monthly.toString() ;
        function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('tblInventories');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
			
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
                XLSX.writeFile(wb, fn || ('Inventory-Report'+ ddate + '.' + (type || 'xlsx')));
        }
</script>
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