<?php
require_once("../common/database.php");
require_once("../setting/Model.php");

class Product extends Model {

    protected $table = "customer";
    public $id,$model,$timeadded,$status,$pricedefault,$pricesilver,$pricegold,$priceplatinum,$cmb;
}