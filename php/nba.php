<?php
  include ("connectToDB.inc");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Jersey Collection</title>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/mobile.css" />
    <style>
      	.login-register-buttons{
        <?php
          if(isset($_COOKIE['userLog'])){
            echo "display:none;";
          }
        ?>
      }
      .logout-button{
        <?php
          if(isset($_COOKIE['userLog'])){
            echo "display:block;width:auto;";  
          }else{
            echo "display:none;";
          }
        ?>
      }
      .logout-button button{
        background-color: #f44336;
      }
            
      img{
        height: 100px;
      }
      .team-logo{
        height:20px;
      }
      .icons{
        height:30px;
      }
      td {
        width: 25% ;
      }
    </style>
  </head>
  <body>
    <header>
      <div class="header-title">
        <h1>Jersey Collection</h1>
        
        <!-- THESE ARE FOR THE LOGIN AND REGISTER BUTTONS -->
        <div class="login-register-buttons">
          <button onclick="document.getElementById('login-form').style.display='block'" style="width:auto;">Login</button>
          <button onclick="document.getElementById('register-form').style.display='block'" style="width:auto;">Register</button>
        </div>

        <!-- THIS IS THE LOG-OUT BUTTON -->
        <div class="logout-button">
          <button onclick="location.href='logout.php'">Log Out</button>
        </div>

      </div>
      <nav class="header-nav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="jerseys.php">Jerseys</a></li>
          <li><a href="nba.php" id="this">NBA</a></li>
          <li><a href="user.php">User Collection</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <section>
      <?php 

        $dataBase = connectDB();
        echo "<h3 align='center'>Here you can find all the teams from the NBA. </br></h3>";

        $q='SELECT DISTINCT Division FROM Team WHERE League="NBA";';
        $r=mysqli_query($dataBase,$q) or die('Query failed: '.mysqli_error($dataBase));
        while ($rowDivision = mysqli_fetch_array($r, MYSQL_ASSOC))
        {
          extract($rowDivision);
          $query='SELECT * FROM Team WHERE League="NBA" AND Division="'.$Division.'";';
          $result=mysqli_query($dataBase,$query) or die('Query failed: '.mysqli_error($dataBase));
          echo  "<table><tr><td colspan='5'>$Division</td></tr>";
          $numberOfJerseys=0;
          while ($row = mysqli_fetch_array($result, MYSQL_ASSOC))
          {
          extract($row);
              if($numberOfJerseys==5){
                  echo "</tr>";
                  $numberOfJerseys=0;
              }
              if($numberOfJerseys==0){
                  echo "<tr>";
              }
              if ($numberOfJerseys<5){
                  echo  "<td><a href='team.php?id=$TeamId'><img src='$TeamLogo'/></a></br>
                      $TeamName </td>
                  ";
                  $numberOfJerseys+=1;
              }
          }
          echo "</tr></table>";
        }

        mysql_close($dataBase);
      ?>
      </section>

      <!-- THESE ARE FOR THE LOGIN AND REGISTER BUTTONS -->
      <section class="login-and-register">
        <div id="login-form" class="login-window">
          <form class="login-window-box animate" action="login.php" method="post">
            <div class="close-x-div">
              <span onclick="document.getElementById('login-form').style.display='none'" class="close">&times;</span>
            </div>
  
            <div class="login-info">
              <label for="username"><b>Username</b></label>
              <input type="text" placeholder="Enter Username" name="username" required>
        
              <label for="password"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="password" required>
                
              <button type ="submit">Login</button>
              <button type ="reset" class="clearButton">Clear</button>
            </div>
        
            <div class="container" style="background-color:#f1f1f1">
              <span>Are you not <a href="">registered?</a></span>
            </div>
          </form>
        </div>
  
        <div id="register-form" class="register-window">
          <form class="register-window-box animate" action="register.php" method="post">
            <div class="close-x-div">
              <span onclick="document.getElementById('register-form').style.display='none'" class="close">&times;</span>
            </div>
  
            <div class="register-info">
              <label for="username"><b>Username</b></label>
              <input type="text" placeholder="Enter Username" name="username" required>
        
              <label for="password"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="password" required>
  
              <label for="email"><b>E-Mail</b></label>
              <input type="email" placeholder="email@domain.com" name="email" required>
                
              <button type ="submit">Register</button>
              <button type ="reset" class="clearButton">Clear</button>
            </div>
        
            <div class="container" style="background-color:#f1f1f1">
              <span>Are you already <a href="">registered?</a></span>
            </div>
          </form>
        </div>
      </section>
    </main>

    <footer>
      <div>
        This page is possible thanks to 
        <a href="https://github.com/DiegoRojo99">Diego Rojo</a>.
      </div>
      <div>
        All images are taken from the teams social media pages.
      </div>
    </footer>
  </body>
</html>