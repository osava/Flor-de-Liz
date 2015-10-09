<?php global $config;?>
<?php
	$boss_manager = array(
		'option' => array(
			'bt_scroll_top' => true,
			'animation' 	=> true,
			'quick_view'   	=> false
		),
		'layout' => array(
			'mode_css'   => 'wide',
			'box_width' 	=> 1200,
			'h_mode_css'   => 'inherit',
			'h_box_width' 	=> 1200,
			'f_mode_css'   => 'inherit',
			'f_box_width' 	=> 1200
		),
		'status' => 1
	);
?>
<?php $footer_about = $config->get('boss_manager_footer_about'); ?>
<?php $footer_social = $config->get('boss_manager_footer_social'); ?>
<?php $footer_payment = $config->get('boss_manager_footer_payment'); ?>
<?php $footer_powered = $config->get('boss_manager_footer_powered'); ?>
<?php $footer_contact = $config->get('boss_manager_footer_contact'); ?>
<?php 
	if($config->get('boss_manager')){
		$boss_manager = $config->get('boss_manager'); 
	}else{
		$boss_manager = $boss_manager;
	} 
?>
	
<?php 
	//echo '<pre>';print_r($boss_manager); die(); echo '</pre>';
?>

<?php
	if(!empty($boss_manager)){
		$layout = $boss_manager['layout'];
		$footer_link = isset($boss_manager['footer_link'])?$boss_manager['footer_link']:'';
	}
	$f_style = '';
	if($layout['f_mode_css']=='fboxed'){
		$f_mode_css = 'bt-fboxed';
		$f_style = (!empty($layout['f_box_width']))?'style="max-width:'.$layout['f_box_width'].'px"':'';
	}else{
		$f_mode_css = '';
	}
?>
<div id="bt_footer" class="<?php echo $f_mode_css;?>" <?php echo $f_style;?>>
<footer>
  <div class="bt-footer-middle">
  <div class="container">
	<div class="row">
	  <div class="col-md-12">
	  <?php if($footer_about['status']){ ?> 
	  <div class="bt-block-footer col-sm-4 col-xs-12">
		<div class="col-xs-12">
		  <?php if($footer_about['image_status']){ ?>
			<a href="<?php echo $footer_about['image_url']; ?>"><img src="image/<?php echo$footer_about['image_link']; ?>" alt="Comohost" title="Comohost"/></a>
		  <?php } ?>
		<?php echo html_entity_decode($footer_about['about_content'][$config->get('config_language_id')],ENT_QUOTES, 'UTF-8'); ?>
		
		<?php if($footer_contact['status']){ ?> 
		<div class="footer-contact">
			<?php echo html_entity_decode($footer_contact['contact_content'][$config->get('config_language_id')],ENT_QUOTES, 'UTF-8'); ?>
		</div>
		<?php } ?>
		</div>
	  </div>
	  <?php } ?>
	  
	  <div class="col-sm-4 col-xs-12">
	  <!--Load modules in position footer middle-->
		<?php echo isset($btfootermid)?$btfootermid:''; ?>
	  </div>
	  
	  <?php if(isset($footer_link['newsletter']) && $footer_link['newsletter']){ ?>
	  <div class="col-sm-4 col-xs-12">
		<!--Load modules in position footer newsletter-->
		<?php echo isset($btnewsletter)?$btnewsletter:''; ?>
	  </div>
	  <?php } ?>
	  
	  <?php if($footer_social['status']){ ?>
		<div class="footer-social col-xs-4">
		<h3><?php echo html_entity_decode($footer_social['title'][$config->get('config_language_id')],ENT_QUOTES, 'UTF-8'); ?></h3>
		<ul>
			<?php if(isset($footer_social['face_status'])&&$footer_social['face_status']){ ?>
			<li><a class="facebook" href="<?php echo isset($footer_social['face_url'])?$footer_social['face_url']:'#'; ?>" title="Facebook"><i class="fa fa-facebook"></i></a></li>
			<?php } ?>
			<?php if(isset($footer_social['pinterest_status'])&&$footer_social['pinterest_status']){ ?>
			<li><a class="pinterest" href="<?php echo isset($footer_social['pinterest_url'])?$footer_social['pinterest_url']:'#'; ?>" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
			<?php } ?>
			<?php if(isset($footer_social['twitter_status'])&&$footer_social['twitter_status']){ ?>
			<li><a class="twitter" href="<?php echo isset($footer_social['twitter_url'])?$footer_social['twitter_url']:'#'; ?>" title="Twiter"><i class="fa fa-twitter"></i></a></li>
			<?php } ?>
			<?php if(isset($footer_social['googleplus_status'])&&$footer_social['googleplus_status']){ ?>
			<li><a class="google" href="<?php echo isset($footer_social['googleplus_url'])?$footer_social['googleplus_url']:'#'; ?>" title="Google plus"><i class="fa fa-google-plus"></i></a></li>
			<?php } ?>
			<?php if(isset($footer_social['rss_status'])&&$footer_social['rss_status']){ ?>
			<li><a class="rss" href="<?php echo isset($footer_social['rss_url'])?$footer_social['rss_url']:'#'; ?>" title="RSS"><i class="fa fa-rss"></i></a></li>
			<?php } ?>
			<?php if(isset($footer_social['youtube_status'])&&$footer_social['youtube_status']){ ?>
			<li><a class="youtube" href="<?php echo isset($footer_social['youtube_url'])?$footer_social['youtube_url']:'#'; ?>" title="YouTube"><i class="fa fa-youtube"></i></a></li>
			<?php } ?>
		</ul>
		</div>
	  <?php } ?>
	  </div>
	</div>
  </div>
  </div>
  
  <div class="bt-footer-bottom">
  <div class="container">
    <div class="row">
	  <div class="link">
		<ul class="list-unstyled">
		  <?php if(isset($footer_link['information']) && $footer_link['information']) { ?>
		  <?php if ($informations) { ?>
			<?php foreach ($informations as $information) { ?>
			  <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
			<?php } ?>
		  <?php } ?>
		  <?php } ?>
		  <?php if(isset($footer_link['contact_us']) && $footer_link['contact_us']){ ?>
		  <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
		  <?php } ?>
		  <?php if(isset($footer_link['return']) && $footer_link['return']){ ?>
		  <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
		  <?php } ?>
		  <?php if(isset($footer_link['site_map']) && $footer_link['site_map']){ ?>
		  <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
		  <?php } ?>
		  
		  <?php if(isset($footer_link['brands']) && $footer_link['brands']){ ?>
		  <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
		  <?php } ?>
		  <?php if(isset($footer_link['gift_vouchers']) && $footer_link['gift_vouchers']){ ?>
          <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
		  <?php } ?>
		  <?php if(isset($footer_link['affiliates']) && $footer_link['affiliates']){ ?>
          <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
		  <?php } ?>
		  <?php if(isset($footer_link['specials']) && $footer_link['specials']){ ?>
          <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
		  <?php } ?>
		  <?php if(isset($footer_link['newsletter']) && $footer_link['newsletter']){ ?>
		  <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
		  <?php } ?>
        </ul>
      </div>
	  
	  <div class="powered-payment">
		<div class="row">
		  <div class="powered col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<?php echo html_entity_decode($footer_powered[$config->get('config_language_id')],ENT_QUOTES, 'UTF-8'); ?>
		  </div>
		  <?php if($footer_payment['status']){ ?>
		  <div class="payment col-lg-6 col-md-6 col-sm-6 col-xs-12">
		  <ul>
			<?php if(isset($footer_payment['visa_status'])&&$footer_payment['visa_status']){ ?>
				<li><a title="Visa" href="<?php echo isset($footer_payment['visa_link'])?$footer_payment['visa_link']:'#'; ?>" class="visa"><img alt="Visa" src="image/catalog/<?php echo $config->get('config_template'); ?>/visa.jpg"></a></li>
			<?php } ?>
			<?php if(isset($footer_payment['master_status'])&&$footer_payment['master_status']){ ?>
				<li><a title="MasterCard" href="<?php echo isset($footer_payment['master_link'])?$footer_payment['master_link']:'#'; ?>" class="masterCard"><img alt="MasterCard" src="image/catalog/<?php echo $config->get('config_template'); ?>/master_card.jpg" /></a></li>
			<?php } ?>
			<?php if(isset($footer_payment['paypal_status'])&&$footer_payment['paypal_status']){ ?>
				<li><a title="Paypal" href="<?php echo isset($footer_payment['paypal_link'])?$footer_payment['paypal_link']:'#'; ?>" class="paypal"><img alt="Paypal" src="image/catalog/<?php echo $config->get('config_template'); ?>/paypal.jpg"></a></li>
			<?php } ?>
			<?php if(isset($footer_payment['merican_status'])&&$footer_payment['merican_status']){ ?>
				<li><a title="Merican" href="<?php echo isset($footer_payment['merican_link'])?$footer_payment['merican_link']:'#'; ?>" class="merican"><img alt="Merican" src="image/catalog/<?php echo $config->get('config_template'); ?>/american.jpg" /></a></li>
			<?php } ?>
			
			<?php if(isset($footer_payment['dhl_status'])&&$footer_payment['dhl_status']){ ?>
				<li><a title="DHL" href="<?php echo isset($footer_payment['dhl_link'])?$footer_payment['dhl_link']:'#'; ?>" class="dhl"><img alt="DHL" src="image/catalog/<?php echo $config->get('config_template'); ?>/dhl.jpg"></a></li>
			<?php } ?>
		  </ul>
		  </div>
		  <?php } ?>

		</div>
	  </div>
    </div>
  </div>
  </div>
</footer>
</div>
<?php if(isset($boss_manager['option']['bt_scroll_top'])&&($boss_manager['option']['bt_scroll_top'])){ ?>
<div id="back_top" class="back_top" title="Back To Top"><span><i class="fa fa-angle-up"></i></span></div>
 <script type="text/javascript">
        $(function(){
			$(window).scroll(function(){
				if($(this).scrollTop()>600){
				  $('#back_top').fadeIn();
				}
				else{
				  $('#back_top').fadeOut();
				}
			});
			$("#back_top").click(function (e) {
				e.preventDefault();
				$('body,html').animate({scrollTop:0},800,'swing');
			});
        });
</script> 
<?php } ?>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//--> 

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->
</div>
</body></html>