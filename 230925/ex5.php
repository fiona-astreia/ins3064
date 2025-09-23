<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My First PHP File</title>
</head>
<body>
    <h1>This is my first PHP file</h1>

    <table border="1">
        <?php
        for ($i = 0; $i < 5; $i++) {
            echo "<tr>";
            echo "<td>$i</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>