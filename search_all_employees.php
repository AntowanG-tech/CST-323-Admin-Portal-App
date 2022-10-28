<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Accordion - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>  
   $( function() {    
      $( "#accordion" ).accordion();  
      } );  
  </script>
  </head>
<?php
require_once "db_connect.php";


$stmt = $mysqli->prepare("SELECT employee_id, first_name, last_name, hire_date, state, phone, position, salary FROM employees");


$stmt->execute();
$row = $stmt->fetch_row();
print $row[0]; // $row[0] will contain the value you're looking for
#$stmt->store_result();

$stmt->bind_result($employee_id, $first_name, $last_name, $hire_date, $state, $phone, $position, $salary);

if ($stmt->num_rows > 0) {
    // output data of each row
        
        echo '<table class="table table-bordered table-striped">';
        echo "<thead>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Hire Date</th>";
        echo "<th>State</th>";
        echo "<th>Phone</th>";
        echo "<th>Position</th>";
        echo "<th>Salary</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . $row['employee_id'] . "</td>";
            echo "<td>" . $row['first_name'] . "</td>";
            echo "<td>" . $row['last_name'] . "</td>";
            echo "<td>" . $row['hire_date'] . "</td>";
            echo "<td>" . $row['state'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['position'] . "</td>";
            echo "<td>" . $row['salary'] . "</td>";
            echo "<td>";
            echo '<a href="read.php?id='. $row['employee_id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
            echo '<a href="update.php?id='. $row['employee_id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
            echo '<a href="delete.php?id='. $row['employee_id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
    echo "0 results";
}

?>