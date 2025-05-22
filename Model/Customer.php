<?php
require_once("../common/database.php");
require_once("../setting/Model.php");

class Customer extends Model {

    protected $table = "customer";
    public $vat,$vat_no,$warrantyid,$fullname,$nic,$phone,$address,$purdate,$modelid,$dealerid='100224';
}