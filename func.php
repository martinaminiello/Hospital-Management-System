<?php



if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include CSRF token protection
require_once('csrf_token.php');
initializeCSRFToken();

$con=mysqli_connect("localhost","root","","myhmsdb");
if(isset($_POST['patsub'])){
	// Validate CSRF token
	if (!validateCSRFToken()) {
		echo("<script>alert('Security validation failed. Please try again.');
		      window.location.href = 'index1.php';</script>");
		exit();
	}
	$email=$_POST['email'];
	$password=$_POST['password2'];
	$query = "SELECT * FROM patreg WHERE email = ?";
  $stmt = mysqli_prepare($con, $query);


    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "s", $email);


        mysqli_stmt_execute($stmt);


        $result = mysqli_stmt_get_result($stmt);
          if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['pid'] = $row['pid'];
                    $_SESSION['username'] = $row['fname'] . " " . $row['lname'];
                    $_SESSION['fname'] = $row['fname'];
                    $_SESSION['lname'] = $row['lname'];
                    $_SESSION['gender'] = $row['gender'];
                    $_SESSION['contact'] = $row['contact'];
                    $_SESSION['email'] = $row['email'];
                } else {
                    mysqli_stmt_close($stmt);
                    echo("<script>alert('Invalid Username or Password. Try Again!');
                          window.location.href = 'index1.php';</script>");
                    exit();
                }
            }
         
            mysqli_stmt_close($stmt);
            header("Location:admin-panel.php");
            exit(); 
        } else {
            mysqli_stmt_close($stmt);
            echo("<script>alert('Invalid Username or Password. Try Again!');
                  window.location.href = 'index1.php';</script>");
        }
    } else {
       
        die("Error in preparing query: " . mysqli_error($con));
    }
}

if(isset($_POST['update_data']))
{
	// Validate CSRF token
	if (!validateCSRFToken()) {
		die("Security validation failed. Request rejected.");
	}
	
	$contact = $_POST['contact'];
  $status = $_POST['status']; //int
  $query = "UPDATE appointmenttb SET payment=? WHERE contact = ?;" ;

  $stmt = mysqli_prepare($con, $query);
  if($stmt){
    mysqli_stmt_bind_param($stmt, "si", $status, $contact);
    
     if(mysqli_stmt_execute($stmt)){
      mysqli_stmt_close($stmt);
      header("Location:updated.php");
      exit(); 
    } else {
      die("Error executing query: " . mysqli_stmt_error($stmt));
    }
  }
  else {
    die("Error in preparing query: " . mysqli_error($con));
  }
}




// function display_docs()
// {
// 	global $con;
// 	$query="select * from doctb";
// 	$result=mysqli_query($con,$query);
// 	while($row=mysqli_fetch_array($result))
// 	{
// 		$name=$row['name'];
//     $cost=$row['docFees'];
// 		echo '<option value="'.$name.'" data-price="' .$cost. '" >'.$name.'</option>';
// 	}
// }

if(isset($_POST['doc_sub']))
{
	// Validate CSRF token
	if (!validateCSRFToken()) {
		die("Security validation failed. Request rejected.");
	}
	
	// Validate path traversal
	$raw_name = strip_tags($_POST['doctor']);
	if (strpbrk($raw_name, './\\') !== false) {
		http_response_code(400);
		die("Invalid input.");
	}
	
	$doctor=$_POST['doctor'];
  $dpassword=$_POST['dpassword'];
  $demail=$_POST['demail'];
  $docFees=$_POST['docFees']; //int
  $dpassword_hashed = password_hash($dpassword, PASSWORD_BCRYPT);
  $query = "INSERT INTO  doctb(username,password,email,docFees)VALUES( ?,?,?,?)" ;

  $stmt = mysqli_prepare($con, $query);
  if($stmt){
    
   mysqli_stmt_bind_param($stmt, "sssi", $doctor, $dpassword_hashed, $demail, $docFees);
   if(mysqli_stmt_execute($stmt)){
      mysqli_stmt_close($stmt);
      header("Location:adddoc.php");
      exit();
   }


  }
  else {
    die("Error in preparing query: " . mysqli_error($con));
  }


}
function display_admin_panel(){
	echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Global Hospital</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post" action="search.php">
      <input class="form-control mr-sm-2" type="text" placeholder="enter contact number" aria-label="Search" name="contact">
      <input type="submit" class="btn btn-outline-light my-2 my-sm-0 btn btn-outline-light" id="inputbtn" name="search_submit" value="Search">
    </form>
  </div>
</nav>
  </head>
  <style type="text/css">
    button:hover{cursor:pointer;}
    #inputbtn:hover{cursor:pointer;}
  </style>
  <body style="padding-top:50px;">
 <div class="jumbotron" id="ab1"></div>
   <div class="container-fluid" style="margin-top:50px;">
    <div class="row">
  <div class="col-md-4">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Appointment</a>
      <a class="list-group-item list-group-item-action" href="patientdetails.php" role="tab" aria-controls="home">Patient List</a>
      <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Payment Status</a>
      <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Prescription</a>
      <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Doctors Section</a>
       <a class="list-group-item list-group-item-action" id="list-attend-list" data-toggle="list" href="#list-attend" role="tab" aria-controls="settings">Attendance</a>
    </div><br>
  </div>

  





  <div class="col-md-8">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <center><h4>Create an appointment</h4></center><br>
              <form class="form-group" method="post" action="appointment.php">
                <div class="row">
                  <div class="col-md-4"><label>First Name:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control" name="fname"></div><br><br>
                  <div class="col-md-4"><label>Last Name:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control"  name="lname"></div><br><br>
                  <div class="col-md-4"><label>Email id:</label></div>
                  <div class="col-md-8"><input type="text"  class="form-control" name="email"></div><br><br>
                  <div class="col-md-4"><label>Contact Number:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control"  name="contact"></div><br><br>
                  <div class="col-md-4"><label>Doctor:</label></div>
                  <div class="col-md-8">
                   <select name="doctor" class="form-control" >

                     <!-- <option value="" disabled selected>Select Doctor</option>
                     <option value="Dr. Punam Shaw">Dr. Punam Shaw</option>
                      <option value="Dr. Ashok Goyal">Dr. Ashok Goyal</option> -->
                      <?php display_docs();?>




                    </select>
                  </div><br><br>
                  <div class="col-md-4"><label>Payment:</label></div>
                  <div class="col-md-8">
                    <select name="payment" class="form-control" >
                      <option value="" disabled selected>Select Payment Status</option>
                      <option value="Paid">Paid</option>
                      <option value="Pay later">Pay later</option>
                    </select>
                  </div><br><br><br>
                  <div class="col-md-4">
                    <input type="submit" name="entry_submit" value="Create new entry" class="btn btn-primary" id="inputbtn">
                  </div>
                  <div class="col-md-8"></div>                  
                </div>
              </form>
            </div>
          </div>
        </div><br>
      </div>
      <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
        <div class="card">
          <div class="card-body">
            <form class="form-group" method="post" action="func.php">
              <input type="text" name="contact" class="form-control" placeholder="enter contact"><br>
              <select name="status" class="form-control">
               <option value="" disabled selected>Select Payment Status to update</option>
                <option value="paid">paid</option>
                <option value="pay later">pay later</option>
              </select><br><hr>
              <input type="submit" value="update" name="update_data" class="btn btn-primary">
            </form>
          </div>
        </div><br><br>
      </div>
      <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
        <form class="form-group" method="post" action="func.php">
          <label>Doctors name: </label>
          <input type="text" name="name" placeholder="enter doctors name" class="form-control">
          <br>
          <input type="submit" name="doc_sub" value="Add Doctor" class="btn btn-primary">
        </form>
      </div>
       <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
    </div>
  </div>
</div>
   </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <!--Sweet alert js-->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
   <script type="text/javascript">
   $(document).ready(function(){
   	swal({
  title: "Welcome!",
  text: "Have a nice day!",
  imageUrl: "images/sweet.jpg",
  imageWidth: 400,
  imageHeight: 200,
  imageAlt: "Custom image",
  animation: false
})</script>
  </body>
</html>';
}
?>