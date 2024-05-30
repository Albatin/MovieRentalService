<?php
include 'db.php';

$customer_id = 1; // Assuming customer_id is 1 for demonstration purposes

// Handle adding movie to the queue
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id'])) {
    $movie_id = $_POST['movie_id'];
    $sql = "INSERT INTO rentals (customer_id, movie_id, rental_date) VALUES ('$customer_id', '$movie_id', NOW())";
    if ($conn->query($sql) === TRUE) {
        header("Refresh:0"); // Refresh the page to reflect changes
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle removing movie from the queue
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_movie_id'])) {
    $remove_movie_id = $_POST['remove_movie_id'];
    $remove_sql = "DELETE FROM rentals WHERE customer_id = '$customer_id' AND movie_id = '$remove_movie_id'";
    if ($conn->query($remove_sql) === TRUE) {
        header("Refresh:0"); // Refresh the page to reflect changes
        exit();
    } else {
        echo "Error: " . $remove_sql . "<br>" . $conn->error;
    }
}

// Fetch current queue
$sql = "SELECT rentals.*, movies.title FROM rentals JOIN movies ON rentals.movie_id = movies.movie_id WHERE customer_id = '$customer_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rental Queue</title>
    <style>
        /* General styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        h1 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }

        a.seeall {
            display: block;
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
            font-size: 0.9em;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        td:last-child {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>My Rental Queue</h1>
    <a class="seeall" href="index.html">See All</a>
    <table>
        <tr>
            <th>Title</th>
            <th>Rental Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['rental_date']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="remove_movie_id" value="<?php echo $row['movie_id']; ?>">
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Add Movie to Queue</h2>
    <form method="POST">
        <label for="movie_id">Movie ID:</label>
        <input type="text" id="movie_id" name="movie_id" required>
        <button type="submit">Add to Queue</button>
        <a href="checkout.php">Checkout</a>
    </form>
    <div style="text-align: center; margin-top: 20px;">
        <a href="logout.php" style="text-decoration: none; color: #007bff; font-weight: bold;">Logout</a>
    </div>
</body>

</html>

<?php $conn->close(); ?>