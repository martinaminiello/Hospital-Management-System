 <?php 
session_start();
require_once('csrf_token.php');
initializeCSRFToken();

$con = mysqli_connect("localhost", "root", "", "myhmsdb");

if (!$con) {
    die("Connessione fallita: " . mysqli_connect_error());
}

if(isset($_POST['btnSubmit']))
{
    // Debug: check if token is in POST
    if (empty($_POST['csrf_token'])) {
        echo("<script>alert('CSRF token not found in form submission. Please reload the page.');
              window.location.href = 'contact-form.php';</script>");
        exit();
    }
    
    // Validate CSRF token - NO reinitialize, just validate
    if (!validateCSRFToken()) {
        http_response_code(403);
        echo("<script>alert('Security validation failed. Please try again.');
              window.location.href = 'contact-form.php';</script>");
        exit();
    }

    $raw_name = strip_tags($_POST['txtName']);
    

    if (strpbrk($raw_name, './\\') !== false) {
        http_response_code(400);
        die("INvalid input.");
    }
    

    $name = htmlspecialchars((string)$raw_name, ENT_QUOTES, 'UTF-8');
    
 
    $email = htmlspecialchars((string)strip_tags($_POST['txtEmail']), ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars((string)strip_tags($_POST['txtMsg']), ENT_QUOTES, 'UTF-8');


    $clean_phone = preg_replace('/[^0-9]/', '', $_POST['txtPhone']);
    $contact = substr($clean_phone, 0, 10);

    if(empty($name) || empty($contact)) {
        http_response_code(400); 
        die("Input non valido rilevato.");
    }

    $query = "INSERT into contact(name,email,contact,message) VALUES(?,?,?,?);";
    $stmt = mysqli_prepare($con, $query);
    
    if($stmt){
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $contact, $message);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_close($stmt);
            echo '<script type="text/javascript">'; 
            echo 'alert("Message sent successfully!");'; 
            echo 'window.location.href = "contact-form.php";';
            echo '</script>';
            exit();
        }
        mysqli_stmt_close($stmt);
    }
    else {
        http_response_code(500);
        die("Errore interno del server.");
    }
}
?>