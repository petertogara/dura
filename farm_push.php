<?php include 'select_list_front.php'; ?>

<?php
error_reporting(0);
$farm_number_msg  = $reg_msg = $size_msg = $user_exists   = $success = "";
$category =  $regname = $farm_size =$farm_number = $farm_dist_msg = "" ;

$conn=mysqli_connect("localhost","root","");

if (!$conn)
  {
  die('Could not connect: ' . mysqli_error());
  }
mysqli_select_db($conn,"zimcommand");

if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['submit_logout']))
{
unset($_SESSION['idnumber']);  
unset($_SESSION['id']);     
unset($_SESSION['phone']);   
unset($_SESSION['password']); 
unset($_SESSION['fullname']);   
unset($_SESSION['grower_number']); 
unset($_SESSION['region']);       
unset($_SESSION['email']);          
header("location: index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['submit_farm']))
{

$grower_number   =  $_SESSION['grower_number'];
$farm_number     =  $_POST['farm_number'];
$reg_name        =  $_POST['reg_name'];
$farm_size       =  $_POST['farm_size'];
$category        =  $_POST['category'];
$province        =  $_POST['Province'];
$district        =  $_POST['District'];
$ward            =  $_POST['Ward'];

if(empty($_POST['farm_number']))
{
 $farm_number_msg =   'Farm No. is missing';
}

if(strcmp($district,$_SESSION['region'])!== 0)
{
 $farm_dist_msg =   'Account registered for '.$_SESSION['region'];
}

if(empty($_POST['reg_name']))
{
 $reg_msg =   'Registered name is missing';
}

if(empty($farm_size) or !is_numeric($farm_size))
{
$size_msg    = 'Farm size must be numeric';
}

$conn=mysqli_connect("localhost","root","");

if (!$conn)
  {
  die('Could not connect: ' . mysqli_error());
  }
mysqli_select_db($conn,"zimcommand");

$check_exists     = mysqli_query($conn,"SELECT * FROM farms WHERE grower_number  = '$_SESSION[grower_number]'");
$count            = mysqli_num_rows($check_exists);
$array 			  = mysqli_fetch_assoc($check_exists);
if($count!=0)
{
$user_exists    =  'Farm already registered';
}
else
{


if($farm_number_msg  =='' and $reg_msg =='' and $size_msg =='' and $user_exists =='' and  $farm_dist_msg == '')
	{												  
	$data_push  = mysqli_query($conn,"INSERT INTO farms( grower_number , farm_number ,reg_name ,size, category, province, district, ward ) 
              VALUES( '$grower_number' , '$farm_number', '$reg_name', '$farm_size', '$category', '$province' , '$district' , '$ward')");
     $success_msg = "You`ve successfully registered";
 }
 
}
}

$check_exist     = mysqli_query($conn,"SELECT * FROM farms WHERE grower_number  = '$_SESSION[grower_number]'");
$counts           = mysqli_num_rows($check_exist);
if($counts!=0)
{
$arr 			  = mysqli_fetch_assoc($check_exist);
$_SESSION['reg_name'] = $arr['reg_name'];
$_SESSION['size'] = $arr['size'];
$_SESSION['farm_number']= $arr['farm_number'];
}
else
{
$_SESSION['reg_name'] = '';
$_SESSION['size'] = '';
$_SESSION['farm_number']= '';
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Prestige Account: <?php   echo $_SESSION['idnumber'];?> </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
   <style>
    /* FROM HTTP://WWW.GETBOOTSTRAP.COM
     * Glyphicons
     *
     * Special styles for displaying the icons and their classes in the docs.
     */

    .bs-glyphicons {
      padding-left: 0;
      padding-bottom: 1px;
      margin-bottom: 20px;
      list-style: none;
      overflow: hidden;
    }

    .bs-glyphicons li {
      float: left;
      width: 25%;
      height: 115px;
      padding: 10px;
      margin: 0 -1px -1px 0;
      font-size: 12px;
      line-height: 1.4;
      text-align: center;
      border: 1px solid #ddd;
    }

    .bs-glyphicons .glyphicon {
      margin-top: 5px;
      margin-bottom: 10px;
      font-size: 24px;
    }

    .bs-glyphicons .glyphicon-class {
      display: block;
      text-align: center;
      word-wrap: break-word; /* Help out IE10+ with class names */
    }

    .bs-glyphicons li:hover {
      background-color: rgba(86, 61, 124, .1);
    }

    @media (min-width: 768px) {
      .bs-glyphicons li {
        width: 12.5%;
      }
    }
	</style>
  <style type="text/css">
<!--
.style1 {
	font-size: 24px;
	color: #00CC33;
}
-->
  </style>
   <style>
         .error {color: #FF0000;}
		 .success {color: #00CC00;}
   </style>
   <script src="select_ajax_front.js" type="text/javascript"></script>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#" class="style1">Zim Prestige Farming</a>  </div>

  <div class="register-box-body">
  
 <section class="content">
      <div class="row">
        <div class="col-xs-13">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
			  <li><a href="welcome.php">Account</a></li>
              <li><a href="request_push.php">Request</a></li>
			  <li ><a href="status_push.php">Status</a></li>
            </ul>
            <div class="tab-content">
            
              <div class="tab-pane active" id="fa-icon">
                <section id="new">
                  <h4 class="page-header">Farm</h4>

                  <div class="row fontawesome-icon-list">
                  
				  
				  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">	
					<span class="error"><?php echo $user_exists ; ?></span>
		            <span class="success"><?php echo $success_msg ; ?></span>
					 <div class="form-group has-feedback">
					 <span class="error"><?php echo $farm_number_msg;?></span>
        <input type="text" name="farm_number" class="form-control" placeholder="Farm Number" value="<?php echo $_SESSION['farm_number'];?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
	    <div class="form-group has-feedback">
		<span class="error"><?php echo $reg_msg;?></span>
        <input type="text" name="reg_name" class="form-control" placeholder="Registered Name" value="<?php echo $_SESSION['reg_name'];?>" >
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
	  
	    <div class="form-group has-feedback">
		<span class="error"><?php   echo $size_msg;?></span>
        <input type="text" name="farm_size" class="form-control" placeholder="Farm Size( Ha )" value="<?php echo $_SESSION['size'];?>">
        <span class="glyphicon  glyphicon-info-sign form-control-feedback"></span>
      </div>
	  
	    <div class="form-group has-feedback">
                  <select class="form-control select2" name="category" style="width: 100%;">
                  <option selected="selected">A1</option>
                  <option>A2</option>
                </select>
              </div>
			  
			  
	<div class="form-group has-feedback">
	 <span class="error"><?php   echo $farm_dist_msg;?></span>
           <?php echo $re_html; ?>
               
              </div>
			  
      <div class="row">
        <div class="col-xs-12" align="center">
          <button type="submit" name="submit_farm" class="btn btn-primary btn-block btn-flat">Update Farm</button>
        </div>
        <!-- /.col -->
      </div>
		</form>	
				  
				  
                  </div>
                </section>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
   
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>

<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
