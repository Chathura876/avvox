<?php require_once "component/header.php" ?>
<?php require_once "../common/nav.php" ?>

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

    th {
        font-size: 12px !important;
    }

    td {
        font-size: 12px !important;
    }

    td input {
        height: 25px !important;
    }

    td button {
        height: 25px !important;
        font-size: 12px !important;
    }

    label {
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
            <div class="col-2">
                <h4>Sales Invoice</h4>
            </div>
            <div class="col-3">
                <h5>Invoice No : <span id="invoice_no"></span></h5>
            </div>
            <div class="col-3">
                <select name="shop" id="shop" class="form-control">
                    <option value="">Select Shop</option>
                    <?php
                    $sql = "SELECT * FROM user WHERE shopname !='' AND shopname != 'jjj'";
                    $result = $mysqli->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['shopname']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-12">
                        <h5>Customer Name : <span id="customerNameLabel" style="font-size: 20px"></span></h5>
                    </div>
                    <div class="col-12">
                        <h5>Customer Phone : <span id="customerPhoneLabel"></span></h5>
                    </div>

                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-9">
                <div class="row mt-4">
                    <div class="col-12">
                        <input type="text" id="search" autocomplete="off" class="form-control"
                               placeholder="Search Product">
                        <div class="w-100" id="suggestion-box"></div>
                    </div>

                    <div class="col-12">
                        <table class="table mt-2">
                            <thead>
                            <tr>
                                <th scope="col">no</th>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Subtotal</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="item-details">
                            <!--                            <tr>-->
                            <!--                                <th scope="row">1</th>-->
                            <!--                                <td>AC 1</td>-->
                            <!--                                <td>-->
                            <!--                                    <input type="number" name="price" class="form-control" required>-->
                            <!--                                </td>-->
                            <!--                                <td>-->
                            <!--                                    <input type="number" name="qty" class="form-control" required>-->
                            <!--                                </td>-->
                            <!--                                <td>-->
                            <!--                                    <input type="number" name="discount" class="form-control" required>-->
                            <!--                                </td>-->
                            <!--                                <td>-->
                            <!--                                    <input type="number" name="subtotal" class="form-control" disabled required>-->
                            <!--                                </td>-->
                            <!--                                <td>-->
                            <!--                                    <button class="btn btn-danger">X</button>-->
                            <!--                                </td>-->
                            <!---->
                            <!--                            </tr>-->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <h6>Service Date</h6>
                    </div>
                    <div class="col-12">
                        <table class="table mt-2">
                            <thead>
                            <tr>
                                <th scope="col">1st Service</th>
                                <th scope="col">2nd Service</th>
                                <th scope="col">3th Service</th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="date" id="date1" class="form-control">
                                </td>
                                <td>
                                    <input type="date" id="date2" class="form-control">
                                </td>
                                <td>
                                    <input type="date" id="date3" class="form-control">
                                </td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <!--                <label for="customer">Customer</label>-->
                <div class="d-flex">
                    <input type="text" id="customerName" class="form-control mt-4" placeholder="Customer Name"
                           style="height: 80%;">
                    <button class="btn btn-primary ms-2 mt-4" style="height: 35px;" data-toggle="modal"
                            data-target="#customerSearchModal">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-warning text-white ms-2 mt-4" style="height: 35px;" data-toggle="modal"
                            data-target="#customerCreateModal">
                        +
                    </button>
                </div>
                <div class="row mt-2">

                    <div class="col-12">
                        <label for="">Total</label>
                        <input type="text" id="total" class="form-control" readonly>
                    </div>
                    <div class="col-12">
                        <label for="">Total Discount</label>
                        <input type="number" value="0" id="total_discount" class="form-control" disabled>
                    </div>
                    <div class="col-12">
                        <label for="">Net Total</label>
                        <input type="text" id="net_total" class="form-control" readonly>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" id="warranty" name="warranty" onchange="setWarranty(this)">
                            <label class="form-check-label" for="warranty">Warranty</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-success w-100 mt-2" data-toggle="modal" data-target="#paymentModal">
                            Payment
                        </button>
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
        function setWarranty(checkbox) {
            if (checkbox.checked) {
                const today = new Date();

                const threeMonthsFromToday = new Date(today);
                threeMonthsFromToday.setMonth(threeMonthsFromToday.getMonth() + 3);

                const sixMonthsFromToday = new Date(threeMonthsFromToday);
                sixMonthsFromToday.setMonth(sixMonthsFromToday.getMonth() + 3);

                const formatDate = (date) => {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                };

                document.getElementById('date1').value = formatDate(today);
                document.getElementById('date2').value = formatDate(threeMonthsFromToday);
                document.getElementById('date3').value = formatDate(sixMonthsFromToday);
            } else {
                document.getElementById('date1').value = '';
                document.getElementById('date2').value = '';
                document.getElementById('date3').value = '';
            }
        }
    </script>

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
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#customerTable').on('click', '.customer-row', function () {
                const name = $(this).data('name');
                const phone = $(this).data('phone');
                document.getElementById('customerNameLabel').innerHTML=name.trim();
                document.getElementById('customerPhoneLabel').innerHTML=phone.trim();
                $('#customerName').val(name);
                $('#customerSearchModal').css('display', 'none');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#customerTable').DataTable({
                // optional config, e.g.
                responsive: true,
                paging: true,
                searching: true
            });
        });
        $(document).ready(function () {

            $.ajax({
                url: '../Controller/SalesInvoiceController.php',
                method: 'POST',
                data: JSON.stringify({command: 'get_invoice_no'}),
                contentType: 'application/json',
                success: function (response) {
                    document.getElementById("invoice_no").innerHTML = response;
                },
                error: function () {
                    alert("Failed to fetch invoice number.");
                }
            });


        });

    </script>
    <script src="../js/sales_inv.js"></script>


<?php } ?>
