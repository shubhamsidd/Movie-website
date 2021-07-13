<?php 
	session_start();
	$_SESSION['theatre_n']=null;
	$_SESSION['timer']=null;
?>


<html>
<head>
<title>User Dashboard</title>
<link href="css/animate.css" type='text/css' rel="stylesheet">

<link rel="stylesheet" type="text/css" href="css/swiper.min.css">

<link rel="stylesheet" type="text/css" href="css/userdashboardstyles.css">

<link rel="stylesheet" type="text/css" href="css/footer.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
.navbar li a:hover {
     background-color: black;
		color: white;
	
}

.navbar ul 
{	
	height:50px;
    list-style-type: none;
    overflow: hidden;
    background-color: #0b243d;
}

.navbar li a {
  float: left;
  display: block;
  color:white;
  text-align: center;
  padding: 12px 16px;
  text-decoration: none;
  font-size: 22px;
}

.navbar li a.active {
	background-color:black;
 color: white;
}


.navbar .search-container {
  float: right;
}

.navbar input[type=text] {
  padding: 6px;
  margin-top: 2px;
  font-size: 17px;
  border: none;
}

.navbar .search-container button {
  float: right;
  padding: 7.5px 10px;
  margin-top: 2px;
  margin-right: 16px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.navbar .search-container button:hover {
  background: #ccc;
}



</style>

<body class="animated fadeIn">

<div class='navbar'>
<ul>	
<li>
	<div class="toggle-btn" onclick="toggleSidebar()">
	<span></span>
	<span></span>
	<span></span>
	</div>
</li>

<li><img src="images/logo2.png" style="padding-left:50px;padding-right:20px;padding-top:8px;float:left;height:35px;width:250px" /></li>

<li ><a class="active" href="userdashboard.php">Home</a></li>
<li ><a href="upcomingmovies.php">Upcoming Movies</a></li>
<li ><a href="booking.php">Book Now</a></li>
<li><a href="about.php">About</a></li>

<?php if(isset($_SESSION['name']))
	{?>
<li style="padding-left:50px;padding-right:20px;padding-top:6px;"><button class='sign' onclick="document.location.href='userlogout.php'">Logout</button></li>
<?php }else{?>
<li style="padding-left:50px;padding-right:20px;padding-top:6px;"><button class='sign'  onclick="document.location.href='index.php'">Sign In</button></li>
<?php }?>
 
 
 
  <div class="search-container">
    <form method="post">
      <input type="text" placeholder="Search Movie" name="search">
      <button type="submit" name="search1" ><i class="fa fa-search"></i></button>
    </form>
  </div>

</ul>
</div>

<?php
if(isset($_POST['search1']))
	
{
	$movie=$_POST['search'];
	include('dbcon.php');
	$qry1 = "Call searchmovie('$movie'); ";
	$result=mysqli_query($con,$qry1);
	$rows=mysqli_num_rows($result);
	if($rows==0)
	{
		$_SESSION['noid']=$movie;
		header('location:mdetails.php');
		
	}
	$row = mysqli_fetch_array($result);
	$_SESSION['mid']=$row['Movie_id'];
	header('location:mdetails.php');
	
	
}

?>





<div id="sidebar">
	<ul>
	
		<li><center><img src="images/profile.png" width="150px" height="150px" /></center></li>
		<?php if(isset($_SESSION['name']) && isset($_SESSION['email']))
		{
			?>
		<li>Name : <?php echo $_SESSION['name'];?></li>
		<li>Email : <?php echo $_SESSION['email'];?></li>
		<li>Movie Booked : <br>
		
		<?php 
		$user=$_SESSION['name']; 
		include 'dbcon.php';
		$qry5 = "select * from bookings where username='$user' ";
		$res=mysqli_query($con,$qry5);
		while($book=mysqli_fetch_array($res)){
		echo nl2br("\n"."Movie-".$book['movie']."\nDate-".$book['date']."\n");
		}
		?> 
		</li>
		
		<?php }else{?>
		<li><h4>You are not Logged In.Please Sign In to book tickets.</h4></li>
		<?php }?>
		
	</ul>
</div>



<?php 
include('dbcon.php');
		
$qry1 = "SELECT * from movies";
		
$result = mysqli_query($con,$qry1);


$row_count=mysqli_num_rows($result);
?>

<div class="swiper-container">
    <div class="swiper-wrapper">
	
	<?php	
	for($i=0;$i<$row_count;$i++)
	{
	$row1 = mysqli_fetch_array($result);	
	?>
	
	
    <div class="swiper-slide">
		<div class="imgBx">
			<img src="Image/<?php echo $row1['poster'];?>" width="300px" height="300px">
		</div>
		<div class="details">
			<h3><?php echo $row1['Movie_Name'];?><br><span><?php echo $row1['type'];?></span></h3>
		</div>
	</div>
	
	    
	<?php
	}
	?>	
	
	
	
	
</div>
    <!-- Add Pagination -->
<div class="swiper-pagination"></div>
</div>


<br>


<div style="background-color: #0b243d;">
<br><br>
<h2 class="headings" style="margin-left:30px;color:#886D2C;font-size:30px;text-decoration:underline;text-decoration-color:red;">NEW </h2>

<h2 style="margin-left:30px;color:#886D2C;font-size:30px;">RELEASES</h2>
<br>
<br>
</div>





<h2 style="position:absolute;left:30px;top:720px">COMEDY<i class="right"></i></h2>

<h2 style="position:absolute;left:30px;top:1150px">DRAMA/ACTION<i class="right"></i></h2>

<h2 style="position:absolute;left:30px;top:1590px">HORROR/THRLLER<i class="right"></i></h2>




<div class="movie-list">

 <table height="1300px" width="100%">
 
        <tr style="padding-bottom:10px;">
	
        <?php
       
        include('dbcon.php');
       
        $qry = "select * from movies where type='comedy'";
 
        $run = mysqli_query($con,$qry);
		$rows=mysqli_num_rows($run);
		while($row = mysqli_fetch_array($run))
		{
		if($row['Release_date']<="2021-05-15")
		{
        ?>       
                <td width="25%">
                <center>
 
                     <div class="zoomimg">
					 <a href="mdetails.php?id=<?php echo $row['Movie_id'];?>">
		<img height="300px" width="300px" style="transition:0.75s;border-radius:20px;" src="Image/<?php echo $row['poster'];?>"> 
					 </a>
					 </div>
                   
                </center>
                </td>
				
				
		<?php }
		
		}?>
			   
		</tr>
		
		
		
		<tr style="padding-top:20px;padding-bottom:10px;">
        <?php
       
        include('dbcon.php');
       
        $qry = "select * from movies where type like '%drama%' or type like '%action%'";
 
        $run = mysqli_query($con,$qry);
		$rows=mysqli_num_rows($run);
		while($row = mysqli_fetch_array($run))
		{
		if($row['Release_date']<="2021-05-15")
		{
        ?>       
                <td width="25%">
                <center>
                 
 
                     <div class="zoomimg">
					 <a href="mdetails.php?id=<?php echo $row['Movie_id'];?>">
		<img height="300px" width="300px" style="transition:0.75s;border-radius:20px;" src="Image/<?php echo $row['poster'];?>"> 
					 </a>
					</div>
                   
                </center>
                </td>
				
				
		<?php }
		
		}?>
			   
		</tr>
		
		
		
		<tr style="padding-top:20px;padding-bottom:10px;">
        <?php
       
        include('dbcon.php');
       
        $qry = "select * from movies where type like '%horror%' or type like '%thriller%'";
 
        $run = mysqli_query($con,$qry);
		$rows=mysqli_num_rows($run);
		while($row = mysqli_fetch_array($run))
		{
		if($row['Release_date']<="2021-05-15")
		{
        ?>      
                <td width="25%">
                <center>
                       
 
                     <div class="zoomimg">
					 <a href="mdetails.php?id=<?php echo $row['Movie_id'];?>">
			<img height="300px" width="300px" style="transition:0.75s;border-radius:20px;" src="Image/<?php echo $row['poster'];?>"> 
					 </a>
					 </div>
               
                         
                   
                </center>
                </td>
				
				
		<?php }
		
		}?>
			   
		</tr>

    </table>

</div>



<div class="book" style="background-color:#0b243d" ><center><form action="booking.php" method="post"> <input type="submit" name="submit" value="Book Now"> </form></center>
</div>

<div class="book1" style="background-color:#0b243d ;margin-bottom:100px;"><center><a href="upcomingmovies.php"><input type="submit" name="submit" value="Upcoming Movies"></center></a></center>
</div>


<?php

if(isset($_POST["submit"]))
{
	header('location:booking.php');
}
?>


<script type="text/javascript" src="js/swiper.min.js">
</script>


<script>
    var swiper = new Swiper('.swiper-container', {
      effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
      coverflowEffect: {
        rotate: 20,
        stretch: 0,
        depth: 200,
        modifier: 4,
        slideShadows : true,
      },
	   autoplay: {
        delay: 1000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
      },
    });
  </script>



<script>
	function toggleSidebar()
	{
		
		
		document.getElementById("sidebar").classList.toggle("active");
		
	}

</script>

<footer class="footer-distributed">
 
		<div class="footer-left">
 
		<h3>Show<span>Booking</span></h3>
 
		<p class="footer-links">
		<a href="userdashboard.php">Home</a>
	|
		<a href="about.php">About Us</a>
		</p>
 
		<p class="footer-company-name">ShowBooking &copy; 2021</p>
		</div>
 
		<div class="footer-center">
 
		<div>
		<i class="fa fa-map-marker"></i>
		<p><span>Lovely Professional University</span> Punjab, India</p>
		</div>
 
		<div>
		<i class="fa fa-phone"></i>
		<p>+91 9784333670</p>
		</div>
 
		<div>
		<i class="fa fa-envelope"></i>
		<p><a href="mailto:contact@fantasycinema.com">contact@showbooking.com</a></p>
		</div>
 
		</div>
 
		<div class="footer-right">
 
		<p class="footer-company-about">
		<span>About the company</span>
	Show Booking is a website to know about trending movies, tv-series  &amp; also you can stream the content you love from anywhere at anytime.
		</p>
 
		<div class="footer-icons">
 
		<a href="https://facebook.com"><i class="fa fa-facebook"></i></a>
		<a href="https://twitter.com"><i class="fa fa-twitter"></i></a>
		<a href="https://linkedin.com"><i class="fa fa-linkedin"></i></a>
		<a href="https://github.com"><i class="fa fa-github"></i></a>
 
		</div>
 
		</div>
 
    </footer>


</body>
</html>

