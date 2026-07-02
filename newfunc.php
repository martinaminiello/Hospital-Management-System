<?php
// session_start();
$con=mysqli_connect("localhost","root","","myhmsdb");

if(isset($_POST['update_data']))
{
 $contact=$_POST['contact'];
 $status=$_POST['status'];
 
 $query="update appointmenttb set payment=? where contact=?;";
 $stmt = mysqli_prepare($con, $query);
 if($stmt){
  mysqli_stmt_bind_param($stmt, "ss", $status, $contact);
  if(mysqli_stmt_execute($stmt)){
   mysqli_stmt_close($stmt);
   header("Location:updated.php");
   exit();
  }
 }
}

function display_specs() {
  global $con;
  $query="select distinct(spec) from doctb";
  $result=mysqli_query($con,$query);
  while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
    $spec=htmlspecialchars((string)$row['spec'], ENT_QUOTES);
    echo '<option data-value="'.$spec.'">'.$spec.'</option>';
  }
}

function display_docs()
{
 global $con;
 $query = "select username, docFees, spec from doctb";
 $result = mysqli_query($con,$query);
 while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
 {
  $username = htmlspecialchars((string)$row['username'], ENT_QUOTES);
  $price = htmlspecialchars((string)$row['docFees'], ENT_QUOTES);
  $spec = htmlspecialchars((string)$row['spec'], ENT_QUOTES);
  echo '<option value="' .$username. '" data-value="'.$price.'" data-spec="'.$spec.'">'.$username.'</option>';
 }
}

if(isset($_POST['doc_sub']))
{
 $username=$_POST['username'];
 $query="insert into doctb(username) values(?);";
 $stmt = mysqli_prepare($con, $query);
 if($stmt){
  mysqli_stmt_bind_param($stmt, "s", $username);
  if(mysqli_stmt_execute($stmt)){
   mysqli_stmt_close($stmt);
   header("Location:adddoc.php");
   exit();
  }
 }
}
?>