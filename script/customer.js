function initiate() {
    $.get("order.php?action=fetch", function(data, status){
		$('#spinner').hide();
		$('#content').empty();
		if(status == "nocontent") {
			$('#content').append("<p>No Orders yet</p>");
		}else {
			$('#content').append("<table id='tb' class='table table-striped'></table>");
			$('#tb').append("<thead><tr><th>Sl.no</th><th>Restaurant</th><th>Order for</th><th>Price</th><th>Seats</th><th>Status</th><th>Ordered on</th></tr></thead>");
			$('#tb').append("<tbody id='table-bod'></tbody>");
			for(var i=0; i<data.length; i++) {
				$('#table-bod').append("<tr><td>"+(i+1)+"</td><td>"+data[i][8]+"</td><td>"+data[i][3]+"</td><td>"+data[i][4]+"</td><td>"+data[i][6]+"</td><td>"+data[i][7]+"</td><td>"+data[i][5]+"</td></tr>");
			}
		}
    });
}

function homeClicked() {
	if($('#search-result').children().length>0) {
		$('#orders').hide();
		$('#search-result').show();
	}
}

function ordersClicked() {
	$('#search-result').hide();
	$('#orders').show();
}

function search() {
	var text = $('#searchtext').val();
	if(text != '' && text != ' ') {
		$('#orders').hide();
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
		$('#restaurant').show();
		if(status == "nocontent") {
			$('#restaurant').append("<p>No Menu available</p>");
		}else{
			////Something here
		}
	});
}