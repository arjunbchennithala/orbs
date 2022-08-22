<link rel="stylesheet" href="stylesheet/main.css">
    <script src="script/restaurant.js"></script>
    <title>Restaurant</title>
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
              <li class="nav-item">
                  <a class="nav-link" href="#" onclick="reviewsClicked()">Reviews</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#" onclick="complaintsClicked()">Complaints</a>
              </li>
          </ul>
      </div>
  </div>
</nav>
    
<div id="container">
  <div class="content-pane" id="requests" style="display : none;">
      <h3>Requests</h3>
      <hr>
  </div>

  <div class="content-pane" id="orders">
  </div>

  <div class="content-pane" id="menu" style="display : none;">
      <h3>Menu</h3>
      <hr>
      <button class="btn btn-warning" onclick="addMenu()"><b>+</b> Add Menu</button>
      <div id="menu-display"></div>
  </div>
  <button class="btn btn-dark" id="back" onclick="clickedBack()" style="display : none"><- Back</button>
  <button class="btn btn-dark" id="backfromdetailsorders" onclick="clickedBackDetailsOrders()" style="display : none"><- Back</button>
  <button class="btn btn-dark" id="backfromdetailsrequests" onclick="clickedBackDetailsRequests()" style="display : none"><- Back</button>
  <div class="div-center" id="menuAdd" style="display: none">
            <div class="content">
                <h3>Add Menu</h3>
                <hr>
                <form onsubmit="return validateMenu()">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="textarea" class="form-control" id="description" name="description" placeholder="Description">
                    </div> <br>
                    <div class="form-group">
                        Price in Rs:
                        <input type="number" min="0" class="form-control" id="price" name="price">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-warning" name="submit-button">Add</button>
                    <hr>
                </form>
            </div>
        </div>
        <button class="btn btn-dark" id="back" onclick="clickedBack()" style="display : none"><- Back</button>
    <div class="div-center" id="menuEdit" style="display: none">
    <div class="content">
                <h3>Edit Menu</h3>
                <hr>
                <form onsubmit="return editMenu()">
                    <div class="form-group">
                        <label for="editname">Name</label>
                        <input type="text" class="form-control" id="editname" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="editdescription">Description</label>
                        <input type="textarea" class="form-control" id="editdescription" name="description" placeholder="Description">
                    </div> <br>
                    <div class="form-group">
                        Price in Rs:
                        <input type="number" min="0" class="form-control" id="editprice" name="price">
                    </div>
                    <br>
                    <input type="hidden" id="men_id" value="">
                    <button type="submit" class="btn btn-warning" name="submit-button">Edit</button>
                    <hr>
                </form>
            </div>
    </div>

    <div id="details"></div>

    <div class="div-center" id="complaints" style="display: none">
    <div class="content">
                <h3>Complaints</h3>
                <hr>
                <form onsubmit="return complaints()">
                    <div class="form-group">
                        <label for="complaint">Your complaint</label>
                        <input type="textarea" class="form-control" id="complaint" name="text" placeholder="Complaint">
                    </div> <br>
                    <br>
                    <button type="submit" class="btn btn-warning" name="submit-button">Submit</button>
                    <hr>
                </form>
            </div>
    </div>

    <div class="content-pane" id="reviews" style="display :none;">
    <div id="reviews-container"></div>
  </div>



  <div class="d-flex justify-content-center text-warning" id="loading" style="display :none;">
    <div class="spinner-border" role="status" id="spinner" style="display: none;">
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    initiate();
  });
</script>

 