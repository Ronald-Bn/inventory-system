<style>
.raduis-div{
  border: 2px solid red;
  padding: 10px;
  border-radius: 25px;
}

.small, small {
    font-size: 50%;
    font-weight: 400;
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
    
    //convert the PHP array into JSON format, so it works with javascript
    $json_avail = json_encode($available);
    $json_stoin = json_encode($inn);
    $json_stoout = json_encode($out);
    $json_def = json_encode($def);
?>
<div class="containe-fluid">
  <div class="row mt-3 ml-3 mr-3">
    <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
      <h2><?php echo "Welcome back <b>".$_SESSION['login_name']."!</b>"  ?><h2>		
      <hr/>
      
      <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-10">
              <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div
                      class="card-header py-3 text-center">
                      <h5 class="m-0 font-weight-bold"><b>STOCK MONITORING</b></h5>
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
                              <i class="fas fa-circle text-secondary"></i> Defective 
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
                              <i class="fas fa-circle text-secondary"></i> Defective : <?php echo str_replace('"', "",$json_def)?>
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
      
      <footer class="sticky-footer bg-white">
                  <div class="container my-auto">
                      <div class="copyright text-center my-auto">
                          <span>Copyright &copy; Red Camia Inventory System 2022</span>
                      </div>
                  </div>
              </footer>

    </div>
  </div>
</div>
</div>

<script>
var xValues = ["Stock Out", "Stock In", "Defective" , "Available"];
var Available = <?php echo $json_avail; ?>;
var StockIn = <?php echo $json_stoin; ?>;
var StockOut = <?php echo $json_stoout; ?>;
var Defective = <?php echo $json_def; ?>;
var yValues = [StockOut , StockIn, Defective ,Available];
console.log(yValues);
var barColors = [
  "#0275d8",
  "#5cb85c",
  "#6c757d",
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
      fontSize:20,
      xPadding: 0,
      yPadding: 0,
    }
  }
});
</script>
