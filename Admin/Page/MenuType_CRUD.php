<?php
    include "../ConnectDB.php";
$action = $_POST['action'] ?? "";
if($action != ""){
switch($action) {
    case "addMenuType": 
        $typeName = $_POST['TypeName'];
        $sql = "INSERT INTO menutype (typeName) VALUES ('$typeName')";
        if ($conn->query($sql) === TRUE) {
            echo "เพิ่มข้อมูลเรียบร้อยเเล้ว";
        } else {
            echo "Error : " . $sql . "<br>" . $conn->error;
        }
        break;
    case "editMenutype":
        $typeId = $_POST['typeId'];
        $typeName = $_POST['TypeName'];
        $sql = "UPDATE menutype SET typeName='$typeName' WHERE typeId='$typeId'";
        
        if ($conn->query($sql) === TRUE) {
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
            echo "<script>
                    Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update menu type.',
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                    });
                </script>";
        }
        break;

    case "DelMenu": 
        $typeId = $_POST['typeId'] ?? "";

        $sql_check_reference = "SELECT COUNT(*) AS countReference FROM menu WHERE typeId = $typeId";
        $result_check_reference = $conn->query($sql_check_reference);
        $row_check_reference = $result_check_reference->fetch_assoc();
        $countReference = $row_check_reference['countReference'];

        if ($countReference > 0) {
            echo "failed";
        } else {
            $sql_delete = "DELETE FROM menutype WHERE typeId = $typeId";
            if ($conn->query($sql_delete) === TRUE) {
                echo "success";
            }
        }
        break;


}
exit();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu CRUD</title>
</head>
<body>
<?php  include "../Libary.html";?>
<!-- Reading -->
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>จัดการเมนู</h2>
        <button class="btn btn-success m-2"  data-bs-toggle="modal" data-bs-target="#addMenuType">
            <i class="fas fa-plus-circle"></i> เพิ่มข้อมูล
        </button>
    </div>
    <table class="table text-center">
        <thead>
            <tr>
                <th>Type Id</th>
                <th>Type Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../ConnectDB.php";
            $sql = "SELECT * FROM menuType";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['typeId']}</td>";
                echo "<td>{$row['typeName']}</td>";
                echo "<td>";
                echo "<a data-id={$row['typeId']} class='btn btn-primary show-edit-btn'><i class='fas fa-edit'></i></a>";
                echo " ";
                echo "<a data-id={$row['typeId']} class='btn btn-danger delete-btn'><i class='fas fa-trash-alt'></i></a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Menu Modal -->
<div class="modal fade" id="addMenuType" tabindex="-1" aria-labelledby="addMenuTypeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMenuTypeLabel">เพิ่มข้อมูลเมนู</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addMenuForm" action="./Page/MenuType_CRUD.php" method="POST">
                    <div class="mb-3">
                        <label for="TypeName" class="form-label">ประเภทอาหาร</label>
                        <input type="text" class="form-control" id="TypeName" name="TypeName">
                    </div>
                    <!-- เพิ่ม input hidden สำหรับส่งค่า action -->
                    <input type="hidden" name="action" value="addMenuType">
                    <button type="button" class="btn btn-success add-btn" onclick="submitForm()">บันทึกข้อมูล</button>
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
                <h5 class="modal-title" id="editMenuModalLabel">แก้ไขข้อมูลประเภทเมณู</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body edit-modal">
                
            </div>
        </div>
    </div>
</div>

<!-- AJAX -->
<script>

$('.add-btn').click(function() {
    $.ajax({
        type: 'POST',
        url: './Page/MenuType_CRUD.php',
        data: $('#addMenuForm').serialize(),
        success: function (response) {
            console.log(response);
            if (response === 'failed') {
                console.log("ไม่สำเร็จ");
                Swal.fire('ไม่สามารถเพิ่มข้อมูลได้', 'มีข้อผิดพลาด', 'error');
            } else {
                console.log("สำเร็จ");
                Swal.fire('เพิ่มข้อมูลเรียบร้อยแล้ว', '', 'success').then(function() {
                    $('#addMenuType').modal('hide');  
                    location.reload(true);
                });
            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
});

$('.show-edit-btn').click(function () {
    var typeId = $(this).data('id');
    $.ajax({
        url: './Form/MenuType_Edit.php',
        data: {
            action: 'editMenuTypeForm',
            typeId: typeId,
        },
        method: "POST",
        success: function (res) {
            $('#editMenuModal').modal('show');
            $('.edit-modal').html(res);
        }
    });
});

$('.delete-btn').click(function () {
    var typeId = $(this).data('id');
    console.log(typeId);
    
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
                type: 'POST',
                url: './Page/MenuType_CRUD.php',
                data: {
                    action: 'DelMenu',
                    typeId: typeId,
                },
                success: function (response) {
                    console.log(response);
                    if (response === 'success') {
                        console.log("สำเร็จ");
                        Swal.fire('ลบข้อมูลเรียบร้อยแล้ว', '', 'success').then(function() {
                            location.reload(true);
                        });
                    } else {
                        console.log("ไม่สำเร็จ");
                        Swal.fire('ไม่สามารถลบข้อมูลได้', 'มีการอ้างอิงในตาราง menu', 'error').then(function() {
                            location.reload(true);
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
</script>
</body>
</html>
