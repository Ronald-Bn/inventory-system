<style>
.raduis-div{
  border: 2px solid red;
  padding: 10px;
  border-radius: 25px;
}
</style>

<?php include 'db_connect.php'; 
  if(!isset($_SESSION['login_id'])){
  header('location:login.php');
}
   date_default_timezone_set('Asia/Manila');
    $i = 1;
    $cat = $conn->query("SELECT * FROM category_list order by name asc");
    while($row=$cat->fetch_assoc()):
        $cat_arr[$row['id']] = $row['name'];
    endwhile;
   
    $inn = $conn->query("SELECT sum(qty) as inn FROM inventory where type = 1");
    $inn = $inn && $inn->num_rows > 0 ? $inn->fetch_array()['inn'] : 0;
    $out = $conn->query("SELECT sum(qty) as `out` FROM inventory where type = 2");
    $out = $out && $out->num_rows > 0 ? $out->fetch_array()['out'] : 0;
    $def = $conn->query("SELECT sum(qty) as `def` FROM inventory where type = 3");
    $def = $def && $def->num_rows > 0 ? $def->fetch_array()['def'] : 0;
    $available = $inn - $out - $def;
    

    $b = date("Y",strtotime("-1 year"));
    $c = date("Y",strtotime("-2 year"));
    $d = date("Y",strtotime("-3 year"));
    $e = date("Y",strtotime("-4 year"));
    $currentyear = $conn->query("SELECT SUM(qty) as amount FROM inventory WHERE date(date_updated) BETWEEN'".date("$b-01-01")."'AND'".date("Y-m-d")."' AND type = 2");
    $currentyear = $currentyear && $currentyear->num_rows > 0 ? number_format($currentyear->fetch_array()['amount']) : 0;
    $previousYear = $conn->query("SELECT SUM(qty) as amount FROM inventory WHERE date(date_updated) BETWEEN'".date("$b-01-01")."'AND'".date("$b-12-31")."' AND type = 2");
    $previousYear = $previousYear && $previousYear->num_rows > 0 ? number_format($previousYear->fetch_array()['amount']) : 0;
    $twopreviousYear = $conn->query("SELECT SUM(qty) as amount FROM inventory WHERE date(date_updated) BETWEEN'".date("$c-01-01")."'AND'".date("$c-12-31")."' AND type = 2");
    $twopreviousYear = $twopreviousYear && $twopreviousYear->num_rows > 0 ? number_format($twopreviousYear->fetch_array()['amount']) : 0;
    $thirdpreviousYear = $conn->query("SELECT SUM(qty) as amount FROM inventory WHERE date(date_updated) BETWEEN'".date("$d-01-01")."'AND'".date("$d-12-31")."' AND type = 2");
    $thirdpreviousYear = $thirdpreviousYear && $thirdpreviousYear->num_rows > 0 ? number_format($thirdpreviousYear->fetch_array()['amount']) : 0;
    $fourthpreviousYear = $conn->query("SELECT SUM(qty) as amount FROM inventory WHERE date(date_updated) BETWEEN'".date("$e-01-01")."'AND'".date("$e-12-31")."' AND type = 2");
    $fourthpreviousYear = $fourthpreviousYear && $fourthpreviousYear->num_rows > 0 ? number_format($fourthpreviousYear->fetch_array()['amount']) : 0;

    //convert the PHP array into JSON format, so it works with javascript
    $json_avail = json_encode($available);
    $json_stoin = json_encode($inn);
    $json_stoout = json_encode($out);
    $currentyear = str_replace(',', "",$currentyear);
    $previousYear = str_replace(',', "",$previousYear);
    $twopreviousYear = str_replace(',', "",$twopreviousYear );
    $thirdpreviousYear = str_replace(',', "",$thirdpreviousYear);
    $fourthpreviousYear = str_replace(',', "",$fourthpreviousYear);
    $arrayYears = array("$b", "$c", "$d", "$e");
    $YearArray = array("$currentyear", "$previousYear", "$twopreviousYear", "$thirdpreviousYear", "$fourthpreviousYear");
    $json_Years = json_encode($YearArray);
    $json_arrayYears = json_encode($arrayYears);

    
?>
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between m-4">
  <h1 class="h3 mb-0 text-gray-800"><?php echo "Welcome back <b>".$_SESSION['login_name']."!</b>"  ?></h1>
</div>

<!-- Content Row -->
<div class="row">

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-primary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
							STOCK OUT(TODAY)</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php 
              $sales = $conn->query("SELECT SUM(qty) as amount FROM inventory where type = '2' and date(date_updated)= '".date('Y-m-d')."'");
              echo $sales->num_rows > 0 ? number_format($sales->fetch_array()['amount'],2) : "0";
              ?>
            </div>
					</div>
					<div class="col-auto">
						<i class="fas fa-coins fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
							STOCK IN(TODAY)</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php 
              date_default_timezone_set('Asia/Manila');
              $sales = $conn->query("SELECT SUM(qty) as amount FROM inventory where type = '1' and date(date_updated)= '".date('Y-m-d')."'");
              echo $sales->num_rows > 0 ? number_format($sales->fetch_array()['amount'],2) : "0.00";
              ?>
            </div>
					</div>
					<div class="col-auto">
						<i class="fas fa-file-alt fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Defective(Today)
						</div>
						<div class="row no-gutters align-items-center">
							<div class="col-auto">
								<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                  <?php 
                    date_default_timezone_set('Asia/Manila');
                     $def = $conn->query("SELECT SUM(qty) as def FROM inventory where type = '3' and date(date_updated)= '".date('Y-m-d')."'");
                     $def = $def && $def->num_rows > 0 ? number_format($def->fetch_array()['def'],2) : 0;
                     echo $def;
                  ?>  
                </div>
							</div>
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-warning shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
							Users</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">
						<?php 
							include 'db_connect.php';
							$sales = $conn->query("SELECT Count(name) as amount FROM users");
							echo $sales->num_rows > 0 ? number_format($sales->fetch_array()['amount']) : "0";
							?>
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-users fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Stock Out (Annually)</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Inventory</h6>
                                    <div class="dropdown">
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="mydoughChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Stock out 
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Stock in
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Available
                                        </span>
                                    </div>
                                    <div class="mt-4 text-center small">
                                    <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Stock Out : <?php echo str_replace('"', "", $json_stoout)?>
                                        </span>
                                    </div>
                                    <div class="mt-4 text-center small">
                                    <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Stock In : <?php echo str_replace('"', "",$json_stoin)?>
                                        </span>
                                    </div>
                                    <div class="mt-4 text-center small">
                                    <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Available : <?php echo $json_avail?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Red Camia Inventory System 2022</span>
                    </div>
                </div>
            </footer>
<script>
var xValues = ["Stock Out", "Stock In", "Available"];
var Available = <?php echo $json_avail; ?>;
var StockIn = <?php echo $json_stoin; ?>;
var StockOut = <?php echo $json_stoout; ?>;
var yValues = [StockOut , StockIn, Available];
console.log(yValues);
var barColors = [
  "#0275d8",
  "#5cb85c",
  "#5bc0de"
];

new Chart("mydoughChart", {
  type: "pie",
  data:{
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Inventory (Overall)",
      borderWidth: 1,
      xPadding: 0,
      yPadding: 0,
    }
  }
});
</script>
<script> 
const currentYear = new Date().getFullYear();
const previousYear =  currentYear-1;
const twoPreviousYear =  currentYear-2;
const thirdPreviousYear =  currentYear-3;
const fourthPreviousYear =  currentYear-4;
var years = <?php echo $json_Years ?>;
console.log(years[0]);
console.log(years[1]);
console.log(years[2]);
console.log(years[3]);
console.log(years[4]);
var dates = <?php echo $json_arrayYears ?>;
console.log(dates);

years = years.map(Number);
var xValues = [currentYear,previousYear, twoPreviousYear, thirdPreviousYear ,fourthPreviousYear];
var yValues = [years[0],years[1],years[2],years[3],years[4]];

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      fill: false,
      lineTension: 0,
      backgroundColor: "rgba(0,0,255,1.0)",
      borderColor: "rgba(0,0,255,0.1)",
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{ticks: {min: 0, max:10000}}],
    }
  }
});
</script>
