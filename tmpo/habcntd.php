<html>
<body>
<?php

$con=mysqli_connect("localhost","Irridescent","Irridescent","Irridescent");

if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

mysqli_query($con,"alter table districtdata add Habitation_count int");

$dstt=mysqli_query($con,"select distinct state,district from districtdata");


while($row_dstt=mysqli_fetch_array($dstt))
{

$dstt_val=$row_dstt['district'];

$std_val=$row_dstt['state'];

$hbc1=mysqli_query($con,"select count(habitation) from data where district='$dstt_val' and state='$std_val'");
$hbc1_r=mysqli_fetch_array($hbc1);
$hbc1_v=$hbc1_r['count(habitation)'];


mysqli_query($con,"update districtdata set Habitation_count=$hbc1_v where district='$dstt_val' and state='$std_val'");

}

?>
</body>
</html>
