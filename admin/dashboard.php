<?php
session_start();
include('../db/connect.php');
if(!isset($_SESSION['admin'])){
   header("Location: login.php");
}else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="/orbs/stylesheet/bootstrap.min.css" rel="stylesheet">
    <script src="/orbs/script/jquery.min.js"></script>
    <link rel="stylesheet" href="/orbs/stylesheet/jquery-ui.css">
  <script src="/orbs/script/jquery-3.6.0.js"></script>
  <script src="/orbs/script/jquery-ui.js"></script>
  <link rel="stylesheet" href="/orbs/stylesheet/main.css"></link>
  <script src="dash.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-sm sticky-top bg-warning navbar-light">
  <div class="container-fluid">
      <a href="/orbs" class="navbar-brand">ORBS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navmenu">
          <ul class="navbar-nav ms-auto">
          <li class="nav-item">
                  <a class="nav-link" href="logout.php">Logout</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#" onclick="statusClicked()">Status</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#" onclick="restaurantsClicked()">Restaurants</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#" onclick="customersClicked()">Customers</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#" onclick="complaintsClicked()">Complaints</a>
              </li>
          </ul>
      </div>
  </div>
</nav>

<div class="tabs" id="status" style="display: none;">
<h3>Status</h3>
<hr>
<table class="table table-striped">
    <thead>
        <tr><th>#</th><th>Type</th><th>Count</th></tr>
    </thead>
    <tbody id="status-table-body">
    </tbody>
</table>
</div>

<div class="tabs" id="restaurants" style="display: none;"></div>

<div class="tabs" id="customers" style="display: none;"></div>

<div class="tabs" id="compaints" style="display: none;"></div>
<script>
  $(document).ready(function(){
    statusClicked();
  });
</script>
<script src="/orbs/script/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
}
?>