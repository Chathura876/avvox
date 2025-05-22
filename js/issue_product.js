
    let selectedIndex = -1;
    let selectedProducts = [];
    let netTotal = 0;
    let balance;
    let payments;
    document.addEventListener("DOMContentLoaded", function () {
        let inv=document.getElementById("search").value;
        fetchItemDetails(inv);
    });
    // ============== Product Search ==============
    $('#search').keyup(function(e){
    let query = $(this).val();

    // Skip key navigation keys
    if ([38, 40, 13].includes(e.keyCode)) return;

    if(query.length > 1){
    $.ajax({
    url: '../Controller/IssueProductController.php',
    method: 'POST',
    data: {
    command: 'search',
    query: query
},
    success: function(data){
    let output = '';
    if (data.length > 0) {
    data.forEach(function(item, index){
    output += `<div class="suggestion-item" data-customer="${item.customer_name}" data-id="${item.invoice_no}" data-index="${index}">${item.invoice_no} - ${item.customer_name} </div>`;
});
    selectedIndex = -1;
} else {
    output = '<div class="suggestion-item">No results found</div>';
}
    $('#suggestion-box').html(output).fadeIn();
}
});
} else {
    $('#suggestion-box').fadeOut();
}
});

    // Keyboard navigation
    $('#search').keydown(function(e) {
    let items = $('#suggestion-box .suggestion-item');
    if (items.length === 0) return;

    if (e.keyCode === 40) { // Down
    selectedIndex = (selectedIndex + 1) % items.length;
    highlightItem(items);
    e.preventDefault();
} else if (e.keyCode === 38) { // Up
    selectedIndex = (selectedIndex - 1 + items.length) % items.length;
    highlightItem(items);
    e.preventDefault();
} else if (e.keyCode === 13) { // Enter
    if (selectedIndex >= 0 && selectedIndex < items.length) {
    let selectedItem = $(items[selectedIndex]);
    $('#search').val(selectedItem.text());
    $('#suggestion-box').fadeOut();
    $('#search').val('');
    fetchItemDetails(selectedItem.data('id'));
}
    e.preventDefault();
}
});

    // On click suggestion
    $(document).on('click', '#suggestion-box .suggestion-item', function(){
    let itemId = $(this).data('id');
    document.getElementById('invoice_no').innerHTML = $(this).data('id');
    document.getElementById('customer').innerHTML = $(this).data('customer');
    $('#search').val($(this).text());
    $('#suggestion-box').fadeOut();
    $('#search').val('');
    fetchItemDetails(itemId);
});

    function highlightItem(items) {
    items.removeClass('highlighted');
    if (selectedIndex >= 0) {
    $(items[selectedIndex]).addClass('highlighted');
}
}

    function fetchItemDetails(invoiceNo) {
    $.ajax({
        url: '../Controller/IssueProductController.php',
        method: 'POST',
        data: {
            command: 'getDetails',
            id: invoiceNo
        },
        dataType: 'json',
        success: function (items) {
            if (Array.isArray(items)) {
                items.forEach(item => {
                    if (selectedProducts.some(p => p.id == item.id)) {
                        alert(`Product ID ${item.id} already added`);
                        return;
                    }

                    item.qty = item.qty || 1;
                    item.discount = 0;
                    item.subtotal = item.pricedefault * item.qty;

                    selectedProducts.push(item);

                    let barcodeInputs = '';
                    for (let i = 0; i < item.qty; i++) {
                        barcodeInputs += `
                            <div class="mb-1">
                                <input type="text" class="form-control barcode-input" name="indoor_barcodes[${item.id}][]" placeholder="Indoor Barcode ${i + 1}">
                                <input type="text" class="form-control barcode-input" name="out_barcodes[${item.id}][]" placeholder="Outdoor Barcode ${i + 1}">
                            </div>
                        `;
                    }

                    const row = `
                        <tr data-id="${item.id}">
                            <td>${item.invoice_no}</td>
                            <td>${item.item_id}</td>
                            <td>
                                <input type="text" class="form-control" value="${item.item_name}" readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control" value="${item.qty}" readonly>
                            </td>
                            <td>
                                ${barcodeInputs}
                            </td>
                        </tr>
                    `;

                    $('#item-details').append(row);
                });

                $('#search').val('');

            } else {
                $('#item-details').append('<tr><td colspan="6">No items found</td></tr>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            $('#item-details').append('<tr><td colspan="6">Error fetching item</td></tr>');
        }
    });
}

    // ============= Collect Data as Array or JSON =============
    function collectProductData() {
        const products = [];

        $('#item-details tr').each(function () {
            const invoiceNo = $(this).find('td:eq(0)').text().trim();
            const itemName = $(this).find('td:eq(2) input').val().trim();
            const barcodeInputs = $(this).find('td:eq(4) input');

            const indoor = [];
            const outdoor = [];

            barcodeInputs.each(function (index) {
                const name = $(this).attr('name');
                const val = $(this).val().trim();
                if (val) {
                    if (name.includes('indoor_barcodes')) {
                        indoor.push(val);
                    } else if (name.includes('out_barcodes')) {
                        outdoor.push(val);
                    }
                }
            });

            products.push({
                invoice_no: invoiceNo,
                item_name: itemName,
                indoor_barcodes: indoor,
                outdoor_barcodes: outdoor
            });
        });

        return products;
    }


    // ============== Submit to Server ==============
    $('#submitBtn').click(function () {
    const productData = collectProductData();
    console.log(productData);
    if (productData.length === 0) {
    alert("No products to submit.");
    return;
}

    $.ajax({
    url: '../Controller/IssueProductController.php',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({
    command: 'saveBarcodes',
    products: productData
}),
    success: function (response) {
    alert('Data submitted successfully!');
    console.log(response);
    location.reload();
},
    error: function () {
    alert('Error submitting data.');
}
});
});

    // ============= Highlight CSS =============
    $(' <style>')
        .prop('type', 'text/css')
        .html(`.highlighted {background - color: #d0d0d0; cursor: pointer;}`)
        .appendTo('head');

