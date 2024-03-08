<form action="register.php" method="post">
        <div class="mb-3">
            <label for="register_username" class="form-label">Username:</label>
            <input type="text" class="form-control" id="register_username" name="username" required>
        </div>

        <div class="mb-3">
            <label for="register_password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="register_password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="register_phone" class="form-label">Phone Number:</label>
            <input type="text" class="form-control" id="register_phone" name="phone_number" required>
        </div>

        <div class="mb-3">
            <label for="register_name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="register_name" name="name" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>