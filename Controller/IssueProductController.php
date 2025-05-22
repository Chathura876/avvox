<?php
require_once '../Model/SalesInvoice.php';
require_once("../common/database.php");

header('Content-Type: application/json');

if ($_POST['command'] === 'search') {
    $query =$_POST['query'];

    $sql = "SELECT id, invoice_no,customer_name FROM `sales_invoice` WHERE invoice_no LIKE '%$query%'";
    $result = $mysqli->query($sql);

    $suggestions = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $suggestions[] = [
                'id' => $row['id'],
                'invoice_no' => $row['invoice_no'] ,
                'customer_name' => $row['customer_name']
            ];
        }
    }

    echo json_encode($suggestions);
    exit;
}

if ($_POST['command'] == 'getDetails') {
    $sql = "SELECT * FROM sales_invoice_item WHERE invoice_no = '" . $_POST['id'] . "'";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Items not found']);
    }

    $mysqli->close();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if (isset($data['command']) && $data['command'] === 'saveBarcodes') {
        $products = $data['products'];
        $today = date('Y-m-d');

        foreach ($products as $product) {
            $invoiceNo = $product['invoice_no'];
            $productName = $product['item_name'];
            $indoor_barcodes = $product['indoor_barcodes'];
            $outdoor_barcodes = $product['outdoor_barcodes'];
            $price = isset($product['price']) ? $product['price'] : 0; // Default price if not passed

            $qty = count($indoor_barcodes);

            for ($i = 0; $i < $qty; $i++) {
                $indoor_barcode = $indoor_barcodes[$i] ?? '';
                $outdoor_barcode = $outdoor_barcodes[$i] ?? '';

                $sql = "INSERT INTO `issue_product_barcode` 
                    (`invoice_no`, `product_name`, `qty`, `price`, `indoor_barcode`, `date`, `outdoor_barcode`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

                $stmt = $mysqli->prepare($sql);
                if ($stmt === false) {
                    echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $mysqli->error]);
                    exit;
                }

                $stmt->bind_param("ssddsss", $invoiceNo, $productName, $qty, $price, $indoor_barcode, $today, $outdoor_barcode);
                $stmt->execute();

                $sql = "UPDATE `sales_invoice` SET `issue` = 1 WHERE `invoice_no` = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("s", $invoiceNo); // Use "s" if invoice_no is a string
                $stmt->execute();

            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Barcodes saved successfully']);
        exit;
    }

}
?>

