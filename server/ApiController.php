<?php
// Define the API controller class
class MyApiController
{
    private $headers;

    public function __construct()
    {
        $this->headers = [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ];
    }


    /**
     * READ method
     * @param $db
     * @return void
     */
    public function read($db)
    {
        try {

            $stmt = $db->query('SELECT * from menu');
            $menu = array();
            while ($row = mysqli_fetch_assoc($stmt)) {
                $menu[] = $row;
            }
            $this->headers;
            http_response_code(200);
            $response = array(
                'message' => "Data successfully retrived",
                'status' => http_response_code(200),
                'data' => $menu
            );
            // Encode response as JSON and output
            echo json_encode($response, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            $this->headers;
            http_response_code(500);
            $response = array(
                'message' => 'server error',
                'status' => http_response_code(500),
                'data' => []
            );
            // Encode response as JSON and output
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
        // echo json_encode(array('success' => 'Data read controller successfully'));
    }

    /**
     * CREATE method 
     * @param $db
     * @param $data
     * @return void
     */
    public function create($db, $data)
    {
        $this->headers;
        $restaurant_id = $data['restaurant_id'];
        $price = $data['price'];
        $day = $data['day'];
        $dish = $data['dish'];
        $type = $data['type'];
        try {

            $stmt1 = $db->query("select dish from menu where menu.dish ='$dish'");
            if (mysqli_num_rows($stmt1) > 0) {
                http_response_code(409);
                $response = array(
                    'message' => "Dish already exist",
                    'status' => http_response_code(409),
                    'data' => []
                );
                // Encode response as JSON and output
                echo json_encode($response, JSON_PRETTY_PRINT);
            } else {

                $stmt = $db->query("INSERT INTO menu (restaurant_id, price, day, dish, type) VALUES ('$restaurant_id','$price','$day','$dish','$type');");

                http_response_code(201);
                $response = array(
                    'message' => "Successfully created",
                    'status' => http_response_code(201),
                    'data' => []
                );
                // Encode response as JSON and output
                echo json_encode($response, JSON_PRETTY_PRINT);
            }
        } catch (Exception $e) {
            $this->headers;
            http_response_code(500);
            $response = array(
                'message' => 'server error',
                'status' => http_response_code(500),
                'data' => []
            );
            // Encode response as JSON and output
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
    }

    /**
     * UPDATE method 
     * @param $db
     * @param $id
     * @param $data
     * @return void
     */
    public function update($db, $menu_id, $put_data)

    {

        try {
            if (empty($menu_id)) {
                $this->headers;
                http_response_code(400);
                echo json_encode(array('message' => 'Bad request', "status" => http_response_code(400), "data" => []));
            } else {
                // Retrieve data from request payload
                $type = $put_data['type'];
                $day = $put_data['day'];
                $price = $put_data['price'];
                $dish = $put_data['dish'];
                $res_id = $put_data['restaurant_id'];

                // Update database
                $stmt = $db->prepare("UPDATE menu SET type = ?, day = ?, price = ?, dish = ?, restaurant_id = ? WHERE id = ?");
                $stmt->bind_param("ssdsii", $type, $day, $price, $dish, $res_id, $menu_id);
                $stmt->execute();
                if (mysqli_affected_rows($db) > 0) {

                    // Set response headers
                    $this->headers;
                    http_response_code(200);

                    // Return success message
                    echo json_encode(array('message' => 'Data updated successfully', "status" => http_response_code(200), "data" => []));
                } else {
                    $this->headers;
                    http_response_code(400);

                    // Return success message
                    echo json_encode(array('message' => 'Bad request ', "status" => http_response_code(400), "data" => []));
                }
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array('message' => 'Server error' . $e->getMessage(), "status" => http_response_code(500), "data" => []));
        }
    }

    /**
     * DELETE method by id
     * @param $db
     * @param $id
     * @return void
     */
    public function delete($db, $id)
    {
        try {

            $this->headers;

            if (empty($id)) {
                $this->headers;
                http_response_code(400);
                echo json_encode(array('message' => 'Bad request', "status" => http_response_code(400), "data" => []));
            } else {
                $stmt = $db->query("DELETE FROM menu WHERE id = '$id'");
                $this->headers;
                http_response_code(200);
                echo json_encode(array('message' => 'Data deleted successfully', "status" => http_response_code(200), "data" => []));
            }
        } catch (Exception $e) {
            $this->headers;
            http_response_code(500);
            echo json_encode(array('message' => 'Server error ' . $e->getMessage(), "status" => http_response_code(500), "data" => []));
        }
    }
}
