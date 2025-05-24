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
    <div class="col-6">
        <h2>Product Issue Report</h2>
    </div>
    <div class="col-6 d-flex justify-content-end">
        <div>
            <button class="btn btn-dark pr-2" onclick="printReport()">Print</button>
            <button class="btn btn-danger" onclick="downloadPDF()">PDF</button>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-12">
        <table id="invoiceTable" class="table">
            <thead>
            <tr>
                <th class="d-none" scope="col">ID</th>
                <th scope="col">Invoice No</th>
                <th scope="col">Product Name</th>
                <th scope="col">Indoor Barcode</th>
                <th scope="col">Outdoor Barcode</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
             $sql="SELECT * FROM issue_product_barcode ORDER BY id DESC ";
                $result = $mysqli->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                <td class='d-none'>{$row['id']}</td>
                <td>{$row['invoice_no']}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['indoor_barcode']}</td>
                <td>{$row['outdoor_barcode']}</td>
                <td>{$row['date']}</td>
              </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No invoices found</td></tr>";
            }

            ?>
            </tbody>
        </table>
    </div>
</div>
    <div id="printArea">
    <div class="row mt-2">
        <div class="col-12 d-flex justify-content-center">
            <h2>Issue Product Report</h2>
        </div>
        <div class="col-12">
            <table id="invoiceTable" class="table">
                <thead>
                <tr>
                    <th class="d-none" scope="col">ID</th>
                    <th scope="col">Invoice No</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Indoor Barcode</th>
                    <th scope="col">Outdoor Barcode</th>
                    <th scope="col">Date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql="SELECT * FROM issue_product_barcode ORDER BY id DESC ";
                $result = $mysqli->query($sql);
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                <td class='d-none'>{$row['id']}</td>
                <td>{$row['invoice_no']}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['indoor_barcode']}</td>
                <td>{$row['outdoor_barcode']}</td>
                <td>{$row['date']}</td>
              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No invoices found</td></tr>";
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>

<!-- JS Section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<!-- html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


<script>
    $(document).ready(function () {
        $('#invoiceTable').DataTable({
            "order": [[0, "desc"]],
            "searching": true,
            "paging": true,
            "info": true
        });
    });


</script>
<script>
    function printReport() {
        const printContents = document.getElementById('printArea').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        // Reload to re-apply scripts/styles (like DataTable)
        location.reload();
    }
</script>
<script>
    async function downloadPDF() {
        const { jsPDF } = window.jspdf;

        const printArea = document.getElementById("printArea");

        // Use html2canvas to take a screenshot
        await html2canvas(printArea, { scale: 2 }).then((canvas) => {
            const imgData = canvas.toDataURL("image/png");
            const pdf = new jsPDF("p", "mm", "a4");

            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();

            const imgProps = pdf.getImageProperties(imgData);
            const imgWidth = pageWidth;
            const imgHeight = (imgProps.height * imgWidth) / imgProps.width;

            let position = 0;

            if (imgHeight < pageHeight) {
                pdf.addImage(imgData, "PNG", 0, 0, imgWidth, imgHeight);
            } else {
                // Split across multiple pages if content is long
                let heightLeft = imgHeight;

                while (heightLeft > 0) {
                    pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                    position -= pageHeight;
                    if (heightLeft > 0) pdf.addPage();
                }
            }

            pdf.save("invoice-report.pdf");
        });
    }
</script>
