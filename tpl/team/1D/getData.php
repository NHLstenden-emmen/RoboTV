<?php
    // Tijd van een wedstrijd bepalen
    function timeGame($game) {
        if(strpos(strtolower($game), "steen") === false) {
            return "5 minuten";
        } else {
            return "45 seconden";
        }
    }
    
    // Volledige Nederlandse spelnaam bepalen aan de hand van meegegeven naam
    function determineGame($game) {
        $game = strtolower($game);
        $alleSpellen = array("Steen, papier, schaar" => "sps/p", "Doolhof" => "maze/z/f", "Race" => "race/c", "Tekenen" => "draw/w/teken");
        foreach($alleSpellen as $key => $spel) {
            $vergelijkingsWaarden = explode("/", $spel);
            foreach($vergelijkingsWaarden as $vergelijkingsWaarde) {
                if(strpos($game, strtolower($vergelijkingsWaarde)) !== false) {
                    return $key;
                }
            }
        }
    }

    // Zorgen voor database object wanneer er wordt gerefreshed
    if(!isset($DB)) {
        define('Start', microtime(true));
        require_once '../../../config/classes/mysql.php';
        require_once '../../../config/classes/template.php';
        require_once '../../../config/Configuration.php';

        $DB             = new Database;
        $TPL            = new Template;
        $TPL->Output();
    }
    
    // Ophalen van de botnamen en deze aan de teams koppelen
    $botList = array("A" => null, "B" => null, "C" => null, "D" => null, "E" => null);
    $bots = $DB->Select("SELECT TeamID, RobotName FROM teams");
    foreach($bots as $bot) {
        $botList[substr($bot["TeamID"], 1)] = strtolower($bot["RobotName"]);
    }
    
    // Scores van de teams
    $arrayOfScores = array("A" => 0, "B" => 0, "C" => 0, "D" => 0, "E" => 0);
    
    $initialA = 0;
    $initialB = 0;
    $initialC = 0;
    $initialD = 0;
    $initialE = 0;

    // Uitvoeren van query voor het ophalen van de punten per team
    $points = $DB->Select("SELECT robot, SUM(score) AS score FROM punten WHERE robot IN ('Dimitri', 'BrokkoBot', 'ROBot Jetten', 'Wall-D', 'BumbleBert') GROUP BY robot");
    foreach($points as $point) {
        // Opslaan van punten bij het bijbehorende team
        $team = array_search(strtolower($point["robot"]), $botList);
        $score = $point["score"];
        $arrayOfScores[$team] = $score;
        
        // Opslaan van de punten voor het berekenen van de kansen
        $pointsVariable = "initial".$team;
        $$pointsVariable = $score;
    }
    
    // Te spelen spellen
    $wedstrijden = array("Steen, papier, schaar" => "sps/p", "Doolhof" => "maze/z/f", "Race" => "race/c", "Tekenen" => "draw/w/teken");
    
    // Ophalen van uitslagen
    $uitslagen = $DB->Select("SELECT * FROM resultaat WHERE robot IN ('Dimitri', 'BrokkoBot', 'ROBot Jetten', 'Wall-D', 'BumbleBert')");
    
    // Ophalen gespeelde spellen
    $gespeeldeSpel = $DB->Select("SELECT game, COUNT(*) AS gamesPlayed FROM punten GROUP BY game HAVING gamesPlayed = 5");
    
    // Verwijderen van gespeelde spellen uit wedstrijden-array
    foreach($wedstrijden as $key => $wedstrijd) {
        $vergelijkingsWaarden = explode("/", $wedstrijd);
        foreach($gespeeldeSpel as $spel) {
            foreach($vergelijkingsWaarden as $vergelijkingsWaarde) {
                if(strpos(strtolower($spel['game']), strtolower($vergelijkingsWaarde)) !== false) {
                    unset($wedstrijden[$key]);
                    break;
                }
            }
        }
    }
    
    $wedstrijden = array_keys($wedstrijden);
?>

        <div class="data currentRanking neonBlock" data-aos="fade-right" data-aos-duration="1000">
            <h3>Huidige stand</h3>
            <table>
                <?php
                    // Weergeven scores
                    foreach($arrayOfScores as $team => $score) {
                        echo "<tr id='team".$team."'>";
                        echo "<td>Team ".$team."</td>";
                        echo "<td>".$score."</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        <div class="data upcoming neonBlock" data-aos="fade-right" data-aos-duration="1250">
            <h3>Nog te spelen</h3>
            <div class="aankomend">
                <table>
                    <thead>
                        <tr>
                            <th>Spel</th>
                            <th>Wedstrijdlengte</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Het weergeven van de wedstrijden die nog gespeeld moeten worden
                            if(count($wedstrijden) > 0) {   
                                foreach($wedstrijden as $wedstrijd) {
                                    echo "<tr>";
                                    echo "<td>".ucfirst($wedstrijd)."</td>";
                                    echo "<td>".timeGame($wedstrijd)."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr>";
                                echo "<td colspan='2'>Er zijn geen wedstrijden gevonden</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="chance" class="data chances neonBlock" data-aos-anchor-placement="center-bottom" data-aos="fade-right" data-aos-duration="1100">
            <h3>Je kansen</h3>
            <?php include("chances.php"); ?>
        </div>
        <div class="data pastResults neonBlock" data-aos="fade-right" data-aos-duration="1600">
            <h3>Resultaten</h3>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Spel</th>
                            <th>Score</th>
                            <th>Team</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Weergeven resultaten
                            if(count($uitslagen) > 0) {
                                foreach($uitslagen as $uitslag) {
                                    echo "<tr>";
                                    echo "<td>".determineGame($uitslag['game'])."</td>";
                                    echo "<td>".$uitslag['score']."</td>";
                                    echo "<td>".array_search(strtolower($uitslag['robot']), $botList)."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr>";
                                echo "<td colspan='3'>Er zijn momenteel geen uitslagen</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>