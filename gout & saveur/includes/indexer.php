<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['query'])) {
    $query = escapeshellarg($_POST['query']);
    $output = shell_exec("python indexer.py $query");
    header('Content-Type: application/json');
    echo $output;
    exit;
}
?>

