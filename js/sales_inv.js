let selectedIndex = -1;
let selectedProducts = [];
let netTotal = 0;
let balance;
let payments;


// ===================== Product Search ================
$('#search').keyup(function (e) {
    let query = $(this).val();
    let shop = $('#shop').val();


    // Skip key navigation keys
    if ([38, 40, 13].includes(e.keyCode)) return;

    if (query.length > 1) {
        $.ajax({
            url: '../Controller/ProductController.php',
            method: 'POST',
            data: {
                command: 'search',
                query: query,
                shop: shop
            },
            success: function (data) {
                let output = '';
                if (data.length > 0) {
                    data.forEach(function (item, index) {
                        output += `<div class="suggestion-item" data-id="${item.id}" data-index="${index}">${item.model}</div>`;
                    });
                    selectedIndex = -1;
                } else {
                    output = '<div class="suggestion-item">No results found or not have stock this shop </div>';
                }
                $('#suggestion-box').html(output).fadeIn();
            }
        });
    } else {
        $('#suggestion-box').fadeOut();
    }
});

// Keyboard navigation and enter key
$('#search').keydown(function (e) {
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


$(document).on('click', '#suggestion-box .suggestion-item', function () {
    let itemId = $(this).data('id');
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

function fetchItemDetails(id) {
    let shop = document.getElementById('shop').value.trim();
    if (selectedProducts.some(p => p.id == id)) {
        alert('Product already added');
        $('#search').val(''); // Clear input
        return;
    }

    $.ajax({
        url: '../Controller/ProductController.php',
        method: 'POST',
        data: {
            command: 'getDetails',
            id: id,
            shop:shop
        },
        dataType: 'json',
        success: function (item) {
            console.log(item);
            if (item && item.id) {
                item.qty = 1;
                item.discount = 0;
                item.subtotal = item.pricedefault;

                // netTotal += parseFloat(item.subtotal);
                // Add to product list
                selectedProducts.push(item);
                // console.log(netTotal);
                let row = `
                <tr data-id="${item.id}"> 
                    <td>${item.id}</td>
                    <td>${item.model}</td>
                    <td>
                        <input type="number" class="form-control" id="price_${item.id}" name="price[]" value="${item.pricedefault}" />
                    </td>
                    <td>
                        <input type="number" id="qty_${item.id}" data-inventory="${item.amount}" class="form-control" value="1" onchange="updateSubtotal(${item.id})" required>
                    </td>
                    <td>
                        <input type="number" id="discount_${item.id}" class="form-control" value="0" onchange="updateSubtotal(${item.id})">
                    </td>
                    <td>
                        <input type="number" class="form-control" id="subtotal_${item.id}" readonly value="${item.pricedefault}">
                    </td>
                  <td>
                         <button class="btn btn-danger btn-sm" onclick="removeProduct(${item.id})">X</button>
                  </td>

                </tr>
            `;

                $('#item-details').append(row);
                $('#search').val('');
                calculateNetTotal();// Clear input
            } else {
                $('#item-details').append('<tr><td colspan="6">Item not found</td></tr>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching item details:', error);
            $('#item-details').append('<tr><td colspan="6">Error fetching item</td></tr>');
        }
    });
}


function updateSubtotal(id) {
    let qty = parseFloat($(`#qty_${id}`).val()) || 0;
    let inventory = parseFloat($(`#qty_${id}`).data('inventory')) || 0;

    if (inventory >= qty) {
        let price = parseFloat($(`#price_${id}`).val()) || 0;
        let discount = parseFloat($(`#discount_${id}`).val()) || 0;
        qty = qty === 0 ? 1 : qty;
        const subtotal = (price * qty) - discount;

        $(`#subtotal_${id}`).val(subtotal.toFixed(2));

        const product = selectedProducts.find(p => p.id == id);
        if (product) {
            netTotal -= product.subtotal;

            product.qty = qty;
            product.discount = discount;
            product.subtotal = subtotal;

            $('#net_total').val(netTotal.toFixed(2));
        }

        calculateNetTotal();
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Stock Limit Exceeded',
            text: `Only ${inventory} items in stock for this product.`,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        $(`#qty_${id}`).val('');
    }
}


function calculateNetTotal() {
    let total = 0;
    let netTotal = 0;
    let totalDiscount = 0;

    // Select all subtotal input fields
    const subtotals = document.querySelectorAll('input[id^="subtotal_"]');
    const totalDiscounts = document.querySelectorAll('input[id^="discount_"]');
    const price = document.querySelectorAll('input[id^="price_"]');

    subtotals.forEach(input => {
        const value = parseFloat(input.value) || 0;
        netTotal += value;
    });
    totalDiscounts.forEach(input => {
        const value = parseFloat(input.value) || 0;
        totalDiscount += value;
    });

    price.forEach(input => {
        const value = parseFloat(input.value) || 0;
        total += value;
    });

    document.getElementById('total').value = total.toFixed(2);
    document.getElementById('net_total').value = netTotal.toFixed(2);
    document.getElementById('total_discount').value = totalDiscount.toFixed(2);
    document.getElementById('netTotal').value = netTotal.toFixed(2);
    document.getElementById('discount').value = totalDiscount.toFixed(2);

}

function removeProduct(id) {
    $(`tr[data-id="${id}"]`).remove();
    selectedProducts = selectedProducts.filter(p => p.id !== String(id));
    calculateNetTotal();
    console.log('Updated product list:', selectedProducts);
}


$('<style>')
    .prop('type', 'text/css')
    .html(`.highlighted { background-color: #d0d0d0; cursor: pointer; }`)
    .appendTo('head');

function calculateBalance() {
    const netTotal = parseFloat(document.getElementById('netTotal').value) || 0;
    // Sum all payment inputs
    let totalPaid = 0;
    document.querySelectorAll('.payment-input').forEach(input => {
        const val = parseFloat(input.value);
        if (!isNaN(val)) totalPaid += val;
    });

    balance = netTotal - totalPaid;
    document.getElementById('balance').value = balance.toFixed(2);
}

// Attach event listeners to all payment inputs
document.querySelectorAll('.payment-input').forEach(input => {
    input.addEventListener('input', calculateBalance);
});

// On payment button click — gather all payment data (example)
document.getElementById('payButton').addEventListener('click', () => {
    payments = {
        cash: parseFloat(document.getElementById('cash_pay').value) || 0,
        card: parseFloat(document.getElementById('card_pay').value) || 0,
        credit: parseFloat(document.getElementById('credit_pay').value) || 0,
        cheque: parseFloat(document.getElementById('online_pay').value) || 0,
        bank: document.getElementById('bank').value,
    };

    console.log("Payments:", payments);

    // alert(`Payment summary:
    // Cash: ${payments.cash}
    // Card: ${payments.card} (Bank: ${payments.bank})
    // Credit: ${payments.credit}
    // Cheque: ${payments.cheque}
    // `);

});

calculateBalance();

function paymentSave() {
    let inv_no = document.getElementById("invoice_no").innerText.trim();
    let customerName = document.getElementById('customerName').value.trim();
    if (customerName === '') {
        alert('Please select customer');
        return;
    }
    let shop = document.getElementById('shop').value;
    let date1 = document.getElementById('date1').value;
    let date2 = document.getElementById('date2').value;
    let date3 = document.getElementById('date3').value;

    let cash = parseFloat(document.getElementById('cash_pay').value) || 0;
    let card = parseFloat(document.getElementById('card_pay').value) || 0;
    let credit = parseFloat(document.getElementById('credit_pay').value) || 0;
    let cheque = parseFloat(document.getElementById('online_pay').value) || 0;

    let totalPaid = cash + card + credit + cheque;
    let netTotal = parseFloat(document.getElementById('netTotal').value) || 0;
    let balance = totalPaid - netTotal;

    let balanceField = document.getElementById('balance');
    if (balanceField) {
        balanceField.value = balance.toFixed(2);
    } else {
        alert('Balance field not found!');
    }

    // console.log({
    //     customer: customerName,
    //     netTotal: netTotal,
    //     cash: cash,
    //     card: card,
    //     credit: credit,
    //     cheque: cheque,
    //     totalPaid: totalPaid,
    //     balance: balance,
    //     item: selectedProducts
    // });
    let data = {
        command: 'save_payment',
        customer: customerName,
        netTotal: netTotal,
        cash: cash,
        card: card,
        credit: credit,
        cheque: cheque,
        totalPaid: totalPaid,
        balance: balance,
        item: selectedProducts,
        inv_no: inv_no,
        shop: shop,
        date1: date1,
        date2: date2,
        date3: date3
    };
    $.ajax({
        url: '../Controller/SalesInvoiceController.php',
        method: 'POST',
        data: JSON.stringify({
            command: 'save_payment',
            inv_no: inv_no,
            customer: customerName,
            netTotal: netTotal,
            cash: cash,
            card: card,
            cheque: cheque,
            credit: credit,
            totalPaid: totalPaid,
            balance: balance,
            item: selectedProducts,
            shop: shop,
            date1: date1,
            date2: date2,
            date3: date3

        }),
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.success && response.invoice_id) {
                const win = window.open(
                    `../view/component/invoice_print.php?id=${response.invoice_id}`,
                    'PrintWindow',
                    'width=800,height=600,top=100,left=100,toolbar=no,scrollbars=no,resizable=no'
                );

                // Optional: Reload the main page right away
                location.reload();
            } else {
                alert('Invoice save failed.');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            alert('Something went wrong while saving payment.');
        }
    });
}
