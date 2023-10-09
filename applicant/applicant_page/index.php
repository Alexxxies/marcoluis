<?php
include('../../dbcon.php');
$app_id = 2; //to be changed by actual login credentials

if(isset($_POST['submitprofile'])){
  $sql = "SELECT * FROM applicantdb WHERE application_id = 1";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $oldimage = $row['profile_pic'];

  $fileName = $_FILES["profilepic"]["name"];
  $fileSize = $_FILES["profilepic"]["size"];
  $tmpName = $_FILES["profilepic"]["tmp_name"];

  if(!empty($fileName)){
    $imageExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $imageExtension = strtolower($imageExtension);
    $validExtension = ['jpg','jpeg','png'];

    if(!in_array($imageExtension, $validExtension)){
      $crslerror = '
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Invalid image extension!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    elseif($fileSize > 5000000){
      $crslerror ='
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Image size is too large!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    else{
      unlink('profile_img/'.$oldimage);

      $newImageName = uniqid() . '.' . $imageExtension;
      $uploadDir = 'profile_img/' . $newImageName;

      move_uploaded_file($tmpName, $uploadDir);

      $addsql = "UPDATE applicantdb SET profile_pic = ? WHERE application_id = ?";
      $stmt = mysqli_prepare($conn, $addsql);
      mysqli_stmt_bind_param($stmt, "si", $newImageName, $app_id);

      $result = mysqli_stmt_execute($stmt);
      if($result){
        $crslsuccess = '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Successfully added an image!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
      }
      else{
        echo "Failed: " . mysqli_error($conn);
      }
      mysqli_stmt_close($stmt);
    }
  }else{
    $crslerror ='
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      You need to Input a Photo!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
  }
}

$sql = "SELECT * FROM applicantdb WHERE application_id = 2";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$fullname = $row['Lastname'] . ', ' . $row['Firstname'] . ' ' . $row['Middlename'][0] . '.';
$address = $row['streetname'] . ', ' . $row['barangay'] . ', ' . $row['city'] . ', ' . $row['province'];
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Southern Jade</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha384-ePjGJxNV59PKnOMIwJ0Dp0a7KeW2R4zj9Ukb8UaRKY1exaP0gNz6roF26djpvt0A" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">
</head>

<style>
  .profile-container {
    background-image: url("assets/images/lol.jpg"); 
    background-size: cover; 
    background-position-y: 25%; 
    height: 20%;
  }

  .inside-container {
    background-color: azure;
    background-size: cover; 
    background-position: center;
    background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
    height: 100%;
  }

  strong {
    font-family: 'Manrope', sans-serif;
    font-size: large;
  }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .step-wizard-list {
        color: #333;
        list-style-type: none;
        border-radius: 10px;
        display: flex;
        padding: 20px 10px;
        position: relative;
        z-index: 10;
    }

    .step-wizard-item {
        padding: 0 20px;
        flex-basis: 0;
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
        display: flex;
        flex-direction: column;
        text-align: center;
        min-width: 170px;
        position: relative;
    }

    .step-wizard-item+.step-wizard-item:after {
        content: "";
        position: absolute;
        left: 0;
        top: 19px;
        background: #21d4fd;
        width: 100%;
        height: 2px;
        transform: translateX(-50%);
        z-index: -10;
    }

    .progress-count {
        height: 40px;
        width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: 600;
        margin: 0 auto;
        position: relative;
        z-index: 10;
        color: transparent;
    }

    .progress-count:after {
        content: "";
        height: 40px;
        width: 40px;
        background: #21d4fd;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        z-index: -10;
    }

    .progress-count:before {
        content: "";
        height: 10px;
        width: 20px;
        border-left: 3px solid #fff;
        border-bottom: 3px solid #fff;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -60%) rotate(-45deg);
        transform-origin: center center;
    }

    .progress-label {
        font-size: 14px;
        font-weight: 600;
        margin-top: 10px;
    }

    .current-item .progress-count:before,
    .current-item~.step-wizard-item .progress-count:before {
        display: none;
    }

    .current-item~.step-wizard-item .progress-count:after {
        height: 10px;
        width: 10px;
    }

    .current-item~.step-wizard-item .progress-label {
        opacity: 0.5;
    }

    .current-item .progress-count:after {
        background: #fff;
        border: 2px solid #21d4fd;
    }

    .current-item .progress-count {
        color: #21d4fd;
    }
</style>

<body>
  <div class="container form-container">
    <div class="col-lg-12 mx-auto login-container">
      <div class="row form-header">
        <div class="col-md-3 logocol">
          <img src="assets/images/logo.png" alt="">
        </div>
      </div>
      <div class="col-lg-15 mx-auto profile-container">
        <div class="col-lg-15 mx-auto inside-container">
          <div class="row">
            <div id="end" class="col-md-5 border-custom">
              <div class="row">
                <div class="col-md-3  ms-4 mt-3">
                  <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#profile">
                    <img src="profile_img/<?php echo $row['profile_pic'] ?>" alt="" class="img-fluid">
                  </button>
                </div>
                <div class="col-md-6">
                  <br> 
                  <p><strong>Allysa Jane Catibog </strong></p>
                  <p>Sinisian East, Lemery Batangas</p>
                  <p>Application ID:<strong> 0392 </strong></p>
                </div>
              </div>
            </div>
            <div class="col-md-3">                  
              <br> 
              <p>Email:</p>
              <p>PLUK Email:</p>
              <p>Contact Number:</p>
            </div>
            <div class="col-md-4 ">                  
              <br> 
              <div class="text-end me-3">
                <div class="dropdown">
                  <button class="btn btn-light " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-gear fa-lg " style="color: #000000;"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                    <li><a class="dropdown-item" href="#">Change Password</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-body">
      <section class="step-wizard">
        <ul class="step-wizard-list">
            <li class="step-wizard-item current-item">
                <span class="progress-count">1</span>
                <span class="progress-label">Billing Info</span>
            </li>
            <li class="step-wizard-item">
                <span class="progress-count">2</span>
                <span class="progress-label">Payment Method</span>
            </li>
            <li class="step-wizard-item">
                <span class="progress-count">3</span>
                <span class="progress-label">Checkout</span>
            </li>
            <li class="step-wizard-item">
                <span class="progress-count">4</span>
                <span class="progress-label">Success</span>
            </li>
        </ul>
      </section>
        <div class="form-title row">
          <h4></h4>
        </div>
        <div class="card">
            <ul class="nav nav-tabs">
                <li class="nav-item "><a data-bs-toggle="tab" class="nav-link active" aria-current="page" href="#about" style="font-weight:Lighter; font-size:125%;">About</a> </li>
                <li class="nav-item"><a data-bs-toggle="tab" class="nav-link" href="#docu" style="font-weight:lighter; font-size:125%;">Documents</a> </li>
            </ul>
            <div id="about" class="tab-pane fade show active">
                <div class="row">
                    <nav id="sidebar" class="col-md-3 col-lg-3 d-md-block border-end">
                    <div class="position-sticky">
                        <ul class="nav flex-column">
                        <li class="nav-item active">
                            <a class="nav-link active" href="#" onclick="showContent('home-content');">
                            Personal Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('about-content');">
                            Contact Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('page1-content');">
                            Recruiter's Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('page2-content');">
                            Other Information
                            </a>
                        </li>
                        </ul>
                    </div>
                    </nav>
                    <div class="col-md-9">
                    <div id="home-content" class="page-content">
                        <br>
                        <p><i class="fa-solid fa-location-dot fa-lg"></i> Purok 5 Luya, San Luis Batangas</p>
                        <p><i class="fa-solid fa-person-half-dress fa-lg"></i> Male</p>
                        <p>Civil Status:</p>
                        <p>Birthplace:</p>
                        <p>Birthdate: November 5, 2000</p>
                        <p>Age: 22</p>
                        <p>SSS Number:</p>
                        <p>TIN Number:</p>
                    </div>
                    <div id="about-content" class="page-content">
                        <p>Email:</p>
                        <p>PLUK Email:</p>
                        <p>Contact Number:</p>
                    </div>
                    <div id="page1-content" class="page-content">
                        <p>Recruiter's Name:</p>
                        <p>Recruiter's Code:</p>
                    </div>
                    <div id="page2-content" class="page-content">
                        <h1>Welcome to Page 2</h1>
                        <p>This is the content of Page 2.</p>
                    </div>
                    </div>
                </div>
            </div>
            <div id="docu" class="tab-pane fade">
            </div>
        </div>
      </div>
    </div>



    <!-- modal -->
    <form method="post" enctype="multipart/form-data">
      <div class="modal fade" id="profile" tabindex="-1" aria-labelledby="profile" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="profile">Upload Profile</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div>
                <label for="formFile" class="form-label">Default file input example</label>
                <input class="form-control" type="file" name="profilepic" id="formFile">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="submitprofile" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- modal -->
  </div>

  <!--JQuery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Function to hide all page content divs
    function hideAllContent() {
      var allContentDivs = document.querySelectorAll('.page-content');
      for (var i = 0; i < allContentDivs.length; i++) {
        allContentDivs[i].style.display = 'none';
      }
    }

    // Hide all content initially when the page loads
    window.onload = function () {
      hideAllContent();
    };

    function showContent(contentId) {
      // Hide all page content divs
      hideAllContent();

      // Show the selected content div
      var selectedContent = document.getElementById(contentId);
      if (selectedContent) {
        selectedContent.style.display = 'block';
      }
    }
  </script>
</body>
</html>
