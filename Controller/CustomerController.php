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
//        $customer->modelid = 'a';
//    $customer->district=$_POST['district'];
        $customer->purdate =  date('Y-m-d');
        $customer->vat = 0;
        $customer->vat_no = 0;
        $customer->save();
        return 'success';
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

