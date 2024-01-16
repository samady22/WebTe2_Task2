<?php
include './Database.php';
class SitesController
{
    public function __construct()
    {
    }
    public function  savePageContent($db, $url, $name)
    {
        // error message
        $errorMsg = '';
        // cURL initialization
        $ch = curl_init();

        // Configure cURL: set the URL and return type to string.
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute the cURL request.
        $output = curl_exec($ch);

        // Close the cURL connection.
        curl_close($ch);

        // Insert the page content into the database.
        try {
            $query = "SELECT name FROM sites WHERE name='$name'";
            $query_run = mysqli_query($db, $query);
            if (mysqli_num_rows($query_run) == 0) {
                $stmt = $db->prepare("INSERT INTO sites (name, html) VALUES (?, ?)");
                $stmt->bind_param("ss", $name, $output);
                $stmt->execute();
                $stmt->close();
                $errorMsg = "Page data saved.";
            }
        } catch (Exception $e) {
            $errorMsg = "Somethign went wrong: " . $e->getMessage();
        }
        return $errorMsg;
    }

    public function getMenuFromDB($db, $name)
    {
        // Function get the html data from DB.
        try {
            $page_content = "";
            $sql = "SELECT html FROM sites WHERE name = '$name' LIMIT 1";

            $result = mysqli_query($db, $sql);
        } catch (Exception $e) {
            echo $e->getMessage();
        }



        if (mysqli_num_rows($result) == 1) {
            // Data exist with the given name
            $row = mysqli_fetch_assoc($result);
            $page_content = $row["html"];
        } else {
            echo "No data with the given name.";
        }

        return $page_content;
    }
    public function parseFreeFoodMenu($db, $output, $name)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($output);
        $xpath = new DOMXPath($dom);
        $menu_lists = $xpath->query('//ul[contains(@class, "daily-offer")]');
        $free_food = $menu_lists[1];
        try {
            $stmt = $db->prepare("INSERT INTO restaurant (name) VALUES (?)");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->close();
            $resId = $db->insert_id;
        } catch (Exception) {
            $query = "SELECT id FROM restaurant WHERE name='$name'";
            $query_run = mysqli_query($db, $query);
            $result = mysqli_fetch_assoc($query_run);
            $resId = $result['id'];
        }

        foreach ($free_food->childNodes as $day) {
            // Ignore DOMText nodes.
            if ($day->nodeType === XML_ELEMENT_NODE) {
                // Get the date and split it into day and date parts.
                $datum = explode(',', $day->firstElementChild->textContent);
                // Iterate over the daily offers.
                foreach ($day->lastElementChild->childNodes as $ponuka) {
                    // Get the offer type, dish name, and price.
                    $type = $ponuka->firstElementChild;
                    $price = $ponuka->lastElementChild;
                    $dish = trim($ponuka->textContent);
                    try {
                        $stmt = $db->prepare("INSERT INTO menu (restaurant_id, day, type, dish, price) VALUES ('$resId','$datum[0]','$type->textContent','$dish','$price->textContent')");
                        $stmt->execute();
                        $stmt->close();
                    } catch (Exception $e) {
                        continue;
                        // echo $e->getMessage();
                    }
                }
            }
        }
    }
    public function parseEatAndMeet($db, $output, $name)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($output);
        $xpath = new DOMXPath($dom);
        $menu_lists = $xpath->query('//div[contains(@class, "tab-content weak-menu")]');
        $eatAndMeet = $menu_lists[0];

        try {
            $stmt = $db->prepare("INSERT INTO restaurant (name) VALUES (?)");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->close();
            $resId = $db->insert_id;
        } catch (Exception) {
            $query = "SELECT id FROM restaurant WHERE name='$name'";
            $query_run = mysqli_query($db, $query);
            $result = mysqli_fetch_assoc($query_run);
            $resId = $result['id'];
        }

        $weekdays = array('Pondelok', 'Utorok', 'Streda', 'Stvrtok', 'Piatok', 'Sobota', 'Nedela');
        $day = $weekdays[0];
        $counter = 0;
        $countDay = 0;
        foreach ($eatAndMeet->childNodes as $children) {
            foreach ($children->childNodes as $child) {
                foreach ($child->firstElementChild->childNodes as $item) {
                    $text1 = $item->firstElementChild->textContent;
                    $text2 = $item->lastElementChild->textContent;
                    $text = $text1 . " " . $text2;
                    if (strlen($text) != 1) {
                        $pattern = '/([\p{L}\s\d]+)\s(\d+,\d+\s€)\s\/\s(\d+,\d+\s€)\s([\p{L}\s\d\(\),]+)/u';
                        // Match the pattern against the text
                        preg_match($pattern, $text, $matches);
                        // Extract the desired information from the matches array
                        $item_name = $matches[1];      // "Polievka 1"
                        $price = $matches[2];          // "0,70 €"
                        $text_after_price = $matches[4];
                        // Store the extracted information in an array
                        $counter++;
                        try {
                            $stmt = $db->prepare("INSERT INTO menu (restaurant_id, day, type, dish, price) VALUES ('$resId','$day','$item_name','$text_after_price','$price')");
                            $stmt->execute();
                            $stmt->close();
                        } catch (Exception $e) {
                            continue;
                            // echo $e->getMessage();
                        }
                    }
                }
            }
            if ($counter == 9) {
                $counter = 0;
                $day = $weekdays[++$countDay];
            }
        }
    }
    public function mlynskaKoliba($db, $output, $name)
    {
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $output);
        $xpath = new DOMXPath($dom);
        $menu_lists = $xpath->query('//section[contains(@id, "done-section")]');

        $mlynskaKoliba = $menu_lists[0];
        try {
            $stmt = $db->prepare("INSERT INTO restaurant (name) VALUES (?)");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->close();
            $resId = $db->insert_id;
        } catch (Exception) {
            $query = "SELECT id FROM restaurant WHERE name='$name'";
            $query_run = mysqli_query($db, $query);
            $result = mysqli_fetch_assoc($query_run);
            $resId = $result['id'];
        }

        $counter = 0;
        foreach ($mlynskaKoliba->childNodes as $children) {
            if ($counter < 2) {
                $counter++;
                continue;
            }
            foreach ($children->childNodes as $child) {
                // Check if the child element has text content.
                if (!empty(trim($child->textContent))) {
                    foreach ($child->childNodes as $node) {
                        $children = $node->childNodes;
                        $day = $children->item(0)->textContent;
                        $middle_child = $children->item(intdiv($children->length, 2))->textContent;
                        $last_child = $children->item($children->length - 1)->textContent;

                        $items = explode("MENU", $middle_child); // split the string into individual items
                        foreach ($items as $item) {
                            $parts = explode(":", $item); // split each item into its word and meaning
                            $type = trim($parts[0]); // remove any extra white space around the word
                            $dish = trim($parts[1]); // remove any extra white space around the meaning
                            try {
                                $stmt = $db->prepare("INSERT INTO menu (restaurant_id, day, type, dish) VALUES ('$resId','$day','$type','$dish')");
                                $stmt->execute();
                                $stmt->close();
                            } catch (Exception $e) {
                                continue;
                                // echo $e->getMessage();
                            }
                        }
                    }
                }
            }
        }
    }
    public function eraseData($db)
    {
        $query = "DELETE FROM restaurant";
        $result = $db->query($query);
        $query1 = "DELETE FROM sites";
        $result1 = $db->query($query1);

        if ($result && $result1) {
            echo "All data deleted successfully";
        } else {
            echo "Error deleting data: " . $db->error;
        }
    }
}
