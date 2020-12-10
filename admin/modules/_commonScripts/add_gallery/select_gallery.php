<?php
define("ADMIN", true);
$to_root = '../../../..';
require_once($to_root . "/system/config.php");

if (!isset($_POST['userID']) || !isset($_POST['cpass']) || !isset($_POST['token']) || !isset($_POST['rdts'])) {
    die_500();
}
security($_POST['userID'], $_POST['cpass'], $_POST['token'], $_POST['rdts'], $_SERVER['REQUEST_URI'], $last_ip);//First check
evolveAllow($_POST['userID'], $_POST['moduleID'], true);                                                        //Second check

if (isset($_POST["galID"])) {
    $gal_id = $_POST["galID"];
    get_gallery_selected_data($gal_id); ?>
    <span class="label label-warning unsaved"><?php echo $lang['notice_unsaved'] ?></span>
    <?php
} elseif (isset($_POST["focus"])) { //SHOW LAST 10 ON FOCUS
    $result_array = $mysqli->query('
    SELECT evolve_galleries.*
    FROM evolve_galleries 
    ORDER BY id DESC
    LIMIT 10
  ');
    if ($result_array->num_rows > 0) {
        foreach ($result_array as $result) { ?>
            <li class="result">
                <div data-id="<?php echo $result['id'] ?>" class="res"><?php echo $result['gallery_name'] ?></div>
            </li>
            <?php
        }
    }
    // /SHOW LAST 10 ON FOCUS
} else {
    //DO SEARCH
    $html = '';
    $html .= '<li class="result">';
    $html .= '<div data-id="gal_id" class="res">nameString</div>';
    $html .= '</li>';
    //$search_string = preg_replace("/[^A-Ža-ž0-9]/", " ", $_POST['query']);
    $search_string = $_POST['query'];
    // Check Length More Than One Character
    if (strlen($search_string) >= 1 && $search_string !== ' ') {
        $result_array = $mysqli->query('
      SELECT evolve_galleries.*
      FROM evolve_galleries 
      WHERE gallery_name LIKE "%' . $search_string . '%"
    ');
        if ($result_array->num_rows > 0) {
            foreach ($result_array as $result) {
                // Format Output Strings And Hightlight Matches
                $display_name = preg_replace("/" . $search_string . "/i", "<b class='highlight'>" . $search_string . "</b>", $result['gallery_name']);
                // Insert Name
                $output = str_replace('nameString', $display_name, $html);
                $output = str_replace('gal_id', $result['id'], $output);
                // Output
                echo($output);
            }
        } else {
            // Format No Results Output
            $output = str_replace('class="res">nameString</div>', '>' . $lang['no_results'] . '</div>', $html);
            // Output
            echo($output);
        }
    }
} // /DO SEARCH
?>
