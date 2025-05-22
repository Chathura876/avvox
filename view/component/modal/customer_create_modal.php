<div class="modal fade" id="customerCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="exampleModalLabel">Customer Create</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
<!--                                <div class="col-4">-->
<!--                                    <label for="">Ref No</label>-->
<!--                                    <input type="text" class="form-control" name="ref_no" id="ref_no" disabled>-->
<!--                                </div>-->
                                <div class="col-4">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Name" name="name" id="name" required>
                                </div>
                                <div class="col-4">
                                    <label for="">NIC</label>
                                    <input type="text" class="form-control" name="nic" id="nic">
                                </div>
                                <div class="col-4">
                                    <label for="">Phone </label>
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="07XXXXXXXX" required>
                                </div>
                                <div class="col-4">
                                    <label for="">Address</label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address">
                                </div>
                                <div class="col-4">
                                    <label for="district">District</label>
                                    <select id="district" name="district" class="form-control">
                                        <option value="Ampara">Ampara</option>
                                        <option value="Anuradhapura">Anuradhapura</option>
                                        <option value="Badulla">Badulla</option>
                                        <option value="Batticaloa">Batticaloa</option>
                                        <option value="Colombo">Colombo</option>
                                        <option value="Galle">Galle</option>
                                        <option value="Gampaha">Gampaha</option>
                                        <option value="Hambantota">Hambantota</option>
                                        <option value="Jaffna">Jaffna</option>
                                        <option value="Kalutara">Kalutara</option>
                                        <option value="Kandy">Kandy</option>
                                        <option value="Kegalle">Kegalle</option>
                                        <option value="Kilinochchi">Kilinochchi</option>
                                        <option value="Kurunegala">Kurunegala</option>
                                        <option value="Mannar">Mannar</option>
                                        <option value="Matale">Matale</option>
                                        <option value="Matara">Matara</option>
                                        <option value="Monaragala">Monaragala</option>
                                        <option value="Mulativu">Mulativu</option>
                                        <option value="Nuwaraeliya">Nuwaraeliya</option>
                                        <option value="Polonnaruwa">Polonnaruwa</option>
                                        <option value="Puttalam">Puttalam</option>
                                        <option value="Rathnapura">Rathnapura</option>
                                        <option value="Trincomalee">Trincomalee</option>
                                        <option value="Vavuniya">Vavuniya</option>
                                    </select>

                                </div>

                                <div class="col-4">
                                    <label for="">Purchased Date</label>
                                    <input type="date" class="form-control" name="purchase_date" id="purchase_date">
                                </div>
                                <div class="col-4">
                                    <label for="">Model</label>
                                    <select name="model" id="model" class="form-control">
                                        <option value="">Select Model</option>
                                        <?php
                                        $sql = "SELECT * FROM product WHERE status='Active' ORDER BY model ASC";
                                        $result = mysqli_query($mysqli, $sql);
                                        while ($row = $result->fetch_object()) {
                                            echo "<option value='" . $row->id . "'>" . $row->model . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-4 mt-3">
                                    <label>VAT Type</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="vat_option" id="vat_yes" value="yes">
                                        <label class="form-check-label" for="vat_yes">VAT</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="vat_option" id="vat_no" value="no" >
                                        <label class="form-check-label" for="vat_no">Non-VAT</label>
                                    </div>

                                    <!-- VAT number field placed directly under the radio buttons -->
                                    <div id="vat_number_section" style="display: none;" class="mt-2">
                                        <label for="vat_number">VAT Number</label>
                                        <input type="text" class="form-control" name="vat_no" id="vat_no" placeholder="Enter VAT number">
                                    </div>
                                </div>


                            </div>
                            <div class="col-12">
                                <div class="row mt-2">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button class="btn btn-success w-25" onclick="save()">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>