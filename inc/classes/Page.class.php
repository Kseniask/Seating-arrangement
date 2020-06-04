<?php

class Page  {

    private $_title = "Please change title.";

    function __construct(string $title) {
        $this->_title = $title;
    }
   
    function header()   { ?>
    
    <!doctype html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <title><?php echo $this->_title; ?></title>
        </head>
        <body>
            <div class="container">
            <h1><?php echo $this->_title; ?></h1>

    <?php }

    function footer() { ?>
    
            </div>
    <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
    </html>

    <?php }

    function displaySeatingPlan(Array $seatingPlan)    {

                    //Show the number of rows
        echo "<table class='table'>";
                    for ($r = 1; $r <= $seatingPlan['rowWidth']; $r++) {
                        echo '<th>'.$r.'</th>';
                        
                    }
                    for($r = 0;$r<$seatingPlan["rowNum"]-1;$r++) {
                        echo '<tr>';
                        for($s=0;$s<$seatingPlan["rowWidth"];$s++){
                                //if index is Seat class -> check if occupied or not
                            if (is_a($seatingPlan[$r][$s], 'Seat'))  {
                                if ($seatingPlan[$r][$s]->getOccupied()) {
                                    echo '<td width="36px" height="44px"><img src="img/personicon.png"></td>';
                                } 
                                else {
                                    echo '<td width="36px" height="44px"><a href="?seat='.$r.'-'.$s.'">'.$seatingPlan[$r][$s]->getPrice().'</a></td>';  
                                }
                            }
                            else {
                                echo '<td width="36px" height="44px"> Isle </td>';
                            }
                        }  
                echo "</tr>";
            }
            echo "</table>";
         }


         function displayStatistics($stats)    {
             echo "<h2>Manifest statistics</h2>";
     $totalProg = 100*$stats["seatsBooked"]/$stats["totalSeats"];
    //  var_dump(intval($totalProg));
     $windowSeats = 100*$stats["windowSeatsBooked"]/$stats["totalWindowSeats"];
     $isleSeats = 100*$stats["isleSeatsBooked"]/$stats["totalIsleSeats"];
     $legSeats = 100*$stats["legRoomSeatsBooked"]/$stats["totalLegRoomSeats"];

    // <!-- <progress id="file" value="32" max="100"> 32% </progress>  -->
        echo"<table>";

        echo '<tr><td>Total seats:</td><td><progress  value="'.intval($totalProg).'" max="100">'.intval($totalProg).'%</progress></td></tr>';
        echo '<tr><td>Window seats:</td><td><progress  value="'.intval($windowSeats).'" max="100">'.intval($windowSeats).'%</progress></td></tr>';
        echo '<tr><td>Isle seats:</td><td><progress  value="'.intval($isleSeats).'" max="100">'.intval($isleSeats).'%</progress></td></tr>';
        echo '<tr><td>Leg Room seats:</td><td><progress  value="'.intval($legSeats).'" max="100">'.intval($legSeats).'%</progress></td></tr>';
        echo"</table>";
        echo '<form method="get" action=""><input type="submit" value="Clear Manifest" name="reset"></form>';

       }
    function displayManifestform()  { ?>

        <h3>Generate Manifest</h3>
        <p>Please create the manifest below by setting the various options and clicking "Generate Manifest"</p>
        <form method="get" action="">
        <label width="100px" for="rows">Number of Rows</label>
        <input type="text" id="rows" name="rows">
        <br>
        <label width="100px" for="seats">Row width(incl isle)</label>
        <input type="text" id="seats" name="seats">
        <br>
        <label width="100px" for="isle">Isle position</label>
        <input type="text" id="isle" name="isle">
        <br>
        <br>
        <input type="submit" value="Generate Manifest" name="generate">
        <br>

        </form>
    <?php }
}

?>