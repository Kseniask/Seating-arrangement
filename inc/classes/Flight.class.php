<?php

class Flight implements FlightInterface   {

    //Store the flight number
    private $_flightNo = "";
    
    //Store the seating plan
    private $_seatingPlan = array();
    
    //Store the statistics
    private $_seatingStatistics = array();

    //assigns the seating plan to the object
    function assignSeatingPlan(Array $seatingPlan)  {
        $this->_seatingPlan = $seatingPlan;
    }

    //return the seating plan
    function getSeatingPlan() : Array {
        return $this->_seatingPlan;
    }

    function generateStatistics() : array   {
        $stats = array();
    
        $stats["totalSeats"] = ($this->_seatingPlan["rowWidth"]-1)*($this->_seatingPlan["rowNum"]-1);
        $stats["totalWindowSeats"] = $this->_seatingPlan["windowSeat"];
        $stats["totalIsleSeats"] =  $this->_seatingPlan["isleSeat"];
        $stats["totalLegRoomSeats"] = $this->_seatingPlan["legRoom"];
        $stats["seatsBooked"] = $this->_seatingPlan["occupied"];
        $stats["windowSeatsBooked"] = $this->_seatingPlan["windowOccupied"];
        $stats["isleSeatsBooked"] = $this->_seatingPlan["isleOccupied"];
        $stats["legRoomSeatsBooked"] = $this->_seatingPlan["legRoomOccupied"];
       
            $this->_seatingStatistics = $stats;
            return $this->_seatingStatistics;
    }
    
}