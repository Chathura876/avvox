function save() {
    let name = document.getElementById("name").value.trim();
    let nic = document.getElementById("nic").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let address = document.getElementById("address").value.trim();
    let district = document.getElementById("district").value.trim();

    if (name === "") {
        Swal.fire("Error", "Name is required.", "error");
        return;
    }

    if (name.length > 50) {
        Swal.fire("Error", "Name must not exceed 50 characters.", "error");
        return;
    }

    if (phone.length !== 10 || isNaN(phone)) {
        Swal.fire("Error", "Invalid phone number. Must be exactly 10 digits.", "error");
        return;
    }


    $.ajax({
        url: '../Controller/CustomerController.php',
        method: 'POST',
        data: {
            command: 'save',
            name: name,
            phone: phone,
            nic: nic,
            address: address,
            district: district,
        },
        success: function (data) {
            Swal.fire("Success", "Customer saved successfully.", "success").then(() => {
                resetForm();
            });
            document.getElementById('customerName').value = name;
            document.getElementById('customerNameLabel').innerHTML=name.trim();
            document.getElementById('customerPhoneLabel').innerHTML=phone.trim();
            $('#customerCreateModal').css('display', 'none');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        },
        error: function (xhr) {
            Swal.fire("Error", xhr.responseText || "An error occurred", "error");
        }
    });
}


function resetForm() {
    document.getElementById("name").value = "";
    document.getElementById("nic").value = "";
    document.getElementById("phone").value = "";
    document.getElementById("address").value = "";
    document.getElementById("district").value = "";
    document.getElementById("purchase_date").value = "";
    document.getElementById("model").value = "";
    document.getElementsByName("vat_option").value = "";
    document.getElementById("vat_no").value = "";

}




