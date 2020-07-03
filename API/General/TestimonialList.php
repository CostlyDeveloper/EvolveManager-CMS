<?php

// if (isset($_POST['EvolveMaster'])) {

// define("FRONTEND", true);
$to_root = '../..';
require_once($to_root . "/system/config.php");

$result = $mysqli->query("
    SELECT evolve_testimonials.name,
           evolve_testimonials_data.occupation,
           evolve_testimonials_data.job_title,
           evolve_testimonials_data.city,
           evolve_testimonials_data.message,
           evolve_testimonials.folder, 
           evolve_testimonials_data.web_name,
           evolve_testimonials_data.rating
    
           
    FROM  evolve_testimonials
    
    LEFT JOIN evolve_testimonials_data
    ON evolve_testimonials.id = evolve_testimonials_data.for_instance
      
    WHERE evolve_testimonials.for_instance = '1' AND evolve_testimonials.published = '1'
    ORDER BY   evolve_testimonials.id DESC, evolve_testimonials.position ASC
  ");

//Fetch into associative array
while ( $row = $result->fetch_assoc())  {
    $db_data[]=$row;
}

//Print array in JSON format
echo json_encode($db_data);

// }
