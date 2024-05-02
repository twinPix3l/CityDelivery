// ---START CART SCRIPTS--- //

function showHide(id) {
    var x = document.getElementById(id)
    if (x.style.visibility === "hidden") {
        x.style.visibility = "visible"
    }
    else {
        x.style.visibility = "hidden"
    }
}

if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
}
else {
    ready()
}

function ready() {
    var removeCartItemButtons = document.getElementsByClassName('btn-remove')
    for (var i = 0; i < removeCartItemButtons.length; i++) {
        var button = removeCartItemButtons[i]
        button.addEventListener('click', removeCartItem)
    }

    var quantityInputs = document.getElementsByClassName('cart-quantity-input')
    for (var i = 0; i < quantityInputs.length; i++) {
        var input = quantityInputs[i]
        input.addEventListener('change', quantityChanged)
    }

    var addToCartButtons = document.getElementsByClassName('add-to-cart')
    for (var i = 0; i < addToCartButtons.length; i++) {
        var button = addToCartButtons[i]
        button.addEventListener('click', addToCartClicked)
    }

  //document.getElementsByClassName('btn-purchase')[0].addEventListener('click', purchaseClicked)
}

function purchaseClicked() {
    alert('Thank you for your order')
    var cartItems = document.getElementsByClassName('cart-items')[0]
    while (cartItems.hasChildNodes()) {
        cartItems.removeChild(cartItems.firstChild)
    }
    updateCartTotal()
}

function removeCartItem(event) {
    var buttonClicked = event.target
    buttonClicked.parentElement.parentElement.remove()
    updateCartTotal()
    CallAjaxAddItemToCart()
}

function quantityChanged(event)
{
    var input = event.target
    if (isNaN(input.value) || input.value <= 0)
    {
        input.value = 1
    }
    updateCartTotal()
    CallAjaxAddItemToCart() 
}

function addToCartClicked(event) {
  var button = event.target;
  var shopItem = document.getElementById(button.dataset.form);
  var modalEl = document.getElementById(button.dataset.modal);
  var quantityInput = shopItem.getElementsByClassName("card-quantity-input")[0];
  var title = shopItem.getElementsByClassName("card-title-input")[0].value;
  var price = shopItem
    .getElementsByClassName("card-price-input")[0]
    .value.replace("€", "");
  var quantity = quantityInput.value;
  if (isNaN(quantity) || quantity <= 0) {
    quantity = 1;
  }
  console.log(quantity);
  addItemToCart(title, price, quantity);
  updateCartTotal();
  CallAjaxAddItemToCart();
  var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
  modal.hide();
}

function addItemToCart(title, price, quantity) {
  var cartRow = document.createElement("div");
  cartRow.classList.add("cart-row");
  var cartItems = document.getElementsByClassName("cart-items")[0];
  var cartItemNames = cartItems.getElementsByClassName("cart-item-title");
  var totalItems = cartItemNames.length;
  for (var i = 0; i < cartItemNames.length; i++) {
    if (cartItemNames[i].textContent == title) {
      alert("This item is already added to the cart");
      return;
    }
  }
  var cartRowContents = `
        <div class="cart-item cart-column">
            <span class="cart-item-title">${title}</span>
            <input type="hidden" name="riga_ordine['${title}'][title]" value="${title}">
        </div>
        <span class="cart-price-el cart-column">€${price}</span>
        <input type="hidden" name="riga_ordine['${title}'][price]" value="${price}">
        <div class="cart-quantity cart-column">
            <input class="cart-quantity-input" type="number" name="riga_ordine['${title}'][quantity]" value="${quantity}">
        </div>
        <div class="cart-action cart-column">
            <button class="btn-remove btn btn-danger" type="button">X</button>
        </div>`;
  cartRow.innerHTML = cartRowContents;
  cartItems.append(cartRow);
  cartRow
    .getElementsByClassName("btn-remove")[0]
    .addEventListener("click", removeCartItem);
  cartRow
    .getElementsByClassName("cart-quantity-input")[0]
    .addEventListener("change", quantityChanged);
}

function updateCartTotal() {
  var cartItemContainer = document.getElementsByClassName("cart-items")[0];
  var cartRows = cartItemContainer.getElementsByClassName("cart-row");
  var total = 0;
  var totalQuantity = 0;
  for (var i = 0; i < cartRows.length; i++) {
    var cartRow = cartRows[i];
    var priceElement = cartRow.getElementsByClassName("cart-price-el")[0];
    var quantityElement = cartRow.getElementsByClassName(
      "cart-quantity-input"
    )[0];
    var price = parseFloat(priceElement.textContent.replace("€", ""));
    var quantity = quantityElement.value;
    total = total + price * quantity;
    totalQuantity = totalQuantity + parseFloat(quantity);
  }
  total = Math.round(total * 100) / 100;
  var totalBoxes = document.getElementsByClassName("cart-total-price");
    for (let i = 0; i < totalBoxes.length; i++) {
      totalBoxes[i].textContent = "€" + total;
    }
    let minicartTotalCountBoxes =
      document.getElementsByClassName("minicart-count");
    for (let i = 0; i < minicartTotalCountBoxes.length; i++) {
      if (totalQuantity > 0) {
        minicartTotalCountBoxes[i].classList.remove("d-none");
      } else {
        minicartTotalCountBoxes[i].classList.add("d-none");
      }
      minicartTotalCountBoxes[i].textContent = totalQuantity;
    }
  }

function CallAjaxAddItemToCart() {
  const form = document.querySelector(".minicart-form");
  const formData = new FormData(form);
  const button = document.querySelector(".btn-purchase");

  button.setAttribute("disabled", true);
  fetch(form.action, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((result) => {
      console.log(result); 
      var cartRows = document.getElementsByClassName("cart-row");
      if(cartRows && cartRows.length > 0) {
        button.removeAttribute("disabled");
      }    
    })
    .catch((error) => {
      console.error(error);
      button.removeAttribute("disabled");
    });
}

// ---END CART SCRIPTS--- //

// ---START RIDER SCRIPTS--- //

$(document).ready(function () {
    updatePendingOrders();
    updateConfirmedOrders();
    checkAcceptedOrders();
    checkConfirm();
});

function updatePendingOrders() {
    $.ajax({
        type: 'POST',
        url: '../backend/getPendingOrders.php',
        data: {},
        success: function (response) {
            checkAcceptedOrders();
            var orders = JSON.parse(response);

            var current_time = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

      $("#pending-orders").empty();

            for (var i = 0; i < orders.length; i++) {
                var order = orders[i];
                $('#pending-orders').append(
                    '<div class="card mb-3 bg-dark card-order position-relative" style="padding:1.5rem">' +
                    '<p class="card-text">BUYER: ' + order["acquirente"] + '</p>' +
                    '<p class="card-text">TIME: ' + order["ora_ordine"] + '</p>' +
                    '<p class="card-text">STATE OF ORDER: ' + order["stato"] + '</p>' +
                    '<p class="card-text">TOTAL PRICE: €' + order["prezzo_tot"] + '</p>' +
                    '<p class="card-text">RESTAURANT: ' + order["ristorante"] + '</p>' +
                    '<p class="card-text">RESTAURANT ADDRESS: ' + order["indirizzo_ristorante"] + '</p>' +
                    '<p class="card-text">BUYER ADDRESS: ' + order["via_acquirente"] + ', ' + order["civico_acquirente"] + '</p>' +
                    '<p class="card-text">BUYER INTERPHONE: ' + order["citofono"] + '</p>' +
                    '<p class="card-text">DELIVERY INSTRUCTIONS: ' + order["istruzioni_consegna"] + '</p>' +
                    '<form method="POST" action="../backend/acceptOrder.php" style="background-color:transparent;">' +
                    '<input type="hidden" name="acquirente" value="' + order["acquirente"] + '">' +
                    '<input type="hidden" name="ora_ordine" value="' + order["ora_ordine"] + '">' +
                    '<label for="delivery_timing">Choose a time for your delivery: </label>' +
                    '<input type="time" id="delivery_timing" name="tempistica_consegna" min="' + current_time + '"/>' +
                    '<button class="btn btn-success accept" id="accept-button" name="accept-order" type="submit">ACCEPT ORDER</button>' + '</form>'
                )
            }
        },
        error: function (error) {
            console.log(error)
        }
    });
}

function updateConfirmedOrders() {
  $.ajax({
    type: "POST",
    url: "../backend/getConfirmedOrders.php",
    data: {},
    success: function (response) {
      var orders = JSON.parse(response);

      $("#confirmed-orders").empty();

      for (var i = 0; i < orders.length; i++) {
        var order = orders[i];
        $("#confirmed-orders").append(
          '<div class="card mb-3 bg-dark card-order position-relative" style="background:var(--bs-success) !important;  padding:1.5rem">' +
            '<p class="card-text">BUYER: ' +
            order["acquirente"] +
            "</p>" +
            '<p class="card-text">TIME: ' +
            order["ora_ordine"] +
            "</p>" +
            '<p class="card-text">STATE OF ORDER: ' +
            order["stato"] +
            "</p>" +
            '<p class="card-text">TO DELIVER BEFORE: ' +
            order["tempistica_consegna"] +
            "</p>" +
            '<p class="card-text">TOTAL PRICE: €' +
            order["prezzo_tot"] +
            "</p>" +
            '<p class="card-text">PAYMENT METHOD: ' +
            order["metodo_pagamento"] +
            "</p>" +
            '<p class="card-text">RESTAURANT: ' +
            order["ristorante"] +
            "</p>" +
            '<p class="card-text">RESTAURANT ADDRESS: ' +
            order["indirizzo_ristorante"] +
            "</p>" +
            '<p class="card-text">BUYER ADDRESS: ' +
            order["via_acquirente"] +
            ", " +
            order["civico_acquirente"] +
            "</p>" +
            '<p class="card-text">BUYER INTERPHONE: ' +
            order["citofono"] +
            "</p>" +
            '<p class="card-text">DELIVERY INSTRUCTIONS: ' +
            order["istruzioni_consegna"] +
            "</p>"
        );
      }
    },
    error: function (error) {
      console.log(error);
    },
  });
}

var prev_state = "In attesa di conferma";
function checkConfirm() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var response = JSON.parse(xhttp.responseText);

            if (response[0] == "not_changed") {
                prev_state = response[1];
            }
            if (response[0] == "changed" && response[1] == "In consegna" && window.location.pathname.endsWith("homeFattorino.php") == true) {
                prev_state = response[1];
                alert("The order has been confirmed");
            }
            if (response[0] == "changed" && response[1] == "Annullato" && window.location.pathname.endsWith("homeFattorino.php") == true) {
                prev_state = response[1];
                alert("The order has been aborted");
            }
        }
    }
    xhttp.open("GET", "../backend/checkConfirm.php?prev_state=" + prev_state, true);
    xhttp.send();
};
setInterval(checkConfirm, 2000);

function updatePastOrders() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var pastOrders = JSON.parse(xhttp.responseText);

      $("#past-orders").empty();

            for (var i = 0; i < pastOrders.length; i++) {
                var pastOrder = pastOrders[i];
                $('#past-orders').append(
                    '<div class="card mb-3 bg-dark card-order position-relative" style="background:var(--bs-danger) !important; padding:1.5rem; width: fit-content;">' +
                    '<p class="card-text">BUYER: ' + pastOrder["acquirente"] + '</p>' +
                    '<p class="card-text">TIME: ' + pastOrder["ora_ordine"] + '</p>' +
                    '<p class="card-text">STATE OF ORDER: ' + pastOrder["stato"] + '</p>' +
                    '<p class="card-text">TOTAL PRICE: €' + pastOrder["prezzo_tot"] + '</p>' +
                    '<p class="card-text">PAYMENT METHOD: ' + pastOrder["metodo_pagamento"] + '</p>' +
                    '<p class="card-text">RESTAURANT: ' + pastOrder["ristorante"] + '</p>'
                )
            }
        }
    }
  
  xhttp.open("GET", "../backend/getPastOrders.php", true);
  xhttp.send();
}
setInterval(updatePastOrders, 2000);

function checkAcceptedOrders() {
    const acceptOrderButtons = document.getElementsByName('accept-order');
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var acceptedOrders = JSON.parse(xhttp.responseText);

            if (acceptedOrders.length >> 0) {
                acceptOrderButtons.forEach(function (element) {
                    element.disabled = true;
                });
            } else {
                acceptOrderButtons.forEach(function (element) {
                    element.disabled = false;
                });
            }
        }
    }
    xhttp.open("GET", "../backend/checkAccepted.php", true);
    xhttp.send();
}

function updateLastOrders() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var lastOrders = JSON.parse(xhttp.responseText);

            $('#last-orders').empty();

            for (var i = 0; i < lastOrders.length; i++) {
                var lastOrder = lastOrders[i];
                $('#last-orders').append(
                    '<div class="card mb-3 bg-dark card-order position-relative" style="background:var(--bs-orange) !important; padding:1.5rem; width: fit-content;">' +
                    '<p class="card-text">BUYER: ' + lastOrder["acquirente"] + '</p>' +
                    '<p class="card-text">TIME: ' + lastOrder["ora_ordine"] + '</p>' +
                    '<p class="card-text">STATE OF ORDER: ' + lastOrder["stato"] + '</p>' +
                    '<p class="card-text">RESTAURANT: ' + lastOrder["ristorante"] + '</p>' +
                    '<p class="card-text">RIDER: ' + lastOrder["fattorino"] + '</p>'
                )
            }
        }
    }
    xhttp.open("GET", "../backend/getLastOrders.php", true);
    xhttp.send();
}
setInterval(updateLastOrders, 2000);

// ---END RIDER SCRIPTS--- //

// ---START RESTAURANT SCRIPTS--- //

$(document).ready(function () {
  updateInactiveOrders();
  updateCurrentOrders();
  updateClosedOrders();
});

function updateInactiveOrders() {
  var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var inactiveOrders = JSON.parse(xhttp.responseText);

            $('#inactive-orders').empty();
            let addedOrders = new Set();
            for (var i = 0; i < inactiveOrders.length; i++) {
                var inactiveOrder = inactiveOrders[i];
                if (!addedOrders.has(inactiveOrder["acquirente"]) && !addedOrders.has(inactiveOrder["ora_ordine"])) {
                  addedOrders.add(inactiveOrder["acquirente"]);
                  addedOrders.add(inactiveOrder["ora_ordine"]);
                  $('#inactive-orders').append(
                    '<div class="card mb-3 bg-dark card-order position-relative" style="width:100%;background:#ffc107c0;padding:1rem;border:1px solid black;"' +
                        '<p class="card-text">BUYER: ' + inactiveOrder["acquirente"] + '</p>' +
                        '<p class="card-text">TIME: ' + inactiveOrder["ora_ordine"] + '</p>' +
                        '<p class="card-text">STATE OF ORDER: ' + inactiveOrder["stato"] + '</p>' +
                        '</div>'
                  );
                  for (var j = 0; j < inactiveOrder["orderLines"].length; j++) {
                    var orderLine = inactiveOrder["orderLines"][j];
                    $('#inactive-orders').append(
                      '<li  style="background:#ffc107c0;text-align:left;width:50%">' + orderLine["quantit\u00e0"] + 
                      'x ' + orderLine["nome_prodotto"] +
                      '</li>'
                    );
                  }
                }
            }
        }
    }
    xhttp.open("GET", "../backend/getInactiveOrders.php", true);
    xhttp.send();
}
setInterval(updateInactiveOrders, 2000);

function updateCurrentOrders() {
  var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var currentOrders = JSON.parse(xhttp.responseText);

            $('#current-orders').empty();
            let addedOrders = new Set();
            for (var i = 0; i < currentOrders.length; i++) {
                var currentOrder = currentOrders[i];
                if (!addedOrders.has(currentOrder["acquirente"]) && !addedOrders.has(currentOrder["ora_ordine"])) {
                  addedOrders.add(currentOrder["acquirente"]);
                  addedOrders.add(currentOrder["ora_ordine"]);
                  $('#current-orders').append(
                    '<div class="card mb-3 bg-dark card-order position-relative" style="width:100%;background:#198754c0!important;padding:1rem;border:1px solid black;"' +
                    '<p class="card-text">BUYER: ' + currentOrder["acquirente"] + '</p>' +
                    '<p class="card-text">TIME: ' + currentOrder["ora_ordine"] + '</p>' +
                    '<p class="card-text">STATE OF ORDER: ' + currentOrder["stato"] + '</p></div>'
                  );
                  for (var j = 0; j < currentOrder["orderLines"].length; j++) {
                    var orderLine = currentOrder["orderLines"][j];
                    $('#current-orders').append(
                      '<li  style="background:#198754c0;text-align:left;width:50%">' + orderLine["quantit\u00e0"] + 
                      'x ' + orderLine["nome_prodotto"] +
                      '</li>'
                    );
                  }
                }
            }
        }
    }
    xhttp.open("GET", "../backend/getCurrentOrders.php", true);
    xhttp.send();
}
setInterval(updateCurrentOrders, 2000);

function updateClosedOrders() {
  var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var closedOrders = JSON.parse(xhttp.responseText);

            $('#closed-orders').empty();
            let addedOrders = new Set();
            for (var i = 0; i < closedOrders.length; i++) {
                var closedOrder = closedOrders[i];
                if (!addedOrders.has(closedOrder["acquirente"]) && !addedOrders.has(closedOrder["ora_ordine"])) {
                  addedOrders.add(closedOrder["acquirente"]);
                  addedOrders.add(closedOrder["ora_ordine"]);
                  $('#closed-orders').append(
                    '<div class="card mb-3 bg-dark card-order position-relative" style="width:100%;background:#dc3545c0!important;padding:1rem;border:1px solid black;"' +
                    '<p class="card-text">BUYER: ' + closedOrder["acquirente"] + '</p>' +
                    '<p class="card-text">TIME: ' + closedOrder["ora_ordine"] + '</p>' +
                    '<p class="card-text">STATE OF ORDER: ' + closedOrder["stato"] + '</p></div>'
                  );
                  for (var j = 0; j < closedOrder["orderLines"].length; j++) {
                    var orderLine = closedOrder["orderLines"][j];
                    $('#closed-orders').append(
                      '<li  style="background:#dc3545c0;text-align:left;width:50%">' + orderLine["quantit\u00e0"] + 
                      'x ' + orderLine["nome_prodotto"] +
                      '</li>'
                    );
                  }
                }
            }
        }
    }
    xhttp.open("GET", "../backend/getClosedOrders.php", true);
    xhttp.send();
}
setInterval(updateClosedOrders, 2000);

// ---END RESTAURANT SCRIPTS--- //