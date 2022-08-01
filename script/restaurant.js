function initiate() {
    $('#spinner').show();
    $.get("order.php?filter=accepted", function(data, status){
        $('#spinner').hide();
        $('#orders').show();
        $('#orders').empty();
        if(status == "nocontent")
            $('#orders').append('<h3>Orders</h3><hr><p>No orders</p>');
        else {
            $('#orders').append("<h3>Orders</h3><hr><table class='table table-striped'><thead><tr><th>#</th><th>Customer ID</th><th>Date&time</th><th>Seats</th><th>Price</th><th>Confirmation</th></tr></thead><tbody id='order-table'></tbody><table>");
            for(var i=0; i<data.length; i++) {
                console.log("somethin");
                $('#order-table').append("<tr><td>"+(i+1)+"</td><td>"+data[i][1]+"</td><td>"+data[i][3]+"</td><td>"+data[i][6]+"</td><td>"+data[i][4]+"</td><td><button class='btn btn-success' onclick='confirmOrder("+data[i][0]+")'>Confirm</button></td></tr>")
            }
        }
    
    });
}

function requestsClicked() {
    $('#orders').hide();
    $('#menu').hide();
    $('#spinner').show();
    $.get("order.php?filter=requested", function(data, status){
        $('#spinner').hide();
        $('#requests').show();
        $('#requests').empty();
        if(status == "nocontent") 
            $('#requests').append("<h3>Requests</h3><hr><p>No Requests</p>");
        else {
            $('#requests').append("<h3>Requests</h3><hr><table class='table table-striped'><thead><tr><th>#</th><th>Customer ID</th><th>Date&time</th><th>Seats</th><th>Price</th><th colspan='2' >Action</th></tr></thead><tbody id='td'></tbody><table>");
            for(var i=0; i<data.length; i++) {
                $('#td').append("<tr><td>"+(i+1)+"</td><td>"+data[i][1]+"</td><td>"+data[i][3]+"</td><td>"+data[i][6]+"</td><td>"+data[i][4]+"</td><td><a href='#' class='btn btn-success' onclick='acceptOrder("+data[i][0]+")'>Accept</a><a href='#' class='btn btn-warning' onclick='rejectOrder("+data[i][0]+")'>Reject</a></td></tr>")
            }
        }
    });
}

function ordersClicked() {
    $('#requests').hide();
    $('#menu').hide();
    initiate();
}

function menuClicked() {

}

function confirmOrder(order_id) {
    $.ajax({url : "order.php?action=confirm&order_id="+order_id, complete:function(){
        ordersClicked();
    }});
}

function acceptOrder(order_id) {
    $.ajax({url : "order.php?action=accept&order_id="+order_id, complete:function(){
        requestsClicked();
    }});
}

function rejectOrder(order_id) {
    $.ajax({url : "order.php?action=reject&order_id="+order_id, complete:function(){
        requestsClicked();
    }});
}