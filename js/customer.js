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
        Swal.fire("Error", "Name is characters long.", "error");
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
            command:'save',
            name: name,
            phone: phone,
            nic: nic,
            address: address,
            district: district,
        },
        success: function (data) {
            Swal.fire("Success", "Customer saved successfully.", "success");
            resetForm();
            $('customerCreateModal').modal('hide');
            location.reload();
        },
        error: function (data) {
            Swal.fire("Error", data.responseText, "error");
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




