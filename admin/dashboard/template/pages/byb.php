<?php
include('../../../../dbcon.php');
if(isset($_POST['submit']))
{
  $bybtitle = filter_input(INPUT_POST, "bybtitle", FILTER_SANITIZE_SPECIAL_CHARS);
  $bybdate = filter_input(INPUT_POST, "bybdate", FILTER_SANITIZE_SPECIAL_CHARS); 

  $addsql = 'INSERT INTO bybEvents(byb_title,byb_date) VALUES (?,?)';
  $stmt = mysqli_prepare($conn, $addsql);
  mysqli_stmt_bind_param($stmt, 'ss' , $bybtitle,$bybdate);
  $addresult = mysqli_stmt_execute($stmt);

  if($addresult){
    $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Added Successfully!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
  }
}

$sql = 'SELECT * FROM bybEvents';
$result = mysqli_query($conn, $sql);

$success = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Southern Jade Life Insurance</title>
  <link rel="icon" href="../images/logajade.png" type="image/x-icon">
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/feather/feather.css">
  <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../../Pictures/loghousetitle.jpg" />
  <script src="https://kit.fontawesome.com/866d550866.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="../index.html"><img src="../images/logo-topnav.png" class="mr-3" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="../index.html"><img src="../images/logajade.png" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="../images/faces/face28.jpg" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="../../logout.php">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
          <li class="nav-item nav-settings d-none d-lg-flex">
            <a class="nav-link" href="#">
              <i class="icon-ellipsis"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
 
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">&nbsp;Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="agents.php">
            <i class="fa-solid fa-user-tie fa-lg menu-icon"></i>
            <span class="menu-title">&nbsp;&nbsp;Agent List</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="byb.php">
          <i class="fa-solid fa-users-rectangle fa-lg menu-icon"></i>
            <span class="menu-title">BYB Attendees</span>
            </a>
          </li>
           <li class="nav-item">
          <a class="nav-link" href="prospects.php">
          <span class="fa-stack fa-sm mr-1 menu-icon">
            <i class="fa-solid fa-magnifying-glass fa-stack-2x"></i>
            <i class="fa-solid fa-user fa-stack-1x"></i>
          </span>  <span class="menu-title">&nbsp;Prospects</span>
          </a>
        </li>
          </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
      
        
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">BYB Table</p>
                  <?= $success?>
<div class="top d-flex justify-content-between align-items-center">
                  <div class="btn-group mb-3" style="width: 4cm;">
                  <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Sort List
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                  </ul>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addBYBmeet">
                    Add
                  </button>
                </div>
                    <div class="row">
                      <?php
                      if(!mysqli_num_rows($result)>0){
                        echo '<div class="col-lg-12 text-center bg-light shadow rounded p-3">
                                <h1>There are no records found</h1>
                              </div>';
                      }else{
                        while($row = mysqli_fetch_assoc($result)){
                          ?>
                          <div class="col-lg-3 p-1 bg-white text-center">
                          <a href="add_attendees.php?byb_id=<?= $row['byb_id'] ?>&title=<?= $row['byb_title'] ?>" class="btn btn-success btn-lg shadow">
                              <strong><?= $row['byb_title'] ?></strong> 
                            </a>
                            <h6><strong>Date:</strong> <?= $row['byb_date']?></h6>
                          </div>
                          <?php
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>

        <!-- modal add byb title -->
        <form method="post">
          <div class="modal fade" id="addBYBmeet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">New BYB Event List</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label >BYB Title:</label>
                    <input class="form-control" type="text" name="bybtitle" placeholder="Input BYB Title" required>
                  </div>
                  <div class="form-group">
                    <label >Date of the Event:</label>
                    <input class="form-control" type="date" name="bybdate" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" name="submit" class="btn btn-primary">Add</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <!-- modal end -->

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../vendors/chart.js/Chart.min.js"></script>
  <script src="../vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="../js/dataTables.select.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <script src="../js/settings.js"></script>
  <script src="../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../js/dashboard.js"></script>
  <script src="../js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

