<?php

class SeatService implements SeatServiceInterface  {

    private static $seatPlan = array();
   
    static function getSeatingPlan() : Array {
            return self::$seatPlan;
        }

    static function generateSeatingPlan(int $rowNums, int $rowWidth, int $islePos = 0)   {

        for($r=0; $r<$rowNums+1;$r++){
           for($s=0;$s<$rowWidth;$s++){
                
                //Create the seat
               $seat = new Seat($r+1,$s+1);
                
                if($s != $islePos-1){
                    //legroom
                    if($r==0){
                        $seat->setlegRoom();
                    }
                    //window seat
                    if($s==0 || $s == $rowWidth-1){
                        $seat->setWindowSeat();
                    }                
                    //isle before
                     if($s == $islePos-2) {
                        $seat->setIsleSeat();
                     }
                    //isle after
                    if($s == $islePos){
                        $seat->setIsleSeat();
                    }
            self::$seatPlan[$r][$s]= $seat;        
            }
            else{
                $isle = new Isle();
                self::$seatPlan[$r][$s] = $isle;
            }
        }
    }
        //Record the seating Plan parameters
        self::$seatPlan["rowNum"]= $rowNums+1;
        self::$seatPlan["rowWidth"] = $rowWidth;
        self::$seatPlan["islePos"] = $islePos;

        return  self::$seatPlan;
    }
  

    static function serialize($seatingPlan) : string {
        $contents = "";
        // var_dump($seatingPlan);
        for($x=0;$x<$seatingPlan["rowNum"]-1;$x++){
            for($y=0; $y<$seatingPlan["rowWidth"];$y++){
                //Append the Seat to the seatingPlan
                $contents .= $seatingPlan[$x][$y]."|";
            }
                //last seat = put a seperating pipe
                $contents .= "\n";
        }
        return $contents;
    }

    //Parse out the file contents back to a seathing Plan
    static function parse($serializedSeatingPlan)    {
        //A place to store the new seating plan
        $seatingPlan = array(); 
        $windowSeat = 0;
        $isleseat = 0;
        $legRoom = 0;
        $occupied = 0;
        $islePos= 0;
        $windowOccupied=0;
        $isleOccupied = 0;
        $legRoomOccupied =0;

        $rows = explode("\n", $serializedSeatingPlan);
       
        for($r=0;$r<count($rows);$r++){
            $seating = explode("|",$rows[$r]);
            array_pop($seating);
                    //Explode the seat if its a seat, isle if isle
                for($s=0;$s<count($seating);$s++){ 
                    $parameters = explode(",", $seating[$s]);
                        //record the islePosition
                        if($seating[$s] == "Isle"){ 
                            $isle = new Isle();
                            $seatingPlan[$r][$s] = $isle;
                            $islePos = $s+1;
                        }
                       
                        //If its not a string I know that its a seat.
                        else{
                            $seat = new Seat($r,$s);
                            if($parameters[5] == "1")
                            {
                            $occupied++;
                            $seat->setOccupied();
                            
                                if($parameters[3] == "1") {
                                    $windowOccupied++;
                                }
                                if($parameters[2] == "1") {
                                    $isleOccupied++;
                                }
                                if($parameters[4]=="1"){
                                    $legRoomOccupied++;
                                    
                                }
                            }
                            if($parameters[3] == "1"){
                                $windowSeat++;
                                $seat->setWindowSeat();
                            }
                            if($parameters[2] == "1"){
                            $isleseat++;
                            $seat->setIsleSeat();
                            }
                            if($parameters[4]=="1"){
                            $legRoom++;
                            $seat->setLegRoom();
                            }
                        $seatingPlan[$r][$s] = $seat;
                    }
                }
            } 
            //getting seats count to put it in array
            $seatNum = explode("|",$rows[0]);
            if(in_array("Isle",$seatNum)){
             $seatCount =count($seatNum)-1;
            }
            else{
            $seatCount = count($seatNum);
            }
            
        $seatingPlan["rowWidth"] =$seatCount;
        $seatingPlan["islePos"] = $islePos;
        $seatingPlan["rowNum"] = count($rows);
        $seatingPlan["isleSeat"] = $isleseat;
        $seatingPlan['windowSeat'] = $windowSeat;
        $seatingPlan['legRoom'] = $legRoom;
        $seatingPlan['occupied'] = $occupied;
        $seatingPlan["windowOccupied"] = $windowOccupied;
        $seatingPlan["isleOccupied"] = $isleOccupied;
        $seatingPlan["legRoomOccupied"] = $legRoomOccupied;
       
        return $seatingPlan;
    }

    
}

?>