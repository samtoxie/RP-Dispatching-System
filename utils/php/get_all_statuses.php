<?php
$filename = 'statuses.json';
if (time() - filemtime($filename) > 15) {
    require_once "config.php";
    $sql = "SELECT id, unitstatus FROM `status` WHERE (NOW() - INTERVAL 1 HOUR) < lastUpdated";
    $result = mysqli_query($link, $sql);
    $rows = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        $data = json_encode($rows);

        $myfile = fopen($filename, "w") or die("Unable to open file!");
        fwrite($myfile, $data);
        fclose($myfile);

        header('Content-Type: application/json');
        echo $data;
    }
    mysqli_close($link);
} else {
    $data = file_get_contents($filename);;
    header('Content-Type: application/json');
    echo $data;
}
?>