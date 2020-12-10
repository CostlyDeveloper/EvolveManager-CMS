<?php 
if ($row['keywords']){
$keywords = explode(',', $row['keywords']); ?>
<div class="blog-tags margin-b-40">
  <h2><?php lang('tags_title')?></h2>
  <ul>
  <?php foreach ($keywords as $keyword){?>
  <li><a href="javascript:;"><i class="fa fa-tags"></i><?php echo $keyword ?></a></li>
<?php } ?>

  </ul>
</div>
<?php } ?>