<?php

class Seat implements SeatInterface {

    //Store all the member attributes
    private $_rowNo;
    private $_seatNo;
    private $_isleSeat = false;
    private $_windowSeat=false;
    private $_occupied=false;
    private $_legRoom= false;
    private $_price= 200;
    
    public function __construct(int $rowNo, int $seatNo)   {
        $this->_rowNo = $rowNo;
        $this->_seatNo = $seatNo;
    }

    public function getRowNo():int{
        return $this->_rowNo;
    }
    public function setRowNo(int $rowNo){
        $this->_rowNo = $rowNo;
    }
    public function getSeatNo():int{
        return $this->_seatNo;
    }
    public function setSeatNo(int $seatNo){
        $this->_seatNo = $seatNo;
    }
    public function getIsleSeat(){
        return $this->_isleSeat;
    }
    public function setIsleSeat(){
        $this->_isleSeat= true;
    }
    public function getOccupied(): bool{
        return $this->_occupied;
    }
    public function setOccupied(){
        $this->_occupied = true;
    }
    public function getLegRoom(): bool{
        return $this->_legRoom;
    }
    public function setLegRoom(){
        $this->_legRoom = true;
    }
    public function getIsWindowSeat(): bool{
        return $this->_windowSeat;
    }
    public function setWindowSeat(){
        $this->_windowSeat = true;
    }
   
    //Implement toString because there is no html we can use this to output to our file
    public function __toString() : string {

        $seatString  = "";
        $seatString .= $this->_rowNo.",".$this->_seatNo.",".$this->_isleSeat.",".$this->_windowSeat.",".$this->_legRoom.",".$this->_occupied;

       return $seatString;
    }

    function getPrice() : int  {
        
        if($this->_windowSeat == true){
            $this->_price += 20;
        }
        if($this->_isleSeat == true){
            $this->_price += 15;
        }
        if($this->_legRoom == true){
            $this->_price +=50;
        }
        return $this->_price;
    }

}

?>