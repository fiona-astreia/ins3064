<?php
session_start();
require_once 'db.php'; // Kết nối CSDL

// ===== BẮT ĐẦU =====
// 1. Kiểm tra: User CHƯA đăng nhập (chưa có session) 
//    VÀ có cookie "remember_me"?
if (!isset($_SESSION['username']) && isset($_COOKIE['remember_me'])) {

    $token = $_COOKIE['remember_me'];

    // 2. Tìm token trong CSDL VÀ token còn hạn
    $stmt_find = mysqli_prepare(
        $con,
        "SELECT users.* FROM auth_tokens 
         JOIN users ON auth_tokens.user_id = users.id 
         WHERE auth_tokens.token = ? AND auth_tokens.expires_at > NOW()"
    );

    mysqli_stmt_bind_param($stmt_find, "s", $token);
    mysqli_stmt_execute($stmt_find);
    $result_find = mysqli_stmt_get_result($stmt_find);

    // 3. Nếu tìm thấy token hợp lệ
    if ($user = mysqli_fetch_assoc($result_find)) {

        // 4. "Đăng nhập" bằng cách tạo session
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
    }

    mysqli_stmt_close($stmt_find);
}
// ===== KẾT THÚC =====

/* KIỂM TRA ĐĂNG NHẬP */
if (!isset($_SESSION['username'])) { // note
    header('location:login.php');
    exit();
}

/* LẤY DANH SÁCH SẢN PHẨM */
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($con, $query); // Object - False
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
        }

        .container {
            background: #fff;
            padding: 30px;
            margin-top: 30px;
            border-radius: 8px;
        }

        img.product-img {
            max-width: 80px;
            border-radius: 4px;
        }

        .btn-secondary {
            background-color: #6f42c1;
            border-color: #6f42c1;
        }

        .btn-secondary:hover {
            background-color: #5a359a;
            border-color: #5a359a;
        }

        .btn-success {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-success:hover {
            background-color: #e0a800;
            border-color: #e0a800;
            color: #212529;
        }


        /* .table-hover tbody tr:hover {
    background-color: #fef0f0; 
} */
    </style>
</head>

<body>
    <div class="container">

        <!-- <?php if (isset($_GET['msg'])): ?>
            <?php
            $message = '';
            $alertClass = '';

            // Kiểm tra xem "bưu thiếp" (msg) nói gì
            if ($_GET['msg'] == 'deleted') {
                $message = 'Product deleted successfully!';
                $alertClass = 'alert-success'; // Màu xanh lá
            } elseif ($_GET['msg'] == 'error') {
                $message = 'Error! Could not delete product.';
                $alertClass = 'alert-danger'; // Màu đỏ
            } elseif ($_GET['msg'] == 'invalid_id') {
                $message = 'Invalid product ID.';
                $alertClass = 'alert-warning'; // Màu vàng
            }
            ?>

            <?php if ($message): ?>
                <div class="alert <?= $alertClass ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>
        <?php endif; ?> -->


        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Coffee Management (Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!)</h2>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Products List</h4>
            <a href="create.php" class="btn btn-success">+ Add Product</a>
        </div>

        <table class="table table-bordered table-hover text-center">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price (VND)</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><img class="product-img"
                                    src="<?= htmlspecialchars($row['image'] ?: 'https://placehold.co/80x80?text=No+Img') ?>"
                                    alt="Image"></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= number_format($row['price'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                <a href="create.php" class="btn btn-success">+ Add Product</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">There is nothing here!</td>
                    </tr>
                <?php endif; ?><s
            </tbody>
        </table>

        <?php mysqli_close($con); ?>
    </div>
<script>
if(window.location.search.length >=0 ){
    window.history.replaceState({}, document.title,window.location.pathname);
}
</script>
</body>

</html>