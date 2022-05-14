<!--remove stock in modal-->
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

<!--insert stock in modal-->
<div class="modal" id="insert_modal_stock_in">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	  	<h4 class="modal-title"><b>New Stock In</b></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
		  <form action="" id="save-stockin">	
			<input type="hidden" name="id" class="col-md-12"/>
			<input type="hidden" name="ref_no">
		  <div class="col-md-12 pt-1">
			<label>Supplier</label>
			<select name="supplier_id" id="supplier_sin" class="custom-select browser-default select2">
				<option value=""></option>
				<?php 

				$supplier = $conn->query("SELECT * FROM supplier_list order by supplier_name asc");
				while($row=$supplier->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>"><?php echo $row['supplier_name'] ?></option>
				<?php endwhile; ?>
				</select>
		  </div>
		  <div class="col-md-12 pt-2">
			<label>Product</label>
			<select name="product_id" id="product_sin"  class="custom-select browser-default select2" >
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
				<option value="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>"><?php echo $row['name'] . ' | ' . $row['sku'] ?></option>
				<?php endwhile; ?>
			</select>
		  </div>
		  
		  <div class="col-md-4 pt-2 float-right">
			<label>Qty</label>
			<input type="number" name="qty"  id="qty_sin" value=""  class="col-md-12 text-center"/>
		  </div>
      </div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Save</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		</form>
    </div>
  </div>
</div>

<!--edit stock in modal-->
<div class="modal" id="edit_modal_stock_in">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	  	<h4 class="modal-title"><b>Edit Stock In</b></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
		  <form action="" id="edit-stockin">	
			<input type="text" name="id" class="col-md-12"/>
            <div class="col-md-4 pt-2 ">
			<label>Reference No.</label>
			<input type="text" name="ref_no">
		  </div>
		  <div class="col-md-12 pt-1">
			<label>Supplier</label>
			<select name="supplier_id" id="" class="custom-select browser-default select2 supplier">
				<option value=""></option>
                <option value="" selected></option>
				<?php 

				$supplier = $conn->query("SELECT * FROM supplier_list order by supplier_name asc");
				while($row=$supplier->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>"><?php echo $row['supplier_name'] ?></option>
				<?php endwhile; ?>
				</select>
		  </div>
           
		  <div class="col-md-12 pt-2">
			<label>Product </label>
			<select name="product_id" id="" class="custom-select browser-default select2 product">
				<option value="" selected></option>
				<?php 
				$product = $conn->query("SELECT * FROM product_list order by name asc");
				while($row=$product->fetch_assoc()):
				$prod[$row['id']] = $row;
				?>
				<option value="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>"><?php echo $row['name'] . ' | ' . $row['sku'] ?></option>
				<?php endwhile; ?>
			</select>
		  </div>
		  
		  <div class="col-md-4 pt-2 float-right">
			<label>Qty</label>
			<input type="number" name="qty" id="qty_ein" value=""  class="col-md-12 text-center"/>
		  </div>
      </div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Save</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		</form>
    </div>
  </div>
</div>

<!--insert stock out modal-->
<div class="modal" id="insert_modal_stock_out">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	  	<h4 class="modal-title"><b>New Stock Out</b></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
		  <form action="" id="save-stockout">	
			<input type="hidden" name="id" class="col-md-12"/>
			<input type="hidden" name="ref_no">
		  <div class="col-md-12 pt-1">
			<label>Clerk</label>
			<select name="users_id" id="users_sout" class="custom-select browser-default select2">
				<option value=""></option>
				<?php 

				$supplier = $conn->query("SELECT * FROM users order by name asc");
				while($row=$supplier->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
				<?php endwhile; ?>
				</select>
		  </div>
		  <div class="col-md-12 pt-2">
			<label>Product</label>
			<select name="product_id" id="product_sout" class="custom-select browser-default select2">
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
				<option value="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>"><?php echo $row['name'] . ' | ' . $row['sku'] ?></option>
				<?php endwhile; ?>
			</select>
		  </div>
		  
		  <div class="col-md-4 pt-2 float-right">
			<label>Qty</label>
			<input type="number" name="qty" id="qty_sout" value=""  class="col-md-12 text-center" />
		  </div>
      </div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Save</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		</form>
    </div>
  </div>
</div>

<!--edit stock out modal-->
<div class="modal" id="edit_modal_stock_out">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	  	<h4 class="modal-title"><b>Edit Stock Out</b></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
		  <form action="" id="edit-stockout">	
			<input type="hidden" name="id" class="col-md-12"/>
			<div class="col-md-4 pt-2 ">
			<label>Reference No.</label>
			<input type="text" name="ref_no">
		  </div>
		  <div class="col-md-12 pt-1">
			<label>Clerk</label>
			<select name="users_id" id="" class="custom-select browser-default select2 users">
				<option value=""></option>
				<?php 

				$supplier = $conn->query("SELECT * FROM users order by name asc");
				while($row=$supplier->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
				<?php endwhile; ?>
				</select>
		  </div>
		  <div class="col-md-12 pt-2">
			<label>Product</label>
			<select name="product_id" id="" class="custom-select browser-default select2 product">
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
				<option value="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>"><?php echo $row['name'] . ' | ' . $row['sku'] ?></option>
				<?php endwhile; ?>
			</select>
		  </div>
		  
		  <div class="col-md-4 pt-2 float-right">
			<label>Qty</label>
			<input type="number" name="qty" id="qty_eout" value=""  class="col-md-12 text-center"/>
		  </div>
      </div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Save</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		</form>
    </div>
  </div>
</div>


<!--remove stock out modal-->
<div class="modal" id="remove_stock_out_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Confirmation</b></h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      		</div>
      	<div class="modal-body">
			  <form action="" id="delete-stockout">
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


<!--insert defective item modal-->
<div class="modal" id="insert_modal_defective">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	  	<h4 class="modal-title"><b>Insert item</b></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
		  <form action="" id="save-defective">	
			<input type="hidden" name="id" class="col-md-12"/>
			<input type="hidden" name="ref_no">
		  <div class="col-md-12 pt-2">
			<label>Product</label>
			<select name="product_id" id="product_sdef" class="custom-select browser-default select2">
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
				<option value="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>"><?php echo $row['name'] . ' | ' . $row['sku'] ?></option>
				<?php endwhile; ?>
			</select>
		  </div>
		<div class="col-md-12 pt-3">
			<label>Remarks</label>
			<textarea class="form-control" cols="30" rows="3" value="" name="remarks" id="remarks_sdef"></textarea>
		  </div>
		<div class="col-md-8 pt-2">
				<label class="control-label">Date Purchase (MM/DD/YYYY)</label>
					<div class="input-group date" data-provide="datepicker">
						<input type="text" class="form-control" name="date_purchase" id="date_purchase_sdef" autocomplete="off">
								<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
								</div>
					</div>
				</div>
			<div class="col-md-4 pt-2 float-right">
				<label>Qty</label>
				<input type="number" name="qty" id="qty_sdef" value=""  class="col-md-12 text-center" />
			</div>
		</div>
		
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Save</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		</form>
    </div>
  </div>
</div>

<!--edit defective item modal-->
<div class="modal" id="edit_modal_defective">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
	  	<h4 class="modal-title"><b>Edit item</b></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
		  <form action="" id="edit-defective">	
			<input type="text" name="id" class="col-md-12"/>
			<div class="col-md-4 pt-2 ">
			<label>Reference No.</label>
			<input type="text" name="ref_no">
		  </div>
		  <div class="col-md-12 pt-2">
			<label>Product</label>
			<select name="product_id" id="product" class="custom-select browser-default select2 product">
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
				<option value="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>"><?php echo $row['name'] . ' | ' . $row['sku'] ?></option>
				<?php endwhile; ?>
			</select>
		  </div>
		<div class="col-md-12 pt-2">
			<label>Remarks</label>
			<textarea class="form-control" cols="30" rows="3" value="" name="remarks"></textarea>
		  </div>
		<div class="col-md-8 pt-2">
				<label class="control-label">Date Purchase (MM/DD/YYYY)</label>
				<input type="text" class="form-control" name="date_purchase" id="datepicker">	
				</div>
			<div class="col-md-4 pt-2 float-right">
				<label>Qty</label>
				<input type="number" name="qty" id="qty" value=""  class="col-md-12 text-center" />
			</div>
		</div>
		
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Save</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		</form>
    </div>
  </div>
</div>


<!--remove stock in modal-->
<div class="modal" id="remove_defective_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><b>Confirmation</b></h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      		</div>
      	<div class="modal-body">
			  <form action="" id="delete-defective">
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



