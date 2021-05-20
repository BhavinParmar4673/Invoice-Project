

var count = 1;
$('.repeater').repeater({
    isFirstItemUndeletable: true
});


$('form#quickForm').on('submit', function (event) {
    $('.item').each(function () {
        $(this).rules("add",
            {
                required: true,
                messages: {
                    required: "Please Enter Item",
                }
            });
    });

    $('.price').each(function () {
        $(this).rules("add",
            {
                required: true,
                number: true,
                messages: {
                    required: "Please Enter Price",
                    number: "Price must be number",
                }
            })
    });

    $('.quantity').each(function () {
        $(this).rules("add",
            {
                required: true,
                number: true,
                messages: {
                    required: "Please Enter Quantity",
                    number: "Quantity must be number",
                }
            })
    });
});

$("form#quickForm").validate({
    rules: {
        "receiver": "required"
    },
    messages: {
        "receiver": "Please Enter Receiver",
    }
});


function update_amounts() {
    var sum = 0.0;
    $('.my-div').each(function () {
        var qty = $(this).find('.quantity').val();
        var price = $(this).find('.price').val();
        var amount = (qty * price);
        if (isNaN(amount)) {
            sum += amount;
            $(this).find('.amount').val(0);
        } else {
            sum += amount;
            $(this).find('.amount').val(amount);
        }
    });

    isNaN(sum) ? $('.total').val(0) : $('.total').val(sum);
}

$(document).on('blur', '.price', function () {
    update_amounts();
});

$(document).on('blur', '.quantity', function () {
    update_amounts();
});

//remove row
$(document).on('click', '.remove_row', function () {
    var total_item_amount = $('.amount').val();
    var final_amount = $('.total').val();
    var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
    $('.total').val(result_amount);
    $(this).closest('.my-div').remove();
    update_amounts();
});




