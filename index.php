<?php
session_start();
if($_SESSION["loggedin"] != true){
    header("location: login_form.php");
}
?>

<html>
<head>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<h1>Admin Portal</h1>
<a href="search_all_employees.php">Show all employees</a>
<br>
<a href="logout.php">Logout</a>
<br>

<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

    include "db_connect.php"; 
?>

<form class="form-horizontal" action="search_keyword.php">
<fieldset>
    <legend>Search for an employee</legend>

    <div class="form-group">
        <label class="col-md-4 control-label" for="keyword">Search input</label>
            <div class="col-md-5">
                <input id = "keyword" type="search" name="keyword" placeholder="e.g. name" class="form-control input-md" required="">
            <p class="help-block">Enter a keyword to search for a last name in the employee database</p>
        </div>
    </div>

    <div class="form-group">
        <label for="submit" class="col-md-4 control-label"></label>
        <div class-"col-md-4">
            <button id="submit" name="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
</fieldset>
</form>

<hr>

<form class="form-horizontal" action="add_employee.php">
<fieldset>
    <legend>Add a new employee</legend>

    <div class="form-group">
        <label class="col-md-4 control-label" for="first_name">First Name: </label>
        <div class="col-md-5">
            <input id = "first_name" type="text" name="first_name" placeholder="First Name" class="form-control input-md" required="">
            <p class="help-block">Enter the employee's first name.</p>
        </div>
        <label class="col-md-4 control-label" for="last_name">Last Name: </label>
        <div class="col-md-5">
            <input id = "last_name" type="text" name="last_name" placeholder="Last Name" class="form-control input-md" required="">
            <p class="help-block">Enter the employee's last_name.</p>
        </div>
        <label class="col-md-4 control-label" for="hire_date">Hire Date: </label>
        <div class="col-md-5">
            <input id = "hire_date" type="text" name="hire_date" placeholder="YYYY-MM-DD" class="form-control input-md" required="">
            <p class="help-block">Enter the employee's hire date.</p>
        </div>
        <label class="col-md-4 control-label" for="state">State: </label>
        <div class="col-md-5">
            <input id = "state" type="text" name="state" placeholder="State" class="form-control input-md" required="">
            <p class="help-block">Enter the employee's state.</p>
        </div>
        <label class="col-md-4 control-label" for="phone">Phone Number: </label>
        <div class="col-md-5">
            <input id = "phone" type="text" name="phone" placeholder="##########" class="form-control input-md" required="">
            <p class="help-block">Enter the employee's phone number.</p>
        </div>
        <label class="col-md-4 control-label" for="position">Position Held: </label>
        <div class="col-md-5">
            <input id = "position" type="text" name="position" placeholder="Position Description" class="form-control input-md" required="">
            <p class="help-block">Enter the employee's held position.</p>
        </div>
        <label class="col-md-4 control-label" for="salary">Salary: </label>
        <div class="col-md-5">
            <input id = "salary" type="text" name="salary" placeholder="00000.00" class="form-control input-md" required="">
            <p class="help-block">Enter the employee's current salary.</p>
        </div>
    </div>

    <div class="form-group">
        <label for="submit" class="col-md-4 control-label"></label>
        <div class-"col-md-4">
            <button id="submit" name="submit" class="btn btn-primary">OK</button>
        </div>
    </div>

    </fieldset>
</form>

 
<?php 
$mysqli->close();
?>

</body>
</html>