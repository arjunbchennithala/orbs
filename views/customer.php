<link rel="stylesheet" href="stylesheet/main.css">
    <script src="script/customer.js"></script>
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
              <li class="nav-item">
                  <a class="nav-link" id="home" href="#" onclick="homeClicked()">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#" onclick="ordersClicked()">Orders</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#" onclick="complaintsClicked()">Complaints</a>
              </li>
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

          </ul>
          <form class="d-flex" role="search" onsubmit="return search()">
        <input id="searchtext" class="form-control me-2" type="search" placeholder="Search restaurants" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>

      </div>
  </div>
</nav>
<!--<div id="container">-->
  <div class="content-pane container-fluid" id="search-result" style="display:none;">
  </div>


  <a class="btn btn-dark" id="back" onclick="backfromdetails()" style="display:none;" href="#">Back</a>
  <!--<div id="container">-->
  <div class="content-pane" id="orders">
    <h3>Orders</h3>
    <hr>
    <div id="content"></div>
  </div>

  <div class="content-pane" id="restaurant" style="display :none;">
  <a class="btn btn-dark" onclick="back()" href="#">Back</a>
  <h3>Menu</h3>
  <hr>
  <table class="table table-hover" id="menu-container">
  </table>
  </div>

  <div id="details" style="display: none;"></div>

  <div class="div-center" id="complaints" style="display: none">
    <div class="content">
                <h3>Complaints</h3>
                <hr>
                <form onsubmit="return complaints()">
                    <div class="form-group">
                        <label for="complaint">Your complaint</label>
                        <input type="textarea" class="form-control textarea" id="complaint" name="text" placeholder="Complaint">
                    </div> <br>
                    <br>
                    <button type="submit" class="btn btn-warning" name="submit-button">Submit</button>
                    <hr>
                </form>
            </div>
    </div>

  <div class="d-flex justify-content-center text-warning" id="loading" style="display :none;">
    <div class="spinner-border" role="status" id="spinner">
  <!--    <span class="visually-hidden">Loading...</span>-->
    </div>
  </div>
<!--</div>-->
<script>
  $(document).ready(function(){
    initiate();
  });
</script>
