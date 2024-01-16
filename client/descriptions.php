<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>REST API Documentation</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            /* background-color: #1abc9c; */
            color: #000;
            padding: 10px;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        main {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 10px;
        }

        .resource {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
            margin: 10px;
            width: 100%;
            padding: 20px;
        }

        .method {
            margin-bottom: 20px;
        }

        .method h2 {
            margin-top: 0;
        }

        .method pre {
            background-color: #eee;
            border-radius: 5px;
            padding: 10px;
        }

        .method table {
            border-collapse: collapse;
            margin-bottom: 10px;
            width: 100%;
        }

        .method th {
            background-color: lightblue;
            color: #000;
            font-weight: normal;
            padding: 10px;
            text-align: left;
        }

        .method td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <?php include './components/header.php' ?>
    <div class="">
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">REST API Documentation</h5>
            </div>
            <div class="card-body">


                <!-- <div class="header">
            <h3>REST API Documentation</h3>
        </div> -->
                <main>
                    <div class="resource">
                        <h2>Menus</h2>
                        <div class="method">
                            <h3>GET /menus</h3>
                            <pre>
curl https://site205.webte.fei.stuba.sk/samadycv2/server/api.php
        </pre>
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Required</th>
                                </tr>
                                <tr>
                                    <td>page</td>
                                    <td>integer</td>
                                    <td>The page number to retrieve. Defaults to 1.</td>
                                    <td>No</td>
                                </tr>
                                <tr>
                                    <td>per_page</td>
                                    <td>integer</td>
                                    <td>The number of products per page. Defaults to 20.</td>
                                    <td>No</td>
                                </tr>
                            </table>
                            <p>Returns a list of all menus.</p>
                        </div>
                        <!-- <div class="method">
                    <h3>GET /products/{id}</h3>
                    <pre>
          curl https://api.example.com/products/1
        </pre>
                    <p>Returns a single product by ID.</p>
                </div> -->
                        <div class="method">
                            <h3>POST /menus</h3>
                            <pre>
curl -X POST https://site205.webte.fei.stuba.sk/samadycv2/server/api.php \\
-H "Content-Type: application/json" \\
-d '{"restaurant_id": "4", "dish": "kebab",
      "type": "2.", "price":"8 Eur"}'</pre>
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Required</th>
                                </tr>
                                <tr>
                                    <td>Restaurant ID</td>
                                    <td>int</td>
                                    <td>The restaurant id</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>Dish</td>
                                    <td>string</td>
                                    <td>The menu dish.</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>price</td>
                                    <td>string</td>
                                    <td>The price of the menu.</td>
                                    <td>no</td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>string</td>
                                    <td>The type of the menu.</td>
                                    <td>no</td>
                                </tr>
                            </table>
                            <p>Creates a new menu.</p>
                        </div>
                        <div class="method">
                            <h3>PUT /menu/{id}</h3>
                            <pre>
curl -X PUT https://site205.webte.fei.stuba.sk/samadycv2/server/api.php \
-H "Content-Type: application/json" \
-d '{"id","1", "restaurant_id": "4", "dish": "kebab",
      "type": "2.", "price":"8 Eur"}'
                </pre>
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Required</th>
                                </tr>
                                <tr>
                                    <td>Menu ID</td>
                                    <td>int</td>
                                    <td>The menu id</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>Restaurant ID</td>
                                    <td>int</td>
                                    <td>The restaurant id</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>Dish</td>
                                    <td>string</td>
                                    <td>The menu dish.</td>
                                    <td>Yes</td>
                                </tr>
                                <tr>
                                    <td>price</td>
                                    <td>string</td>
                                    <td>The price of the menu.</td>
                                    <td>no</td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>string</td>
                                    <td>The type of the menu.</td>
                                    <td>no</td>
                                </tr>
                            </table>
                            <p>Updates an existing menu by ID.</p>
                        </div>
                        <div class="method">
                            <h3>DELETE /menu/{id}</h3>
                            <pre>
curl -X DELETE https://site205.webte.fei.stuba.sk/samadycv2/server/api.php
        </pre>
                            <p>Deletes an existing menu by ID.</p>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <?php include './components/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>