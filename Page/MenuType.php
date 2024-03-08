<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <!-- Modal review -->
    <div class="modal fade" id="review-modal" tabindex="-1" aria-labelledby="review-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="review-modalLabel">Review Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content will be dynamically loaded here -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal review -->
    <div class="container">
        <?php
        include "../Database/connectDB.php";
        include "../Admin/Libary.html";

        if (isset($_POST['typeId'])) {
            $typeId = $_POST['typeId'];

            $sql = "SELECT menu.*, AVG(rating.score) AS average_score
                    FROM menu
                    LEFT JOIN rating ON menu.menu_id = rating.menu_id
                    WHERE menu.typeId = $typeId
                    GROUP BY menu.menu_id
                    ORDER BY average_score DESC";

            $result = $conn->query($sql);
        ?>
        <div class="row"><?php 
         while ($row = $result->fetch_assoc()) {
                $rating = round($row['average_score']);?>
                <div class="col-md-4 mt-3">
                    <div class="card menu-card h-100" id="menuCard<?= $row['menu_id'] ?>">
                        <img src="../Admin/<?= $row['image_url'] ?>" class="card-img-top" alt="<?= $row['menu_name'] ?>" />
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?= $row['menu_name'] ?></h5>
                            <p class="card-text">Price: <?= $row['price'] ?> บาท</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-text">Rating:
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo ($i <= $rating) ? '<i class="fas fa-star text-warning"></i>' : '<i class="far fa-star text-warning"></i>';
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <a class="btn btn-primary order-btn" href="cart.php?menu_id=<?= $row['menu_id']?>" role="button" data-menu-id="<?= $row['menu_id'] ?>">
                                    <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                </a>
                                <a class="btn btn-secondary review-btn" role="button" data-menu-id="<?= $row['menu_id'] ?>">
                                    <i class="far fa-comment me-1"></i> Review
                                </a>
                            </div>
                        </div>
                    </div>
                    </div>
                
        <?php
            }
        } else {
            echo 'No typeId provided.';
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

    $(document).ready(function () {
        $('.review-btn').click(function() {
            var reviewId = $(this).data('menu-id');
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
    });
    </script>
</body>
</html>
