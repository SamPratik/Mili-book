

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a style="font-weight:bold;font-size:25px;" class="navbar-brand" href="#">Mili-Book</a>
    </div>
    
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li class="navBtn"><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
          <!--<li class="navBtn"><a href="letters.php"><span class="glyphicon glyphicon-envelope"></span> Letters</a></li>-->
        <li class="dropdown navBtn">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-envelope"></span> Letters
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="letterOperational.php?">Operational</a></li>
                <li><a href="letterAdmin.php">Admin</a></li>
                <li><a href="letterTraining.php">Training</a></li>
                <li><a href="letterMISC.php">MISC</a></li>
            </ul>
        </li>
          <li class="navBtn"><a href="forum.php"><i class="fa fa-comments" aria-hidden="true"></i> Forum</a></li>
          <li class="navBtn"><a href="faq.php"><i class="fa fa-question" aria-hidden="true"></i> FAQ</a></li>
          <li class="navBtn"><a href="recentNews.php"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Recent News</a></li>
          <li class="navBtn"><a href="books.php"><i class="fa fa-book" aria-hidden="true"></i> Books</a></li>
          <li class="navBtn"><a href="#contact"><span class="glyphicon glyphicon-earphone"></span> Contact</a></li>
          <li class="navBtn"><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
        </ul>
    </div>
  </div>
</nav>  