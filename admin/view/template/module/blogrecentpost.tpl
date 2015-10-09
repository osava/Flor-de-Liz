<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-bestseller" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
 <div class="container-fluid">
  <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
<div class="panel panel-default">
    <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3> 
	</div>
  <div class="panel-body">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-blogrecentpost" class="form-horizontal">
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_title; ?></label>
			<div class="col-sm-10">
				<?php foreach ($languages as $language) { ?>
					<div class="form-group">
						<div class="col-sm-11">
							<input name="title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($title[$language['language_id']]) ? $title[$language['language_id']] : ''; ?>" class="form-control" />
						</div>
						<div class="col-sm-1">
							<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_limit; ?></label>
			<div class="col-sm-10">
				<input type="text" name="limit" value="<?php echo isset($limit)?$limit:3; ?>" class="form-control" />
				<?php if ($error_limit) { ?>
					<div class="text-danger"><?php echo $error_limit; ?></div>
				<?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_image_width; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="image_width" value="<?php echo isset($image_width)?$image_width:''; ?>" class="form-control" />
			  <?php if ($error_width) { ?>
				<div class="text-danger"><?php echo $error_width; ?></div>
			  <?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo $entry_image_height; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="image_height" value="<?php echo isset($image_height)?$image_height:''; ?>" class="form-control" />
			  <?php if ($error_height) { ?>
				<div class="text-danger"><?php echo $error_height; ?></div>
			  <?php } ?>
			</div>
		</div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>       
    </form>
  </div>
</div>
</div>
<?php echo $footer; ?>