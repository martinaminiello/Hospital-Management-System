<?php 
$con=mysqli_connect("localhost","root","","myhmsdb");
if(isset($_POST['btnSubmit']))
{
    $name = htmlspecialchars((string)$_POST['txtName'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars((string)$_POST['txtEmail'], ENT_QUOTES, 'UTF-8');
    $contact = htmlspecialchars((string)$_POST['txtPhone'], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars((string)$_POST['txtMsg'], ENT_QUOTES, 'UTF-8');

    $query="INSERT into contact(name,email,contact,message) VALUES(?,?,?,?);";
    $stmt= mysqli_prepare($con, $query);
    if($stmt){
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $contact, $message);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            echo '<script type="text/javascript">'; 
            echo 'alert("Message sent successfully!");'; 
            echo 'window.location.href = "contact.html";';
            echo '</script>';
            exit();
        }
    }
    else {
        die("Error in preparing query: " . mysqli_error($con));
    }
}
?>