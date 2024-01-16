<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Methods</title>
</head>

<body>
    <?php include './components/header.php' ?>

    <div class="">
        <div class="card">
            <div class="card-header">
                <h5 class="m-0">REST API Test Page</h5>
            </div>
            <div class="card-body">

                <div class="d-flex justify-content-end align-items-center mb-3">
                    <form action="../server/service.php" method="post" class="mx-2">
                        <button name="download" type="submit" class="btn btn-primary btn-sm">Download</button>
                    </form>
                    <form action="../server/service.php" method="post" class="mx-2">
                        <button name="parse" type="submit" class="btn btn-secondary btn-sm">Parse</button>
                    </form>
                    <form action="../server/service.php" method="post" class="mx-2">
                        <button name="erase" type="submit" class="btn btn-danger btn-sm">Erase</button>
                    </form>
                </div>

                <hr>

                <h6 class="text-center">GET Method</h6>
                <form action="../server/api.php" method="GET">
                    <button class="btn btn-success btn-sm mb-3" type="submit">Submit</button>
                </form>

                <hr>

                <h6 class="text-center">POST Method</h6>
                <form action="../server/api.php" method="POST">
                    <div class="mb-3">
                        <label for="res_id" class="form-label">Restaurant ID:</label>
                        <input type="number" class="form-control" id="res_id" name="restaurant_id">
                    </div>
                    <div class="mb-3">
                        <label for="day" class="form-label">Day:</label>
                        <input type="text" class="form-control" id="day" name="day">
                    </div>
                    <div class="mb-3">
                        <label for="dish" class="form-label">Dish:</label>
                        <input type="text" class="form-control" id="dish" name="dish">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="text" class="form-control" id="price" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type:</label>
                        <input type="text" class="form-control" id="type" name="type">
                    </div>
                    <button class="btn btn-success btn-sm mb-3" type="submit">Submit</button>
                </form>

                <hr>

                <h6 class="text-center">PUT Method</h6>
                <form action="../server/api.php" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-3">
                        <label for="menu_id" class="form-label">Menu ID:</label>
                        <input type="number" class="form-control" id="menu_id" name="menu_id">
                    </div>
                    <div class="mb-3">
                        <label for="res_id" class="form-label">Restaurant ID:</label>
                        <input type="number" class="form-control" id="res_id" name="restaurant_id">
                    </div>
                    <div class="mb-3">
                        <label for="day" class="form-label">Day:</label>
                        <input type="text" class="form-control" id="day" name="day">
                    </div>
                    <div class="mb-3">
                        <label for="dish" class="form-label">Dish:</label>
                        <input type="text" class="form-control" id="dish" name="dish">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="text" class="form-control" id="price" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type:</label>
                        <input type="text" class="form-control" id="type" name="type">
                    </div>
                    <button class="btn btn-success btn-sm mb-3" type="submit">Submit</button>
                </form>
                <hr>

                <h6 class="text-center">DELETE Method</h6>
                <form action="../server/api.php" method="POST">
                    <input type="hidden" name="_method" value="DELETE">

                    <div class="mb-3">
                        <label for="res_id" class="form-label">Menu ID:</label>
                        <input type="number" class="form-control" id="menu_id" name="menu_id">
                    </div>
                    <button class="btn btn-danger btn-sm mb-3" type="submit">Submit</button>
                </form>

            </div>
        </div>
    </div>
    <?php include './components/footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-/dXN6L0vZZQGJqeuJy0AZkpz9lXomZTEOrnP/nKOWTJU6TQOksdQRVvoxMfooAoK" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/esm/popper-core"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-XVsF2QjKpJhvZzg1nKPfE8KvAQuLtbFy0n6L/0zHvQ9jZgkduhxDX0wW8YjKd+P+" crossorigin="anonymous"></script>
</body>

</html>