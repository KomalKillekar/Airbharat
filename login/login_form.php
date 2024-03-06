<?php
session_start();

@include 'config.php';

if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   if($pass !== $cpass){
      $error[] = 'Passwords do not match!';
   }else{
      $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass'";
      $result = mysqli_query($conn, $select);

      if(mysqli_num_rows($result) > 0){
         $row = mysqli_fetch_array($result);

         if($row['user_type'] == 'admin'){
            $_SESSION['admin_name'] = $row['name'];
            header('location:admin_page.php');
         }elseif($row['user_type'] == 'user'){
            $_SESSION['user_name'] = $row['name'];
            header('location:user_page.php');
         }
      }else{
         $error[] = 'Incorrect email or password!';
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>
   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
</head>
<body>
   
   <div class="form-container">
      <form action="" method="post">
         <h3>login now</h3>
         <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<span class="error-msg">'.$error.'</span>';
            };
         };
         ?>
         <input type="text" name="name" required placeholder="enter your name">
         <input type="email" name="email" required placeholder="enter your email">
         <input type="password" name="password" required placeholder="enter your password">
         <input type="password" name="cpassword" required placeholder="confirm your password">
         <select name="user_type" id="user_type" required>
            <option value="" disabled selected hidden>Select user type</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
         </select>
         <input type="submit" name="submit" value="login now" class="form-btn">
         <p>don't have an account? <a href="register_form.php">register now</a></p>
      </form>
   </div>

</body>
</html>