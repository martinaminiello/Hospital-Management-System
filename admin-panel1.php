<?php 


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$con = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$con) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}


include_once('newfunc.php');

if (!function_exists('h')) {
    function h($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if(isset($_POST['docsub']))
{
  $doctor = $_POST['doctor'];
  $dpassword = $_POST['dpassword'];
  $demail = $_POST['demail'];
  $spec = $_POST['special'];
  $docFees = $_POST['docFees']; 
  $dpassword_hashed = password_hash($dpassword, PASSWORD_BCRYPT);
  
  $query = "INSERT into doctb(username,password,email,spec,docFees) VALUES(?,?,?,?,?)";
  $stmt = mysqli_prepare($con, $query);

  if($stmt){
   mysqli_stmt_bind_param($stmt, "ssssi", $doctor, $dpassword_hashed, $demail, $spec, $docFees);

   if(mysqli_stmt_execute($stmt)){
      mysqli_stmt_close($stmt);
      echo "<script>alert('Doctor added successfully!');window.location='admin-panel1.php';</script>";
      exit();
   } else {
       echo "<script>alert('Insert error: " . h(mysqli_error($con)) . "');</script>";
   }
  }
  else {
    die("Error in preparing query: " . h(mysqli_error($con)));
  }
}

if(isset($_POST['docsub1']))
{
  $demail = $_POST['demail'];
  $query = "DELETE from doctb where email=?;";
  $stmt = mysqli_prepare($con, $query);
  
  if($stmt){
   mysqli_stmt_bind_param($stmt, "s", $demail);
   if(mysqli_stmt_execute($stmt)){
      mysqli_stmt_close($stmt);
      echo "<script>alert('Doctor removed successfully!');window.location='admin-panel1.php';</script>";
      exit();
   } else {
      echo "<script>alert('Unable to delete!');window.location='admin-panel1.php'</script>";
   }
  }
  else {
    die("Error in preparing query: " . h(mysqli_error($con)));
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Global Hospital </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <script>
        var check = function() {
          if (document.getElementById('dpassword').value == document.getElementById('cdpassword').value) {
            document.getElementById('message').style.color = '#5dd05d';
            document.getElementById('message').innerHTML = 'Matched';
          } else {
            document.getElementById('message').style.color = '#f55252';
            document.getElementById('message').innerHTML = 'Not Matching';
          }
        }

        function alphaOnly(event) {
          element.addEventListener('input', function(event) {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
          });
        };
      </script>

      <style>
        .bg-primary { background: -webkit-linear-gradient(left, #3931af, #00c6ff); }
        .col-md-4 { max-width:20% !important; }
        .list-group-item.active { z-index: 2; color: #fff; background-color: #342ac1; border-color: #007bff; }
        .text-primary { color: #342ac1!important; }
        #cpass { display: -webkit-box; }
        #list-app { font-size:15px; }
        .btn-primary { background-color: #3c50c1; border-color: #3c50c1; }
      </style>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">
           <li class="nav-item">
            <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
          </li>
        </ul>
      </div>
    </nav>
  </head>
  
  <body style="padding-top:50px;">
   <div class="container-fluid" style="margin-top:50px;">
    <h3 style="margin-left: 40%; padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> WELCOME RECEPTIONIST </h3>
    <div class="row">
      <div class="col-md-4" style="max-width:25%; margin-top: 3%;">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
          <a class="list-group-item list-group-item-action" href="#list-doc" id="list-doc-list" role="tab" aria-controls="home" data-toggle="list">Doctor List</a>
          <a class="list-group-item list-group-item-action" href="#list-pat" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">Patient List</a>
          <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list" role="tab" data-toggle="list" aria-controls="home">Appointment Details</a>
          <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">Prescription List</a>
          <a class="list-group-item list-group-item-action" href="#list-settings" id="list-adoc-list" role="tab" data-toggle="list" aria-controls="home">Add Doctor</a>
          <a class="list-group-item list-group-item-action" href="#list-settings1" id="list-ddoc-list" role="tab" data-toggle="list" aria-controls="home">Delete Doctor</a>
          <a class="list-group-item list-group-item-action" href="#list-mes" id="list-mes-list" role="tab" data-toggle="list" aria-controls="home">Queries</a>
        </div><br>
      </div>
      
      <div class="col-md-8" style="margin-top: 3%;">
        <div class="tab-content" id="nav-tabContent" style="width: 950px;">

          <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
            <div class="container-fluid container-fullw bg-white">
              <div class="row">
                <div class="col-sm-4">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-users fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Doctor List</h4>
                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script> 
                      <p class="links cl-effect-1">
                        <a href="#list-doc" onclick="clickDiv('#list-doc-list')">View Doctors</a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: -3%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-users fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Patient List</h4>
                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-pat-list')">View Patients</a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Appointment Details</h4>
                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-app-list')">View Appointments</a>
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-4" style="left: 13%; margin-top: 5%;">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Prescription List</h4>
                      <p class="cl-effect-1">
                        <a href="#list-pres" onclick="clickDiv('#list-pres-list')">View Prescriptions</a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: 18%; margin-top: 5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-plus fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Manage Doctors</h4>
                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-adoc-list')">Add Doctors</a>
                        &nbsp|
                        <a href="#app-hist" onclick="clickDiv('#list-ddoc-list')">Delete Doctors</a>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="list-doc" role="tabpanel" aria-labelledby="list-home-list">
            <div class="col-md-8">
              <form class="form-group" action="doctorsearch.php" method="post">
                <div class="row">
                  <div class="col-md-10"><input type="text" name="doctor_contact" placeholder="Enter Email ID" class="form-control"></div>
                  <div class="col-md-2"><input type="submit" name="doctor_search_submit" class="btn btn-primary" value="Search"></div>
                </div>
              </form>
            </div>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Doctor Name</th>
                  <th scope="col">Specialization</th>
                  <th scope="col">Email</th>
                  <th scope="col">Fees</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $query_doc = "select username, spec, email, docFees from doctb";
                  $result_doc = mysqli_query($con, $query_doc);
                  
                  if($result_doc){
                    while ($row = mysqli_fetch_array($result_doc, MYSQLI_ASSOC)){
                      $doc_username = isset($row['username']) ? h($row['username']) : '';
                      $doc_spec = isset($row['spec']) ? h($row['spec']) : '';
                      $doc_email = isset($row['email']) ? h($row['email']) : '';
                      $doc_fees = isset($row['docFees']) ? h($row['docFees']) : '';
                      
                      echo "<tr>
                        <td>$doc_username</td>
                        <td>$doc_spec</td>
                        <td>$doc_email</td>
                        <td>$doc_fees</td>
                      </tr>";
                    }
                  }
                ?>
              </tbody>
            </table><br>
          </div>

          <div class="tab-pane fade" id="list-pat" role="tabpanel" aria-labelledby="list-pat-list">
            <div class="col-md-8">
              <form class="form-group" action="patientsearch.php" method="post">
                <div class="row">
                  <div class="col-md-10"><input type="text" name="patient_contact" placeholder="Enter Contact" class="form-control"></div>
                  <div class="col-md-2"><input type="submit" name="patient_search_submit" class="btn btn-primary" value="Search"></div>
                </div>
              </form>
            </div>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Patient ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Gender</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $query_pat = "select * from patreg";
                  $result_pat = mysqli_query($con, $query_pat);
                  if($result_pat){
                    while ($row = mysqli_fetch_array($result_pat, MYSQLI_ASSOC)){
                        $pid = h($row['pid']);
                        $fname = h($row['fname']);
                        $lname = h($row['lname']);
                        $gender = h($row['gender']);
                        $email = h($row['email']);
                        $contact = h($row['contact']);

                        echo '<tr>' .
                              '<td>' . $pid . '</td>' .
                              '<td>' . $fname . '</td>' .
                              '<td>' . $lname . '</td>' .
                              '<td>' . $gender . '</td>' .
                              '<td>' . $email . '</td>' .
                              '<td>' . $contact . '</td>' .
                              '</tr>';
                    }
                  }
                ?>
              </tbody>
            </table><br>
          </div>

          <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Doctor</th>
                  <th scope="col">Patient ID</th>
                  <th scope="col">Appointment ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Appointment Date</th>
                  <th scope="col">Appointment Time</th>
                  <th scope="col">Disease</th>
                  <th scope="col">Allergy</th>
                  <th scope="col">Prescription</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $query_pres = "select * from prestb";
                  $result_pres = mysqli_query($con, $query_pres);
                  if($result_pres){
                    while ($row = mysqli_fetch_array($result_pres, MYSQLI_ASSOC)){
                      $doctor = h($row['doctor']);
                      $pid = h($row['pid']);
                      $ID = h($row['ID']);
                      $fname = h($row['fname']);
                      $lname = h($row['lname']);
                      $appdate = h($row['appdate']);
                      $apptime = h($row['apptime']);
                      $disease = h($row['disease']);
                      $allergy = h($row['allergy']);
                      $pres = h($row['prescription'] ?? '');

                      echo '<tr>' .
                           '<td>' . $doctor . '</td>' .
                           '<td>' . $pid . '</td>' .
                           '<td>' . $ID . '</td>' .
                           '<td>' . $fname . '</td>' .
                           '<td>' . $lname . '</td>' .
                           '<td>' . $appdate . '</td>' .
                           '<td>' . $apptime . '</td>' .
                           '<td>' . $disease . '</td>' .
                           '<td>' . $allergy . '</td>' .
                           '<td>' . $pres . '</td>' .
                           '</tr>';
                    }
                  }
                ?>
              </tbody>
            </table><br>
          </div>

          <div class="tab-pane fade" id="list-app" role="tabpanel" aria-labelledby="list-pat-list">
            <div class="col-md-8">
              <form class="form-group" action="appsearch.php" method="post">
                <div class="row">
                  <div class="col-md-10"><input type="text" name="app_contact" placeholder="Enter Contact" class="form-control"></div>
                  <div class="col-md-2"><input type="submit" name="app_search_submit" class="btn btn-primary" value="Search"></div>
                </div>
              </form>
            </div>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Appointment ID</th>
                  <th scope="col">Patient ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Gender</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact</th>
                  <th scope="col">Doctor Name</th>
                  <th scope="col">Consultancy Fees</th>
                  <th scope="col">Appointment Date</th>
                  <th scope="col">Appointment Time</th>
                  <th scope="col">Appointment Status</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $query_app = "select * from appointmenttb;";
                  $result_app = mysqli_query($con, $query_app);
                  if($result_app){
                    while ($row = mysqli_fetch_array($result_app, MYSQLI_ASSOC)){
                        $row_id = h($row['ID']);
                        $row_pid = h($row['pid']);
                        $row_fname = h($row['fname']);
                        $row_lname = h($row['lname']);
                        $row_gender = h($row['gender']);
                        $row_email = h($row['email']);
                        $row_contact = h($row['contact']);
                        $row_doctor = h($row['doctor']);
                        $row_docFees = h($row['docFees']);
                        $row_appdate = h($row['appdate']);
                        $row_apptime = h($row['apptime']);
                ?>
                    <tr>
                      <td><?php echo $row_id;?></td>
                      <td><?php echo $row_pid;?></td>
                      <td><?php echo $row_fname;?></td>
                      <td><?php echo $row_lname;?></td>
                      <td><?php echo $row_gender;?></td>
                      <td><?php echo $row_email;?></td>
                      <td><?php echo $row_contact;?></td>
                      <td><?php echo $row_doctor;?></td>
                      <td><?php echo $row_docFees;?></td>
                      <td><?php echo $row_appdate;?></td>
                      <td><?php echo $row_apptime;?></td>
            
                      <td>
                  <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1)) {
                    echo "Active";
                  }
                  if(($row['userStatus']==0) && ($row['doctorStatus']==1)) {
                    echo "Cancelled by Patient";
                  }
                  if(($row['userStatus']==1) && ($row['doctorStatus']==0)) {
                    echo "Cancelled by Doctor";
                  }
                      ?></td>
                    </tr>
                  <?php } 
                  } ?>
              </tbody>
            </table><br>
          </div>

          <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
            <form class="form-group" method="post" action="admin-panel1.php">
              <div class="row">
                <div class="col-md-4"><label>Doctor Name:</label></div>
                <div class="col-md-8"><input type="text" class="form-control" name="doctor" required></div><br><br>
                <div class="col-md-4"><label>Specialization:</label></div>
                <div class="col-md-8">
                 <select name="special" class="form-control" id="special" required="required">
                    <option value="" disabled selected>Select Specialization</option>
                    <option value="General">General</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Neurologist">Neurologist</option>
                    <option value="Pediatrician">Pediatrician</option>
                  </select>
                </div><br><br>
                <div class="col-md-4"><label>Email ID:</label></div>
                <div class="col-md-8"><input type="email" class="form-control" name="demail" required></div><br><br>
                <div class="col-md-4"><label>Password:</label></div>
                <div class="col-md-8"><input type="password" class="form-control" onkeyup='check();' name="dpassword" id="dpassword" autocomplete="off" required></div><br><br>
                <div class="col-md-4"><label>Confirm Password:</label></div>
                <div class="col-md-8" id='cpass'><input type="password" class="form-control" onkeyup='check();' name="cdpassword" id="cdpassword" autocomplete="off" required>&nbsp &nbsp<span id='message'></span> </div><br><br>
                 
                <div class="col-md-4"><label>Consultancy Fees:</label></div>
                <div class="col-md-8"><input type="text" class="form-control" name="docFees" required></div><br><br>
              </div>
              <input type="submit" name="docsub" value="Add Doctor" class="btn btn-primary">
            </form>
          </div>

          <div class="tab-pane fade" id="list-settings1" role="tabpanel" aria-labelledby="list-settings1-list">
            <form class="form-group" method="post" action="admin-panel1.php">
              <div class="row">
                <div class="col-md-4"><label>Email ID:</label></div>
                <div class="col-md-8"><input type="email" class="form-control" name="demail" required></div><br><br>
              </div>
              <input type="submit" name="docsub1" value="Delete Doctor" class="btn btn-primary" onclick="return confirm('do you really want to delete?')">
            </form>
          </div>

          <div class="tab-pane fade" id="list-mes" role="tabpanel" aria-labelledby="list-mes-list">
            <div class="col-md-8">
              <form class="form-group" action="messearch.php" method="post">
                <div class="row">
                  <div class="col-md-10"><input type="text" name="mes_contact" placeholder="Enter Contact" class="form-control"></div>
                  <div class="col-md-2"><input type="submit" name="mes_search_submit" class="btn btn-primary" value="Search"></div>
                </div>
              </form>
            </div>
            
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">User Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact</th>
                  <th scope="col">Message</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $query_contact = "select * from contact;";
                  $result_contact = mysqli_query($con, $query_contact);
                  if($result_contact){
                    while ($row = mysqli_fetch_array($result_contact, MYSQLI_ASSOC)){
                        $contact_name = h($row['name']);
                        $contact_email = h($row['email']);
                        $contact_phone = h($row['contact']);
                        $contact_message = h($row['message']);
                ?>
                    <tr>
                      <td><?php echo $contact_name;?></td>
                      <td><?php echo $contact_email;?></td>
                      <td><?php echo $contact_phone;?></td>
                      <td><?php echo $contact_message;?></td>
                    </tr>
                  <?php } 
                  } ?>
              </tbody>
            </table><br>
          </div>

        </div>
      </div>
    </div>
   </div>
   
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  </body>
</html>