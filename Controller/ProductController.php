<?php
require_once '../Model/Product.php';
require_once("../common/database.php");

header('Content-Type: application/json');

if ($_POST['command'] == 'search') {
    $query = $_POST['query'];
    $shop = (int)$_POST['shop']; // cast to int for safety

    // Simulated SQL for debugging (not used for execution)
//    echo "DEBUG SQL: SELECT id, model FROM product_inventory WHERE dealerid = $shop AND amount > 0 AND model LIKE '%$query%' OR id LIKE '%$query%';";

    $sql = "SELECT id, model FROM product_inventory WHERE dealerid = ? AND amount > 0 AND model LIKE ? OR id LIKE ?";

    if ($stmt = $mysqli->prepare($sql)) {
        $searchTerm = '%' . $query . '%';

        // Bind 3 parameters: int, string, string
        $stmt->bind_param("iss", $shop, $searchTerm, $searchTerm);

        $stmt->execute();

        $result = $stmt->get_result();

        $suggestions = [];
        while ($row = $result->fetch_assoc()) {
            $suggestions[] = [
                'id' => $row['id'],
                'model' => $row['model']
            ];
        }

        echo json_encode($suggestions);

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare statement']);
    }
}




if ($_POST['command']=='getDetails') {
    $sql="SELECT * FROM product WHERE id='".$_POST['id']."'";
    $result = $mysqli->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Item not found or not have stock this shop']);
    }

    $mysqli->close();
    exit;
}
