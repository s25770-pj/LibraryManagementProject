<?php

session_start();

if(isset($_POST['email'])) 
{

    $all_right = true;

    $nick = $_POST['nick'];

    if((strlen($nick)<3) || (strlen($nick)>20))
    {
        $all_right = false;
        $_SESSION['e_nick'] = "Nick should consider 3 to 20 characters!";
    }

    if (ctype_alnum($nick)==false)
    {
        $all_right=false;
        $_SESSION['e_nick'] = "Nickname should consider only letters and numbers";
    }

    $email = $_POST['email'];
    $SaveEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
     
    if ((filter_var($SaveEmail, FILTER_VALIDATE_EMAIL)==false) || ($SaveEmail!=$email))
    {
        $all_right=false;
        $_SESSION['e_email'] = "Wrong email adress, write real one";
    }

    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if((strlen($password1)<8) || (strlen($password1)>20))
    {
        $all_right = false;
        $_SESSION['e_password'] = "Password should consider 8 to 20 characters!";
    }

    if($password1!=$password2)
    {
        $all_right = false;
        $_SESSION['e_password'] = "Passwords doesnt match";
    }

    $password_hash = password_hash($password1, PASSWORD_DEFAULT);
    echo $password_hash; exit();

    if($all_right == true)
    {
        echo "Udana walidacja!"; exit();
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TheSettlers - create your free acount</title>

    <script src="https://www.google.com/recaptcha/api.js" asyncdefer></script>

    <script>
   function onSubmit(token) {
     document.getElementById("demo-form").submit();
   }
 </script>
 <style>
    .error {
        color: red;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    </style>
</head>
<body>

<form method='POST'>
    Nickname: <br /> <input type='text' name='nick'><br />
    <?php
    if(isset($_SESSION['e_nick'])) 
    {
        echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
        unset($_SESSION['e_nick']);
    }

?>
    E-mail: <br /> <input type='text' name='email'><br />
    <?php
    if(isset($_SESSION['e_email'])) 
    {
        echo '<div class="error">'.$_SESSION['e_email'].'</div>';
        unset($_SESSION['e_email']);
    }

?>
    Password: <br /> <input type='password' name='password1'><br />
    <?php
    if(isset($_SESSION['e_password'])) 
    {
        echo '<div class="error">'.$_SESSION['e_password'].'</div>';
        unset($_SESSION['e_password']);
    }

?>
    Repeat password: <br /> <input type='password' name='password2'><br />
    
    <div class="g-recaptcha" 
        data-sitekey="6LftPwUmAAAAAAQQg-z8tysG29odzeKI1g3gzurW">
    </div>

    <label>
    <input type='checkbox' name='statute' /> Accept statute
</label>
<br /><input type='submit' name='submit' value='sign in'>
</form>
</body>
</html>