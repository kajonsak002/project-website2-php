<?php
session_start();
include "../Database/connectDB.php";

function updateCart() {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $menu_id => $quantity) {
            if (is_numeric($quantity) && $quantity >= 0) {
                $_SESSION['cart'][$menu_id] = (int)$quantity;
            }
        }
    }
}

function removeItem() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['remove_item'])) {
        $remove_menu_id = $_POST['remove_item'];
        unset($_SESSION['cart'][$remove_menu_id]);
    }
}

updateCart();
removeItem();

$result = null;
$totalAmount = 0;

if (!empty($_SESSION['cart'])) {
    $menuIds = array_keys($_SESSION['cart']);
    $menuIdsString = implode(',', $menuIds);
    $sql = "SELECT * FROM menu
            WHERE menu_id IN ($menuIdsString)";

    $result = $conn->query($sql);

    if ($result === false) {
        echo 'Error executing query: ' . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">
    <title>Shopping Cart</title>
</head>

<body>
    <div class="container mt-5 shadow-lg p-3 mb-5 bg-body-tertiary rounded">
        <div class="content-section" id="content">
            <h2 class="text-center mb-4">ตะกร้าสินค้า</h2>
            <form method="post" action="">
                <table class="table">
                    <thead class="table">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        if (!is_null($result) && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $quantity = $_SESSION['cart'][$row['menu_id']] ?? 0;
                                $subtotal = $quantity * $row['price'];
                                $totalAmount += $subtotal;
                        ?>
                                <tr>
                                    <th scope="row"><?= $counter++ ?></th>
                                    <td><?= $row['menu_name'] ?></td>
                                    <td><?= $row['price'] ?> บาท</td>
                                    <td>
                                        <input type="number" name="quantity[<?= $row['menu_id'] ?>]" value="<?= $quantity ?>" min="0" class="form-control">
                                    </td>
                                    <td><?= $subtotal ?> บาท</td>
                                    <td>
                                        <button type="submit" name="remove_item" value="<?= $row['menu_id'] ?>" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="6">No items in the cart</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <div class="total-amount text-end">
                    <strong>Total: <?= $totalAmount ?> บาท</strong>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button type="submit" name="update_cart" class="btn btn-success">
                        <i class="fas fa-sync-alt"></i> Update Cart
                    </button>
                    <button type="submit" name="checkout" class="btn btn-primary" id="checkoutBtn">
                        <i class="fas fa-shopping-cart"></i> Check Out
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>
    <script>
        document.getElementById('checkoutBtn').addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'ยืนยันการสั่งซื้อ?',
                text: 'คุณต้องการที่จะสั่งซื้อสินค้าทั้งหมดในตะกร้าหรือไม่',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $maxSaleIdSql = "SELECT MAX(sale_id) AS max_sale_id FROM sales";
                    $maxSaleIdResult = $conn->query($maxSaleIdSql);

                    if ($maxSaleIdResult && $maxSaleIdRow = $maxSaleIdResult->fetch_assoc()) {
                        $newSaleId = $maxSaleIdRow['max_sale_id'] + 1;

                        document.getElementById('saleIdInput').value = $newSaleId;
                        document.querySelector('form').submit();
                    }
                }
            });
        });
    </script>
    
</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {

    $salesId = $_POST['sale_id'] ?? 0;
    $checkoutDate = date("Y-m-d H:i:s");

    $maxSaleIdSql = "SELECT MAX(sale_id) AS max_sale_id FROM sales";
    $maxSaleIdResult = $conn->query($maxSaleIdSql);
    $maxSaleIdRow = $maxSaleIdResult->fetch_assoc();
    $newSaleId = $maxSaleIdRow['max_sale_id'] + 1;

    $insertSalesSql = "INSERT INTO sales (sale_id, sale_date) VALUES ('$newSaleId', '$checkoutDate')";
    $conn->query($insertSalesSql);

    $salesId = $conn->insert_id;

    foreach ($_SESSION['cart'] as $menuId => $quantity) {
        $menuSql = "SELECT * FROM menu WHERE menu_id = '$menuId'";
        $menuResult = $conn->query($menuSql);

        if ($menuResult->num_rows > 0) {
            $menuRow = $menuResult->fetch_assoc();
            $menuPrice = $menuRow['price'];
            $subtotal = $quantity * $menuPrice;

            $insertDetailsSql = "INSERT INTO sales_details (sale_id, menu_id, quantity, total_price)
                                 VALUES ('$salesId', '$menuId', '$quantity', '$subtotal')";

            $conn->query($insertDetailsSql);
             echo '<script>
                    Swal.fire({
                        title: "สั่งซื้อเสร็จสมบูรณ์",
                        text: "คุณได้ทำการสั่งซื้อเรียบร้อยแล้ว",
                        icon: "success"
                    }).then(() => {
                        window.location.href = "../index.php";
                    });
                </script>';
        }
    }
    session_destroy();
}
?>
