<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}



// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "utils/php/config.php";

    $unitstatus = trim($_POST["status"]);

    // Prepare a select statement
    $sql = "CALL `updateStatus`(?, ?);";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION["id"], $unitstatus);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            mysqli_stmt_store_result($stmt);
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>

<body class="text-center">
    <div class="container center content">
        <form class="row" action="unitview.php" method="post">
            <div class="mx-auto align-middle col-xs-6 col-md-4 col-lg-3 col-xl-2"><button name="status" type="submit" class="btn btn-primary w-100" value="1">1</button></div>
            <div class="mx-auto align-middle col-xs-6 col-md-4 col-lg-3 col-xl-2"><button name="status" type="submit" class="btn btn-primary w-100" value="2">2</button></div>
            <div class="mx-auto align-middle col-xs-6 col-md-4 col-lg-3 col-xl-2"><button name="status" type="submit" class="btn btn-primary w-100" value="3">3</button></div>
            <div class="mx-auto align-middle col-xs-6 col-md-4 col-lg-3 col-xl-2"><button name="status" type="submit" class="btn btn-primary w-100" value="4">4</button></div>
            <div class="mx-auto align-middle col-xs-6 col-md-4 col-lg-3 col-xl-2"><button name="status" type="submit" class="btn btn-primary w-100" value="5">5</button></div>
        </form>
    </div>
</body>

</html>