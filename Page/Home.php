<?php
session_start();
include "../Database/connectDB.php";
include "../Admin/Libary.html";
$sql = "SELECT menu.*, AVG(rating.score) AS average_score
        FROM menu
        LEFT JOIN rating ON menu.menu_id = rating.menu_id
        GROUP BY menu.menu_id
        ORDER BY average_score DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Project Website</title>
  </head>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai&family=Prompt&display=swap");
    * {
      font-family: "IBM Plex Sans Thai", sans-serif;
    }
    .banner-image {
      position: relative;
      height: 500px;
    }

    .banner-content {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
    }

  </style>
  <body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-white sticky-top navbar-light p-3 shadow-sm">
      <div class="container">
          <a class="navbar-brand" href="../index.php">
              <i class="fa-solid fa-shop me-2"></i> <strong>KAJXN CAFE</strong>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                      <a class="nav-link mx-2 text-uppercase page-link menu-type-btn" href="./Home.php">เมนูทางร้าน</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link mx-2 text-uppercase page-link" data-page="Contact">ติดต่อ</a>
                  </li>
              </ul>
              <ul class="navbar-nav ms-auto">
                  <li class="nav-item position-relative">
                      <a class="nav-link mx-2 text-uppercase" href="cart-list.php">
                          <i class="fa-solid fa-cart-shopping me-1"></i>
                          <span class="position-absolute top-0 end-10 translate-middle badge rounded-pill bg-danger">
                              <div id="cart-count">0</div>
                          </span>
                      </a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>
  <!-- End Navbar -->


    <!-- Content Section -->
    <div class="container content-section mt-5" id="content">
        <h2 class="text-center mb-4">เมนูทั้งหมด</h2>
        <div class="d-flex justify-content-center align-items-center gap-2">
          <?php
            $sqlMenuTypes = "SELECT * FROM menutype";
            $resultMenuTypes = $conn->query($sqlMenuTypes);
            while ($rowMenuType = $resultMenuTypes->fetch_assoc()) {
                $activeClass = ($rowMenuType['typeId'] == 1) ? 'active' : '';
                echo "<button class='btn btn-primary menu-type-btn $activeClass' data-type='{$rowMenuType['typeId']}'>{$rowMenuType['typeName']}</button>";
            }
          ?>
        </div>
        <div class="row">
            <?php
              while ($row = $result->fetch_assoc()) {
                  $rating = round($row['average_score']);
                  ?>
                  <div class="col-md-4 mt-3">
                      <div class="card menu-card h-100" id="menuCard<?= $row['menu_id'] ?>">
                          <img src="../Admin/<?= $row['image_url'] ?>" class="card-img-top" alt="<?= $row['menu_name'] ?>" />
                          <div class="card-body">
                              <h5 class="card-title text-primary"><?= $row['menu_name'] ?></h5>
                              <p class="card-text">ราคา <?= $row['price'] ?> บาท</p>
                              <div class="d-flex justify-content-between align-items-center">
                                  <p class="card-text">คะแนน:
                                      <?php
                                      for ($i = 1; $i <= 5; $i++) {
                                          if ($i <= $rating) {
                                              echo '<i class="fas fa-star text-warning"></i>';
                                          } else {
                                              echo '<i class="far fa-star text-warning"></i>';
                                          }
                                      }
                                      ?>
                                  </p>
                              </div>
                              <div class="d-flex justify-content-between mt-3">
                                  <a class="btn btn-primary order-btn" href="#" role="button" data-menu-id="<?= $row['menu_id'] ?>">
                                    <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
                                  </a>
                                  <a class="btn btn-secondary review-btn" data-menu-id="<?= $row['menu_id'] ?>" role="button">
                                    <i class="far fa-comment me-1"></i> Review
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
              <?php } ?>
        </div>
    </div>
    <!-- End Content Section -->

    <!-- Modal review -->
    <div class="modal fade" id="review-modal" tabindex="-1" aria-labelledby="review-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="review-modalLabel">ข้อมูลการรีวิว</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal review -->


    <!-- Footer -->
    <div class="container">
      <footer
        class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
          <a
            href="/"
            class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
            <svg class="bi" width="30" height="24">
              <use xlink:href="#bootstrap"></use>
            </svg>
          </a>
          <span class="mb-3 mb-md-0 text-body-secondary"
            >© 2023 Dev , kajonsak leepongkul</span
          >
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
          <li class="ms-3">
            <a class="text-body-secondary" href="#"
              ><i class="fa-brands fa-facebook"></i
            ></a>
          </li>
          <li class="ms-3">
            <a class="text-body-secondary" href="#"
              ><i class="fa-brands fa-instagram"></i
            ></a>
          </li>
          <li class="ms-3">
            <a class="text-body-secondary" href="#"
              ><i class="fa-solid fa-envelope"></i
            ></a>
          </li>
        </ul>
      </footer>
    </div>
    <!-- End Footer -->
  </body>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$('.menu-type-btn').click(function () {
    $('.menu-type-btn').removeClass('active');
    $(this).addClass('active');
    var typeId = $(this).data('type');
    console.log(typeId);
    $.ajax({
        type: 'POST',
        url: './MenuType.php',
        data: { typeId: typeId },
        success: function (data) {
            $('.content-section .row').html(data);
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
});

$('.page-link').click(function () {
    var page = $(this).data('page');
    $.ajax({
        url: page + '.php',
        method: 'GET',
        success: function (data) {
            $('#content').html(data);
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
});

$('.review-btn').click(function() {
    var reviewId = $(this).data('menu-id');
    console.log(reviewId);
    $.ajax({
        type: "POST",
        url: "./review_menu.php",
        data: {menuId: reviewId},
        success: function (res) {
            $('.modal-body').html(res);
            $('#review-modal').modal('show');
        },
        error: function (err) {
            console.error("Error:", err);
        }
    });
});

$(document).ready(function () {
    $('.order-btn').click(function (e) {
        e.preventDefault();
        const menuId = $(this).data('menu-id');
        $.ajax({
            type: 'GET',
            url: 'cart.php',
            data: { menu_id: menuId },
            success: function (updatedCartCount) {
                Swal.fire({
                    icon: 'success',
                    title: 'เพิ่มลงตะกร้าแล้ว',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#cart-count').text(updatedCartCount);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });
});




</script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</html>
