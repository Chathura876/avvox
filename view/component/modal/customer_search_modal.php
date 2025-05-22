<div class="modal fade" id="customerSearchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="exampleModalLabel">Search Customer</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container mt-5">
                    <table id="customerTable" class="display table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>NIC</th>
                            <th>Address</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM customer";
                        $result = mysqli_query($mysqli, $sql);

                        while ($row = $result->fetch_object()) {
                            echo "
                                <tr class='customer-row' 
                                     data-id='{$row->dealerid}' 
                                     data-name='{$row->fullname}' 
                                     data-phone='{$row->phone}' 
                                     data-nic='{$row->nic}' 
                                     data-address='{$row->address}'>
                                    <td>{$row->dealerid}</td>
                                    <td>{$row->fullname}</td>
                                    <td>{$row->phone}</td>
                                    <td>{$row->nic}</td>
                                    <td>{$row->address}</td>
                                </tr>
                                ";

                        }
                        ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

