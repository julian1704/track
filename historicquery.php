<?php

  include 'database.php';

  $servername = "designlocations.cl8waza61otc.us-east-2.rds.amazonaws.com";
  $username = "abcr";
  $password = "abcr1234";
        // Create connection
  $conn = new mysqli($servername, $username, $password);
        // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
         #echo "Connected successfully";
  mysqli_select_db($conn, "designlocations");

  $query=suscintquery($_POST['date1'],$_POST['date2'],$_POST['time1'],$_POST['time2'], $_POST["plc"], $_POST["lmt"]);

  echo "Generated query: ".$query;

  $result = mysqli_query($conn, $query);

  echo '<table style="width:100%">';
  echo "<tr>";
  echo "<th>ID</th>";
  echo "<th>Latitude</th>";
  echo "<th>Longitude</th>";
  echo "<th>Date/Time</th>";
  echo "</tr>";
 // $hist=[];
  while($row = mysqli_fetch_array($result))
  {
    echo "<tr>";
    echo "<td>" . $row['ID'] . "</td>";
    echo "<td>" . $row['Latitude'] . "</td>";
    echo "<td>" . $row['Longitude'] . "</td>";
    echo "<td>" . $row['DateTime'] . "</td>";
    echo "</tr>";
    //$hist[]=$row;
   
  }
  echo "</table>";
  //echo json_encode($hist);
  
?>
