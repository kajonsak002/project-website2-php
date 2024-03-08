<?php 
include "../ConnectDB.php";
include "../Libary.html";
    $typeId = $_POST['typeId']; 
    $sql = "SELECT * FROM menutype WHERE typeId = $typeId ";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
?>
<form id="EditMenutype" method="POST" action="./Page/MenuType_CRUD.php" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="typeId" class="form-label">TypeId</label>
        <input type="text" class="form-control" id="typeId" name="typeId" value="<?php echo $row['typeId']?>" readonly>
    </div>
    <div class="mb-3">
        <label for="TypeName" class="form-label">TypeName</label>
        <input type="text" class="form-control" id="TypeName" name="TypeName" value="<?php echo $row['typeName']?>">
    </div>
    <button type="submit" class="btn btn-success edit-btn" name ="action" value="editMenutype">บันทึกข้อมูล</button>
</form>