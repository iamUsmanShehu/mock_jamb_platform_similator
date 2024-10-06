<nav class="navbar">
    <div class="nav_icon" onclick="toggleSidebar()">
      <i class="fa fa-bars" aria-hidden="true"></i>
    </div>
    <div class="navbar__left">
      
    </div>
    <div class="navbar__right">
      
      <a href="#">
        <img width="30" src="<?=$_SESSION['image']?>" alt="" />
      <a href="#">
       <?=$_SESSION['username']?>
      </a>
        <!-- <i class="fa fa-user-circle-o" aria-hidden="true"></i> -->
      </a>
    </div>
</nav>