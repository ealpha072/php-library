<?php
  #creating a new connection

  session_start();
  $dsn = "mysql:host=localhost;dbname=library;charset=utf8mb4";
  $username = "root";
  $password = "";
  $msg='';

  try{
    $conn = new PDO($dsn,$username,$password);
    //set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully!!"."<br>";
    //$conn->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS"));
  }catch(Exception $e){
    echo "Connection failed ".$e->getMessage();
  }
  //login code
  if(isset($_POST['login'])){
    global $conn;

    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors=[];

    //check if email is empty
    if(empty($email)){
      array_push($errors,"No email address provided");
      echo "Please provide a email address"."<br>";
    }

    if(empty($password)){
      array_push($errors,"Please provide a password");
      echo "Please provide a password";
    }

    if(count($errors)===0){
        $password =md5($password);
        $sql = $conn->prepare("SELECT * FROM users where email='$email' AND password='$password'");
        $sql->execute();
        $num_rows = $sql->rowCount();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        if($num_rows===1){

          $_SESSION['loggedin']=true;
          $_SESSION['username'] = $result[0]['user_name'];
          $_SESSION['user_email']=$result[0]['email'];
          $_SESSION['id']= $result[0]['id'];
          $_SESSION['password']=$result[0]['password'];
          
          header("location:index.php");
          //echo var_dump($result);
        }else{
          echo $num_rows."<br>";
          echo "Invalid email or password!!";
        }
      }

  }

  //register code
  if(isset($_POST['register'])){
    try{    
      global $conn;
      $error =[];
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password_1 = $_POST['password_1'];
      $password_2 = $_POST['password_2'];

      //check if email is empty
      if(empty($email)){
        echo "Please provide an email address!!"."<br>";
        array_push($error,"Email Error");
      }

      //check if username is empty
      if(empty($username)){
        echo "Username is empty"."<br>";
        array_push($error,"Username Error");
      }

      //check if password is empty
      if(empty($password_1)){
        echo "Please provide a password"."<br>";
        array_push($error,"Password Error");
      }

      //check if confirm password is empty
      if(empty($password_2)){
        echo "Please confirm your password"."<br>";
        array_push($error,"Password Error");
      }

      //check for password match
      if(!($password_1===$password_2)){
        echo "Password mismatch, please provide matching passwords!";
        array_push($error," Error");
      }

      //check if email exists in database
      $sql1 = $conn->prepare("SELECT * FROM users WHERE email='$email' OR user_name ='$username'");
      $sql1->execute();
      $results = $sql1->rowCount();

      if($results>1){
        array_push($error,"User exists");
        echo "Username or email already taken!!";
      }

      if(count($error)===0){
        //code for uploading image
        $filename =$_FILES['userimage']['name'];
        $tempname =$_FILES['uploadfile']['temp_name'];
        $folder = "image/".$filename;
        
        //password processing and database entry
        $password_1 = md5($password_1);
        $sql = "INSERT INTO users (email,user_name,password,user_image) VALUES ('$email','$username','$password_1','$filename')";
        $newResults=$conn->query($sql);
        
        if(move_uploaded_file($tempname,$folder)){
          $msg = "Image uploaded successfully";
        }else{
          $msg='Failed to upload image';
        }
        //session variables
        $_SESSION['loggedin']=true;
        $_SESSION['username'] = $username;
        $_SESSION['success'] = 'You are now logged in';
        $_SESSION['user_email']=$email;
        $_SESSION['password']=$password_1;
        
        //echo $_SESSION['username'];
        header('location:index.php');
      }

    }catch(Exception $e){
      die ("Error: Could not execute .$sql1 ".$e->getMessage());
    }
}

?>