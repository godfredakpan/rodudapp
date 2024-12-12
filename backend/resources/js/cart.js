$('.add_to_cart_button').find('a').click(function (event) {
    // $('#update').html('Sending..');
event.preventDefault();

var quantity = $(this).parent().prev().find('input').val();
var id = $('#checkout_items').attr("data-id");
var all = 1;
var c = (+id) + (+all);


$.ajax({
    type: "GET",
    url: $(this).attr('href'),
    // secondurl:secondurl,
    data: {quantity: quantity}
    , success: function (data) {
        // console.log("data");
        // alert("Added to cart = " c);
        $('#checkout_items').html(data);
        $('#checkout_item').html(data);
        // $("#btn_cart").html('Added..');
    }, error: function(err) {
        console.log('err',err)
    }
});
return false; //for good measure
});
