<header>
    <div class="container-fluid">  
    <div class="row">
      <div class="col-md-4 col-sm-4">
        <div class="logo">
          <a href="#">
            <img src="{{ URL('/')}}/public/resources/img/tier5.png" alt="img">
          </a>  
        </div>
      </div>
      <div class="col-md-8 col-sm-8 header-right">
        <div class="menu-icon">
          <a href="#" onclick="openNav()">
            <span>
            <i class="fa fa-bars" aria-hidden="true"></i>
            </span>
          </a>  
        </div>
        <div class="header-btn">
          <a class="btn link-btn1" href="#" onclick="openNav1()">Create Bitlink1</a>
          <a class="btn link-btn1" href="#">Create Bitlink2</a>
        </div> 
        <div class="search-part"> 
            <div class="search-part-main">
            <input type="text"> 
              <span class="search-icon">
              <input type="submit" value="">
              </span>
            </div>
        </div>  
      </div>
    </div>  
    </div> 

<div id="myNav" class="overlay">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <div class="overlay-content">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="profile-pic">
        <img src="{{ URL('/')}}/public/resources/img/profile-pic.jpg" alt="img">
        </div>
        <div class="profile-name">Kingsuk Majumdar</div>
        <div class="profile-email">kingsuk.majumder@gmail.com</div>
      </div>
    </div> 
    <div class="row log-sign">
      <div class="col-md-6 col-sm-12">
        <input type="submit" value="Signout">

      </div>
      
    </div>  
  </div>
</div> 

<div id="myNav1" class="overlay">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav1()">×</a>
Hello

</div>  



    </header>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- <script src="js/bootstrap.min.js"></script> -->


<script>
function openNav() {
    document.getElementById("myNav").style.width = "25%";
}

function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}
function openNav1() {
    document.getElementById("myNav1").style.width = "25%";
}

function closeNav1() {
    document.getElementById("myNav1").style.width = "0%";
}



</script>
