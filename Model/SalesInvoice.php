<?php
require_once("../common/database.php");
require_once("../setting/Model.php");

class SalesInvoice extends Model {

    protected $table = "sales_invoice";
    public $id,$invoice_no,$total,$discount,$net_total,$balance,$customer_name,$cash,$card,$cheque,$online;
}