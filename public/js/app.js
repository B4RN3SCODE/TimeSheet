'use strict';

var urlPrefix = window.location.protocol + '//' + window.location.host;
var root_dir = '/';
var debug = true;

$(document).ready(function() {
    $("[id^=Customer]").on('click',function(event) {
        var order = $(this).parent().data("order-id");
        var customer = $(this).attr("id").substr("Customer".length);
        $('#Menu input[name="OrderId"]').val(order);
        $('#Menu input[name="CustomerId"]').val(customer);
        $('#Menu').modal('show');
    });
    $('form[name="AddItems"] .glyphicon-plus-sign').on('click', function(event) {
        var item = $(this).parent().html().substr(0,$(this).parent().html().indexOf("<")).trim();
        var price = $(this).parent().children('.rate').html().trim();
        $('<input>').attr({
            type: 'hidden',
            name: 'item[]',
            value: item
        }).appendTo('form');
        $('<input>').attr({
            type: 'hidden',
            name: 'price[]',
            value: price
        }).appendTo('form');
        alert("Item added!");
    });
    $('#Menu').on('hide.bs.modal', function (event) {
        if($('form[name="AddItems"] input[name="item[]"]').length == 0 || confirm('Cancel add items to customer?')) {
            $('form[name="AddItems"] input[name="item[]"],form[name="AddItems"] input[name="price[]"]').remove();
        } else {
            event.preventDefault();
        }
    });
    $('#Menu button#cancel, #Menu button.close').on('click', function(event) {
       $('form[name="AddItems"] input[name="item[]"],form[name="AddItems"] input[name="price[]"]').remove();
    });
    $('[data-item-id] span.glyphicon-remove-circle').on('click', function(event) {
        var item = $(this).parent();
        var CustomerId = $(item).data('customerId');
        var ItemId = $(item).data('itemId');
        var ItemName = $(item).children('label.item-name').html();
        $('form[name="RemoveItem"] input[name="CustomerId"]').val(CustomerId);
        $('form[name="RemoveItem"] input[name="ItemId"]').val(ItemId);
        $('#RemoveItem #ItemToRemove').html(ItemName);
        $('#RemoveItem').modal('show');
    });
    $('#NewOrder').on('click',function(event) {
        $('#NewOrderModal').modal('show');
    });
    $('.glyphicon-edit').on('click', function(event) {
        var item = $(this).parent();
        var CustomerId = $(item).data('customerId');
        var ItemId = $(item).data('itemId');
        $('form[name="CustomOrder"] input[name="CustomerId"]').val(CustomerId);
        $('form[name="CustomOrder"] input[name="ItemId"]').val(ItemId);
       $('#CustomOrder').modal('show');
    });
    $('.glyphicon-info-sign').on('click', function(event) {
        $("#ItemInfo").modal('show');
    });
});

function validate(form) {
    return (form.table.value.length > 0 && form.customer.value.length > 0);
}