<?php


  session_start();

  require_once "pdo.php";

  if( isset($_POST['cancelPost']) ){
    header("Location: index.php");  
  }
  // p' OR '1' = '1
  if ( isset($_POST['loginPost']) &&
       isset($_POST['name'])) {
      //delete account key from session array
      unset($_SESSION["email"]);  // Logout current user
      echo "here agagin ain";

      echo("<p>Handling POST data...</p>\n");
      $sql = "SELECT name, email FROM users 
          WHERE email = :em AND password = :pw";
          
      echo "<p>$sql</p>\n";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
          ':em' => $_POST['email'], 
          ':pw' => $_POST['password']));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      print_r($row);
      var_dump($row);
     if ( $row === FALSE ) {
        echo "<h1>Login incorrect.</h1>\n";
        $_SESSION["error"] = "Incorrect password.";
        header( 'Location: login.php' ) ;
        return;
     } else { 
        $_SESSION["email"] = $row['email'];//copy into session.
        $_SESSION["success"] = "Logged in.";
        header("Location: view.php?email=".$_SESSION["email"]);
        echo "<p>Login success.</p>\n";
        return;
     }
     
  }
?>

<head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <h1>Please Login</h1>
    <?php
        if ( isset($_SESSION["error"]) ) {//flash message
            echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
            unset($_SESSION["error"]);
        }
    ?>
    <form method="post">
      <p>Email: <input type="text" size="40" name="email"></p>
      <p>Password:<input type="text" size="40" name="password"></p>
      <p>
        <input type="submit" name="loginPost" value="Login"/>
        <input type="submit" name="cancelPost" value="Cancel"/>
      </p>

      <p><a href="<?php echo($_SERVER['PHP_SELF']);?>">Refresh</a></p>
    </form>
  </div>
</body>
