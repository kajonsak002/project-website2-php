<?php 
include "../Admin/ConnectDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menuId = $_POST['menuId'] ?? "";
    $username = $_POST['username'] ?? "";
    $comment = $_POST['comment'] ?? "";
    $rating = $_POST['rating'] ?? "";

    $sql = "INSERT INTO rating (username, comment, menu_id, score) VALUES ('$username', '$comment', '$menuId','$rating')";
    if ($conn->query($sql) === TRUE) {
        echo "รีวิวสำเร็จเเล้ว";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
