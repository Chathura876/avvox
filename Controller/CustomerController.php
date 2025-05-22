<?php
require_once '../Model/Customer.php';


if ($_POST['command'] == 'save') {
    try {

        $customer = new Customer();
        $customer->warrantyid = 'WR-' . rand(100000, 999999); // e.g., WR-452918
        $customer->fullname = $_POST['name'];
        $customer->nic = $_POST['nic'];
        $customer->phone = $_POST['phone'];
        $customer->address = $_POST['address'];
        $customer->modelid = $_POST['model'];
//    $customer->district=$_POST['district'];
        $customer->purdate = $_POST['purchase_date'];
        $customer->vat = $_POST['vat_option'];
        $customer->vat_no = $_POST['vat_no'];
        $customer->save();
        return 'success';
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

