<?php
require_once '../Model/Product.php';
require_once("../common/database.php");

header('Content-Type: application/json');

if ($_POST['command']=='search') {
    $query = $_POST['query'];
    $item = new Product();
    $results = $item->search($query);
    $suggestions = [];
    foreach ($results as $row) {
        $suggestions[] = [
            'id' => $row['id'],         // Make sure your SQL selects 'id'
            'model' => $row['model']    // Use 'model' instead of just a string
        ];
    }

    echo json_encode($suggestions);
}

if ($_POST['command']=='getDetails') {
    $sql="SELECT * FROM product WHERE id='".$_POST['id']."'";
    $result = $mysqli->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Item not found']);
    }

    $mysqli->close();
    exit;
}
