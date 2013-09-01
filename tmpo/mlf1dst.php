<!DOCTYPE html>
<html>
<head>
	<title>Leaflet debug page</title>

	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.6.2/leaflet.css" />
	<!--[if lte IE 8]><link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.6.2/leaflet.ie.css" /><![endif]-->
	<script src="http://cdn.leafletjs.com/leaflet-0.6.2/leaflet.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" href="mobile.css" />

	<link rel="stylesheet" href="MarkerCluster.css" />
	<link rel="stylesheet" href="MarkerCluster.Default.css" />
	<!--[if lte IE 8]><link rel="stylesheet" href="MarkerCluster.Default.ie.css" /><![endif]-->
	<script src="leaflet.markercluster-src.js"></script>
	<script src="realworld.3888.js"></script>
	
	
</head>
<body>

	<div id="map"></div>

	<?php 

$con=mysqli_connect("localhost","Irridescent","Irridescent","Irridescent");

if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


echo "<script>

var yyp,yylt,yyln,yyvhb;
var yydt,i,ttle,yyst,yybl;
var arr=[];
var arrdt=[];
var arrbl=[];
var arrlt=[];
var arrln=[];
var vhbt=[];
var arrst=[];

</script>";

$read=mysqli_query($con,"select state,district,percentage,latitude,longitude,habitation_count from districtdata");
//$rlt=mysqli_query($con,"select latitude from block_data1");
//$rln=mysqli_query($con,"select longitude from block_data1");
//$rdt=mysqli_query($con,"select Block from block_data1");


while($rread=mysqli_fetch_array($read))
{
//$rrdt=mysqli_fetch_array($rdt);
//$rrlt=mysqli_fetch_array($rlt);
//$rrln=mysqli_fetch_array($rln);

$tmpp=$rread['percentage'];
$tmplt=$rread['latitude'];
$tmpln=$rread['longitude'];
$tmpdt=$rread['district'];
$tmps=$rread['state'];
$tmphb=$rread['habitation_count'];



echo "<script> 
yyp=$tmpp;
yylt=$tmplt;
yyln=$tmpln;
yydt=\"$tmpdt\";
yyvhb=$tmphb;
yyst=\"$tmps\";

vhbt.push(yyvhb);
arrdt.push(yydt);
arr.push(yyp);
arrlt.push(yylt);
arrln.push(yyln);
arrst.push(yyst);


</script>";
}


echo "<script>

var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/5d205a745590448bbb2598e28fd70844/997/256/{z}/{x}/{y}.png',
			cloudmadeAttribution = 'Map data &copy; 2011 OpenStreetMap contributors, Imagery &copy; 2011 CloudMade, Points &copy 2012 LINZ',
			cloudmade = L.tileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution}),
			latlng = L.latLng(21.6, 79);

var map = L.map('map', {center: latlng, zoom: 5, layers: [cloudmade]});

		var markers = L.markerClusterGroup();

		for(i=0;i<arr.length;i++)
{	
ttle=arrdt[i]+\", \"+arrst[i]+\": \"+arr[i]+\"%\"+\"(\"+vhbt[i]+\")\";

			var marker = L.marker(L.latLng(arrlt[i], arrln[i]),{title: ttle});
			marker.bindPopup(\"<a href='homer.php?a=$tmpdt'>Get Habitation Level Data</a><br><a href='home.php?a=$tmpdt'>Get Block Level Data</a>\");
markers.addLayer(marker);
}		

		map.addLayer(markers);

	</script>";


?>
</body>
</html>