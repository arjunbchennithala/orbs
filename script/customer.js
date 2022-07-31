function initiate() {
	$('#spinner').show();
    $.get("order.php?action=fetch", function(data, status){
		$('#spinner').hide();
		$('#content').empty();
		if(status == "nocontent") {
			$('#content').append("<p>No Orders yet</p>");
		}else {
			$('#content').append("<table id='tb' class='table table-striped'></table>");
			$('#tb').append("<thead><tr><th>Sl.no</th><th>Restaurant</th><th>Order for</th><th>Price</th><th>Seats</th><th>Status</th><th>Ordered on</th><th>Action</th></tr></thead>");
			$('#tb').append("<tbody id='table-bod'></tbody>");
			var index=1;
			for(var i=0; i<data.length; i++) {
				if(data[i][7] == 'requested')
					$('#table-bod').append("<tr><td>"+index+"</td><td>"+data[i][8]+"</td><td>"+data[i][3]+"</td><td>"+data[i][4]+"</td><td>"+data[i][6]+"</td><td>"+data[i][7]+"</td><td>"+data[i][5]+"</td><td><a href='#' class='btn btn-danger' onclick='cancelOrder("+data[i][0]+")'>Cancel</a></td></tr>");
				else if(data[i][7] == 'accepted')
					$('#table-bod').append("<tr><td>"+index+"</td><td>"+data[i][8]+"</td><td>"+data[i][3]+"</td><td>"+data[i][4]+"</td><td>"+data[i][6]+"</td><td>"+data[i][7]+"</td><td>"+data[i][5]+"</td><td><a href='#' class='btn btn-success' onclick='payOrder("+data[i][0]+")'>Pay</a></td></tr>");
				else if(data[i][7] != 'hidden')
					$('#table-bod').append("<tr><td>"+index+"</td><td>"+data[i][8]+"</td><td>"+data[i][3]+"</td><td>"+data[i][4]+"</td><td>"+data[i][6]+"</td><td>"+data[i][7]+"</td><td>"+data[i][5]+"</td><td><a href='#' class='btn btn-warning' onclick='hideOrder("+data[i][0]+")'>Hide</a></td></tr>");
				if(data[i][7] == 'hidden')
					continue;
				index++;
			}
		}
    });
}

function homeClicked() {
	if($('#search-result').children().length>0) {
		$('#orders').hide();
		$('#search-result').show();
	}
	$('#restaurant').hide();
}

function ordersClicked() {
	$('#search-result').hide();
	$('#restaurant').hide();
	initiate();
	$('#orders').show();
}

function search() {
	var text = $('#searchtext').val();
	if(text != '' && text != ' ') {
		$('#orders').hide();
		$('#restaurant').hide();
		$('#spinner').show();
		$.get("search.php?type=restaurant&query="+text, function(data, status){
			$('#spinner').hide();
			$('#search-result').empty();
			$('#search-result').show();
			$('#search-result').append("<h3>Restaurants</h3><hr><div class='row' id='row'></div>");
			if(status == "nocontent") {
				$('#row').append("<p>No result</p>");
			}else{
				//$('#search-result').append("<p>"+data+"</p>");
				for(var i=0; i<data.length; i++) {
					var content = '<div class="col-sm-3"><div class="card" style="width: 18rem;"><img class="card-img-top" src="..." alt="Card image cap"><div class="card-body"><h5 class="card-title">'+data[i][1]+'</h5><p class="card-text">'+data[i][2]+'</p><a href="#" onclick="checkRestaurant('+data[i][0]+')" class="btn btn-warning">Check</a></div></div></div>';
					$('#row').append(content);
				}				
			}
		});
	}
	return false;
}

function checkRestaurant(rest_id) {
	$('#spinner').show();
	$('#orders').hide();
	$('#search-result').hide();
	$.get("menu.php?restid="+rest_id, function(data, status){
		$('#spinner').hide();
		$('#menu-container').empty();
		$('#restaurant').show();
		if(status == "nocontent") {
			$('#menu-container').append("<p>No menu available</p>");
		}else{
			var content = '<thead><tr><th>#</th><th>Name</th><th>Description</th><th>Price</th><th>Count</th></tr></thead><tbody id="menu-tb"></tbody>';
			$('#menu-container').append(content);
			for(var i=0; i<data.length; i++) {
				var content = '<tr><td>'+(i+1)+'</td><td>'+data[i][2]+'</td><td>'+data[i][3]+'</td><td>'+data[i][4]+'</td><td><input type="number" onchange="changeCount()" min="0" id="'+data[i][0]+'-'+data[i][4]+'" style="width:100px" class="form-control count" placeholder="Count"></td></tr>';
				$('#menu-tb').append(content);
			}
			var content = 'No of seats you need<input type="number" min="0" style="width:200px" class="form-control" id="no-of-seats" value="1" placeholder="No of Seats"><br>Date for the event<input class="form-control" type="date" id="date"><br>Time for the event<input class="form-control" type="time" id="time"><div id="price-print"></div>';
			$('#menu-container').append(content);
			var content = '<br><a href="#" class="btn btn-warning" onclick="placeOrder('+rest_id+')">Place Order</a>';
			$('#menu-container').append(content);
		}
	});
}

function back() {
	$('#restaurant').hide();
	$('#search-result').show();
}

function placeOrder(rest_id) {
	var children = $('#menu-tb').children();
	const item = [];
	const price = [];
	const count = [];
	var seats;
	for(var i=0; i<children.length; i++) {
		var id = children[i].children[4].firstChild.id;
		var splitted = id.split('-');
		item[i] = parseInt(splitted[0]);
		price[i] = parseInt(splitted[1]);
		var val = children[i].children[4].firstChild.value;
		if( val == '' || val == '0' ){
			count[i] = 0;
		}else{
			count[i] = parseInt(val);
		}
	}
	seats = parseInt($('#no-of-seats')[0].value);
	var date = $('#date')[0].value;
	var time = $('#time')[0].value;
	var total = 0;
	for(var i=0; i<children.length; i++) {
		total += price[i] * count[i];
	}
	if(seats == 0 || total == 0 || date == '' || time == '') {
		alert("Fields cannot be empty");
	}else{
		const prereq = [];
		var counter = 0;
		for(var i=0; i<item.length; i++) {
			if(count[i] == 0)
				continue;
			else{
				prereq[counter] = [item[i], count[i]];
				counter++;
			}
		}
		const req = {
			"details" : {
				"rest_id" : rest_id,
				"time" : date + " " +  time + ":00", 
				"seats" : seats
			},
			"item" : prereq
		};
		$.post('order.php?action=place', JSON.stringify(req), function(data, status){
			document.write(data + status);
		});
	}
}

function changeCount() {
	var children = $('#menu-tb').children();
	const price = [];
	const count = [];
	var seats;
	for(var i=0; i<children.length; i++) {
		var id = children[i].children[4].firstChild.id;
		var splitted = id.split('-');
		price[i] = parseInt(splitted[1]);
		var val = children[i].children[4].firstChild.value;
		if( val == '' || val == '0' ){
			count[i] = 0;
		}else{
			count[i] = parseInt(val);
		}
	}
	var total = 0;
	for(var i=0; i<children.length; i++) {
		total += price[i] * count[i];
	}
	$('#price-print').empty();
	$('#price-print').append("<b>Total Price : " + total + "</b>");
}

function payOrder(order_id) {
	console.log("something");
}

function cancelOrder(order_id) {
	//$('#spinner').show();
	$.get("order.php?action=cancel&order_id="+order_id, function(data, status) {
		//$('#spinner').hide();
		document.write(data + status);
		if(status == "created") {
			console.log("Canceled");
		}else{
			console.log("failed to cancel");
		}
		initiate();
		console.log(data + status);
	});
}

function hideOrder(order_id) {
	$.get("order.php?action=hide&order_id="+order_id, function(data, status){
		document.write(data + status);
		initiate();
		console.log(data+status);
	});
}