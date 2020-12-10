<?php if ($row['show_author'] OR $row['show_date']){ ?>

<ul class="blog-info">
<?php if ($row['show_author']){ ?>
  <li class="hidden"><i class="fa fa-user"></i> </li>
  <?php  }?>
  <?php if ($row['show_date']){
    $date = date('d.m.Y', strtotime($row['date'])); ?>
  <li><i class="fa fa-calendar"></i> <?php echo $date ?></li>
  <?php  }?>
</ul> 
<?php  }?>