<?php
    // This file contains a quick description of each venue to 
    // be displayed on the search page

    $descriptions = array(
                            "Central Plaza" => "A cozy courtyard on the banks of the River Derwent.",
                            "Pacific Towers Hotel" => "A beautiful escape to California, boasting expansive beaches and unrivaled luxury.",
                            "Sky Center Complex" => "Enjoy views like no other, having your moment high above the buzz of London.",
                            "Sea View Tavern" => "Hidden away in the atolls of the Maldives, experience a truly unique landscape.",
                            "Ashby Castle" => "Perfect for your dream, fairytale wedding, this monumental castle is steeped in millenia of history.",
                            "Fawlty Towers" => "An intimate setting for an imtimate experience. Fawlty Towers truly stands above the rest...in more than one way.",
                            "Hilltop Mansion" => "Breath-taking views from every angle, this mansion lies at the very peak of the Lake District.",
                            "Haslegrave Hotel" => "Experience luxury in the heart of Leicestershire, living like kings and queens for the day.",
                            "Forest Inn" => "Surrounded by lush, dense forest, experience a truly out-of-this-world wedding.",
                            "Southwestern Estate" => "Perfect for traditional weddings, this venue comes complete with themed dining room, chapel, and gardens."
    );

    $venuename = $_REQUEST["venuename"];
    $result = $descriptions[$venuename];

    echo json_encode($result);
?>