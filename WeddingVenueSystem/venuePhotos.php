<?php 
//This file contains photos for the venues stored in the database
// The reason this file is PHP is that, ideally, these photos would be stored in the 
// database meaning they would be dealt with server-side, hence the user of a server-side language

$venuephotos = array("Central Plaza"=>array("CentralPlaza1.jpg","CentralPlaza2.jpg","CentralPlaza3.jpg","CentralPlaza4.jpg","CentralPlaza5.jpg","CentralPlaza6.jpg"),
                        "Pacific Towers Hotel"=>array("PacificTowersHotel1.jpg","PacificTowersHotel2.jpg","PacificTowersHotel3.jpg","PacificTowersHotel4.jpg","PacificTowersHotel5.jpg","PacificTowersHotel6.jpg"),
                        "Sky Center Complex"=>array("SkyCenterComplex1.jpg","SkyCenterComplex2.jpg","SkyCenterComplex3.jpg","SkyCenterComplex4.jpg","SkyCenterComplex5.jpg","SkyCenterComplex6.jpg"),
                        "Sea View Tavern"=>array("SeaViewTavern1.jpg","SeaViewTavern2.jpg","SeaViewTavern3.jpg","SeaViewTavern4.jpg","SeaViewTavern5.jpg","SeaViewTavern6.jpg"),
                        "Ashby Castle"=>array("AshbyCastle1.jpg","AshbyCastle2.jpg","AshbyCastle3.jpg","AshbyCastle4.jpg","AshbyCastle5.jpg","AshbyCastle6.jpg"),
                        "Fawlty Towers"=>array("FawltyTowers1.jpg","FawltyTowers2.jpg","FawltyTowers3.jpg","FawltyTowers4.jpg","FawltyTowers5.jpg","FawltyTowers6.jpg"),
                        "Hilltop Mansion"=>array("HilltopMansion1.jpg","HilltopMansion2.jpg","HilltopMansion3.jpg","HilltopMansion4.jpg","HilltopMansion5.jpg","HilltopMansion6.jpg"),
                        "Haslegrave Hotel"=>array("HaslegraveHotel1.jpg","HaslegraveHotel2.jpg","HaslegraveHotel3.jpg","HaslegraveHotel4.jpg","HaslegraveHotel5.jpg","HaslegraveHotel6.jpg"),
                        "Forest Inn"=>array("ForestInn1.jpg","ForestInn2.jpg","ForestInn3.jpg","ForestInn4.jpg","ForestInn5.jpg","ForestInn6.jpg"),
                        "Southwestern Estate"=>array("SouthwesternEstate1.jpg","SouthwesternEstate2.jpg","SouthwesternEstate3.jpg","SouthwesternEstate4.jpg","SouthwesternEstate5.jpg","SouthwesternEstate6.jpg")
);

$venuename = $_REQUEST["venuename"];
$result = $venuephotos[$venuename];

echo json_encode($result);

?>