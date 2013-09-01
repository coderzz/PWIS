<html>
<head>
<title> HOME </title>
<style type="text/css">
table.curvedEdges { border:10px solid RoyalBlue;-webkit-border-radius:13px;-moz-border-radius:13px;-ms-border-radius:13px;-o-border-radius:13px;border-radius:13px; }
table.curvedEdges td, table.curvedEdges th { border-bottom:1px dotted black;padding:5px; }
</style>
<style type="text/css">
table.curvedEdges1 { border:10px solid Orange;-webkit-border-radius:13px;-moz-border-radius:13px;-ms-border-radius:13px;-o-border-radius:13px;border-radius:13px; }
table.curvedEdges1 td, table.curvedEdges th { border-bottom:1px dotted black;padding:5px; }
</style>

<link rel="stylesheet" href="css/nv.d3.css" />

<script src="js/d3.v2.min.js"></script>
<script src="js/nv.d3.js"></script>


</head>
<body>

<img src="./img/logo.png"><br>

<?php
$con=mysqli_connect("localhost","root","","irridescent");

if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
$valb=$_GET['a'];
$vald=$_GET['p'];
$vals=$_GET['q'];
$min=$_GET['b'];
$max=$_GET['c'];

  $zt=mysqli_query($con,"select count(habitation) from data where percentage>=0 and percentage<=20 and block='$valb' and district='$vald' and state='$vals'");
  $ztr=mysqli_fetch_array($zt);
  $ztv=$ztr['count(habitation)'];
    
  $tf=mysqli_query($con,"select count(habitation) from data where percentage>20 and percentage<=40 and block='$valb' and district='$vald' and state='$vals'");
  $tfr=mysqli_fetch_array($tf);
  $tfv=$tfr['count(habitation)'];
  
  
  $fs=mysqli_query($con,"select count(habitation) from data where percentage>40 and percentage<=60 and block='$valb' and district='$vald' and state='$vals'");
  $fsr=mysqli_fetch_array($fs);
  $fsv=$fsr['count(habitation)'];
  
  
  $se=mysqli_query($con,"select count(habitation) from data where percentage>60 and percentage<=80 and block='$valb' and district='$vald' and state='$vals'");
  $ser=mysqli_fetch_array($se);
  $sev=$ser['count(habitation)'];
  
  
  $eh=mysqli_query($con,"select count(habitation) from data where percentage>80 and percentage<=100 and block='$valb'and district='$vald' and state='$vals'");
  $ehr=mysqli_fetch_array($eh);
  $ehv=$ehr['count(habitation)'];
  
?>
<script >
var data = [
  {
    key: "",
    values: [
      { 
        "label": "0-20%",
        "value" : <?php echo $ztv;?>
      } , 
      { 
        "label": "20-40%",
        "value" : <?php echo $tfv;?>
      } , 
      { 
        "label": "40-60%",
        "value" : <?php echo $fsv;?>
      } , 
      { 
        "label": "60-80%",
        "value" : <?php echo $sev;?>
      } , 
      { 
        "label": "80-100%",
        "value" : <?php echo $ehv;?>
      } 
      
    ]
  }
];

nv.addGraph(function() {
  var chart = nv.models.pieChart()
      .x(function(d) { return d.label })
      .y(function(d) { return d.value })
      .showLabels(true);

    d3.select("#chart svg")
        .datum(data)
      .transition().duration(1200)
        .call(chart);

  return chart;
});

</script>
<style>

#chart svg {
  height: 400px;
  width: 100%;
}

</style>


<div id="chart">
  <svg></svg>
</div>


<table class="curvedEdges" align="center">
<tr>
<th align="left"><h>State&nbsp&nbsp&nbsp&nbsp</th>
<th align="left"><h>District&nbsp&nbsp&nbsp&nbsp</th>
<th align="left"><h>Block&nbsp&nbsp&nbsp&nbsp</th>
<th align="left"><h>Total Habitations&nbsp&nbsp&nbsp&nbsp</th>
<th align="left"><h>Habitation in Range&nbsp&nbsp&nbsp&nbsp</th>
</tr>
<?php
$d=54;

$llk=mysqli_query($con,"select count(habitation) from data where block='$valb'and district='$vald' and state='$vals'");
$llkr=mysqli_fetch_array($llk);
$chb=$llkr['count(habitation)'];

$llkt=mysqli_query($con,"select count(habitation) from data where block='$valb'and district='$vald' and state='$vals' and percentage>=$min and percentage<=$max");
$llkrt=mysqli_fetch_array($llkt);
$chbt=$llkrt['count(habitation)'];


?>
<tr>
<td align="left"><?php echo $vals; ?></td>
<td align="left"><?php echo $vald; ?></td>
<td align="left"><?php echo $valb; ?></td>
<td align="center"> <?php echo $chb; ?></td>
<td align="center"> <?php echo $chbt; ?></td>

</tr>
</table>
<br>

<table class="curvedEdges" align="center">
<tr>
<th align="left"><h>Village</th>
<th align="left"><h>Habitation</th>
<th align="left"><h>Percentage</th>
</tr>
<?php

$blk=mysqli_query($con,"select distinct village,habitation,percentage from data where block='$valb'and district='$vald' and state='$vals' and percentage>=$min and percentage<=$max order by village");
while($blkr=mysqli_fetch_array($blk))
{
$hbv=$blkr['habitation'];

$vlg=$blkr['village'];

$pr=$blkr['percentage'];


?>
<tr>
<td> <?php echo $vlg; ?></td>
<td> <?php echo $hbv; ?></td>
<td> <?php echo $pr."%"; ?></td>


</tr>
<?php

$d=$d+1;
}
?>
</table>
</body>
</html>
