<?php require_once "./component/header.php" ?>
<?php
$permissions = array("admin", "salesrep","accountant","director","operator");

if (!(in_array($_SESSION['usertype'], $permissions))) {
  header("Location: index.php");
}

?>
<?php require_once "../common/nav.php" ?>

<style>
  #udaratable {
    /*font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;*/
    border-collapse: collapse;
    width: 100%;
  }

  #udaratable td,
  #udaratable th {
    border: 1px solid #ddd;
    padding: 8px;
  }

  #udaratable tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  #udaratable tr:hover {
    background-color: #ddd;
  }

  #udaratable th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
  }
</style>

<div class="container-fluid">
<div class="row mt-5">
    <div class="col-12">
        <h2>Product Issue Report</h2>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <table id="invoiceTable" class="table">
            <thead>
            <tr>
                <th scope="col">Invoice No</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Invoice Date</th>
                <th scope="col">Shop</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM sales_invoice WHERE issue ='0'";
            $result = $mysqli->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
            <td>{$row['invoice_no']}</td>
            <td>{$row['customer_name']}</td>
            <td>{$row['invoice_date']}</td>
            <td>{$row['shop']}</td>
            <td>
                <a href='product_issue.php?inv={$row['invoice_no']}' class='btn btn-primary btn-sm'>Issue</a>
            </td>
        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No invoices found</td></tr>";
            }
            ?>

            </tbody>
        </table>
    </div>
</div>
</div>
<script>
    $(document).ready(function () {
        $('#invoiceTable').DataTable({
            searching: true,
            paging: true,
            info: true
        });
    });
</script>
