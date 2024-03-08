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
<?php 
    include "../ConnectDB.php";
    $menuId = $_POST['menuId']; 
    $sql = "SELECT * FROM menu WHERE menu_id = $menuId ";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
?>
<form id="editMenuForm" action="./Page/Menu_CRUD.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">                    
        <label for="menuId" class="form-label">Menu ID</label>
        <input type="text" class="form-control" id="menuId" name="menuId" value="<?php echo $row['menu_id']; ?>" readonly>
    </div>
    <div class="mb-3">
        <label for="menuName" class="form-label">ชื่อเมนู</label>
        <input type="text" class="form-control" id="menuName" name="menuName" value="<?php echo $row['menu_name']; ?>">
    </div>
    <div class="mb-3">                          
        <label for="menuDescription" class="form-label">รายละเอียดเมนู</label>
        <input type="text" class="form-control" id="menuDescription" name="menuDescription" value="<?php echo $row['description']; ?>">
    </div>
    <div class="mb-3">
        <label for="menuPrice" class="form-label">ราคา</label>
        <input type="text" class="form-control" id="menuPrice" name="menuPrice" value="<?php echo $row['price']; ?>">
    </div>
    <div class="mb-3">
        <label for="menuImage" class="form-label">รูปภาพ</label>
        <input type="file" class="form-control" id="menuImage" name="menuImage" onchange="previewImage()">
        <img id="imagePreview" src="<?=$row['image_url']; ?>" alt="Preview" style="width: 250px">
    </div>
    <button type="submit" class="btn btn-primary" name="action" value="EditMenu">บันทึกข้อมูล</button>
</form>

