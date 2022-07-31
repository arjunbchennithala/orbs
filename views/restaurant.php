    <link rel="stylesheet" href="stylesheet/main.css">
    <script src="script/restaurant.js"></script>
    <title>Home</title>
</head>
<body>
<nav class="navbar navbar-expand-sm sticky-top bg-warning navbar-light">
  <div class="container-fluid">
      <a href="#" class="navbar-brand">ORBS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navmenu">
          <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Account
          </a>
          <ul class="dropdown-menu">
            <li><?php echo "  Userid:".$_SESSION['userid'];?></li>
            <hr>
            <li><a class="dropdown-item" href="logout">Logout</a></li>
          </ul>
        </li>
              <li class="nav-item">
                  <a class="nav-link" href="#" onclick="requestsClicked()">Requests</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#" onclick="ordersClicked()">Orders</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#" onclick="menuClicked()">Menu</a>
              </li>
          </ul>
      </div>
  </div>
</nav>
    
<div class="content-pane" id="requests" style="display : none;">
    <h3>Requests</h3>
    <hr>
</div>

<div class="content-pane" id="orders">
</div>

<div class="content-pane" id="menu" style="display : none;">
    <h3>Menu</h3>
    <hr>
</div>

<div class="d-flex justify-content-center text-warning" id="loading" style="display :none;">
  <div class="spinner-border" role="status" id="spinner" style="display: none;">
  </div>
</div>

<script>
  $(document).ready(function(){
    initiate();
  });
</script>

 