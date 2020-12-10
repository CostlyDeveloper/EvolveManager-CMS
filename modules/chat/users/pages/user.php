<?php 
if (!evolveLogged()){
   include(FRONTEND_PATH.'pages/login_to_continue.php');
}else{
  
$query = $mysqli->query("
  SELECT boom_users.user_name,
    boom_users.user_about,
  boom_users.user_mood,
  boom_users.user_tumb,
  boom_users.user_id
  FROM boom_users
                    
  WHERE user_name = '$instance_seo_id'
");
if($query->num_rows > 0){
  
$row = $query->fetch_array(MYSQLI_ASSOC);
 recordPostPageView($row['user_id'], 'evolve_profiles_visits');
$instance_seo_id   = $row['user_name'];//article ID
?>  <div class="container user_container">
    <div class="row">
        <header id="header">
          <div class="slider">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                  <img src="http://placehold.it/1200x400/F34336/F34336&text=WORDPRESS THEME DEVELOPER">
                </div>
                <div class="item">
                  <img src="http://placehold.it/1200x400/20BFA9/ffffff&text=CLEAN %26 SMART">
                </div>
              </div>
              <!-- Controls -->
              <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
              <span class="fa fa-angle-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
              <span class="fa fa-angle-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
          <!--slider-->
          <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNav">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><img class="img-responsive" src="<?php echo get_avatar($row['user_tumb']) ?>"></a>
              <span class="user_name"><b><?php echo $row['user_name'] ?></b></span>
              <span class="user_mood"><?php echo $row['user_mood'] ?></span>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="mainNav" >
              <ul class="nav main-menu navbar-nav">
                <li><a href="#"><i class="fa fa-home"></i> HOME</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
              </ul>
              <ul class="nav  navbar-nav navbar-right">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
              </ul>
            </div>
            <!-- /.navbar-collapse -->
          </nav>
        </header>
        <!--/#HEADER-->
      </div>
    </div>
<?php } }?>