<html>
<body>
<?php

$con=mysqli_connect("localhost","Irridescent","Irridescent","Irridescent");

if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


mysqli_query($con,"alter table data add column Percentage decimal");

mysqli_query($con,"alter table data add column Sid int");

mysqli_query($con,"alter table data add column ID int not null auto_increment, add primary key (ID)");

mysqli_query($con,"update data set Percentage=(`sc cov`+`st cov`+`gen cov`)/(`sc total` +`st total`+`gen total`)*100");

?>
</body>
</html>