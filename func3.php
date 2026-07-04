<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

require_once('csrf_token.php');
initializeCSRFToken();


$con = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$con) {
    die("Connessione fallita: " . mysqli_connect_error());
}

if(isset($_POST['adsub'])){
    // Validazione Token CSRF
    if (!validateCSRFToken()) {
      echo("<script>alert('Security validation failed. Please try again.');
            window.location.href = 'index.php';</script>");
      exit();
    }
    
    $username = $_POST['username1'];
    $password = $_POST['password2'];
    
    $query = "select * from admintb where username=?;";
    $stmt = mysqli_prepare($con, $query);
    if($stmt){
        mysqli_stmt_bind_param($stmt, "s", $username);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Verifichiamo se esiste esattamente un amministratore con questo username
            if(mysqli_num_rows($result) == 1)
            {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Controllo sicuro della password hashata
                if (password_verify($password, $row['password'])) {
                    $_SESSION['username'] = $username;
                    mysqli_stmt_close($stmt);
                    
                    // CORRETTO: Il redirect viene eseguito subito qui dentro
                    header("Location: admin-panel1.php");
                    exit();
                } else {
                    mysqli_stmt_close($stmt);
                    echo("<script>alert('Invalid Username or Password. Try Again!');
                          window.location.href = 'index.php';</script>");
                    exit();
                }
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
            // CORRETTO: Cambiato da 'username' a 'name' per combaciare con la query SELECT sopra
            $name = h($row['name']);
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