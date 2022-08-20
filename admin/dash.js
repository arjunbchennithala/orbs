

function statusClicked() {
    $(".tabs").hide();
    $("#status").show();
    var names = ["Number of Restaurants", "Number of Customers", "Number of Orders", "Number of cancelled orders", "Number of rejected orders", "Number of accepted orders", "Number of confirmed orders"];
    $.get("../fetch.php?type=counts&skip=0", function(data, status){
        $("#status-table-body").empty();
        for(var i=0; i<data.length; i++) {
            $("#status-table-body").append("<tr><td>"+(i+1)+"</td><td>"+names[i]+"</td><td>"+data[i]+"</td></tr>")
        }
    });
}

function restaurantsClicked() {
    $('.tabs').hide();
    $('#restaurants').show();
    $('#restaurants').empty();
    $('#customers').empty();
    $('#restaurants').append('<form class="d-flex" role="search" onsubmit="return searchRestaurants()"><input id="searchtext" class="form-control me-2" type="search" placeholder="Search restaurants" aria-label="Search"><button class="btn btn-outline-success" type="submit">Search</button></form>');
    $('#restaurants').append("<div id='search-result'></div>");
    $.ajax({url:"/orbs/fetch.php?type=restaurants&skip=0", type:"get", complete:function(data){
        if(data.status == 204)
            $('#search-result').append("<h3>Restaurants</h3><hr><p>No restaurants</p>");
        else{
            $('#search-result').append("<h3>Restaurants</h3><hr><table class='table table-striped'><thead><tr><th>#</th><th>Rest ID</th><th>Name</th><th>Address</th><th>Email</th><th>Action</th></tr></thead><tbody id='search-table'></tbody></table>");
            for(var i=0; i<data.responseJSON.length; i++) {
                $('#search-table').append("<tr><td>"+(i+1)+"</td><td>"+data.responseJSON[i][0]+"</td><td>"+data.responseJSON[i][1]+"</td><td>"+data.responseJSON[i][2]+"</td><td>"+data.responseJSON[i][4]+"</td><td><button class='btn btn-danger' onclick='restaurantDeactivate("+data.responseJSON[i][0]+")'>Deactivate</button><button class='btn btn-warning' onclick='restaurantDetails("+data.responseJSON[i][0]+")'>Details</button></td></tr>");
            }
        }
    }});
}

function customersClicked() {
    $('.tabs').hide();
    $('#customers').show();
    $('#restaurants').empty();
    $('#customers').empty();
    $('#customers').append('<form class="d-flex" role="search" onsubmit="return searchCustomers()"><input id="searchtext" class="form-control me-2" type="search" placeholder="Search customers" aria-label="Search"><button class="btn btn-outline-success" type="submit">Search</button></form>');
    $('#customers').append("<div id='search-result'></div>");
    $.ajax({url:"/orbs/fetch.php?type=customers&skip=0", type:"get", complete:function(data){
        if(data.status == 204)
            $('#search-result').append("<h3>Customers</h3><hr><p>No Customers</p>");
        else{
            $('#search-result').append("<h3>Customers</h3><hr><table class='table table-striped'><thead><tr><th>#</th><th>Cust ID</th><th>Name</th><th>Dob</th><th>Email</th><th>Mobile Number</th><th>State</th><th>Action</th></tr></thead><tbody id='search-table'></tbody></table>");
            for(var i=0; i<data.responseJSON.length; i++) {
                $('#search-table').append("<tr><td>"+(i+1)+"</td><td>"+data.responseJSON[i][0]+"</td><td>"+data.responseJSON[i][1]+"</td><td>"+data.responseJSON[i][2]+"</td><td>"+data.responseJSON[i][3]+"</td><td>"+data.responseJSON[i][4]+"</td><td>"+data.responseJSON[i][5]+"</td><td><button class='btn btn-danger' onclick='customerDeactivate("+data.responseJSON[i][0]+")'>Deactivate</button></td></tr>");
            }
        }
    }});
}

function complaintsClicked() {
    $(".tabs").hide();
    $("#complaints").show();
    $.get("../fetch.php?type=complaints&skip=0", function(data, status){
        $('#complaints').empty();
        $('#complaints').append("<h3>Complaints</h3><hr>");
        if(status == "nocontent") {
            console.log("No Content");
            $('#complaints').append("<h5>No complaints</h5>");
        }else{
            //console.log(data);
            $('#complaints').append("<table class='table table-striped'><thead><tr><th>#</th><th>Complaint ID</th><th>User ID</th><th>User type</th><th>Date</th><th>Text</th><th>Action</th><tr></thead><tbody id='complaints-table-body'></tbody></table>");
            for(var i=0; i<data.length; i++)
                $('#complaints-table-body').append("<tr><td>"+(i+1)+"</td><td>"+data[i][0]+"</td><td>"+data[i][1]+"</td><td>"+data[i][2]+"</td><td>"+data[i][4]+"</td><td>"+data[i][3].substr(0, 5)+"...</td><td><button class='btn btn-danger' onclick='hideComplaint("+data[i][0]+")'>Hide</button><button class='btn btn-success' onclick='viewComplaint("+data[i][0]+")'>View</button></td></tr>");
        }
    });
}

function searchRestaurants() {
    var text = $('#searchtext').val();
    if(text == '')
        return false;
    $('#searchtext').val("");
    $.ajax({url:"/orbs/fetch.php?type=restaurants&skip=0&id="+text, type:"get", complete:function(data){
        $('#search-result').empty();
        if(data.status == 204)
            $('#search-result').append("<h3>Restaurants</h3><hr><p>No restaurants</p>");
        else{
            $('#search-result').append("<h3>Restaurants</h3><hr><table class='table table-striped'><thead><tr><th>#</th><th>Rest ID</th><th>Name</th><th>Address</th><th>Email</th><th>Action</th></tr></thead><tbody id='search-table'></tbody></table>");
            for(var i=0; i<data.responseJSON.length; i++) {
                $('#search-table').append("<tr><td>"+(i+1)+"</td><td>"+data.responseJSON[i][0]+"</td><td>"+data.responseJSON[i][1]+"</td><td>"+data.responseJSON[i][2]+"</td><td>"+data.responseJSON[i][4]+"</td><td><button class='btn btn-danger' onclick='restaurantDeactivate("+data.responseJSON[i][0]+")'>Deactivate</button><button class='btn btn-warning' onclick='restaurantDetails("+data.responseJSON[i][0]+")'>Details</button></td></tr>");
            }
        }
    }});
    return false;
}

function searchCustomers() {
    var text = $('#searchtext').val();
    if(text == '')
        return false;
    $('#searchtext').val("");
    $.ajax({url:"/orbs/fetch.php?type=customers&skip=0&id="+text, type:"get", complete:function(data){
        $('#search-result').empty();
        if(data.status == 204)
            $('#search-result').append("<h3>Customers</h3><hr><p>No Customers</p>");
        else{
            $('#search-result').append("<h3>Customers</h3><hr><table class='table table-striped'><thead><tr><th>#</th><th>Cust ID</th><th>Name</th><th>Dob</th><th>Email</th><th>Mobile Number</th><th>State</th><th>Action</th></tr></thead><tbody id='search-table'></tbody></table>");
            for(var i=0; i<data.responseJSON.length; i++) {
                $('#search-table').append("<tr><td>"+(i+1)+"</td><td>"+data.responseJSON[i][0]+"</td><td>"+data.responseJSON[i][1]+"</td><td>"+data.responseJSON[i][2]+"</td><td>"+data.responseJSON[i][3]+"</td><td>"+data.responseJSON[i][5]+"</td><td><button class='btn btn-danger' onclick='customerDeactivate("+data.responseJSON[i][0]+")'>Deactivate</button></td></tr>");
            }
        }
    }});
    return false;
}

function hideComplaint(comp_id) {
    $.ajax({url:"../complaints.php?action=hide&comp_id="+comp_id, type:"get", complete:function(){
        complaintsClicked();
    }});
}

function viewComplaint(comp_id) {
    $.ajax({url:"../fetch.php?type=complaints&skip=0&comp_id="+comp_id, type:"get", complete:function(data, status){
        console.log(data);
        $('#complaints').empty();
        $('#complaints').append("<h3>Complaint</h3><br><button class='btn btn-dark' onclick='complaintsClicked()'>Back</button><hr>");
        $('#complaints').append("<h5>Complaint ID : "+data.responseJSON[0][0]+"</h5>");
        $('#complaints').append("<h5>User ID : "+data.responseJSON[0][1]+"</h5>");
        $('#complaints').append("<h5>User Type : "+data.responseJSON[0][2]+"</h5>");
        $('#complaints').append("<h5>Posted Date : "+data.responseJSON[0][4]+"</h5>");
        $('#complaints').append("<h5>Text:</h5>");
        $('#complaints').append("<h4>"+data.responseJSON[0][3]+"</h4>");
    }});
}

function customerDeactivate(cust_id) {

}

function restaurantDeactivate(rest_id) {

}

function restaurantDetails(rest_id) {
    
}
