<?php
header('Content-Type: application/json');

require_once 'Duong2amlich.php';
$dateconverter = new Duong2amlich();

const TIMEZONE = '7.0';

$dateString = $_GET['date'];
if($dateString){
    $date = DateTime::createFromFormat('Y-m-d', $dateString);
    echo json_encode($dateconverter->convertSolar2Lunar($date->format('d'), $date->format('m'), $date->format('Y'), TIMEZONE));
} 

$dateString = $_GET['date_al'];
if($dateString) {
    function getDaysInYear($year, $findDate) {
        global $dateconverter;
        $currentDate = new DateTime("$year-01-01"); // January 1st of the specified year
    
        // Loop through each day of the year
        while ($currentDate->format('Y') == $year) {
            $date = clone $currentDate;
            $currentDate->modify('+1 day'); // Move to the next day
            $lunarDate = $dateconverter->convertSolar2Lunar($date->format('d'), $date->format('m'), $date->format('Y'), TIMEZONE);
            if ($findDate === "$lunarDate[0]-$lunarDate[1]"){
                return $date->format('d-m-Y');
            }
        }
    }
    
    $findDate = DateTime::createFromFormat('Y-m-d', $dateString);
    echo json_encode(getDaysInYear(date('Y'), $findDate->format('j-n')));
}
?>