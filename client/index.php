<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Restaurant Menu</title>
    <style>
        /* Tabs styling */
        .head {
            text-align: center;
            margin: 10;
            color: blue;
        }

        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 20px;
            margin: 0 10px;
            border: 1px solid #ccc;
            border-bottom: none;
            border-radius: 5px 5px 0 0;
            background-color: #f7f7f7;
            font-weight: bold;
            text-decoration: none;
        }

        .active {
            border-color: #ccc;
            background-color: #fff;
        }

        /* Menus styling */
        h2 {
            margin-top: 20px;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        li {
            margin-bottom: 10px;
        }

        .restaurant-container {
            width: 300px;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: inline-block;
        }

        .restaurant-container h3.head {
            font-size: 24px;
            color: #0077c0;
        }

        /* Grid layout rules */
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .col {
            flex-basis: calc(100% / 3 - 40px);
            margin: 20px;
        }
    </style>
</head>

<body>
    <?php include './components/header.php' ?>
    <div class="">
        <?php
        // Connect to database
        include '../server/Database.php';

        $database = new Database();
        $conn = $database->getConnection();

        // Set the default day to Monday
        $selected_day = isset($_GET['day']) ? $_GET['day'] : 'pondelok';

        // Get the menus for the selected day
        $sql = "SELECT * , restaurant.name as resName FROM menu left join restaurant on menu.restaurant_id = restaurant.id WHERE menu.day='$selected_day' ORDER BY resName ASC";
        $result = mysqli_query($conn, $sql);

        // Initialize an array to store the menus for each restaurant
        $menus = array();
        while ($row = mysqli_fetch_assoc($result)) {
            if (!isset($menus[$row['resName']])) {
                $menus[$row['resName']] = array();
            }
            array_push($menus[$row['resName']], array('dish' => $row['dish'], 'type' => $row['type'], 'price' => $row['price']));
        }
        // Create the weekday tabs
        $weekdays = array('Pondelok', 'Utorok', 'Streda', 'Stvrtok', 'Piatok');
        echo '<div class="tabs">';
        foreach ($weekdays as $day) {
            $class = ($day == $selected_day) ? 'active' : '';
            echo "<a href=\"?day=$day\" class=\"tab $class\">$day</a>";
        }
        echo '</div>';

        // Display the menu for each restaurant
        $num_cols = count($menus);
        if ($num_cols > 3) {
            $num_cols = 3;
        } elseif ($num_cols < 1) {
            $num_cols = 1;
        }

        echo '<div class="row">';
        foreach ($menus as $restaurant => $menu) {
            echo '<div class="col">';
            echo '<div class="restaurant-container">';
            echo "<h3 class='head'>" . strtoupper($restaurant) . "</h3>";
            echo '<ul>';
            foreach ($menu as $item) {
                echo "<li><strong>{$item['type']}</strong> {$item['dish']} - <strong>Price:</strong> {$item['price']}</li>";
            }
            echo '</ul>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';

        // Close database connection
        mysqli_close($conn);
        ?>
    </div>
    <?php include './components/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>