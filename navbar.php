<style>
	#sidebar{
		padding-top:20px;
		background-color:#F65058;
	}
	#sidebar{
		height: calc(100%);
    	position: fixed;
    	z-index: 99;
    	left: 0;
    	width: 250px;
		background-color:#F65058;
	}
.sidenav a, .dropdown-btn {	
  height:50px;
  padding:12px;
  text-decoration: none;
  font-size: 18px;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}
#outer
{
    width:100%;

}
.inner
{
    display: inline-block;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}

/* Main content */


/* Add an active class to the active dropdown button */
.active {
  background-color: #000000c4;
  color: white;
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
}

/* Optional: Style the caret down icon */


/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
</style>
<nav class='mx-lt-5 sidebar' id="sidebar">
		
		<div class="sidebar-list">
		<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
		<a href="index.php?page=inventory" class="nav-item nav-inventory" style="width:100%"><span class='icon-field'><i class="fa fa-list"></i></span> Inventory</a></div>
			<button class="dropdown-btn">Manage Inventory&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i></button>
				<div class="dropdown-container">
				<a href="index.php?page=stock-out" class="nav-item nav-stock-out"><span class='icon-field'><i class="fa fa-coins"></i></span> Stock Out</a>
				<a href="index.php?page=defective-item" class="nav-item nav-defective-item"><span class='icon-field'><i class="fa fa-exclamation-circle"></i></span> Defective items</a>
				<a href="index.php?page=stock-in" class="nav-item nav-stock-in"><span class='icon-field'><i class="fa fa-file-alt"></i></span> Stock In</a>
				</div>
			<button class="dropdown-btn hide-btn">List Form&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-down"></i></button>
				<div class="dropdown-container">
				<a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-list"></i></span> Category List</a>
				<a href="index.php?page=product" class="nav-item nav-product"><span class='icon-field'><i class="fa fa-boxes"></i></span> Product List</a>
				<a href="index.php?page=supplier" class="nav-item nav-supplier"><span class='icon-field'><i class="fa fa-truck-loading"></i></span> Supplier List</a>
				<!--<a href="index.php?page=customer" class="nav-item nav-customer"><span class='icon-field'><i class="fa fa-user-friends"></i></span> Customer List</a>-->
				</div>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
			<?php endif; ?>      
				<a href="ajax.php?action=logout" class="nav-item nav-logout"><span class='icon-field'><i class="fa fa-power-off"></i></span> Log out</a>
		</div>
</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var stockout = $('nav-stock-out').hasClass('active');
var nav_defective = document.getElementsByClassName("nav-defective-item");
var stocki = document.getElementsByClassName("nav-stock-in");

var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>
<?php if($_SESSION['login_type'] != 1): ?>
	<style>
		.nav-item{
			display: none!important;
		}
		.nav-stock-in, .nav-defective-item, .nav-stock-out ,.nav-home ,.nav-inventory, .nav-logout{
			display: block!important;
		}
		.hide-btn{
			display: none!important;
		}
	</style>
<?php endif ?>