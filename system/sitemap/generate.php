<?php define("FRONTEND",true);
$portal_ID = '1';
$to_root = '..';
require_once ($to_root."/config.php");
require_once ("SitemapGenerator.php");
$generator = new \Icamys\SitemapGenerator\SitemapGenerator(FRONTEND_URL);
// will create also compressed (gzipped) sitemap
$generator->createGZipFile = false;
// determine how many urls should be put into one file
// according to standard protocol 50000 is maximum value (see http://www.sitemaps.org/protocol.html)
$generator->maxURLsPerSitemap = 50000;
// sitemap file name
$generator->sitemapFileName = "../../sitemaps.xml";
// sitemap index file name
$generator->sitemapIndexFileName = "sitemap-index.xml";

if(module_enabled(4)) {
  
  }
//WEBCAMS CAT
if(module_enabled(3)) {
  $get_webcams_cat = $mysqli->query("
      SELECT evolve_webcam_cat_data.seo_id
      FROM evolve_webcam_cat
      
      
      LEFT JOIN evolve_webcam_cat_data
      ON evolve_webcam_cat_data.for_instance_id = evolve_webcam_cat.id
        AND evolve_webcam_cat_data.lang = '$language'
      ORDER BY evolve_webcam_cat.position ASC 
      ");
  //if(!$get_webcams_cat) print_r($mysqli->error);
  while($cat = $get_webcams_cat->fetch_assoc()) {
    //$datetime = new DateTime($webcam['last_edit_time']);
    //$lastEdit_date = $datetime->format(DateTime::ATOM);
    // adding url `loc`, `lastmodified`, `changefreq`, `priority`
    $generator->addUrl($cat['seo_id'],'','weekly','0.3');
  }
  // /WEBCAMS CAT
  //WEBCAMS
  $wc_slug = $mysqli->query("
  SELECT evolve_webcams_seoid.*
  FROM evolve_webcams_seoid
  WHERE evolve_webcams_seoid.lang = '$language'
  ");
  //if(!$wc_slug) print_r($mysqli->error);
  $sl = $wc_slug->fetch_array(MYSQLI_ASSOC);
  $get_webcam_list = $mysqli->query("
      SELECT 
      evolve_webcams_data.seo_id,
      evolve_webcams.last_edit_time,
      evolve_webcams.date_start 
      FROM evolve_webcams
      
      LEFT JOIN evolve_webcams_data
      ON evolve_webcams_data.for_wcam = evolve_webcams.id
        AND evolve_webcams_data.lang =  '$language'
        
      WHERE evolve_webcams.published = '1' 
        AND evolve_webcams_data.seo_id != ''
      
      ORDER BY evolve_webcams.last_edit_time DESC 
      ");
  //if(!$get_webcam_list) print_r($mysqli->error);
  while($webcam = $get_webcam_list->fetch_assoc()) {
    $time = ($webcam['last_edit_time']?$webcam['last_edit_time']:$webcam['date_start ']);
    $datetime = new DateTime($time);
    $lastEdit_date = $datetime->format(DateTime::ATOM);
    // adding url `loc`, `lastmodified`, `changefreq`, `priority`
    $generator->addUrl($sl['seo_id'].'/'.$webcam['seo_id'],$lastEdit_date,'always','0.5');
  }
}
// /WEBCAMS
// generating internally a sitemap
$generator->createSitemap();
// update robots.txt file
//$generator->updateRobots();
// writing early generated sitemap to file
$generator->writeSitemap();
// submit sitemaps to search engines
//$generator->submitSitemap();
 ?>