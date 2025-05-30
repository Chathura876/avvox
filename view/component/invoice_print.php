<?php
require_once("../../common/database.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM sales_invoice WHERE id=$id";
    $result = $mysqli->query($sql);
    $row = mysqli_fetch_assoc($result);
    $invoice_number = $row['invoice_no'];

    $sql = "SELECT * FROM customer WHERE fullname='" . $row['customer_name'] . "'";
    $result = $mysqli->query($sql);
    $row2 = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        body {
            background: #fff;
            font-family: Calibri, Arial, sans-serif;
            font-size: 12pt;
            color: #000;
        }

        @media print {
            @page {
                size: A4;
                margin: 15mm;
            }

            body {
                margin: 0;
                font-size: 12pt;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .no-print {
                display: none;
            }

            .table {
                border-collapse: collapse !important;
                width: 100%;
            }

            .table th, .table td {
                border: 1px solid #000 !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .table th, .table td
            th {
                border: 1px solid #000 !important;
            }

            td {
                border: 1px solid #000 !important;
            }

            .table thead {
                background-color: #5392d3 !important;
            }

            .text-white {
                color: #fff !important;
            }
        }

        .table {
            border-collapse: collapse !important;
            width: 100%;
        }

        .table th, .table td {
            border: 1px solid #000 !important;
            padding: 0 !important;
            vertical-align: middle;
        }

        .invoice-header-bg {
            background-color: #f8f9fa;
            padding: 10px;
            border-bottom: 2px solid #343a40;
        }

        .invoice-footer {
            padding: 8px;
            margin-top: 20px;
        }

        p {
            margin: 0 !important;
        }

        td {
            font-size: 14px !important;
            font-weight: bold;
        }

        th {
            font-size: 14px !important;
            font-weight: bold;
        }

        .conditions li {
            font-size: 12px !important;
        }
    </style>

</head>

<body onload="window.print();">

<div class="container-fluid ">
    <div class="invoice-header-bg text-center mb-4">
        <div class="row">
            <div class="col-3">
                <img src="../../images/ac_logo.jpg" alt="Logo" style="width: 200px;">
            </div>
            <div class="col-9">
                <h1 class="mb-1">Coolco (Pvt) Ltd</h1>
                <p class="mb-0">
                    <i class="bi bi-telephone-fill"></i> +94 112 072516 |
                    <i class="bi bi-phone-fill"></i> +94 777 99 10 50 / 0752 991050 |
                    <i class="bi bi-envelope-fill"></i> info@coolco.lk
                </p>
                <p class="mb-0">
                    <i class="bi bi-geo-alt-fill"></i> No. 115/6, Horahena Road, Rukmale,
                    Pannipitiya |<br>
                </p>
            </div>

        </div>
    </div>

    <!-- Invoice Info -->
    <div class="row">
        <div class="col-9">
            <p><strong>Invoice No:</strong> <?= $invoice_number; ?> |<br>
                <strong>Date:</strong> <?= date('Y-m-d') ?> |
                <strong>Time:</strong> <?= date('H:i') ?> |
                <strong>Shop:</strong> <?= $row['shop'] ?> |
                <strong>Cashier:</strong> Cashier</p>
        </div>
        <div class="col-3 text-end">
            <p><strong>Customer:</strong> <?= $row['customer_name']; ?> |
                <strong>Phone:</strong> <?= $row2['phone']; ?></p>
        </div>
    </div>

    <!-- Items Table -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead style="background-color: #0a568c !important;">
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Discount</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM sales_invoice_item WHERE invoice_no='$invoice_number'";
            $result = $mysqli->query($sql);

            if ($result && $result->num_rows > 0) {
                $i = 1;
                while ($row2 = $result->fetch_assoc()) {
                    echo '<tr>
                <td>' . $i . '</td>
                <td>' . htmlspecialchars($row2["item_name"]) . '</td>
                <td class="text-center">' . number_format($row2["price"], 2) . '</td>
                <td class="text-center">' . $row2["qty"] . '</td>
                <td class="text-center">' . number_format($row2["discount"], 2) . '</td>
                <td class="text-center">' . number_format($row2["sub_total"], 2) . '</td>
              </tr>';
                    $i++;
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No items found</td></tr>";
            }
            ?>

            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="row justify-content-end ">
        <?php if ($row['date1'] != '0000-00-00'): ?>
            <div class="col-6">
                <table class="table table-bordered">
                    <tr>
                        <th>1st Service</th>
                        <td><?php echo $row['date1']; ?></td>
                    </tr>
                    <tr>
                        <th>2nd Service</th>
                        <td><?php echo $row['date2']; ?></td>
                    </tr>
                    <tr>
                        <th>3rd Service</th>
                        <td><?php echo $row['date3']; ?></td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
        <div class="col-6">
            <table class="table">
                <tr>
                    <td><strong>Total:</strong></td>
                    <td class="text-end"><?= number_format($row['net_total'], 2); ?></td>
                </tr>
                <tr>
                    <td><strong>Paid:</strong></td>
                    <td class="text-end">
                        <?php
                        $payments = [];

                        if (!empty($row['cash']) && $row['cash'] > 0) {
                            $payments[] = "Cash: " . number_format($row['cash'], 2);
                        }
                        if (!empty($row['card']) && $row['card'] > 0) {
                            $payments[] = "Card: " . number_format($row['card'], 2);
                        }
                        if (!empty($row['cheque']) && $row['cheque'] > 0) {
                            $payments[] = "Cheque: " . number_format($row['cheque'], 2);
                        }
                        if (!empty($row['credit']) && $row['credit'] > 0) {
                            $payments[] = "Credit: " . number_format($row['credit'], 2);
                        }
                        if (!empty($row['online']) && $row['online'] > 0) {
                            $payments[] = "Online: " . number_format($row['online'], 2);
                        }
                        echo !empty($payments) ? implode(' | ', $payments) : "-";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Balance:</strong></td>
                    <td class="text-end"><?= number_format($row['balance'], 2); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <?php if ($row['date1'] != '0000-00-00'): ?>
        <div class="row">
            <div class="col-12">
                <h7 class="text-danger">Warranty & Free Services Details:</h7>
                <ol class="conditions">
                    <li>One year comprehensive warranty</li>
                    <li>Five year limited warranty for compressor.</li>
                    <li>The company will provide three free services during the comprehensive warranty period</li>
                    <li>The company will contact the designated telephone number provided by the customer.</li>
                    <li>Installation and technical support will be provided by the company.</li>
                    <li>If quoted Items were supplied directly to customer (Wholesale), the product warranty will not be
                        activated.
                    </li>
                    <li>The following items are provided free of charge along with the product warranty. One plug top,
                        three meters of copper tubes, four
                        installation hoses, two wall brackets, refrigerant gas and one remote with wifi connectivity for
                        compatible models.
                    </li>
                </ol>
                <p class="text-center"><b>The quoted prices are valid for a period of fourteen days from the date of the
                        estimate</b></p>
            </div>
        </div>
        <hr>
    <?php endif; ?>
    <div class="row">
        <div class="col-12">
            <h7 class="text-danger">Warranty & Free Services Details:</h7>
            <ul class="conditions">
                <li>For the warranty to be active it is mandatory to carry out the complimentary services by authorized
                    personal during the warranty period.
                </li>
                <li>The warranty will automatically deemed void if any repairs or modifications has been carried out by
                    unauthorized personnel.
                </li>
                <li>Damage caused by power fluctuations or power related issues is not covered by the warranty.</li>
                <li>Damage caused by lightning, electrical surges, or thunderstorms is considered an act of nature and
                    is not covered under warranty.
                </li>
                <li>The warranty does not cover any damage due to floods or product being exposed to water related
                    issues.
                </li>
                <li>All prices are inclusive of VAT.</li>
                <li>If product without warranty ,plug top and two wall brackets are not provided.</li>
                <li>It is mandatory to regularly service the product every three months, carried out by authorized
                    personal to actively maintain the limited warranty extended for the compressor.
                </li>
            </ul>
        </div>
    </div>
    <!-- Footer -->
    <div class="text-center invoice-footer" style="border-top: 3px solid black; border-bottom:3px solid black; ">
        <p class="mb-1">Thank you for your purchase!</p>
    </div>

</div>

</body>
</html>
