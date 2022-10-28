<?php
session_start();

if (! $_SESSION['admin_id']) {
    echo "Only logged in users may access this page. Click <a href='login.php'here</a> to login<br>";
    exit;
}

// Include config file
require_once "db_connect.php";

// Define variables and initialize with empty values
$first_name = $last_name = $hire_date = $state = $phone = $position = $salary = "";
$first_name_err = $last_name_err = $hire_date_err = $state_err = $phone_err = $position_err = $salary_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_first_name = trim($_POST["first_name"]);
    if(empty($input_first_name)){
        $first_name_err = "Please enter your first name.";
    } elseif(!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $first_name_err = "Please enter a valid name.";
    } else{
        $first_name = $input_first_name;
    }
    
    // Validate last name
    $input_last_name = trim($_POST["last_name"]);
    if(empty($input_last_name)){
        $last_name_err = "Please enter an address.";
    } else{
        $last_name = $input_last_name;
    }
    
    // Validate hire date
    $input_hire_date = trim($_POST["hire_date"]);
    if(empty($input_hire_date)){
        $hire_date_err = "Please enter the hire date.";
    } else{
        $hire_date = $input_hire_date;
    }
    
    // Validate state
    $input_state = trim($_POST["state"]);
    if(empty($input_last_name)){
        $state_err = "Please enter the full state name.";
    } else{
        $state = $input_state;
    }
    
    // Validate phone
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Please enter the phone number i.e. ##########.";
    } else{
        $phone = $input_phone;
    }
    
    // Validate position
    $input_position = trim($_POST["position"]);
    if(empty($input_position)){
        $position_err = "Please enter the position.";
    } else{
        $position = $input_position;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($first_name_err) && empty($last_name_err) && empty($hire_date_err) && empty($state_err) && empty($phone_err) && empty($position_err) && empty($salary_err)){
        // Prepare an update statement
        $sql = "UPDATE employees SET first_name=?, last_name=?, hire_date=?, state=?, phone=?, position=?, salary=? WHERE employee_id=?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssdi", $first_name, $last_name, $hire_date, $state, $phone, $position, $salary, $param_employee_id);
            
            // Set parameters
            $param_first_name = $first_name;         
            $param_last_name = $last_name;
            $param_hire_date = $hire_date;
            $param_state = $state;
            $param_phone = $phone;
            $param_position = $position;
            $param_salary = $salary;
            $param_employee_id = $employee_id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["employee_id"]) && !empty(trim($_GET["employee_id"]))){
        // Get URL parameter
        $id =  trim($_GET["employee_id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM employees WHERE employee_id = ?";
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_employee_id);
            
            // Set parameters
            $param_employee_id = $employee_id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set
                     contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $first_name = $row["first_name"];
                    $last_name = $row["last_name"];
                    $hire_date = $row["hire_date"];
                    $state = $row["state"];
                    $phone = $row["phone"];
                    $position = $row["position"];
                    $salary = $row["salary"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                            <span class="invalid-feedback"><?php echo $first_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <textarea name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>"><?php echo $last_name; ?></textarea>
                            <span class="invalid-feedback"><?php echo $last_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Hire Date</label>
                            <textarea name="hire_date" class="form-control <?php echo (!empty($hire_date_err)) ? 'is-invalid' : ''; ?>"><?php echo $hire_date; ?></textarea>
                            <span class="invalid-feedback"><?php echo $hire_date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <textarea name="state" class="form-control <?php echo (!empty($state_err)) ? 'is-invalid' : ''; ?>"><?php echo $state; ?></textarea>
                            <span class="invalid-feedback"><?php echo $state_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <textarea name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>"><?php echo $phone; ?></textarea>
                            <span class="invalid-feedback"><?php echo $phone_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <textarea name="position" class="form-control <?php echo (!empty($position_err)) ? 'is-invalid' : ''; ?>"><?php echo $position; ?></textarea>
                            <span class="invalid-feedback"><?php echo $position_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
