<?php

session_start();

if (! $_SESSION['admin_id']) {
    echo "Only logged in users may access this page. Click <a href='login.php'here</a> to login<br>";
    exit;
}

// Check existence of id parameter before processing further
if(isset($_GET["employee_id"]) && !empty(trim($_GET["employee_id"]))){
    // Include config file
    require_once "db_connect.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE employee_id = ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_employee_id);
        
        // Set parameters
        $param_employee_id = trim($_GET["employee_id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set
                 contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $first_name = $row["first_name"];
                $first_name = $row["last_name"];
                $hire_date = $row["hire_date"];
                $state = $row["state"];
                $phone = $row["phone"];
                $position = $row["position"];
                $salary = $row["salary"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    
    // Close statement
    $stmt->close();
    
    // Close connection
    $mysqli->close();
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>First Name</label>
                        <p><b><?php echo $row["first_name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <p><b><?php echo $row["last_name"]; ?></b></p>
                    </div>
                     <div class="form-group">
                        <label>Hire Date</label>
                        <p><b><?php echo $row["hire_date"]; ?></b></p>
                    </div>
                     <div class="form-group">
                        <label>State</label>
                        <p><b><?php echo $row["state"]; ?></b></p>
                    </div>
                     <div class="form-group">
                        <label>Phone</label>
                        <p><b><?php echo $row["phone"]; ?></b></p>
                    </div>
                     <div class="form-group">
                        <label>Position</label>
                        <p><b><?php echo $row["position"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <p><b><?php echo $row["salary"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
