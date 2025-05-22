<?php require_once "component/header.php" ?>
<?php require_once "../common/nav.php" ?>

<?php
if (isset($_GET['inv'])) {
    $invoice_no = intval($_GET['inv']); // Sanitize input to prevent SQL injection

    // Get invoice data
    $sql = "SELECT * FROM sales_invoice WHERE invoice_no = $invoice_no";
    $result = $mysqli->query($sql);
    $invoice_data = $result ? $result->fetch_assoc() : null;

    // Get all items related to the invoice
    $sql = "SELECT * FROM sales_invoice_item WHERE invoice_no = $invoice_no";
    $result = $mysqli->query($sql);
    $item_data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $item_data[] = $row;
        }
    }
}
?>

<link rel="stylesheet" href="../css/all.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../css/adminlte.min.css">
<link rel="stylesheet" href="../css/adminlte2.min.css">

<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

<style>
    .icon1:hover {
        transform: scale(1.5);
        filter: invert(0.5) sepia(1);
    }

    input {
        height: 35px !important;
    }

    @media only screen and (max-width: 600px) {
        .dou {
            height: auto !important;
        }

        #canvas1 {
            height: 90%;
        }
    }
    th{
        font-size: 12px !important;
    }
    td{
        font-size: 12px !important;
    }
    td input{
        height: 25px !important;
    }
    td button{
        height: 25px !important;
        font-size: 12px !important;
    }
    label{
        font-size: 12px !important;
    }
    #suggestion-box {
        border: 1px solid #ccc;
        position: absolute;
        background: white;
        z-index: 1000;
    }
    #suggestion-box div {
        padding: 8px;
        cursor: pointer;
    }
    #suggestion-box div:hover {
        background-color: #f0f0f0;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<script src="../scripts/utils.js"></script>

<?php
$permissions = array("dealer", "shop");
if (in_array($_SESSION['usertype'], $permissions)) { ?>
    <!--<h4> Hello <?php echo $_SESSION['shopname'] ?>, Welcome To Avvox CRM!</h4>-->
<?php } else { ?>
    <!--<h4> Hello <?php echo $_SESSION['fullname'] ?>, Welcome To Avvox CRM!</h4>-->
<?php } ?>

<?php if (in_array($_SESSION['usertype'], ["admin", "accountant", "director", "operator", "salesrep"])) { ?>

    <?php
    $jobtotal = "";
    $query = "SELECT COUNT(*) as total FROM job WHERE status=1";
    if ($result = $mysqli->query($query)) {
        $objectname = $result->fetch_object();
        $jobtotal = $objectname->total;
    }
    ?>

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-3">
                <h4>Product Issue</h4>
            </div>
            <div class="col-9 d-flex justify-content-end">
                <div class="row">
                    <div class="col-12">
                        <h7>Invoice No : <span id="invoice_no"><?php echo $_GET['inv']; ?></span></h7>
                    </div>
                    <div class="col-12">
                        <h7>Customer Name : <span id="customer"><?php echo htmlspecialchars($invoice_data['customer_name'] ?? ''); ?></span></h7>
                    </div>

                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <button id="submitBtn" class="btn btn-success">Save Barcodes</button>

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <div class="row mt-4">
                    <div class="col-12 mb-2">
                        <input type="text" id="search" autocomplete="off" class="form-control" placeholder="Search Invoice No"  value="<?php echo isset($_GET['inv']) ? htmlspecialchars($_GET['inv']) : ''; ?>">
                        <div class="w-100" id="suggestion-box"></div>
                    </div>
                    <div class="col-12">
                        <table class="table mt-2" >
                            <thead>
                            <tr>
                                <th scope="col">Invoice No</th>
                                <th scope="col">Product Code</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Qty</th>
                                <th rowspan="" scope="col">Barcode</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="item-details">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- Modal -->

    <?php
    include 'component/modal/customer_create_modal.php';
    include 'component/modal/invoice_payment_modal.php';
    include 'component/modal/customer_search_modal.php';
    ?>
    <!--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
    <!-- jQuery (required for DataTables) -->
    <!--    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>-->

    <!-- DataTables JS -->
    <!--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="../js/customer.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const vatYes = document.getElementById('vat_yes');
            const vatNo = document.getElementById('vat_no');
            const vatNumberSection = document.getElementById('vat_number_section');

            function toggleVatInput() {
                if (vatYes.checked) {
                    vatNumberSection.style.display = 'block';
                } else {
                    vatNumberSection.style.display = 'none';
                }
            }

            vatYes.addEventListener('change', toggleVatInput);
            vatNo.addEventListener('change', toggleVatInput);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#customerTable').on('click', '.customer-row', function () {
                const name = $(this).data('name');
                $('#customerName').val(name);
                $('#customerSearchModal').css('display', 'none');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable on your customer table
            $('#customerTable').DataTable({
                // optional config, e.g.
                responsive: true,
                paging: true,
                searching: true
            });
        });
        // $(document).ready(function() {
        //
        //     $.ajax({
        //         url: '../Controller/SalesInvoiceController.php',
        //         method: 'POST',
        //         data: JSON.stringify({ command: 'get_invoice_no' }),
        //         contentType: 'application/json',
        //         success: function (response) {
        //             document.getElementById("invoice_no").innerHTML = response;
        //
        //         },
        //         error: function () {
        //             alert("Failed to fetch invoice number.");
        //         }
        //     });
        //
        //
        // });

    </script>
    <script src="../js/issue_product.js"></script>


<?php } ?>
