<?php
include "../Libary.html";
require_once('../../vendor/autoload.php'); 
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults(); 
$fontDirs = $defaultConfig['fontDir']; 
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults(); 
$fontData = $defaultFontConfig['fontdata']; 
$mpdf = new \Mpdf\Mpdf([ 
    'fontDir' => array_merge($fontDirs, [ 
        __DIR__ . '/tmp', 
    ]), 
    'fontdata' => $fontData + ['sarabun' => [ 
        'R' => 'THSarabunNew.ttf', 
        'I' => 'THSarabunNew Italic.ttf', 
        'B' => 'THSarabunNew Bold.ttf', 
        'BI'=> 'THSarabunNew BoldItalic.ttf' 
    ] ],
    'default_font' => 'sarabun' 
]); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu CRUD</title>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>จัดการรายการขาย</h2>
        <!-- <button class="btn btn-success m-2"  data-bs-toggle="modal" data-bs-target="#addMenuType">
            <i class="fas fa-plus-circle"></i> เพิ่มข้อมูล
        </button> -->
    </div>
    <?php ob_start();?>
    <table class="table text-center">
        <thead>
            <tr>
                <th>Sale Id</th>
                <th>Menu name</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Sale Date</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            include "../ConnectDB.php";
            
            $sql = "SELECT s.sale_id, sd.menu_id, sd.quantity, sd.total_price, s.sale_date, menu.menu_name
                    FROM sales s
                    JOIN sales_details sd ON s.sale_id = sd.sale_id
                    JOIN menu ON sd.menu_id = menu.menu_id";
            
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['sale_id']}</td>";
                echo "<td>{$row['menu_name']}</td>";
                echo "<td>{$row['quantity']}</td>";
                echo "<td>{$row['total_price']}</td>";
                echo "<td>{$row['sale_date']}</td>";
                // echo "<td>";
                // echo "<a data-id={$row['sale_id']} class='btn btn-primary edit-btn'><i class='fas fa-edit'></i></a>";
                // echo " ";
                // echo "<a data-id={$row['sale_id']} class='btn btn-danger delete-btn'><i class='fas fa-trash-alt'></i></a>";
                // echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    $html=ob_get_contents();
    $mpdf->WriteHTML($html); 
    $mpdf->Output("Report.pdf"); 
    ob_end_flush(); 
    ?>

    <a href="Report.pdf" class="btn btn-primary"><i class="fa-solid fa-file-pdf"></i> แสดงการขายทั้งหมด</a>
</div>
</html>
