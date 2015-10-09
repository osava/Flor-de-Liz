<?php echo $header; ?>
<div class="container">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left) { ?>
    <?php $classl = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $classl = 'col-sm-12'; ?>
    <?php } ?>
    <div id="boss_content_top" class="<?php echo $classl; ?>"><?php echo $btcontenttop; ?></div>
  </div>
</div>
<div class="container">
  <div class="row"><div id="content_top"><?php echo $content_top; ?></div>
    <?php if ($column_right) { ?>
    <?php $classr = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $classr = 'col-sm-12'; ?>
    <?php } ?>
    <div id="boss_content_mid" class="<?php echo $classr; ?>"><?php echo $btcontentmid; ?></div>
    <?php echo $column_right; ?>
	<div id="content_bot"><?php echo $content_bottom; ?></div>
  </div>
</div>
<div id="boss_content_bot"><?php echo $btcontentbot; ?></div>
<?php echo $footer; ?>