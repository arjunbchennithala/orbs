function initiate() {
    $('#spinner').show();
    $.get("order.php?filter=accepted", function(data, status){
        $('#spinner').hide();
        $('#orders').show();
        $('#details').hide();
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
    $('#reviews').hide();
    $('#menuAdd').hide();
    $('#details').hide();
    $('#backfromdetailsorders').hide();
	$('#backfromdetailsrequests').hide();
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
    $('#details').hide();
    $('#backfromdetailsorders').hide();
	$('#backfromdetailsrequests').hide();
    $('#complaints').hide();
    $('#menu').hide();
    $('#reviews').hide();
    $('#menuEdit').hide();
    $('#back').hide();
    $('#menuAdd').hide();
    initiate();
}

function complaintsClicked() {
    $('#requests').hide();
    $('#reviews').hide();
    $('#details').hide();
    $('#backfromdetailsorders').hide();
	$('#backfromdetailsrequests').hide();
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
    $('#details').hide();
    $('#backfromdetailsorders').hide();
	$('#backfromdetailsrequests').hide();
    $('#menuAdd').hide();
    $('#reviews').hide();
    $('#menuEdit').hide();
    $('#back').hide();
    $('#spinner').show();
    $('#menu').show();
    $.ajax({url:"menu.php?type=fetch", success:function(data, status){
        $('#spinner').hide();
        $('#menu-display').empty();
        $('#menu-display').append("<table class='table table-striped'><thead><tr><th>#</th><th>Photo</th><th>Name</th><th>Description</th><th>Price</th><th>State</th><th>Action</th></tr></thead><tbody id='menu-table' ></tbody></table>")
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
            $('#menu-table').append("<tr><td>"+(i+1)+"</td><td><img src='/orbs/uploads/photos/restaurant/menu/"+data[i][3]+"' height='100px'></img></td><td>"+data[i][2]+"</td><td>"+data[i][4]+"</td><td>"+data[i][5]+"</td><td>"+data[i][6]+"</td><td><button class='"+$buttonClass+"' onclick='"+$action+"'>"+$actionString+"</button><button class='btn btn-warning' onclick='clickedMenuEdit("+data[i][0]+")'>Edit</button></td></tr>")
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
    $('#reviews').hide();
    $('#details').hide();
    $('#menuEdit').hide();
    $('#menu').hide();
    $('#menuAdd').show();
    $('#back').show();
    
}

function validateMenu(fm) {
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
        //const det = $('#menudetails-add');
        const frm = new FormData(fm);
        $.ajax({url:"menu.php?type=add", method:"post", contentType: false,cache: false,processData:false, data:frm/*JSON.stringify(req)*/, statusCode:{500:function(){
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
    $('#reviews').hide();
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
        $('#reviews').hide();
        $('#requests').hide();
        $('#backfromdetailsrequests').hide();
		$('#details').show();
		$('#backfromdetailsorders').show();
		$('#details').empty();
		$('#details').append("<table class='table'><thead><th>#</th><th>Photo</th><th>Name</th><th>Description</th><th>Quanity</th></thead><tbody id='table-bodyy'></tbody></table>");
		for(var i=0; i<data.responseJSON.length; i++){
			$('#table-bodyy').append("<tr><td>"+(i+1)+"</td><td><img src='/orbs/uploads/photos/restaurant/menu/"+data.responseJSON[i][0][3]+"' height='100px'></img></td><td>"+data.responseJSON[i][0][2]+"</td><td>"+data.responseJSON[i][0][4]+"</td><td>"+data.responseJSON[i][0][7]+"</td></tr>")
		}
	}});
}

function requestDetails(order_id) {
    $('#spinner').show();
    $.ajax({url:"order.php?action=orderedmenu&order_id="+order_id, complete:function(data, status){
		$('#spinner').hide();
		$('#orders').hide();
        $('#requests').hide();
        $('#reviews').hide();
		$('#details').show();
        $('#backfromdetailsorders').hide();
		$('#backfromdetailsrequests').show();
		$('#details').empty();
		$('#details').append("<table class='table'><thead><th>#</th><th>Photo</th><th>Name</th><th>Description</th><th>Quanity</th></thead><tbody id='table-bodyy'></tbody></table>");
		for(var i=0; i<data.responseJSON.length; i++){
			$('#table-bodyy').append("<tr><td>"+(i+1)+"</td><td><img src='/orbs/uploads/photos/restaurant/menu/"+data.responseJSON[i][0][3]+"' height='100px'></img></td><td>"+data.responseJSON[i][0][2]+"</td><td>"+data.responseJSON[i][0][4]+"</td><td>"+data.responseJSON[i][0][7]+"</td></tr>")
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

function reviewsClicked() {
    $('#spinner').show();
    $('#requests').hide();
    $('#menu').hide();
    $('#menuEdit').hide();
    $('#details').hide();
    $('#backfromdetailsorders').hide();
	$('#backfromdetailsrequests').hide();
    $('#orders').hide();
    $('#back').hide();
    $('#menuAdd').hide();
    $('#complaints').hide();
    $('#reviews').show();

    $('#reviews-container').empty();
    $.ajax({url:"review.php?type=fetchself", complete:(data2)=>{
        $('#spinner').hide();
        if(data2.status == 204)
            $('#reviews-container').append("<h5>No reviews</h5>");
        else {

            $('#reviews-container').append("<div id='review-container'></div>");
            for(var i=0; i<data2.responseJSON.length; i++) {
                var cust_id = data2.responseJSON[i].cust_id;
                //var text = data2.responseJSON[i].text;
                var counter = 0;
                $.ajax({url:"/orbs/accounts.php?type=customer&id="+cust_id, complete:(data3)=>{
                    //console.log("Data3:");
                    //console.log(JSON.parse(data3.responseText)[0]);
                    data3 = JSON.parse(data3.responseText)[0];
                    $('#review-container').append('<hr><img class="review-photo" width="50px" src="/orbs/uploads/photos/customer/profile/'+data3.profile_photo+'"></img>');
                    $('#review-container').append("<span class='review-name'>"+data3.name+"</span>");
                    //console.log(data2);
                    $('#review-container').append("<p class='review-text'>"+data2.responseJSON[counter].text+"</p>");
                    counter++;
                }});
                
            }
        }
    }});
}
