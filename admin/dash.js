

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

}

function customersClicked() {

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
        $('#complaints').append("<p><b>"+data.responseJSON[0][3]+"<b></p>");
    }});
}