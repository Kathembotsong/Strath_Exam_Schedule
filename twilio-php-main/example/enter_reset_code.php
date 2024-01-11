<!-- enter_reset_code.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include necessary styles and scripts -->
</head>
<body>
    <div class="container">
        <h2>Enter Reset Code</h2>
        <form method="post" action="validate_reset_code.php">
            <label for="reset_code">Enter the code received on your phone:</label>
            <input type="text" name="reset_code" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
