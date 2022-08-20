function initiate() {
    $('#spinner').show();
    $.get("order.php?filter=accepted", function(data, status){
        $('#spinner').hide();
        $('#orders').show();
        $('#orders').empty();
        if(status == "nocontent")
            $('#orders').append('<h3>Orders</h3><hr><p>No orders</p>');
        else {
            $('#orders').append("<h3>Orders</h3><hr><table class='table table-hover'><thead><tr><th>#</th><th>Order ID</th><th>Customer ID</th><th>Date&time</th><th>Seats</th><th>Price</th><th>Confirmation</th></tr></thead><tbody id='order-table'></tbody><table>");
            for(var i=0; i<data.length; i++) {
                $('#order-table').append("<tr><td>"+(i+1)+"</td><td>"+data[i][0]+"</td><td>"+data[i][1]+"</td><td>"+data[i][3]+"</td><td>"+data[i][6]+"</td><td>"+data[i][4]+"</td><td><button class='btn btn-warning' onclick='confirmOrder("+data[i][0]+")'>Confirm</button><button class='btn btn-success' onclick='orderDetails("+data[i][0]+")'>Details</button></td></tr>")
            }
        }
    
    });
}

function requestsClicked() {
    $('#orders').hide();
    $('#complaints').hide();
    $('#menu').hide();
    $('#menuAdd').hide();
    $('#menuEdit').hide();
    $('#back').hide();
    $('#spinner').show();
    $.get("order.php?filter=requested", function(data, status){
        $('#spinner').hide();
        $('#requests').show();
        $('#requests').empty();
        if(status == "nocontent") 
            $('#requests').append("<h3>Requests</h3><hr><p>No Requests</p>");
        else {
            $('#requests').append("<h3>Requests</h3><hr><table class='table table-hover'><thead><tr><th>#</th><th>Order ID</th><th>Customer ID</th><th>Date&time</th><th>Seats</th><th>Price</th><th colspan='2' >Action</th></tr></thead><tbody id='td'></tbody><table>");
            for(var i=0; i<data.length; i++) {
                $('#td').append("<tr><td>"+(i+1)+"</td><td>"+data[i][0]+"</td><td>"+data[i][1]+"</td><td>"+data[i][3]+"</td><td>"+data[i][6]+"</td><td>"+data[i][4]+"</td><td><a href='#' class='btn btn-success' onclick='acceptOrder("+data[i][0]+")'>Accept</a><a href='#' class='btn btn-warning' onclick='rejectOrder("+data[i][0]+")'>Reject</a><button class='btn btn-success' onclick='requestDetails("+data[i][0]+")'>Details</button></td></tr>")
            }
        }
    });
}

function ordersClicked() {
    $('#requests').hide();
    $('#complaints').hide();
    $('#menu').hide();
    $('#menuEdit').hide();
    $('#back').hide();
    $('#menuAdd').hide();
    initiate();
}

function complaintsClicked() {
    $('#requests').hide();
    $('#menu').hide();
    $('#menuEdit').hide();
    $('#orders').hide();
    $('#back').hide();
    $('#menuAdd').hide();
    $('#complaints').show();
}

function menuClicked() {
    $('#requests').hide();
    $('#orders').hide();
    $('#complaints').hide();
    $('#menuAdd').hide();
    $('#menuEdit').hide();
    $('#back').hide();
    $('#spinner').show();
    $('#menu').show();
    $.ajax({url:"menu.php?type=fetch", success:function(data, status){
        $('#spinner').hide();
        $('#menu-display').empty();
        $('#menu-display').append("<table class='table table-striped'><thead><tr><th>#</th><th>Name</th><th>Description</th><th>Price</th><th>State</th><th>Action</th></tr></thead><tbody id='menu-table' ></tbody></table>")
        for(var i=0; i<data.length; i++) {
            if(data[i][6] == 'available') {
                $action = "hideMenu(" + data[i][0] +")";
                $actionString = "Hide";
                $buttonClass = "btn btn-warning";
            }else{
                $action = "unhideMenu(" + data[i][0] + ")";
                $actionString = "Show";
                $buttonClass = "btn btn-success";
            }
            $('#menu-table').append("<tr><td>"+(i+1)+"</td><td>"+data[i][2]+"</td><td>"+data[i][4]+"</td><td>"+data[i][5]+"</td><td>"+data[i][6]+"</td><td><button class='"+$buttonClass+"' onclick='"+$action+"'>"+$actionString+"</button><button class='btn btn-warning' onclick='clickedMenuEdit("+data[i][0]+")'>Edit</button></td></tr>")
        }
    }, error:function(){
        $('#spinner').hide();
        $('#menu-display').empty();
        $('#menu-display').append("<p>No Menu items</p>");
    }});
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

function hideMenu(menu_id) {
    $.ajax({url:"menu.php?type=hide&menuid="+menu_id, complete:function(){
        menuClicked();
    }});
}

function unhideMenu(menu_id) {
    $.ajax({url:"menu.php?type=unhide&menuid="+menu_id, complete:function(){
        menuClicked();
    }});
}

function addMenu() {
    $('#requests').hide();
    $('#orders').hide();

    $('#menuEdit').hide();
    $('#menu').hide();
    $('#menuAdd').show();
    $('#back').show();
    
}

function validateMenu() {
    var name = $('#name').val();
    var description = $('#description').val();
    var price = $('#price').val();
    if(name == '' || description == '' || price == ''){
        alert("Inputs cannot be empty..");
    }else{
        const req = {"name":name, 
            "description":description,
            "price":parseInt(price)
        };
        $.ajax({url:"menu.php?type=add", method:"post", data:JSON.stringify(req), statusCode:{500:function(){
            alert("Not created");
        }, 201: function() {
            menuClicked();
        }}});
    }
    return false;
}

function clickedBack() {
   menuClicked();
}
var menuValues;
function clickedMenuEdit(menu_id) {
    $('#menu').hide();
    $('#back').show();
    $('#menuEdit').show();
    $.get("menu.php?type=fetch&menu_id="+menu_id, function(data, status){
        $('#editname').val(data[0][2]);
        $('#editdescription').val(data[0][4]);
        $('#editprice').val(data[0][5]);
        $('#men_id').val(data[0][0]);
        menuValues = {"name":data[0][2], "description" : data[0][4], "price" : data[0][5]};
    });
}

function editMenu() {
    if($('#editname').val() == menuValues["name"] )
        var name = '';
    else
        var name = $('#editname').val();
    if($('#editdescription').val() == menuValues["description"]) 
        var description = '';
    else
        var description = $('#editdescription').val();
    if($('#editprice').val() == menuValues["price"]) 
        var price = '';
    else
        var price = $('#editprice').val();

    if(name == '' && description == '' && price == '')
        alert("No changes");
    else {
        var menu_id = $('#men_id').val();
        var values = {"name" : name, "description" : description, "price" : price};
        $.ajax({url:"menu.php?type=edit&menuid="+menu_id, data:JSON.stringify(values), type:"post", complete:function(){
            menuClicked();
        }});
    }
    return false;
}


function orderDetails(order_id) {
    $('#spinner').show();
    $.ajax({url:"order.php?action=orderedmenu&order_id="+order_id, complete:function(data, status){
		$('#spinner').hide();
		$('#orders').hide();
        $('#requests').hide();
		$('#details').show();
		$('#backfromdetailsorders').show();
		$('#details').empty();
		$('#details').append("<table class='table'><thead><th>#</th><th>Name</th><th>Description</th><th>Quanity</th></thead><tbody id='table-bodyy'></tbody></table>");
		for(var i=0; i<data.responseJSON.length; i++){
			$('#table-bodyy').append("<tr><td>"+(i+1)+"</td><td>"+data.responseJSON[i][0][2]+"</td><td>"+data.responseJSON[i][0][4]+"</td><td>"+data.responseJSON[i][0][7]+"</td></tr>")
		}
	}});
}

function requestDetails(order_id) {
    $('#spinner').show();
    $.ajax({url:"order.php?action=orderedmenu&order_id="+order_id, complete:function(data, status){
		$('#spinner').hide();
		$('#orders').hide();
        $('#requests').hide();
		$('#details').show();
		$('#backfromdetailsrequests').show();
		$('#details').empty();
		$('#details').append("<table class='table'><thead><th>#</th><th>Name</th><th>Description</th><th>Quanity</th></thead><tbody id='table-bodyy'></tbody></table>");
		for(var i=0; i<data.responseJSON.length; i++){
			$('#table-bodyy').append("<tr><td>"+(i+1)+"</td><td>"+data.responseJSON[i][0][2]+"</td><td>"+data.responseJSON[i][0][4]+"</td><td>"+data.responseJSON[i][0][7]+"</td></tr>")
		}
	}});
}

function clickedBackDetailsOrders() {
    $('#backfromdetailsorders').hide();
    $('#details').hide();
    ordersClicked();
}

function clickedBackDetailsRequests() {
    $('#backfromdetailsrequests').hide();
    $('#details').hide();
    requestsClicked();
}

function complaints() {
	var text = $('#complaint').val();
	$('#complaint').val("");
	if(text != "") {
		$('#spinner').show();
		$.ajax({url:"complaints.php?post", type:"post", data:text, complete:function(data){
			$('#spinner').hide();
			if(data.status == 201){
				alert("Your complaint has been recorded..");
				ordersClicked();
			}
			else
				alert("Complaint is not submitted");
		} });
	}
	return false;
}