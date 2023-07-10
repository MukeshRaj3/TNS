
$( document ).ready(function() {
	myCart();
});

// Add to Cart
function add_to_cart(id, varient){
      var quantity = $("#quantity").val();
      var bunch = $("#bunch_id0").val();
      var bunch_id = $("input[name='bunch_id']:checked").val();
      console.log(bunch);
      if (bunch_id != undefined) {
        $('#bunch_error').text('');
		// if (varient != '0') {
        if(localStorage.getItem('printcart') != null) {      
          if(localStorage.getItem('printcart').split('##').includes(id+'_'+varient)) {
          $('.printcart_modal').modal('show');
          } else {
          localStorage.setItem('printcart', localStorage.getItem('printcart') + '##' + id + '_' + varient + '_' + bunch_id);
          localStorage.setItem('printqty', localStorage.getItem('printqty') + '##' + quantity);
          $('.printcart_modal').modal('show');
          }
        } else {
          localStorage.setItem('printcart', id + '_' + varient + '_' + bunch_id);
          localStorage.setItem('printqty', quantity); 
        } 
      } else {
          if(bunch == '0') {
            if(localStorage.getItem('printcart') != null) {      
              if(localStorage.getItem('printcart').split('##').includes(id+'_'+varient)) {
              $('.printcart_modal').modal('show');
              } else {
              localStorage.setItem('printcart', localStorage.getItem('printcart') + '##' + id + '_' + varient + '_0');
              localStorage.setItem('printqty', localStorage.getItem('printqty') + '##' + quantity);
              $('.printcart_modal').modal('show');
              }
            } else {
              localStorage.setItem('printcart', id + '_' + varient + '_0');
              localStorage.setItem('printqty', quantity); 
            } 
          } else {
            $('#bunch_error').text('Select Bunch');
          }
      } 
      myCart();     
    }
           
// cartIcon
function myCart() {   
  if(localStorage.getItem('printcart') != null) {
    $('#printcartValue').html(localStorage.getItem('printcart').split('##').length);
    for (var i=0; i < localStorage.getItem('printcart').split('##').length; i++) {
      $('#printcart'+localStorage.getItem('printcart').split('##')[i].split('_')[0]).prop( "disabled", true);
      $('#printcart'+localStorage.getItem('printcart').split('##')[i].split('_')[0]).addClass('bg-danger').removeClass('bg-success');
      $('#printcart'+localStorage.getItem('printcart').split('##')[i].split('_')[0]).text("Product Added");
    }
  } else {
    $('#printcartValue').html('0');
    
  }
}

// show Cart
function showCart() {
  if (localStorage.getItem('printcart') != null) {
    $.ajax({
      type: 'post',
      url: base_url + 'welcome/show_cart_products',
      data: {
        cart_id: localStorage.getItem('printcart').split('##')
      },
      cache: false,
      success: function(data) {
        var response = $.parseJSON(data);
        $('#cart_product').html(response.html);
        result = response.products
        var qty = localStorage.getItem('printqty').split('##');
        total = 0;
        // console.log(result);return;
        for (var i = 0; i < result.length; i++) {
          // if (result[i].bunch == '0') {
            $('.product_price' + [i]).append('<span class="Price-currencySymbol">₹ </span>' + (parseFloat(result[i]['price']).toFixed(2) * parseFloat(qty[i]).toFixed(2)));  
            total += (Number(parseFloat(result[i]['price']).toFixed(2)) * Number(parseFloat(qty[i]).toFixed(2)));
          // } else {
            // $('.product_price' + [i]).append('<span class="Price-currencySymbol">₹ </span>' + (parseFloat(result[i]['bunch_data']['price']).toFixed(2) * parseFloat(qty[i]).toFixed(2)));
            // total += (Number(parseFloat(result[i]['bunch_data']['price']).toFixed(2)) * Number(parseFloat(qty[i]).toFixed(2)));

          // }
          if (result[i]['variants'] == 0) {
            $('.quantity_add' + [i]).append('<div class="def-number-input number-input safari_only d-flex"><button class="btn btn-light rounded-0 btn-md" onclick="minus(this,' + result[i]['id'] + ', 0, ' + i + ')" ><i class="fa fa-minus" aria-hidden="true"></i></button><input type="number" class="quantity" name="quantity" id="quantity" value="' + qty[i] + '" min="' + result[i]["min_order_qty"] + '" style=" width: 50px;text-align:center"><button class="btn btn-light rounded-0 btn-md" onclick="plus(this, ' + result[i]['id'] + ', 0, ' + i + ')" ><i class="fa fa-plus" aria-hidden="true"></i></button>				</div>');
          } else {
            $('.quantity_add' + [i]).append('<div class="def-number-input number-input safari_only d-flex"><button class="btn btn-light rounded-0 btn-md" onclick="minus(this,' + result[i]['id'] + ', 0, ' + i + ')" ><i class="fa fa-minus" aria-hidden="true"></i></button><input type="number" class="quantity" name="quantity" id="quantity" value="' + qty[i] + '" min="' + result[i]["min_order_qty"] + '" style=" width: 80px;text-align:center"><button class="btn btn-light rounded-0 btn-md" onclick="plus(this, ' + result[i]['id'] + ', 0, ' + i + ')" ><i class="fa fa-plus" aria-hidden="true"></i></button></div>');
          }
        }
        $('#total_price').html(total + ' Rs');
        $('#cart_product_id').val(localStorage.getItem('printcart'));
        $('#cart_qty_id').val(localStorage.getItem('printqty'));
        $('#final_price').val(total + 10);
        $('.total_shipping').html('+ ₹10.00');
        $('.final_price').html('₹ ' + (parseFloat(total) + 10.00));
        localStorage.setItem('final_price', total + 10);
      }
    });
  } else {
    $('#cart_product').html(`<div class="alert alert-danger"  style="margin-top:100px">
                  <strong>Empty Cart!</strong> Please Add Some item to show Cart Item
                </div>`);
    $('#cart_footer').html('');
  }
}


// show Cart
function checkout_cart() {
  if (localStorage.getItem('printcart') != null) {
    $.ajax({
      type: 'post',
      url: base_url + 'welcome/show_checkout_products',
      data: {
        cart_id: localStorage.getItem('printcart').split('##')
      },
      cache: false,
      success: function(data) {
        var response = $.parseJSON(data);
        console.log(response);
        $('#checkout_data').html(response.html);
        result = response.products
        var qty = localStorage.getItem('printqty').split('##');
        total = 0;
        // console.log(result);return;
        for (var i = 0; i < result.length; i++) {
          // if (result[i].bunch == '0') {
            $('.product_price' + [i]).append('<span class="Price-currencySymbol"> ₹ </span>' + (parseFloat(result[i]['price']).toFixed(2) * parseFloat(qty[i]).toFixed(2)));
            $('.qty' + [i]).html(qty[i]);
            total += (Number(parseFloat(result[i]['price']).toFixed(2)) * Number(parseFloat(qty[i]).toFixed(2)));
          // } else {
          //   $('.product_price' + [i]).append('<span class="Price-currencySymbol"> ₹ </span>' + (parseFloat(result[i]['bunch_data']['price']).toFixed(2) * parseFloat(qty[i]).toFixed(2)));
          //   total += (Number(parseFloat(result[i]['bunch_data']['price']).toFixed(2)) * Number(parseFloat(qty[i]).toFixed(2)));
          // }
        }
        $('#sub_total').html(total);
        $('#cart_product_id').val(localStorage.getItem('printcart'));
        $('#cart_qty_id').val(localStorage.getItem('printqty'));
        
        $('.final_price').html('₹ ' + (parseFloat(total) + parseFloat(response.delivery_charge)));
        $('#final_price').val(total + parseFloat(response.delivery_charge));
        localStorage.setItem('final_price', total + parseFloat(response.delivery_charge));
      }
    });
  } else {
    $('#cart_product').html(`<div class="alert alert-danger"  style="margin-top:100px">
                  <strong>Empty Cart!</strong> Please Add Some item to show Cart Item
                </div>`);
    $('#cart_footer').html('');
  }
}



function minus(value, pid, vid, index){
  value.parentNode.querySelector('input[type=number]').stepDown();
  var qty	= $(value).closest('tr').find("#quantity").val();
  update_quantity(qty, pid, vid, index);
}
function plus(value, pid, vid, index){
  value.parentNode.querySelector("input[type=number]").stepUp();
  var qty	= $(value).closest('tr').find("#quantity").val();
  update_quantity(qty, pid, vid, index);
}

function removeCart(product_id, varient_id, bunch_id, pos) {
  // console.log(pos);return;
  var cartArray = localStorage.getItem('printcart').split('##');
  var id = product_id + '_' + varient_id + '_' + bunch_id;
  var qtyArray = localStorage.getItem('printqty').split('##');
  var index = cartArray.indexOf(id.toString());
  if (cartArray.indexOf(id.toString()) > -1) {
    cartArray.splice(index, 1);
    qtyArray.splice(index, 1);
    if (cartArray.toString() == '' || cartArray.toString() == '##') {
      localStorage.removeItem('printcart');
      localStorage.removeItem('printqty');
      // localStorage.removeItem('varient');
      $('.cart_detail').html(`<div class="alert alert-danger" style="margin-top:100px"> 
      <strong>Empty Cart!</strong> Please Add Some item to show Cart Item
      </div>`);
      $('.proceed_button').html('');
      
    } else {
      localStorage.setItem('printcart', cartArray.toString().split(',').join('##'));
      localStorage.setItem('printqty', qtyArray.toString().split(',').join('##'));
    }
    $('#listId' + pos).remove();
    $('#printcart' + id).removeClass('disabled');
    $('#printcart' + id).removeClass('btn-success');
    $('#printcart' + id).text("Add to cart");
  }
  data = showCart();
  if (data) {
    var newArray = localStorage.getItem('printqty').split('##');
    $('#total_price').html(total + ' Rs');
  }
  myCart();
}

// The splice operation will start at index 1, remove 1 item in the array (i.e. 3452), and will replace it with the new item 1010.
function update_quantity(val, pid, vid, index) {
  var qtyArray = localStorage.getItem('printqty').split('##');
  qtyArray.splice(index, 1, val);
  localStorage.setItem('printqty', qtyArray.toString().split(',').join('##'));
  var newArray = localStorage.getItem('printqty').split('##');
  var i = 0;
  total = 0;
  result.forEach(function(res) {
    if (i == index) {
      // if (res.bunch == '0') {
        $('.product_price' + [i]).html('<span class="Price-currencySymbol">₹ </span>' + (parseFloat(res.price).toFixed(2) * parseFloat(val).toFixed(2)));
      // } else {
      //   $('.product_price' + [i]).html('<span class="Price-currencySymbol">₹ </span>' + (parseFloat(res.bunch_data.price).toFixed(2) * parseFloat(val).toFixed(2)));
      // }
    }
    // if (res.bunch == '1') {
      // total += (Number(parseFloat(res.bunch_data.price).toFixed(2)) * Number(parseFloat(newArray[i]).toFixed(2)));
    // } else {
      // console.log(res.bunch);
      total += (Number(parseFloat(res.price).toFixed(2)) * Number(parseFloat(newArray[i]).toFixed(2)));
    // }
    i++;
  });
  $('#total_price').html(total + ' Rs');
  $('.final_price').html('₹ ' + (parseFloat(total) + 10.00));
  localStorage.setItem('final_price', total);
}


$(function () {
  'use strict'
$('form[id="add_address"]').validate({
  rules: {
      first_name: {
          required: true,
      },
      last_name: {
          required: true,
      },
      address: {
          required: true,
      },
      land_mark: {
          required: true,
      },
      city: {
          required: true,
      },
      state: {
          required: true,
      },
      postcode: {
          required: true,
          minlength: 6,
      },
      phone: {
          required: true,
          minlength: 10,
          maxlength: 11
      },
      email: {
          required: true,
          email:true
      },
  },
  //For custom messages
  messages: {
      first_name: {
          required: "First name is required"
      },
      last_name: {
          required: "Last name is required"
      },
      address: {
          required: "Address name is required"
      },
      land_mark: {
          required: "LandMark name is required"
      },
      city: {
          required: "City name is required"
      },
      state: {
          required: "State name is required"
      },
      postcode: {
          required: "Postcode field is required",
          minlength: 'Phone number must be at least 6 characters long'
      },
      email: {
          required: "Email is required"
      },
      phone: {
          required: "Phone is required",
          minlength: 'Phone number must be at least 10 characters long'
      },
  },
  errorElement: 'div',
  errorPlacement: function (error, element) {
      var placement = $(element).data('error');
      if (placement) {
          $(placement).append(error)
      } else {
          error.insertAfter(element);
      }
  },
  submitHandler: function (form) {
      form.submit();
  }
});
});