<?php if(!empty($product_datas)){ ?>
<?php if ($type) { ?>
<div id="boss_pro_cate_column_<?php echo $module;?>" class="bt-product-category-column col-sm-<?php echo $column_css; ?> col-xs-12">
<div class="box-heading title"><h3><?php echo $heading_title; ?></h3></div>
<?php if ($large_image) { ?>
<div class="main-category col-xs-12">
	<div class="image">
		<a href="<?php echo $product_datas['href'];?>" title="<?php echo $product_datas['name']; ?>"><img src="<?php echo $product_datas['image']; ?>" alt="<?php echo $product_datas['name']; ?>" title="<?php echo $product_datas['name']; ?>"/></a>
	</div>
	<div class="detail">
		<h1><?php echo $product_datas['name'];?></h1>
		<p><?php echo $product_datas['count'];?> <?php echo $text_product; ?></p>
		<a href="<?php echo $product_datas['href'];?>" title="<?php echo $product_datas['name']; ?>"><?php echo $shop_now; ?></a>
	</div>
</div>
<?php } ?>
<div class="product-category-column">
	<?php if(!empty($product_datas['products'])){ ?>
	<?php $products = $product_datas['products']; ?>
	  <?php foreach ($products as $product) { ?>
		<div class="procate-item">
			<?php if ($product['thumb']) { ?>
			  <div class="image">
				<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/></a>
			  </div>
			<?php } ?>
			  
			<div class="pro-detail">
				<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
				
                <?php if ($product['rating']) { ?>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($product['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
				
                <?php if ($product['price']) { ?>
                <div class="price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span> 
                  <?php } ?>
                </div>
                <?php } ?>
			</div>
		</div>
	<?php } ?>
	<?php } ?>
</div>
</div>
<?php }else { ?>
<div class="bt-product-category" id="boss_pro_cate_<?php echo $module;?>">
<div class="box-heading title"><h1><?php echo $heading_title; ?></h1></div>
<?php if ($large_image) { ?>
<div class="main-category col-sm-4 col-xs-12">
	<div class="image">
		<a href="<?php echo $product_datas['href'];?>" title="<?php echo $product_datas['name']; ?>"><img src="<?php echo $product_datas['image']; ?>" alt="<?php echo $product_datas['name']; ?>" title="<?php echo $product_datas['name']; ?>"/></a>
	</div>
	<div class="detail">
		<h1><?php echo $product_datas['name'];?></h1>
		<p><?php echo $product_datas['count'];?> Products</p>
		<a href="<?php echo $product_datas['href'];?>" title="<?php echo $product_datas['name']; ?>">Shop Now</a>
	</div>
</div>
<?php } ?>
<div class="product-category <?php if ($large_image) { ?>col-sm-8 col-xs-12<?php } ?>">
	<?php if(!empty($product_datas['products'])){ ?>
	<?php $products = $product_datas['products'];?>
	<?php if(!$show_slider) { ?>
	  <?php foreach ($products as $product) { ?>
		<div class="procate-item product-grid col-sm-4 col-xs-12">
			  <?php if ($product['thumb']) { ?>
			  <div class="image">
				<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/></a>
			  </div>
			  <?php } ?>
			  
			  <div class="pro-detail">
				<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
				
                <?php if ($product['rating']) { ?>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($product['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
				
                <?php if ($product['price']) { ?>
                <div class="price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span> 
                  <?php } ?>
                </div>
                <?php } ?>
			  </div>
			  <div class="pro-button">
				<button class="btn-cart" type="button" onclick="btadd.cart('<?php echo $product['product_id']; ?>','<?php echo $product['minimum']; ?>');"><i class="fa fa-shopping-cart"></i> <?php echo $button_cart; ?></button>
			  </div>
		</div>
	  <?php } ?>
	<?php }else { ?>
		<section class="box-content">
		  <div id="boss_procate_<?php echo $module; ?>" class="carousel-content">
		  <?php foreach ($products as $product) { ?>
			<div class="procate-item product-thumb">
			  <?php if ($product['thumb']) { ?>
			  <div class="image">
				<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/></a>
				<div class="button-group button-grid">
					<button class="btn-cart" type="button" onclick="btadd.cart('<?php echo $product['product_id']; ?>','<?php echo $product['minimum']; ?>');"><i class="fa fa-shopping-cart"></i> <?php echo $button_cart; ?></button>
					<button class="btn-wishlist" type="button" title="<?php echo $button_wishlist; ?>" onclick="btadd.wishlist('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
					<button class="btn-compare" type="button" title="<?php echo $button_compare; ?>" onclick="btadd.compare('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
				</div>
			  </div>
			  <?php } ?>
			  
			  <div class="pro-detail">
				<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
				
                <?php if ($product['rating']) { ?>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($product['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
				
                <?php if ($product['price']) { ?>
                <div class="price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span> 
                  <?php } ?>
                </div>
                <?php } ?>
			  </div>
			</div>
		  <?php } ?>
		  </div>
		  <a id="bt_next_<?php echo $module; ?>" class="prev nav_thumb" href="javascript:void(0)" title="prev"><i class="fa fa-angle-left"></i></a>
		  <a id="bt_prev_<?php echo $module; ?>" class="next nav_thumb" href="javascript:void(0)" title="next"><i class="fa fa-angle-right"></i></a>
		</section>
	<?php } ?>
	<?php } ?>
</div>
<?php if($show_slider){ ?>
<script type="text/javascript"><!--
function getMaxHeight($elms) {
	var maxHeight = 0;
	$($elms).each(function () {
	
		var height = $(this).outerHeight();
		if (height > maxHeight) {
			maxHeight = height;
		}
	});
	return maxHeight;
};
$(window).load(function(){
	if ($(window).width() > 768) {
		image_width = <?php echo $image_width; ?>;
		per_row = <?php echo $per_row; ?>;
		if ($(window).width() <= 1023) {
			per_row = 3;
		}
	}else {
		image_width = 200;
		per_row = 2;
	}
	
    $('#boss_procate_<?php echo $module; ?>').carouFredSel({
        auto: false,
        responsive: true,
        width: '100%',
		height: 'variable',
        prev: '#bt_next_<?php echo $module; ?>',
        next: '#bt_prev_<?php echo $module; ?>',
        swipe: {
        onTouch : true
        },
        items: {
            width: image_width,
            height: 'variable',
            visible: {
				min: 1,
				max: per_row,
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1000,   //  The duration of the transition.
        },
		onCreate: function () {
			$(window).smartresize(function(){
				$('#boss_procate_<?php echo $module; ?> .procate-item').css("height",getMaxHeight('#boss_procate_<?php echo $module; ?> .procate-item'));
				$('#boss_pro_cate_<?php echo $module; ?> .box-content .caroufredsel_wrapper').css("height",getMaxHeight('#boss_procate_<?php echo $module; ?> .procate-item'));
			});
		},
    });
	$('#boss_procate_<?php echo $module; ?> .procate-item').css("height",getMaxHeight('#boss_procate_<?php echo $module; ?> .procate-item'));
	$('#boss_pro_cate_<?php echo $module; ?> .box-content .caroufredsel_wrapper').css("height",getMaxHeight('#boss_procate_<?php echo $module; ?> .procate-item'));
});
//--></script>
<?php } ?>
</div>
<?php } ?>
<?php } ?>