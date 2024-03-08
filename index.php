<?php
session_start();
session_destroy();
include "./Database/connectDB.php";
$sql = "SELECT menu.*, AVG(rating.score) AS average_score
        FROM menu
        LEFT JOIN rating ON menu.menu_id = rating.menu_id
        GROUP BY menu.menu_id
        ORDER BY average_score DESC
        LIMIT 3";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
      <link rel="stylesheet" href="./index.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <title>Kajon Cafe & Bakery</title>
  </head>
  <body>
    <!-- Navbar -->
    <nav
      class="navbar navbar-expand-lg bg-white sticky-top navbar-light p-3 shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="#"
          > <i class="fa-solid fa-mug-hot me-2"></i> <strong>KAJXN CAFE</strong></a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ms-auto">
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    <!-- Banner -->
    <div class="container-fluid position-relative">
      <div class="row">
        <div
          class="banner-image"
          style="
            background-image: url('https://cdn.pixabay.com/photo/2015/05/31/12/12/coffee-791439_1280.jpg');
            object-fit: cover;
          ">
          <div class="col p-0">
            <div class="banner-content text-white p-5">
              <div class="aos" data-aos="fade-right" data-aos-duration="1000">
                <h1 class="display-4">ร้าน Cafe & Bakery</h1>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                  do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                  Ut enim ad minim veniam, quis nostrud exercitation ullamco
                  laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <a class="btn btn-light" href="./Page/Home.php">ดูเมนูของเรา</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Banner -->


    <!-- Menu Section -->
    <div class="container menu-section mt-5" data-aos="fade-up" data-aos-duration="1000">
        <h2 class="text-center mb-4">เมนูแนะนำ</h2>
        <div class="row">
            <?php
            while ($row = $result->fetch_assoc()) {
                $rating = round($row['average_score']);
                ?>
                <div class="col-md-4 mt-2">
                    <div class="card menu-card h-100">
                        <img src="./Admin/<?= $row['image_url'] ?>" class="card-img-top" />
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?= $row['menu_name'] ?></h5>
                            <p class="card-text"><?= $row['description'] ?></p>
                            <p class="card-text"><?= $row['price'] ?> บาท</p>
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
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- End Menu Section -->

    <!-- Gallery Section -->
    <div
      class="container gallery-section mt-5"
      data-aos="fade-up"
      data-aos-duration="1000">
      <h2 class="text-center mb-4">จุดเด่นของร้าน</h2>
      <div class="row">
        <div class="col-md-4 mt-2">
          <div class="card gallery-card h-100">
            <img
              src="https://via.placeholder.com/300"
              alt="Gallery Item 1"
              class="card-img-top img-fluid" />
            <div class="card-body">
              <h5 class="card-title text-primary">บรรยากาศที่อบอุ่น</h5>
              <p class="card-text text-muted">
                รับประทานอาหารในบรรยากาศอบอุ่นและเป็นกันเอง
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card gallery-card h-100">
            <img
              src="https://via.placeholder.com/300"
              alt="Gallery Item 2"
              class="card-img-top img-fluid" />
            <div class="card-body">
              <h5 class="card-title text-primary">เมนูคุณภาพ</h5>
              <p class="card-text text-muted">
                เมนูที่คัดสรรอย่าง meticuloussly โดยทีมผู้เชี่ยวชาญ
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card gallery-card h-100">
            <img
              src="https://via.placeholder.com/300"
              alt="Gallery Item 3"
              class="card-img-top img-fluid" />
            <div class="card-body">
              <h5 class="card-title text-primary">ของหวานที่อร่อย</h5>
              <p class="card-text text-muted">
                ลิ้มลองรสของขนมหวานที่อร่อยที่สุด
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Gallery Section -->
    
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
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    AOS.init();
  </script>

</html>
