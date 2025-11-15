/* SỬA SẢN PHẨM */
<?php
session_start();
require_once 'db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Lấy ID sản phẩm và validate
$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) { // <-- SỬA LỖI 2 (thêm {})
    mysqli_close($con); // Dọn dẹp $con
    die("Invalid product ID.");
}

// Lấy dữ liệu hiện tại (Dùng Prepared Statement)
$stmt_select = mysqli_prepare($con, "SELECT * FROM products WHERE id = ?");
mysqli_stmt_bind_param($stmt_select, "i", $id);
mysqli_stmt_execute($stmt_select);
$result = mysqli_stmt_get_result($stmt_select);
$product = mysqli_fetch_assoc($result);

// Dọn dẹp $stmt_select ngay sau khi dùng xong
mysqli_stmt_close($stmt_select);

if (!$product) { // <-- SỬA LỖI 2 (thêm {})
    mysqli_close($con); // Dọn dẹp $con
    die("Product not found.");
}

// Cập nhật sản phẩm
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = (float) $_POST['price'];
    $status = trim($_POST['status']);
    $image = $product['image']; // Giữ ảnh cũ nếu không upload mới

    // Nếu có file upload
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir))
            mkdir($targetDir, 0755, true);
        $targetFile = $targetDir . time() . '_' . basename($_FILES["image"]["name"]);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (in_array($fileType, $allowed) && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $targetFile; // Cập nhật ảnh mới
        }
    }

    // Cập nhật (Dùng Prepared Statement)
    $sql_update = "UPDATE products SET name=?, price=?, status=?, image=? WHERE id=?";
    $stmt_update = mysqli_prepare($con, $sql_update);
    // 'sdssi' = string, double, string, string, integer
    mysqli_stmt_bind_param($stmt_update, "sdssi", $name, $price, $status, $image, $id);

    if (mysqli_stmt_execute($stmt_update)) {
        // Cập nhật thành công
        mysqli_stmt_close($stmt_update); // DỌN DẸP TRƯỚC
        mysqli_close($con);              // DỌN DẸP TRƯỚC

        header("Location: home.php");
        exit();
    } else {
        // Cập nhật thất bại
        echo "Lỗi: " . mysqli_error($con);
        mysqli_stmt_close($stmt_update); // Dọn dẹp $stmt_update
    }
} // <-- SỬA LỖI 1 (thêm } ở đây)

// Dòng này chỉ chạy khi vào trang (GET) hoặc khi POST bị lỗi
mysqli_close($con);
?>

<!DOCTYPE html>
...

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 30px;
            max-width: 600px;
        }

        img.current-img {
            max-width: 120px;
            border-radius: 4px;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3 class="text-primary mb-4">Edit Product (ID: <?= $id ?>)</h3>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" required
                    value="<?= htmlspecialchars($product['name']) ?>">
            </div>
            <div class="form-group">
                <label>Price (VND):</label>
                <input type="number" name="price" class="form-control" min="0" step="1000" required
                    value="<?= htmlspecialchars($product['price']) ?>">
            </div>
            <div class="form-group">
                <label>Status:</label>
                <select name="status" class="form-control" required>
                    <option value="In Stock" <?= $product['status'] == 'In Stock' ? 'selected' : '' ?>>In Stock</option>
                    <option value="Out of Stock" <?= $product['status'] == 'Out of Stock' ? 'selected' : '' ?>>Out of Stock
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Product Image:</label><br>
                <input type="file" name="image" accept=".jpg,.jpeg,.png" class="form-control-file">
                <?php if ($product['image']): ?>
                    <img class="current-img" src="<?= htmlspecialchars($product['image']) ?>" alt="Current Image">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="home.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>

</html>