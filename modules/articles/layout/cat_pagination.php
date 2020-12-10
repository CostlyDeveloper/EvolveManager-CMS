<?php
if ($total_rows > $no_of_records_per_page){
  
  $hidden = '';
  if ($total_rows < ($no_of_records_per_page * 5)){
    
    $hidden = 'class="hidden"';
    }

?>
<ul class="pagination">
  <li <?php echo $hidden ?>>
    <a href="javascript:{}" onclick="document.getElementById('pag_first').submit();"><?php lang('pagination_first')?></a>
  </li>
  <li class="<?php echo ($pageno <= 1)? 'hidden disabled' : ''; ?>">
    <a href="javascript:{}" onclick="document.getElementById('pag_prev').submit();"><?php lang('pagination_prev')?></a>
  </li>
  <?php for ($x = 1; $x <= $total_pages; $x++) { ?>
  <li class="<?php echo ($pageno == $x) ? 'disabled active' : ''; ?>">
    <a href="javascript:{}" onclick="document.getElementById('pag_no<?php echo $x ?>').submit();"><?php echo $x ?></a>
  </li>
  <?php } ?>
  <li class="<?php echo ($pageno >= $total_pages) ? 'hidden disabled': ''; ?>">
    <a href="javascript:{}" onclick="document.getElementById('pag_next').submit();"><?php lang('pagination_next')?></a>
  </li>
  <li <?php echo $hidden ?>>
    <a href="javascript:{}" onclick="document.getElementById('pag_last').submit();"><?php lang('pagination_last')?></a>
  </li>
</ul>

<form id="pag_first" action="#" method="post">
  <input type="hidden" name="pageno" value="1"/>
</form>
<form id="pag_prev" action="#" method="post">
  <input type="hidden" name="pageno" value="<?php  echo ($pageno <= 1) ? '1' : ($pageno - 1); ?>"/>
</form>
<form id="pag_next" action="#" method="post">
  <input type="hidden" name="pageno" value="<?php  echo ($pageno >= $total_pages) ? $total_pages : ($pageno + 1); ?>"/>
</form>
<form id="pag_last" action="#" method="post">
  <input type="hidden" name="pageno" value="<?php echo $total_pages; ?>"/>
</form>
<?php for ($x = 1; $x <= $total_pages; $x++) { ?>
<form id="pag_no<?php echo $x ?>" action="#" method="post">
  <input type="hidden" name="pageno" value="<?php echo $x; ?>"/>
</form>  
<?php } 

}?>