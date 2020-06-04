<?php

//Config file
include_once("inc/config.inc.php");
//Interfaces
include_once("inc/interfaces/FileServiceInterface.php");
include_once("inc/interfaces/FlightInterface.php");
include_once("inc/interfaces/IsleInterface.php");
include_once("inc/interfaces/SeatInterface.php");
include_once("inc/interfaces/SeatServiceInterface.php");
//Classes
include_once("inc/classes/FileService.class.php");
include_once("inc/classes/Flight.class.php");
include_once("inc/classes/Isle.class.php");
include_once("inc/classes/Seat.class.php");
include_once("inc/classes/SeatService.class.php");
include_once("inc/classes/Page.class.php");
//Utility Classes
$page = new Page("Assignment 1 - Kseniia Skaletska");
$page->header();
if(isset($_GET["reset"])){//If someone hit reset//Write the blank file
FileService::write("");
}

if(isset($_GET['generate'])){

    $rowNum = $_GET["rows"];
    $seatNum = $_GET["seats"];
    $islePos = $_GET["isle"];
    SeatService::generateSeatingPlan($rowNum,$seatNum,$islePos);
    $generatedPlan = SeatService::getSeatingPlan();
    $contentForFile = SeatService::serialize($generatedPlan);
    FileService::write($contentForFile);
}

if(filesize(DATA_FILE) == 0){//If there is no data in the file make one based on the form parameters 
    $page->displayManifestform();
}
//If the file size is NOT zero  
else{ 
   if(isset($_GET['seat'])){
       //get row number and seat number
    $seatparam = explode("-", $_GET["seat"]);
    $rowNum = intval($seatparam[0]);//Cast the  $_GET variables to ints
    $seatNum = intval($seatparam[1]);

    $fileContent = FileService::read(DATA_FILE);//Pull the seating plan from the file
    // var_dump($fileContent);
    $parsedPlan=SeatService::parse($fileContent);//Parse the seating plan
    $parsedPlan[$rowNum][$seatNum]->setOccupied(); //Find the corresponding seat and set it to occupied
    $reserialized =SeatService::serialize($parsedPlan);//Re-serialize the seating plan
    
    FileService::write($reserialized);}//Write the seating Plan back to the file.

    $seatingPlanRead = FileService::read();//Read in the file seating plan
    $parsedNew =SeatService::parse($seatingPlanRead);  //Parse the seating plan
    $flight = new Flight();//Create the flight and assign the seating plan.
    $flight->assignSeatingPlan($parsedNew);
//New Page and header stuff...
if(empty($seatingPlanRead)){//Check the data file, if it is empty then present the form to create the seating plan.
    $page->displayManifestform();//Display the manifest form
}    
    
else{   //Otherwise show the seating plan from the flight and show the statistics
    $page->displaySeatingPlan($flight->getSeatingPlan());
    $statistics = $flight->generateStatistics();
    $page->displayStatistics($statistics);
}
}
$page->footer();

?>
