<?php
include 'db.php';

// Assuming customer_id is 1 for demonstration purposes
$customer_id = 1;

$sql = "SELECT rentals.*, movies.title FROM rentals JOIN movies ON rentals.movie_id = movies.movie_id WHERE customer_id = '$customer_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        input[type="date"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Checkout</h1>
    <form method="POST">
        <table>
            <tr>
                <th>Title</th>
                <th>Rental Date</th>
                <th>Return Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['rental_date']; ?></td>
                    <td><input type="date" name="return_date[<?php echo $row['rental_id']; ?>]"></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <button type="submit">Complete Checkout</button>
    </form>
    <div style="text-align: center; margin-top: 20px;">
        <a href="logout.php" style="text-decoration: none; color: #007bff; font-weight: bold;">Logout</a>
    </div>
</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['return_date'] as $rental_id => $return_date) {
        $sql = "UPDATE rentals SET return_date='$return_date' WHERE rental_id='$rental_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Checkout completed!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>