<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// if changed, update current unit status in database using a stored procedure
// else get current status from database
require_once "utils/php/config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unitstatus = trim($_POST["status"]);

    $sql = "CALL `updateStatus`(?, ?);";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION["id"], $unitstatus);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        mysqli_stmt_close($stmt);
    }
} else {
    $sql = "SELECT unitstatus FROM `status` WHERE id = " . $_SESSION["id"] . ";";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
            $unitstatus = $row["unitstatus"];
        }
    } else {
        $unitstatus = 0;
    }

    mysqli_close($link);
}


?>
<!-- Statuscodes nederlandse politie
1 	Vrij
2 	Aanrijdend naar de melding
3 	Ter plaatse bij de melding
4 	Aanvraag stemcontact HKD (personalia controle)
5 	Melding afgehandeld
6 	Aanvraag stemcontact Meldkamer
7 	Aanvraag urgent stemcontact
8 	Sluiten (aan bureau of eigen initiatief melding)
9 	Niet in gebruik
0/N 	Noodknop , mobilofoon blijft ca. 30 sec. uitzenden
-->
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
        <div class="row">
            <div class="mx-auto col-sm-12">
                <p>Huidige status: <?php echo $unitstatus?></p>
            </div>
        </div>
        <form class="row" action="unitview.php" method="post">
            <div class="mx-auto align-middle col-xs-6 col-md-4 col-lg-3 col-xl-2" style="padding:1rem;"><button name="status" type="submit" class="btn btn-primary w-100" value="1">1</button></div>
            <div class="mx-auto align-middle col-xs-6 col-md-4 col-lg-3 col-xl-2" style="padding:1rem;"><button name="status" type="submit" class="btn btn-primary w-100" value="2">2</button></div>
            <div class="mx-auto align-middle col-xs-6 col-md-4 col-lg-3 col-xl-2" style="padding:1rem;"><button name="status" type="submit" class="btn btn-primary w-100" value="3">3</button></div>
            <div class="mx-auto align-middle col-xs-6 col-md-4 col-lg-3 col-xl-2" style="padding:1rem;"><button name="status" type="submit" class="btn btn-primary w-100" value="4">4</button></div>
            <div class="mx-auto align-middle col-xs-6 col-md-4 col-lg-3 col-xl-2" style="padding:1rem;"><button name="status" type="submit" class="btn btn-primary w-100" value="5">5</button></div>
        </form>
    </div>
</body>

</html>