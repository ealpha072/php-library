<?php
  //session_start();
  require "header.php";
  require "config.php";
  if(!isset($_SESSION['loggedin'])){
    $_SESSION['msg']= "You must be logged in";
    header("location:login.php");
  }

  
?>

<div class="row">
  <div class="col-3 dashboard" id="dashboard"> 
    <div class="profile">
      <img src="images/avatar.png" alt="Profile">
      <h5 class="username"><?php echo ucfirst($_SESSION["username"]);?></h5>
    </div>
    <div class="links">
      <div>
        <a href="">Dashboard</a>
      </div>
      <div>
        <a href="profile.php">My profile</a>
      </div>
      <div>
        <a href="">View my books</a>
      </div>
      <div>
        <a href="">Add new book</a>
      </div>
      <div>
        <a href="about">About</a>
      </div>      
    </div>
  </div>
  <div class="col-9 holder">
    <div class="search-book">
    <form class="form-inline" method="post" action="">
      <div class="form-group mx-sm-3 mb-2">
        <label for="search" class="sr-only">Search</label>
        <input type="text" class="form-control" id="" placeholder="Search Book" name="book-search" required>
      </div>
      <button type="submit" class="btn btn-primary mb-2" name="search">Search</button>
    </form>
    </div>
    <div class="user-info">
      <div class="log-out">
        <a href="profile.php">My Profile</a>
        <a href="logout.php">Logout</a>
      </div>
    </div>
    <hr>
    <div class="row user-info-holder">
      <div class="col b-b">
        <h1 class="user-books">10</h1>
        <h4>Borrowed books</h4>
      </div>
      <div class="col f-c">
        <h1 class="fines">40</h1>
        <h4>Fines collected</h4>
      </div>
      <div class="col o-t">
        <h1 class="returned">3</h1>
          <h4>Returned</h4>
      </div>
      <div class="col c-e">
        <h1 class="credits">100</h1>
          <h4>Credits Eraned</h4>
      </div>
    </div>
    <hr>
    <div class="result-holder">
      <?php
      if(isset($_POST['search'])){
        $searched_book=$_POST['book-search'];
        $sql = $conn->prepare("SELECT * FROM books WHERE book_name='$searched_book'");
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        echo gettype($result);
      }
      
      ?>
    </div>
  </div>
</div>

