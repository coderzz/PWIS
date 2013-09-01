<html>
<body>
<?php

$con=mysqli_connect("localhost","Irridescent","Irridescent","Irridescent");

if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

//////////////DISTRICT-DATA////////////////////////////////////////////
/**

mysqli_query($con,"create table districtdata(ID int,State text,District text,Percentage decimal,Latitude float,Longitude float)");


$dstt=mysqli_query($con,"select distinct state,district from data");


while($row_dstt=mysqli_fetch_array($dstt))
{

$dstt_val=$row_dstt['district'];

$hbc1=mysqli_query($con,"select count(habitation) from data where district='$dstt_val'");
$hbc1_r=mysqli_fetch_array($hbc1);
$hbc1_v=$hbc1_r['count(habitation)'];

$hbc=mysqli_query($con,"select count(habitation) from data where percentage>70 and district='$dstt_val'");
$hbc_r=mysqli_fetch_array($hbc);
$hbc_v=$hbc_r['count(habitation)'];

$avd=($hbc_v/$hbc1_v)*100;

$id=mysqli_query($con,"select id from data where district='$dstt_val'");
$row_id=mysqli_fetch_array($id);
$id_val=$row_id['id'];

$std=mysqli_query($con,"select state from `data` where district='$dstt_val'");
$row_std=mysqli_fetch_array($std);
$std_val=$row_std['state'];


$vald=$dstt_val.", ".$std_val.", India";
$addd = urlencode($vald);
$urld = "http://maps.googleapis.com/maps/api/geocode/json?address=$addd&sensor=false";
$getmapd = file_get_contents($urld);
$googlemapd = json_decode($getmapd);
foreach($googlemapd->results as $resd)
{
	$addressd = $resd->geometry;
	$latlngd = $addressd->location;
}



mysqli_query($con,"insert into districtdata (ID,State,District,Percentage,Latitude,Longitude) values ('$id_val','$std_val','$dstt_val','$avd','$latlngd->lat','$latlngd->lng')");

}
*/

//////////////BLOCK-DATA////////////////////////////////////////////
/**

mysqli_query($con,"create table blockdata(ID int,State text,District text,Block text,Latitude float,Longitude float)");


$blk=mysqli_query($con,"select distinct state,district,block from data where state='uttar pradesh'");

while($row_blk=mysqli_fetch_array($blk))
{

$blk_val=$row_blk['block'];


$stb_val=$row_blk['state'];

$dtb_val=$row_blk['district'];



$id=mysqli_query($con,"select id from data where block='$blk_val' and district='$dtb_val'");
$row_id=mysqli_fetch_array($id);
$id_val=$row_id['id'];



$valb=$blk_val.", ".$dtb_val.", ".$stb_val.", India";

$addb = urlencode($valb);
$urlb = "http://maps.googleapis.com/maps/api/geocode/json?address=$addb&sensor=false";
$getmapb = file_get_contents($urlb);
$googlemapb = json_decode($getmapb);
foreach($googlemapb->results as $resb)
{
	$addressb = $resb->geometry;
	$latlngb = $addressb->location;
}



mysqli_query($con,"insert into blockdata (ID,State,District,Block,Latitude,Longitude) values ('$id_val','$stb_val','$dtb_val','$blk_val','$latlngb->lat','$latlngb->lng')");

}

*/
/**
mysqli_query($con,"create table statedata(ID int,State text,Percentage decimal,Latitude float,Longitude float)");


$dstt=mysqli_query($con,"select distinct state from data");


while($row_dstt=mysqli_fetch_array($dstt))
{

$dstt_val=$row_dstt['state'];

$hbc1=mysqli_query($con,"select count(habitation) from data where state='$dstt_val'");
$hbc1_r=mysqli_fetch_array($hbc1);
$hbc1_v=$hbc1_r['count(habitation)'];

$hbc=mysqli_query($con,"select count(habitation) from data where percentage>70 and state='$dstt_val'");
$hbc_r=mysqli_fetch_array($hbc);
$hbc_v=$hbc_r['count(habitation)'];

$avd=($hbc_v/$hbc1_v)*100;

$id=mysqli_query($con,"select id from data where state='$dstt_val'");
$row_id=mysqli_fetch_array($id);
$id_val=$row_id['id'];

$std=mysqli_query($con,"select state from `data` where state='$dstt_val'");
$row_std=mysqli_fetch_array($std);
$std_val=$row_std['state'];


$vald=$dstt_val.", India";
$addd = urlencode($vald);
$urld = "http://maps.googleapis.com/maps/api/geocode/json?address=$addd&sensor=false";
$getmapd = file_get_contents($urld);
$googlemapd = json_decode($getmapd);
foreach($googlemapd->results as $resd)
{
	$addressd = $resd->geometry;
	$latlngd = $addressd->location;
}



mysqli_query($con,"insert into statedata (ID,State,Percentage,Latitude,Longitude) values ('$id_val','$std_val','$avd','$latlngd->lat','$latlngd->lng')");

}
*/


mysqli_close($con);
?>


</body>
</html>

