<?php
require_once '../Model/Product.php';
require_once("../common/database.php");

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Read JSON input
$input = json_decode(file_get_contents("php://input"), true);
$command = isset($input['command']) ? $input['command'] : null;

if ($command === 'get_invoice_no') {
    $sql = "SELECT id FROM sales_invoice ORDER BY id DESC LIMIT 1";
    $result = $mysqli->query($sql);

    if (!$result) {
        echo json_encode(['error' => $mysqli->error]);
        exit;
    }

    if ($row = $result->fetch_assoc()) {
        $invoice_no = 'INV/' . str_pad($row['id'] + 1, 6, '0', STR_PAD_LEFT);
    } else {
        $invoice_no = 'INV/000001';
    }

    echo json_encode($invoice_no);
    exit;
}

if ($command === 'save_payment') {
    $inv_no = isset($input['inv_no']) ? $input['inv_no'] : '';
    $customer = isset($input['customer']) ? $input['customer'] : '';
    $netTotal = isset($input['netTotal']) ? floatval($input['netTotal']) : 0;
    $cash = isset($input['cash']) ? floatval($input['cash']) : 0;
    $card = isset($input['card']) ? floatval($input['card']) : 0;
    $credit = isset($input['credit']) ? floatval($input['credit']) : 0;
    $cheque = isset($input['cheque']) ? floatval($input['cheque']) : 0;
    $totalPaid = isset($input['totalPaid']) ? floatval($input['totalPaid']) : 0;
    $balance = isset($input['balance']) ? floatval($input['balance']) : 0;
    $items = isset($input['item']) ? $input['item'] : [];
    $shop = isset($input['shop']) ? $input['shop'] : '';
    $date1 = isset($input['date1']) ? $input['date1'] : null;
    $date2 = isset($input['date2']) ? $input['date2'] : null;
    $date3 = isset($input['date3']) ? $input['date3'] : null;
    $date = date('Y-m-d');

    // Basic validation
    if (empty($inv_no) || empty($customer) || empty($items)) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        exit;
    }

    // Start transaction
    $mysqli->begin_transaction();
    try {
        // Insert into sales_invoice
        $sql = "INSERT INTO `sales_invoice` (
                    `invoice_no`, `total`, `discount`, `net_total`, `balance`, 
                    `customer_name`, `invoice_date`, `cash`, `card`, `cheque`, `online`,
                    `shop`, `date1`, `date2`, `date3`
                ) VALUES (
                    ?, ?, 0, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?, ?
                )";

        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $mysqli->error);
        }

        $stmt->bind_param(
            "sdddssdddssss",
            $inv_no,
            $totalPaid,
            $netTotal,
            $balance,
            $customer,
            $date,
            $cash,
            $card,
            $cheque,
            $shop,
            $date1,
            $date2,
            $date3
        );

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $invoice_id = $mysqli->insert_id;

        // Insert into sales_invoice_item
        $item_sql = "INSERT INTO `sales_invoice_item` 
                        (`invoice_no`, `item_id`, `item_name`, `qty`, `price`, `discount`, `sub_total`)
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
        $item_stmt = $mysqli->prepare($item_sql);
        if (!$item_stmt) {
            throw new Exception("Prepare item insert failed: " . $mysqli->error);
        }

        foreach ($items as $product) {
            $item_stmt->bind_param(
                "sisiddd",
                $inv_no,
                $product['id'],
                $product['model'],
                $product['qty'],
                $product['pricedefault'],
                $product['discount'],
                $product['subtotal']
            );
            $item_stmt->execute();

            // Inventory Update
            $modelId = $product['id'];
            $qtySold = $product['qty'];
//            $shopId = $product['shop'];

            $inv_stmt = $mysqli->prepare("SELECT amount FROM inventory WHERE modelid = ? AND dealerid = ?");
            if (!$inv_stmt) {
                throw new Exception("Prepare inventory select failed: " . $mysqli->error);
            }

            $inv_stmt->bind_param("ii", $modelId, $shop);
            $inv_stmt->execute();
            $inv_result = $inv_stmt->get_result();

            if ($inv_result && $inv_result->num_rows > 0) {
                $row = $inv_result->fetch_assoc();
                $currentQty = $row['amount'];
                $newQty = $currentQty - $qtySold;

                $update_stmt = $mysqli->prepare("UPDATE inventory SET amount = ? WHERE modelid = ? AND dealerid = ?");
                if (!$update_stmt) {
                    throw new Exception("Prepare inventory update failed: " . $mysqli->error);
                }

                $update_stmt->bind_param("iii", $newQty, $modelId, $shop);
                $update_stmt->execute();
            }
        }

        // Commit the transaction
        $mysqli->commit();

        echo json_encode(['success' => true, 'invoice_id' => $invoice_id]);
        exit;

    } catch (Exception $e) {
        $mysqli->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
}


echo json_encode(['error' => 'Invalid command or no command provided']);
exit;


// If no valid command
echo json_encode(['error' => 'Invalid command or no command provided']);
exit;
