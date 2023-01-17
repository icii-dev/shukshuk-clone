function readMore() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");
  var showLess = document.getElementById("showLess");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    showLess.style.display = "inline";
    btnText.innerHTML = "Read more";
    moreText.style.display = "none";
  }
  else {
    dots.style.display = "none";
    showLess.style.display = "none";
    btnText.innerHTML = "Read less";
    moreText.style.display = "inline";
  }
}

// Decrease Quantity
$("#productOptions").on("click", ".button-1", function () {
  var $button = $(this);
  var $parent = $button.parent();
  var oldValue = $parent.find('input[name=qtyProductDetail]').val();
  var newVal = parseFloat(oldValue) - 1;
  if (newVal <= 1) {
    newVal = 1
  }
  $parent.find('input[name=qtyProductDetail]').val(newVal);
});

// Increase Quantity
$("#productOptions").on("click", ".button-2", function () {
  var $button = $(this);
  var $parent = $button.parent();
  var oldValue = $parent.find('input[name=qtyProductDetail]').val();
  var newVal = parseFloat(oldValue) + 1;
  $parent.find('input[name=qtyProductDetail]').val(newVal);
});

// On product changed option
$('select.js-product-option-picker').change(function () {
  const val = $(this).val();

  const selectedVariant = getCurrentSelectedVariant();

  if (!selectedVariant) {
    return;
  }

  $('.js-product-detail-origin-price').html(currencyMoney + ' ' + selectedVariant.formatted_price);
  $('.js-product-detail-present-price').html(currencyMoney + ' ' + selectedVariant.formatted_present_price);
  $('.js-product-detail-discount-amount').html(selectedVariant.formatted_discount_amount);

  let itemsLeft = (selectedVariant.quantity >= 0) ? selectedVariant.quantity : 1000;
  if(itemsLeft === null){
    itemsLeft = 1000;
  }
  $('#itemsLeft').html(itemsLeft);

  var variantImagePosition = currentProduct.images.indexOf(selectedVariant.image);
  if (variantImagePosition != -1) {
    try {
      window.pgwSlider && window.pgwSlider.displaySlide(variantImagePosition + 1);
      $('.carousel').carousel(variantImagePosition);
    }catch (e){
    }
  }

  selectedVariant.has_discount ? $('.js-product-detail-origin-price').removeClass('d-none'): $('.js-product-detail-origin-price').addClass('d-none');
  $('.js-product-detail-present-price').removeClass('d-none');
  // !selectedVariant.has_discount || $('.js-product-detail-discount-amount').removeClass('d-none');
  selectedVariant.has_discount ? $('.js-product-detail-discount-amount').removeClass('d-none') : $('.js-product-detail-discount-amount').addClass('d-none');
});

// add to cart by button
function addToCart() {
  var idProduct = $("input[name=idProductDetail]").val();
  var qty = $("input[name=qtyProductDetail]").val();

  if (!isPickedAllOptions()) {
    return;
  }

  const currentVariant = getCurrentSelectedVariant();

  if (!currentVariant) {
    return;
  }

  const options = getCurrentOptions();

  return httpAddToCart(currentVariant.id, idProduct, qty, options);
}

// add to buynow
function addToBuynow() {
  var idProduct = $("input[name=idProductDetail]").val();
  var qty = $("input[name=qtyProductDetail]").val();

  if (!isPickedAllOptions()) {
    return;
  }

  const currentVariant = getCurrentSelectedVariant();

  if (!currentVariant) {
    return;
  }

  const options = getCurrentOptions();

  return httpAddToBuynow(currentVariant.id, idProduct, qty, options);
}

function openTabReview() {
  $('a[href="#Reviews"]').click();
}

//button buy now
function buyNow(event) {
  event.preventDefault();
  const prom = addToBuynow();

  if(prom) {
    prom.success(function () {
      window.location.href = config.routes.checkoutPage + '/buynow';
    });
  }
}

function isPickedAllOptions() {
  var isPickedAll = true;

  $('form#productOptions select.js-product-option-picker').each(function () {
    if (!$(this).val()) {
      return $.notify({
        content: 'Please choose ' + $(this).attr("name"),
        timeout: 5000,
      });

      isPickedAll = false;
    }
  });

  return isPickedAll;
}

function getCurrentSelectedVariant() {
  let sumOptionId = 0;
  let selectedOptionIds = [];
  var isAllOptionSelected = true;

  // Check all option was picked
  $('form#productOptions select.js-product-option-picker').each(function () {
    if (!$(this).val()) {
      isAllOptionSelected = false;
    }
    else {
      sumOptionId += Number($(this).val());
      selectedOptionIds.push(Number($(this).val()));
    }
  });

  if (!isAllOptionSelected) {
    return null;
  }

  // find
  const indexFound = currentProductVariants.findIndex(function (productVariant) {
    let optionIds = [];
    productVariant.option_1 && optionIds.push(productVariant.option_1);
    productVariant.option_2 && optionIds.push(productVariant.option_2);

    let difference = optionIds.filter(x => !selectedOptionIds.includes(x));

    return difference.length === 0;
  });

  if (indexFound === -1) {
    return null;
  }

  return currentProductVariants[indexFound];
}


function getCurrentOptions() {
  var options = {};
  $("form#productOptions :input").each(function (callback) {
    if ($(this).is('select.js-product-option-picker')) {
      if ($(this).val()) {
        options[$(this).attr("name")] = $(this).find("option:selected").text();
      }
      else {
        $.notify({
          content: 'Please choose ' + $(this).attr("name"),
          timeout: 5000,
        });
        options = false;
      }
    }

  });
  return options;
}

function httpAddToCart(variantId, productId, qty, options = {}) {
  let note = $("input[name=note]").val();
  var data = {variant_id: variantId, id: productId, qty: qty, note: note, options: options};
  // return console.log('post', data);
  return $.ajax({
    type: "POST",
    url: config.routes.url + "api/cart/add",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
    },
    // The key needs to match your method's input parameter (case-sensitive).
    data: JSON.stringify({data: data}),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function (data) {
      updateCartStatus(data);
      updateMobileCartStatus(data);
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      var error = JSON.parse(XMLHttpRequest.responseText);
      //response form validation
      if (error.message) {
        $.notify({
          content: error.message,
          alertType: "alert-warning",
          timeout: 5000
        });
      }
      error.errors.forEach(function (status) {
        $.notify({
          content: status,
          alertType: "alert-warning",
          timeout: 5000
        });
      });
    }
  });
}

function httpAddToBuynow(variantId, productId, qty, options) {
  let note = $("input[name=note]").val();
  var data = {variant_id: variantId, id: productId, qty: qty, note: note, options: options};

  return $.ajax({
    type: "POST",
    url: config.routes.url + "api/buynow/add",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
    },
    // The key needs to match your method's input parameter (case-sensitive).
    data: JSON.stringify({data: data}),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function (data) {
      updateCartStatus(data);
      updateMobileCartStatus(data);
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      var error = JSON.parse(XMLHttpRequest.responseText);
      //response form validation
      if (error.message) {
        $.notify({
          content: error.message,
          alertType: "alert-warning",
          timeout: 5000
        });
      }
      error.errors.forEach(function (status) {
        $.notify({
          content: status,
          alertType: "alert-warning",
          timeout: 5000
        });
      });
    }
  });
}

var formSt1 = $("#productOptions");
formSt1.validate({
  errorPlacement: function ($error, $element) {
    if ($element.is('select')) {
      // console.log($element);
      $error.appendTo($element.closest(".wrap-select"));
      $element.closest(".wrap-select").addClass('error');
    }
    else {
      // the default error placement for the rest
      $error.insertAfter($element);
    }
  },
  success: function (element) {
    element.closest('.wrap-select').removeClass('error');
  }
});


