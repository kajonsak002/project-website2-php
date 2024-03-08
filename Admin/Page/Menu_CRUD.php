<?php 
include "../ConnectDB.php";?>
<?php 
$action = $_POST['action'] ?? "";
if($action != ""){
switch($action) {
    case "AddMenu": 
        $menuImage = $_FILES['menuImage'];
        $menuName = $_POST['menuName'];
        $menuDescription = $_POST['menuDescription'];
        $menuPrice = $_POST['menuPrice'];
        $target_dir = "../Images/";
        $img_db = "./Images/";
    
        $sql = "INSERT INTO menu(menu_name,description,price) VALUES ('$menuName','$menuDescription','$menuPrice')";
        if ($conn->query($sql) === TRUE) {
            $menu_id = $conn->insert_id;
            $newfilename = $menu_id . "." . pathinfo($menuImage['name'], PATHINFO_EXTENSION);
            $target_file = $target_dir . $newfilename;
            $img_db = $img_db . $newfilename;
    
            if (move_uploaded_file($menuImage["tmp_name"], $target_file)) {
                $update_sql = "UPDATE menu SET image_url = '$img_db' WHERE menu_id = $menu_id";
                if ($conn->query($update_sql) === TRUE) {
                    echo "success";
                } else {
                    echo "error";
                }
            } 
        }
    break;    
    case "EditMenu":
        $menuImage = $_FILES['menuImage'];
        $menuName = $_POST['menuName'];
        $menuDescription = $_POST['menuDescription'];
        $menuPrice = $_POST['menuPrice'];
        $menuId = $_POST['menuId'];
        $target_dir = "../Images/";
        $img_db = "./Images/";
    
        if ($menuImage['size'] > 0) {
            $oldImage = $target_dir . $menuId . ".png"; 
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
    
            $newfilename = $menuId . "." . pathinfo($menuImage['name'], PATHINFO_EXTENSION);
            $target_file = $target_dir . $newfilename;
            $img_db = $img_db . $newfilename;
    
            if (!move_uploaded_file($menuImage["tmp_name"], $target_file)) {
                echo 'Error';
                exit;
            }
        }
        $update_sql = "UPDATE menu SET menu_name = '$menuName', description = '$menuDescription', price = '$menuPrice'";
        if (isset($newfilename)) {
            $update_sql .= ", image_url = '$img_db'";
        }
        $update_sql .= " WHERE menu_id = $menuId";
    
        if ($conn->query($update_sql) === TRUE) {
            echo "success";
            echo "<script> window.location.href = '../index.php';</script>";
            echo "<script>
                Swal.fire({
                title: 'Success!',
                text: 'แก้ไขข้อมูลเรียบร้อยเเล้ว',
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6'
                }).then(function() {
                    window.location.href = '../index.php';
                });
            </script>";
        } else {
            echo "Error";
            echo "<script>
            Swal.fire({
              title: 'Error!',
              text: 'Failed to update menu ',
              icon: 'error',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            });
          </script>";
        }
        break;
    case "DelMenu": 
        $menuId = $_POST['menuId'] ?? "";

        $sql = "SELECT * FROM menu WHERE menu_id = '$menuId'";
        $result = $conn->query($sql);
    
        if ($result) {
            if ($data = $result->fetch_array()) {
                if (file_exists("." . $data['image_url'])) {
                    unlink("." . $data['image_url']);
                }
            }

            $sql_delete = "DELETE FROM menu WHERE menu_id = $menuId";
            $result_delete = $conn->query($sql_delete);
    
            if ($result_delete) {
                echo "success"; 
            } else {
                echo "failed to delete menu"; 
            }
        } else {
            echo "failed to fetch menu data"; 
        }
        break;
}
exit();
}
?>
<?php 
include "../Libary.html";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu CRUD</title>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>จัดการเมนู</h2>
        <button class="btn btn-success m-2"  data-bs-toggle="modal" data-bs-target="#addMenuModal">
            <i class="fas fa-plus-circle"></i> เพิ่มข้อมูล
        </button>
    </div>
    <table class="table text-center">
        <thead>
            <tr>
                <th>MenuID</th>
                <th>Menu Name</th>
                <th>Price</th>
                <th>Image URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../ConnectDB.php";
            $sql = "SELECT * FROM menu";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['menu_id']}</td>";
                echo "<td>{$row['menu_name']}</td>";
                echo "<td>{$row['price']}</td>";
                echo "<td><img src='{$row['image_url']}' style=' width: 150px'></td>";
                echo "<td>";
                echo "<a data-id={$row['menu_id']} class='btn btn-primary edit-btn'><i class='fas fa-edit'></i></a>";
                echo " ";
                echo "<a data-id={$row['menu_id']} class='btn btn-danger delete-btn'><i class='fas fa-trash-alt'></i></a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Menu Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMenuModalLabel">เพิ่มข้อมูลเมนู</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form">
            <form id="addMenuForm" action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="AddMenu">
                <div class="mb-3">
                    <label for="menuName" class="form-label">ชื่อเมนู</label>
                    <input type="text" class="form-control" id="menuName" name="menuName">
                </div>
                <div class="mb-3">
                    <label for="menuDescription" class="form-label">รายละเอียดเมนู</label>
                    <input type="text" class="form-control" id="menuDescription" name="menuDescription">
                </div>
                <div class="mb-3">
                    <label for="menuPrice" class="form-label">ราคา</label>
                    <input type="text" class="form-control" id="menuPrice" name="menuPrice">
                </div>
                <div class="mb-3">
                    <label for="menuImage" class="form-label">รูปภาพ</label>
                    <input type="file" class="form-control" id="menuImage" name="menuImage" onchange="previewImage()">
                    <img id="imagePreview" src="#" alt="Preview" style="max-width: 100%; display: none;">
                </div>
                <button type="submit" class="btn btn-success add-btn" name="action" value="AddMenu">บันทึกข้อมูล</button>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Menu Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">แก้ไขข้อมูลเมนู</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body edit-modal">
                
            </div>
        </div>
    </div>
</div>
</body>

<!-- Show IMAGE -->
<script>
    function previewImage() {
        var input = document.getElementById('menuImage');
        var preview = document.getElementById('imagePreview');
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
</script>

<!-- AJAX -->
<script>


$('.form').on('submit', '#addMenuForm', function(e){
    e.preventDefault(); 
    var formData = new FormData(this); 
    $.ajax({
        url: "./Page/Menu_CRUD.php",
        method: 'POST', 
        data: formData,
        contentType: false,
        processData: false,
        success: function(response){
            console.log(response)
            if(response==='success') {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "เพิ่มเมนูเรียบร้อยแล้ว"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#addMenuModal').modal('hide');
                        location.reload(true);
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "error",
                    text: "เกิดข้อผิดพลาดในการเพิ่มข้อมูล"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#addMenuModal').modal('hide');
                       location.reload(true);
                    }
                });
            }
        },
        error: function(error) {
            console.error("AJAX Error:", error);
        }
     });
});

$('.edit-btn').click(function () {
    var menuId = $(this).data('id');
    $.ajax({
        url: './Form/Menu_Edit.php?menuId=' + menuId,
        data: {menuId: menuId},
        method: "POST",
        success: function (res) {
            $('#editMenuModal').modal('show');
            $('.edit-modal').html(res);
        }       
                
    })
});

$('.delete-btn').click(function () {
    var menuId = $(this).data('id');
    console.log(menuId);
    
    Swal.fire({
        title: 'ยืนยันการลบข้อมูล?',
        text: 'ต้องการที่จะลบประเภทเมนูนี้ใช่หรือไม่',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
        dangerMode: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: 'POST',
                url: './Page/Menu_CRUD.php',
                data: {
                    action: 'DelMenu',
                    menuId: menuId,
                },
                success: function (response) {
                    console.log(response);
                    if (response.trim() === 'success') {
                        console.log("สำเร็จ");
                        Swal.fire('ลบข้อมูลเรียบร้อยแล้ว', '', 'success').then(function() {
                            location.reload(true);
                        });
                    } else {
                        console.log("ไม่สำเร็จ");
                        Swal.fire('ไม่สามารถลบข้อมูลได้', 'มีการอ้างอิงในตาราง menu', 'error').then(function() {
                            // location.reload(true);
                        });
                    }
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        }
    });
});

</script>
</html>
