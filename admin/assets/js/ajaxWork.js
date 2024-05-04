/**
 * Function to show product items
 */
function showProductItems() {
    $.ajax({
        url: "./adminView/viewAllProducts.php",
        method: "POST",
        data: { record: 1 },
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}

/**
 * Function to show customers
 */
function showCustomers() {
    $.ajax({
        url: "./adminView/viewCustomers.php",
        method: "POST",
        data: { record: 1 },
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}

/**
 * Function to show orders
 */
function showOrders() {
    $.ajax({
        url: "./adminView/viewAllOrders.php",
        method: "POST",
        data: { record: 1 },
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}

/**
 * Function to change order status
 * @param {number} id - The id of the order
 */
function ChangeOrderStatus(id) {
    $.ajax({
        url: "./controller/updateOrderStatus.php",
        method: "POST",
        data: { record: id },
        success: function () {
            $('form').trigger('reset');
            showOrders();
        }
    });
}

/**
 * Function to change payment status
 * @param {number} id - The id of the order
 */
function ChangePay(id) {
    $.ajax({
        url: "./controller/updatePayStatus.php",
        method: "POST",
        data: { record: id },
        success: function () {
            $('form').trigger('reset');
            showOrders();
        }
    });
}

/**
 * Function to add items
 */
function addItems() {
    var fd = new FormData(document.querySelector('form'));

    $.ajax({
        url: "./controller/addItemController.php",
        method: "POST",
        data: fd,
        processData: false,
        contentType: false,
        success: function (data) {
            $('form').trigger('reset'); 
            showProductItems();
        }
    });
}

/**
 * Function to edit item form
 * @param {number} id - The id of the item
 */
function itemEditForm(id) {
    $.ajax({
        url: "./adminView/editItemForm.php",
        method: "POST",
        data: { record: id },
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}

/**
 * Function to update items
 */
function updateItems() {
    var fd = new FormData();
    fd.append('product_id', $('#product_id').val());
    fd.append('p_name', $('#p_name').val());
    fd.append('p_desc', $('#p_desc').val());
    fd.append('p_price', $('#p_price').val());
    fd.append('existingImage', $('#existingImage').val());
    fd.append('newImage', $('#newImage')[0].files[0]);

    $.ajax({
        url: './controller/updateItemController.php',
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        success: function () {
            $('form').trigger('reset');
            showProductItems();
        }
    });
}

/**
 * Function to delete item
 * @param {number} id - The id of the item
 */
function itemDelete(id) {
    $.ajax({
        url: "./controller/deleteItemController.php",
        method: "POST",
        data: { record: id },
        success: function () {
            $('form').trigger('reset');
            showProductItems();
        }
    });
}

/**
 * Function to show each detail form
 * @param {number} id - The id of the item
 */
function eachDetailsForm(id) {
    $.ajax({
        url: "./view/viewEachDetails.php",
        method: "POST",
        data: { record: id },
        success: function (data) {
            $('.allContent-section').html(data);
        }
    });
}