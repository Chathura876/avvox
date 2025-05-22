<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) { //Prevent the user visiting this page if not logged in 
    //Redirect to user account page
    //header("Location: login.php");
    http_response_code(403);
    die();
}

if (isset($_POST["issue_button"])) {

    $orderid = $_POST["orderid"];
    $issuedby = $_SESSION["id"];
    $issuedtime = time();
    $addedby = $_SESSION['id'];
    $dealerid = $_POST["dealerid"];

    $noerror = true;

    $mysqli->begin_transaction();



    $query = "SELECT * FROM orderitems WHERE orderid=$orderid";
    if ($result = $mysqli->query($query)) {
        while ($orderitem = $result->fetch_object()) {
            $query1 = "UPDATE orderitems SET amountissued=amount, amount=0 WHERE orderid=$orderid AND modelid={$orderitem->modelid} LIMIT 1"; //because here we issue all items at once

            if (!($mysqli->query($query1))) {
                $noerror = false;
            }

            //update main inventory
            $query2 = "UPDATE maininventory SET amount = amount-{$orderitem->amount} WHERE  modelid={$orderitem->modelid}";
            if (!($mysqli->query($query2))) {
                $noerror = false;
            }

            //adding issued items to relevent dealer's/shop's inventory, later i removed this part because this should be added after completing the order.
            /*		$query3 = "INSERT INTO `inventory` (dealerid, modelid, amount) VALUES ($dealerid, {$orderitem->modelid}, {$orderitem->amount}) ON DUPLICATE KEY UPDATE amount = amount + {$orderitem->amount}";
			if(!($mysqli->query($query3))){
				$noerror = false;
			}*/
        }
    }

    //update the order status to 2 (issued)
    $query4 = "UPDATE orders SET
	issued = 2,
	issuedtime = $issuedtime,
	issuedby = $issuedby,
	lastupdate = $issuedtime  
	WHERE orderid=$orderid";

    //Add data to issue table
    $query5 = "INSERT INTO issue(orderId,issuedBy) VALUES($orderid,$issuedby)";
    if (!($mysqli->query($query5))) {
        $noerror = false;
    }
    if (!($mysqli->query($query4))) {
        $noerror = false;
    }


    if ($noerror) {
        $mysqli->commit();
        header("Location: ../manageorders.php?action=issuecomplete&orderid={$_POST["orderid"]}");
        echo "Success";
    } else {
        $mysqli->rollback();
        echo "Fail";
    }
}

if (isset($_POST["issue_button1"])) {

    $orderid = $_POST["orderid"];
    $issuedby = $_SESSION["id"];
    $issuedtime = time();
    $addedby = $_SESSION['id'];
    $dealerid = $_POST["dealerid"];
    $availableamount = $_POST["availableamount"];
    //$remainingamount = $_POST["remainingamount"];
    $reqamount = $_POST["reqamount"];
    $product = $_POST["product"];

    $noerror = true;

    $mysqli->begin_transaction();



    $query = "SELECT orderitems.*, product.*, maininventory.amount AS stock FROM orderitems 
        INNER JOIN product ON orderitems.modelid = product.id 
        LEFT JOIN maininventory ON orderitems.modelid = maininventory.modelid
        WHERE orderid=$orderid";
    if ($result = $mysqli->query($query)) {
        $zeroModels = array();
        $partialModels = array();
        $k = 0;
        while ($orderitem = $result->fetch_object()) {
            $newmodel = $orderitem->modelid;
            $newmodelprice = $orderitem->unitprice;
            $amountreq = $orderitem->amount;
            $freeamount = $orderitem->amountfree;
            $stk = $orderitem->stock;
            $remainingamount = ($amountreq - $freeamount) - $stk;
            $k++;

            if ($stk > 0) {

                if ($amountreq > $stk) {
                    $query1 = "UPDATE orderitems SET amountissued=$stk , amount=$remainingamount, amountfree=$freeamount WHERE orderid=$orderid AND modelid={$orderitem->modelid} LIMIT 1"; //because here we issue all items at once



                    if (!($mysqli->query($query1))) {
                        $noerror = false;
                    }

                    //update main inventory
                    $query2 = "UPDATE maininventory SET amount = 0 WHERE  modelid={$orderitem->modelid}";
                    if (!($mysqli->query($query2))) {
                        $noerror = false;
                    }

                    array_push($partialModels, $orderitem->modelid);
                    $existing = true;
                    //$ordertime = time();

                    // $query11 = "INSERT INTO `orders` (dealerid, ordertime, addedby, lastupdate) VALUES ($dealerid, $ordertime, $addedby, $ordertime)";
                    // if (!($mysqli->query($query11))) {
                    //     $noerror = false;
                    // }

                    // // 	$firstresult = $mysqli->query($query11);

                    // $query22 = "INSERT INTO orderitems (orderid, modelid, amount, amountfree, unitprice) VALUES ($orderid+1, $newmodel, $remainingamount, 0, $newmodelprice )";
                    // if (!($mysqli->query($query22))) {
                    //     $noerror = false;
                    // }
                } else if ($stk > $amountreq) {
                    $query1 = "UPDATE orderitems SET amountissued=amount, amount=0 WHERE orderid=$orderid AND modelid={$orderitem->modelid} LIMIT 1"; //because here we issue all items at once

                    if (!($mysqli->query($query1))) {
                        $noerror = false;
                    }

                    //update main inventory
                    $query2 = "UPDATE maininventory SET amount = amount-{$orderitem->amount} WHERE  modelid={$orderitem->modelid}";
                    if (!($mysqli->query($query2))) {
                        $noerror = false;
                    }
                }
            } else {


                array_push($zeroModels, $orderitem->modelid);


                $orderidnew = $orderid;
                $newOrder = true;
            }
        }

        if ($newOrder && $existing) {
            $ordertime = time();

            $query11 = "INSERT INTO `orders` (dealerid, ordertime, addedby, lastupdate) VALUES ($dealerid, $ordertime, $addedby, $ordertime)";
            if (!($mysqli->query($query11))) {
                $noerror = false;
            }

            for ($i = 0; $i < count($zeroModels); $i++) {
                $m_id = $zeroModels[$i];
                $queryxx = "SELECT amount,amountfree,unitprice FROM orderitems WHERE modelid = $m_id AND orderid = $orderid";
                if (!($mysqli->query($queryxx))) {
                    $noerror = false;
                }
                $resultxx = $mysqli->query($queryxx);
                $modelitem = $resultxx->fetch_object();
                $requestedAmount = $modelitem->amount;
                $newPrice = $modelitem->unitprice;
                $free = $modelitem->amountfree;

                //echo $requestedAmount;
                $query1 = "DELETE FROM orderitems WHERE orderid=$orderid AND modelid=$m_id LIMIT 1"; //because here we issue all items at once

                if (!($mysqli->query($query1))) {
                    $noerror = false;
                }


                $query22 = "INSERT INTO orderitems (orderid, modelid, amount, amountfree, unitprice) VALUES ($orderid+1, $m_id, $requestedAmount, $free, $newPrice)";
                if (!($mysqli->query($query22))) {
                    var_dump($modelitem);
                    echo $queryxx;
                    echo $query22;
                    $noerror = false;
                }
            }

            for ($j = 0; $j < count($partialModels); $j++) {
                $mod_id = $partialModels[$j];
                $queryx = "SELECT amount,amountfree,unitprice FROM orderitems WHERE modelid = $mod_id AND orderid = $orderid";
                if (!($mysqli->query($queryx))) {
                    $noerror = false;
                }
                $resultx = $mysqli->query($queryx);
                $existingItem = $resultx->fetch_object();
                $newModPrice = $existingItem->unitprice;
                $remainingamount = $existingItem->amount + $existingItem->amountfree;
                $free = $existingItem->amountfree;

                $query10 = "UPDATE orderitems SET amount=0,amountfree=0 WHERE orderid=$orderid AND modelid=$mod_id LIMIT 1";
                if (!($mysqli->query($query10))) {
                    $noerror = false;
                }

                $query22 = "INSERT INTO orderitems (orderid, modelid, amount, amountfree, unitprice) VALUES ($orderid+1, $mod_id, $remainingamount, $free, $newModPrice )";
                if (!($mysqli->query($query22))) {
                    $noerror = false;
                }
            }
        } else {

            if ($newOrder) {
                $ordertime = time();

                $query11 = "INSERT INTO `orders` (dealerid, ordertime, addedby, lastupdate) VALUES ($dealerid, $ordertime, $addedby, $ordertime)";
                if (!($mysqli->query($query11))) {
                    $noerror = false;
                }

                for ($i = 0; $i < count($zeroModels); $i++) {
                    $m_id = $zeroModels[$i];
                    $queryxx = "SELECT amount,amountfree,unitprice FROM orderitems WHERE modelid = $m_id AND orderid = $orderid";
                    if (!($mysqli->query($queryxx))) {
                        $noerror = false;
                    }
                    $resultxx = $mysqli->query($queryxx);
                    $modelitem = $resultxx->fetch_object();
                    $requestedAmount = $modelitem->amount;
                    $newPrice = $modelitem->unitprice;
                    $free = $modelitem->amountfree;

                    //echo $requestedAmount;
                    $query1 = "DELETE FROM orderitems WHERE orderid=$orderid AND modelid=$m_id LIMIT 1"; //because here we issue all items at once

                    if (!($mysqli->query($query1))) {
                        $noerror = false;
                    }


                    $query22 = "INSERT INTO orderitems (orderid, modelid, amount, amountfree, unitprice) VALUES ($orderid+1, $m_id, $requestedAmount, $free, $newPrice)";
                    if (!($mysqli->query($query22))) {
                        var_dump($modelitem);
                        echo $queryxx;
                        echo $query22;
                        $noerror = false;
                    }
                }
            }

            if ($existing) {
                $ordertime = time();

                $query11 = "INSERT INTO `orders` (dealerid, ordertime, addedby, lastupdate) VALUES ($dealerid, $ordertime, $addedby, $ordertime)";
                if (!($mysqli->query($query11))) {
                    $noerror = false;
                }

                for ($j = 0; $j < count($partialModels); $j++) {
                    $mod_id = $partialModels[$j];
                    $queryx = "SELECT amount,amountfree,unitprice FROM orderitems WHERE modelid = $mod_id AND orderid = $orderid";
                    if (!($mysqli->query($queryx))) {
                        $noerror = false;
                    }
                    $resultx = $mysqli->query($queryx);
                    $existingItem = $resultx->fetch_object();
                    $newModPrice = $existingItem->unitprice;
                    $remainingamount = $existingItem->amount + $existingItem->amountfree;
                    $free = $existingItem->amountfree;

                    $query10 = "UPDATE orderitems SET amount=0,amountfree=0 WHERE orderid=$orderid AND modelid=$mod_id LIMIT 1";
                    if (!($mysqli->query($query10))) {
                        $noerror = false;
                    }

                    $query22 = "INSERT INTO orderitems (orderid, modelid, amount, amountfree, unitprice) VALUES ($orderid+1, $mod_id, $remainingamount, $free, $newModPrice )";
                    if (!($mysqli->query($query22))) {
                        $noerror = false;
                    }
                }
            }
        }
        if ($k != count($zeroModels)) {

            //update the order status to 2 (issued)
            $query4 = "UPDATE orders SET
            issued = 2,
            issuedtime = $issuedtime,
            issuedby = $issuedby,
            lastupdate = $issuedtime  
            WHERE orderid=$orderid";
            if (!($mysqli->query($query4))) {
                $noerror = false;
            }


            //Add data to issue table
            $query5 = "INSERT INTO issue(orderId,issuedBy) VALUES($orderid,$issuedby)";
            if (!($mysqli->query($query5))) {
                $noerror = false;
            }
        } else {
            $query1 = "DELETE FROM orders WHERE orderid=$orderid LIMIT 1"; //removing order if all items in order are empty stock

            if (!($mysqli->query($query1))) {
                $noerror = false;
            }
        }
    }

    if ($noerror) {
        $mysqli->commit();
        header("Location: ../manageorders.php?action=issuecomplete&orderid={$_POST["orderid"]}");
        echo "Success";
    } else {
        $mysqli->rollback();
        echo "Fail";
    }
}
?>