

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
        if(status == "nocontent") {
            console.log("No Content");
            $('#complaints').append("<h3>No complaints</h3>");
        }else{
            console.log(data);
            $('#complaints').append("<table></table>");
        }
    });
}