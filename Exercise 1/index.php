<?php
include "connection.php";
?>

<html lang="en">
<head>
    <title>Laptop Shop Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="col-lg-4">
        <h2>Laptop Data Form</h2>
        <form action="" name="form1" method="post">
            <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" class="form-control" id="brand" placeholder="Enter Brand (e.g., Dell, Apple)" name="brand" required>
            </div>
            <div class="form-group">
                <label for="model">Model:</label>
                <input type="text" class="form-control" id="model" placeholder="Enter Model (e.g., XPS 15)" name="model" required>
            </div>
            <div class="form-group">
                <label for="cpu">CPU:</label>
                <input type="text" class="form-control" id="cpu" placeholder="Enter CPU (e.g., Core i7)" name="cpu" required>
            </div>
            <div class="form-group">
                <label for="price">Price (VND):</label>
                <input type="number" class="form-control" id="price" placeholder="Enter Price (e.g., 35000000)" name="price" required>
            </div>
            <button type="submit" name="insert" class="btn btn-primary">Insert Laptop</button>
        </form>
    </div>

    <div class="col-lg-12" style="margin-top: 20px;">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Brand</th>
                <th>Model</th>
                <th>CPU</th>
                <th>Price (VND)</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Check if the connection variable exists and is not null
            if (isset($link) && !is_null($link)) {
                // Query the 'laptops' table
                $res = mysqli_query($link, "SELECT * FROM laptops");
                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["brand"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["model"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["cpu"]) . "</td>";
                    echo "<td>" . number_format($row["price"]) . "</td>"; // Format price for readability
                    echo "</tr>";
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php
if (isset($_POST["insert"])) {
    // NOTE: This code is vulnerable to SQL injection. For a real project, use prepared statements.
    mysqli_query($link, "INSERT INTO laptops VALUES (NULL, '$_POST[brand]', '$_POST[model]', '$_POST[cpu]', '$_POST[price]')");
    ?>
    <script type="text/javascript">
        // Refresh page to show new data
        window.location.href = window.location.href;
    </script>
    <?php
}
?>
</body>
</html>