

<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
    //Redirect to user account page
    //header("Location: login.php");
    http_response_code(403);
    die();
}
$user_type = $_SESSION['usertype'];
$user_id = $_SESSION['id'];

//exit("Byeeeeee");
if ($user_type == 'admin') {
    try {
        $datastring = "<h2>Inventory Report</h2>";

//        $query = "
//		SELECT product.* , maininventory.amount AS quantity,
//		(SELECT SUM(amount) FROM orderitems INNER join orders on orderitems.orderid= orders.orderid and orders.issued<2 WHERE orderitems.modelid = product.id) AS pending
//		FROM product
//		INNER JOIN maininventory ON maininventory.modelid = product.id
//		";

        $query = "SELECT * FROM product_inventory";

        if ($result = $mysqli->query($query)) {

            $datastring .= "<table style='width:100%;' class='table display' id='udaratable'>
                <thead>
                    <tr>
                        <th align='right'>Shop</th>
                        <th align='right'>Model</th>
                        <th align='right'>Default Price</th>
                        <th align='right'>Quantity</th>
                        <th align='right'>Pending</th>
                        <th align='right'>Sellable</th>
                    </tr>
                </thead>
                <tbody>";


            while ($item = $result->fetch_object()) {
                $thisaddeddate = date("Y-m-d", $item->timeadded);
                $defaultprice = number_format($item->pricedefault, 2);
                $pending = $item->pending ?? 0;
                $sellable = $item->quantity - $pending;
                $datastring .= "<tr>
                <td>{$item->shopname}</td>
                <td>{$item->model}</td>
                <td align='right'>{$defaultprice}</td>
                <td align='right'>{$item->amount}</td>
                <td align='right'>{$pending}</td>
                <td align='right'>" . ($sellable > 0 ? $sellable : 0) . "</td>
    </tr>";
            }
            $datastring .= "</tbody></table>";


        }
        echo $datastring;


    } catch (Exception $ex) {
        echo $ex->getMessage();

    }
}
else{
    try {
        $datastring = "<h2>Inventory Report</h2>";

//        $query = "
//		SELECT product.* , maininventory.amount AS quantity,
//		(SELECT SUM(amount) FROM orderitems INNER join orders on orderitems.orderid= orders.orderid and orders.issued<2 WHERE orderitems.modelid = product.id) AS pending
//		FROM product
//		INNER JOIN maininventory ON maininventory.modelid = product.id
//		";

        $query = "SELECT * FROM product_inventory WHERE dealerid='".$user_id."'";

        if ($result = $mysqli->query($query)) {

            $datastring .= "<table style='width:100%;' class='table display' id='udaratable'>
                <thead>
                    <tr>
                        <th align='right'>Shop</th>
                        <th align='right'>Model</th>
                        <th align='right'>Default Price</th>
                        <th align='right'>Quantity</th>
                        <th align='right'>Pending</th>
                        <th align='right'>Sellable</th>
                    </tr>
                </thead>
                <tbody>";


            while ($item = $result->fetch_object()) {
                $thisaddeddate = date("Y-m-d", $item->timeadded);
                $defaultprice = number_format($item->pricedefault, 2);
                $pending = $item->pending ?? 0;
                $sellable = $item->quantity - $pending;
                $datastring .= "<tr>
                <td>{$item->shopname}</td>
                <td>{$item->model}</td>
                <td align='right'>{$defaultprice}</td>
                <td align='right'>{$item->amount}</td>
                <td align='right'>{$pending}</td>
                <td align='right'>" . ($sellable > 0 ? $sellable : 0) . "</td>
    </tr>";
            }
            $datastring .= "</tbody></table>";


        }
        echo $datastring;


    } catch (Exception $ex) {
        echo $ex->getMessage();

    }
}

if ($_POST['comment']=='selectShop'){
    $shop=$_POST['shop'];
    try {
        $datastring = "<h2>Inventory Report</h2>";

//        $query = "
//		SELECT product.* , maininventory.amount AS quantity,
//		(SELECT SUM(amount) FROM orderitems INNER join orders on orderitems.orderid= orders.orderid and orders.issued<2 WHERE orderitems.modelid = product.id) AS pending
//		FROM product
//		INNER JOIN maininventory ON maininventory.modelid = product.id
//		";

        $query = "SELECT * FROM product_inventory WHERE dealerid='".$shop."'";

        if ($result = $mysqli->query($query)) {

            $datastring .= "<table style='width:100%;' class='table display' id='udaratable'>
                <thead>
                    <tr>
                        <th align='right'>Shop</th>
                        <th align='right'>Model</th>
                        <th align='right'>Default Price</th>
                        <th align='right'>Quantity</th>
                        <th align='right'>Pending</th>
                        <th align='right'>Sellable</th>
                    </tr>
                </thead>
                <tbody>";


            while ($item = $result->fetch_object()) {
                $thisaddeddate = date("Y-m-d", $item->timeadded);
                $defaultprice = number_format($item->pricedefault, 2);
                $pending = $item->pending ?? 0;
                $sellable = $item->quantity - $pending;
                $datastring .= "<tr>
                <td>{$item->shopname}</td>
                <td>{$item->model}</td>
                <td align='right'>{$defaultprice}</td>
                <td align='right'>{$item->amount}</td>
                <td align='right'>{$pending}</td>
                <td align='right'>" . ($sellable > 0 ? $sellable : 0) . "</td>
    </tr>";
            }
            $datastring .= "</tbody></table>";


        }
        echo $datastring;


    } catch (Exception $ex) {
        echo $ex->getMessage();

    }

}


?>