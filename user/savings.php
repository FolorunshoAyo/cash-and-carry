<?php
require(dirname(__DIR__) . '/auth-library/resources.php');
Auth::User("login");

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  <!-- DATATABLES CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css" />
  <!-- Custom Fonts (Inter) -->
  <link rel="stylesheet" href="../assets/fonts/fonts.css" />
  <!-- BASE CSS -->
  <link rel="stylesheet" href="../assets/css/base.css" />
  <!-- DASHBOARD MENU CSS -->
  <link rel="stylesheet" href="../assets/css/dashboard/user-dash-menu.css" />
  <!-- ITEMS PAGE STYLESHEET -->
  <link rel="stylesheet" href="../assets/css/dashboard/user-dash/savings.css">
  <!-- DASHHBOARD MEDIA QUERIES -->
  <link rel="stylesheet" href="../assets/css/media-queries/user-dash-mediaqueries.css" />
  <title>Savings - Halfcarry</title>
</head>

<body>
  <?php
  include("includes/mobile-sidebar.php");
  ?>
  <header>
    <div class="dash-header-container">
      <div class="menu-icon-container">
        <i class="fa fa-bars"></i>
      </div>
      <div class="header-navigation-container">
        <div class="dropdown">
          <a href="#" class="btn btn-secondary-outline dropdown-toggle header-link" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Browse
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </div>
        <div>
          <a class="header-link" href="#">Homepage</a>
        </div>
        <div>
          <a class="header-link" href="#">Help</a>
        </div>
      </div>
    </div>
  </header>
  <main>
    <div class="main-container">
      <?php
      include("includes/dashboard-navigation.php");
      ?>
      <div class="dashboard-main-section">
        <div class="dashboard-main-container">
          <h1 class="dashboard-main-title">Savings</h1>

          <div class="tabs-container">
            <div class="tab-link-container">
              <a href="javascript:void()" class="active">Active</a>
            </div>
            <div class="tab-link-container">
              <a href="javascript:void()">Requests</a>
            </div>
          </div>
          <div class="tab-container" id="tab-1">
            <div class="items-table-container">
              <table id="active-wallets-table">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Products</th>
                    <th>Current Balance</th>
                    <th>Target</th>
                    <th>Saved For</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>#239</td>
                    <td>
                      <div class="item-name-container">
                        <i class="fa fa-product-hunt"></i>
                        Nikon Dsir, Refrigerator, TV
                      </div>
                    </td>
                    <td>NGN 3,000</td>
                    <td>NGN 250,000</td>
                    <td>3 days</td>
                    <td>
                      <div class="action-container">
                        <button class="details-btn">View Wallet</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#239</td>
                    <td>
                      <div class="item-name-container">
                        <i class="fa fa-product-hunt"></i>
                        Nikon Dsir, Refrigerator, TV
                      </div>
                    </td>
                    <td>NGN 3,000</td>
                    <td>NGN 250,000</td>
                    <td>3 days</td>
                    <td>
                      <div class="action-container">
                        <button class="details-btn">View Wallet</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- <div class="view-btn-container">
              <button class="view-savings-btn">View Savings Plan</button>
            </div> -->
          </div>
          <div class="tab-container" id="tab-2" style="display: none;">
            <div class="items-table-container">
              <table id="requests-table">
                <thead>
                  <tr>
                    <th>Savings ID</th>
                    <th>Products</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Amount to save</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>#2001</td>
                    <td>
                      <div class="item-name-container">
                        <i class="fa fa-product-hunt"></i>
                        Nikon Dsir, Refrigerator, TV
                      </div>
                    </td>
                    <td>Active</td>
                    <td>1, 3, 2</td>
                    <td>NGN 250,000</td>
                    <td>
                      <div class="action-container">
                        <button class="details-btn">View Details</button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>#2001</td>
                    <td>
                      <div class="item-name-container">
                        <i class="fa fa-product-hunt"></i>
                        Nikon Dsir, Refrigerator, TV
                      </div>
                    </td>
                    <td>Active</td>
                    <td>1, 3, 2</td>
                    <td>NGN 250,000</td>
                    <td>
                      <div class="action-container">
                        <button class="details-btn">View Details</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- FONT AWESOME JIT SCRIPT-->
  <script src="https://kit.fontawesome.com/3ae896f9ec.js" crossorigin="anonymous"></script>
  <!-- JQUERY SCRIPT -->
  <script src="../assets/js/jquery/jquery-3.6.min.js"></script>
  <!-- JQUERY MIGRATE SCRIPT (FOR OLDER JQUERY PACKAGES SUPPORT)-->
  <script src="../assets/js/jquery/jquery-migrate-1.4.1.min.js"></script>
  <!-- JAVASCRIPT BUNDLER WITH POPPER -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  <!-- DATATABLES JAVASCRIPT -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
  <!-- CUSTOM DASHBOARD SCRIPT -->
  <script src="../assets/js/user-dash.js"></script>
  <script>
    $(function() {
      $("#requests-table").DataTable({
        "pageLength": 4,
      });

      $("#active-wallets-table").DataTable({
        "pageLength": 4,
      });
    });
  </script>
</body>

</html>