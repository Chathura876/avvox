<?php require_once "common/header.php" ?>
<?php require_once "common/nav.php" ?>

<?php
$query = "
SELECT modelid, model, sum(amount) FROM `orderitems` 
inner join product
inner join orders 
where orderitems.modelid=product.id
AND orderitems.orderid = orders.orderid
AND orders.issued = 0  
group by modelid
";

?>


<?php require_once "common/footer.php" ?>