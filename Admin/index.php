<?php
session_start();

if(!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo '<script>alert("กรุณาลงชื่อเข้าใช้งาน");</script>';
    echo '<script>window.location.href = "Login.php";</script>';
    exit;
}

?>
<?php 
  include "../Admin/ConnectDB.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Page</title>

    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />

    <!-- Font Awesome Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- AdminLTE CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/css/adminlte.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
  </head>
  <body
    class="sidebar-mini layout-fixed layout-navbar-fixed sidebar-open sidebar-collapse">
    <!-- Wrapper -->
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarToggle">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggle">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"
                ><i class="fas fa-bars"></i
              ></a>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <div
              class="user-panel mb-2 d-flex justify-content-center align-items-center ">
              <div class="info position-fixed top-0">
                <h2 class="d-block text-white "><a  href="./index.php" class="nav-link">Admin Page</a></h2>
              </div>
            </div>
            <ul
              class="nav nav-pills nav-sidebar flex-column"
              data-widget="treeview"
              role="menu">
              <li class="nav-item">
                <a class="nav-link" data-page="Menu">
                  <i class="nav-icon fas fa-utensils"></i>
                  <p>Menu</p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-page="MenuType">
                  <i class="nav-icon fas fa-list"></i>
                  <p>Menu Type</p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-page="OrderSale">
                  <i class="nav-icon fas fa-shopping-cart"></i>
                  <p>Order Sales</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" data-page="Member">
                  <i class="nav-icon fas fa-user"></i>
                  <p>Member</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="./Logout.php">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>Log Out</p>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </aside>

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Admin Page</h1>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Content -->
        <div class="content">
          <div class="container-fluid">
            <!-- Table Section -->
            <div class="row mt-3">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">ยอดขายวันนี้</h3>
                  </div>
                  <div class="card-body">
                    <i class="fa fa-coins"></i>
                    <?php 
                        $query = "SELECT SUM(sd.total_price) AS totalSales 
                                  FROM sales_details sd
                                  JOIN sales s ON sd.sale_id = s.sale_id
                                  WHERE DATE(s.sale_date) = CURDATE();";
                        $result = $conn->query($query);
                        $totalSalestd = $result->fetch_assoc()['totalSales'];
                        echo $totalSalestd . ' บาท';
                    ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">ยอดขายทั้งหมด</h3>
                  </div>
                  <div class="card-body">
                    <i class="fa fa-coins"></i>
                    <?php 
                        $totalSales = "SELECT SUM(total_price) as totalSales FROM sales_details";
                        echo $conn->query($totalSales)->fetch_assoc()['totalSales'];
                    ?> บาท
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body" id="tableBody">
                    <h1>รายการขายวันนี้</h1>
                    <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>Sale Id</th>
                                    <th>Menu name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Sale Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT s.sale_id, sd.menu_id, sd.quantity, sd.total_price, s.sale_date, menu.menu_name
                                        FROM sales s
                                        JOIN sales_details sd ON s.sale_id = sd.sale_id
                                        JOIN menu ON sd.menu_id = menu.menu_id
                                        WHERE DATE(s.sale_date) = CURDATE();";
                                
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['sale_id']}</td>";
                                    echo "<td>{$row['menu_name']}</td>";
                                    echo "<td>{$row['quantity']}</td>";
                                    echo "<td>{$row['total_price']}</td>";
                                    echo "<td>{$row['sale_date']}</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <footer class="main-footer">Footer</footer>
      </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/js/adminlte.min.js"></script>
  </body>

  <script>
    $(".nav-link").click(function () {
      var page = $(this).data("page");
      console.log("./Page/" + page + "_CRUD.php");
      $.ajax({
        url: "./Page/" + page + "_CRUD.php",
        method: "GET",
        success: function (data) {
          $("#tableBody").html(data);
        },
        error: function (err) {
          console.log("Error: ", err);
        },
      });
    });
  </script>
  
</html>
