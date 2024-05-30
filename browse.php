<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Movies</title>
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
            /* Smaller font size */
            margin-bottom: 20px;
            /* color: #007bff; */
            /* Changed color to blue */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            /* Smaller padding */
            border-bottom: 1px solid #dee2e6;
            text-align: left;
            font-size: 0.9em;
            /* Smaller font size */
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        td:nth-child(1) {
            width: 5%;
            /* Set width for ID Movie column */
        }

        td:nth-child(n+2) {
            width: 15%;
            /* Set width for other columns */
        }

        td:last-child {
            width: 10%;
            /* Set width for Action column */
        }

        .rent-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .rent-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Browse Movies</h1>
    <table>
        <tr>
            <th>ID Movie</th>
            <th>Title</th>
            <th>Genre</th>
            <th>Release Year</th>
            <th>Director</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php
        include 'db.php';

        $sql = "SELECT * FROM movies";
        $result = $conn->query($sql);

        $id_movie = 1;
        while ($row = $result->fetch_assoc()) :
        ?>
            <tr>
                <td><?php echo $id_movie; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['genre']; ?></td>
                <td><?php echo $row['release_year']; ?></td>
                <td><?php echo $row['director']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><a href="queue.php?movie_id=<?php echo $row['movie_id']; ?>" class="rent-button">Rent</a></td>
            </tr>
        <?php $id_movie++;
        endwhile; ?>
    </table>

    <div style="text-align: center; margin-top: 20px;">
        <a href="logout.php" style="text-decoration: none; color: #007bff; font-weight: bold;">Logout</a>
    </div>
</body>

</html>

<?php $conn->close(); ?>