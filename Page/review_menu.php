<?php 
include "../Database/connectDB.php";

$menuId = $_POST['menuId'] ?? "";

$sql = "SELECT rating.*, AVG(rating.score) AS average_score
        FROM rating
        WHERE rating.menu_id = '$menuId'
        GROUP BY rating.id, rating.username, rating.comment, rating.menu_id;";
        
$rs = $conn->query($sql);

while ($row = $rs->fetch_assoc()) {
    ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Username: <?php echo $row['username']; ?></h5>
            <p class="card-text">Comment: <?php echo $row['comment']; ?></p>
            <p class="card-text">คะแนน: 
                <?php 
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $row['average_score']) {
                        echo '<i class="fas fa-star text-warning"></i>';
                    } else {
                        echo '<i class="far fa-star text-warning"></i>';
                    }
                }
                ?>
            </p>
        </div>
    </div>
    <?php
}

$conn->close();
?>

<div class="container">
    <form id="reviewForm">
    <input type="hidden" name="menuId" value="<?php echo $menuId; ?>">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username">
    </div>
    <div class="mb-3">
        <label for="comment" class="form-label">Comment</label>
        <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
    </div>
    <div class="mb-3">
        <label for="rating" class="form-label">Rating</label>
        <select class="form-select" id="rating" name="rating">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit Review</button>
</form>
</div>

<div id="reviewResult"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
$(document).ready(function() {
    $('#reviewForm').submit(function(e) {
        e.preventDefault(); 
        $.ajax({
            type: 'POST',
            url: 'review_process.php',
            data: $(this).serialize(), 
            success: function(response) {
                swal("Success!", response, "success");
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(error) {
                swal("Error!", "An error occurred while submitting the review.", "error");
            }
        });
    });
});

</script>
