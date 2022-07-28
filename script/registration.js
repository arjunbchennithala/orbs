function validateCustomerForm() {
    return true;
}

function validateRestaurantForm() {
    return true;
}



function account_change() {
    /*
    var value = $('#account-select').val();
    if(value == "customer") {
        $('#customer').show();
    }else if(value == "restaurant") {
        $('#restaurant').show();
    }
    */
   var value = document.getElementById('selection').value;
   if(value == "customer") {
       document.getElementById('customer').style = "diplay: block";
   }else if(value == "restaurant") {
        document.getElementById('restaurant').style = "diplay: block";
    }
}