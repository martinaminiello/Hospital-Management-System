<?php
 session_set_cookie_params([
    'lifetime' => 0,         
    'path' => '/',            
    'domain' => '',           
    'secure' => false,        
    'httponly' => true,       
    'samesite' => 'Lax'       
]);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$con = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$con) {
    die("Connession failed: " . mysqli_connect_error());
}

if(isset($_POST['adsub'])){
    $username = $_POST['username1'];
    $password = $_POST['password2'];
    

    $query = "select * from admintb where username=? and password=?;";
    $stmt = mysqli_prepare($con, $query);
    if($stmt){
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1)
            {
                $_SESSION['username'] = $username;
                mysqli_stmt_close($stmt);
                header("Location:admin-panel1.php");
                exit(); 
            }
            else {
                mysqli_stmt_close($stmt);
                echo("<script>alert('Invalid Username or Password. Try Again!');
                      window.location.href = 'index.php';</script>");
                exit();
            }
        }
    }
}

if(isset($_POST['update_data']))
{
    $contact = $_POST['contact'];
    $status = $_POST['status'];
    

    $query = "update appointmenttb set payment=? where contact=?;";
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


function display_docs()
{
    global $con;
    $query = "select name from doctb"; 
    $result = mysqli_query($con, $query);
    if($result) {
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $name = htmlspecialchars((string)$row['name'], ENT_QUOTES, 'UTF-8');
            echo '<option value="' . $name . '">' . $name . '</option>';
        }
    }
}

if(isset($_POST['doc_sub']))
{
    $name = $_POST['name'];
    
    
	
    $query = "insert into doctb(name) values(?);";
    $stmt = mysqli_prepare($con, $query);
    if($stmt){
        mysqli_stmt_bind_param($stmt, "s", $name);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            header("Location:adddoc.php");
            exit();
        }
    }
}
?>