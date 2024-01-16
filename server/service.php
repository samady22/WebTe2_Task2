<?php
require_once "./SitesController.php";
require_once "./Database.php";

$freefoodURL = "http://www.freefood.sk/menu/#free-food";
$eatAndMeedURL = "http://eatandmeet.sk/tyzdenne-menu";
$mlynskakolibaURL = "https://mlynskakoliba.sk/#done";

$database = new Database();
$db = $database->getConnection();
$siteContoller = new SitesController();


if (isset($_POST["download"])) {
    try {
        $saveToDB = $siteContoller->savePageContent($db, $freefoodURL, 'free-food');
        $saveToDB = $siteContoller->savePageContent($db, $eatAndMeedURL, 'eat-and-meet');
        $saveToDB = $siteContoller->savePageContent($db, $mlynskakolibaURL, 'mlynska-koliba');
        header("Location:../client/methods.php");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
if (isset($_POST["parse"])) {
    $output = $siteContoller->getMenuFromDB($db, "free-food");
    // parsing data
    $siteContoller->parseFreeFoodMenu($db, $output, "free-food");

    $output1 = $siteContoller->getMenuFromDB($db, "eat-and-meet");
    // parsing data
    $siteContoller->parseEatAndMeet($db, $output1, "eat-and-meeet");

    $output2 = $siteContoller->getMenuFromDB($db, "mlynska-koliba");
    // parsing data
    $siteContoller->mlynskaKoliba($db, $output2, "mlynska-koliba");
    header("Location:../client/methods.php");
}
if (isset($_POST["erase"])) {
    $siteContoller->eraseData($db);
    header("Location:../client/methods.php");
}
