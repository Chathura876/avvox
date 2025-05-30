<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="exampleModalLabel">Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-12 mb-3">
                            <label for="netTotal">Net Total</label>
                            <input type="number" class="form-control" id="netTotal" value="0" disabled>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="discount">Discount</label>
                            <input type="number" class="form-control" id="discount" value="0" disabled>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Paid</label>
                            <ul class="nav nav-tabs mt-2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#cash" role="tab">Cash</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#card" role="tab">Card</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#credit" role="tab">Credit</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#online" role="tab">Cheque</a>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div id="cash" class="tab-pane fade show active" role="tabpanel">
                                    <input type="number" min="0" step="0.01" class="form-control payment-input" placeholder="Enter cash amount" id="cash_pay">
                                </div>
                                <div id="card" class="tab-pane fade" role="tabpanel">
                                    <input type="number" min="0" step="0.01" class="form-control payment-input" placeholder="Enter card amount" id="card_pay">
                                    <label class="mt-2 mb-1">Select Bank</label>
                                    <select class="form-control" id="bank">
                                        <option value="BOC">BOC</option>
                                        <option value="Commercial">Commercial</option>
                                    </select>
                                </div>
                                <div id="credit" class="tab-pane fade" role="tabpanel">
                                    <input type="number" min="0" step="0.01" class="form-control payment-input" placeholder="Enter credit amount" id="credit_pay">
                                </div>
                                <div id="online" class="tab-pane fade" role="tabpanel">
                                    <input type="number" min="0" step="0.01" class="form-control payment-input" placeholder="Enter online payment amount" id="online_pay">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="balance">Balance</label>
                            <input type="number" class="form-control" id="balance" value="0" readonly>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-success w-100" id="payButton" onclick="paymentSave()" type="button">Payment</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.btn-close', function() {
        $('#paymentModal').css('display', 'none');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });
</script>
