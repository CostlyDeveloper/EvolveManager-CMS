<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root . "/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
    die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);//Second check

$sort = $_POST['array'];

foreach ($sort as $position => $val) {
    $item_id = $val['id'];
    $have_child = 0;
    if (isset($val['children'])) {
        $have_child = 1;
    }
    $sql = $mysqli->query("    
      UPDATE evolve_menus_relations
      SET 
      position              = '$position',
      child_of              = '0',
      have_child            = '$have_child',
      level                 = '1'
      WHERE id = '$item_id'");

    if (isset($val['children'])) {// LEVEL 2
        foreach ($val['children'] as $position2 => $val2) {
            $have_child = 0;
            if (isset($val2['children'])) {
                $have_child = 1;
            }
            $item_id = $val2['id'];
            $position = $position2;
            $child_of = $val['id'];
            $sql = $mysqli->query("     
          UPDATE evolve_menus_relations
          SET 
          position              = '$position',
          child_of              = '$child_of',
          have_child            = '$have_child',
          level                 = '2'
          WHERE id = '$item_id'");

            if (isset($val2['children'])) {// LEVEL 3
                foreach ($val2['children'] as $position3 => $val3) {
                    $have_child = 0;
                    if (isset($val3['children'])) {
                        $have_child = 1;
                    }
                    $item_id = $val3['id'];
                    $position = $position3;
                    $child_of = $val2['id'];
                    $sql = $mysqli->query("     
              UPDATE evolve_menus_relations
              SET 
              position              = '$position',
              child_of              = '$child_of',
              have_child            = '$have_child',
              level                 = '3'
              WHERE id = '$item_id'");

                    if (isset($val3['children'])) {// LEVEL 4
                        foreach ($val3['children'] as $position4 => $val4) {
                            $have_child = 0;
                            if (isset($val4['children'])) {
                                $have_child = 1;
                            }
                            $item_id = $val4['id'];
                            $position = $position4;
                            $child_of = $val3['id'];
                            $sql = $mysqli->query("     
                  UPDATE evolve_menus_relations
                  SET 
                  position              = '$position',
                  child_of              = '$child_of',
                  have_child            = '$have_child',
                  level                 = '4'
                  WHERE id = '$item_id'");

                        }//FOREACH

                    }//LEVEL 4

                }//FOREACH

            }//LEVEL 3

        }//FOREACH

    }//LEVEL 2

}//FIRST FOREACH

//pr($_POST['array']);