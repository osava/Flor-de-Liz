<div class="bt-carousel">
<div class="box-heading title"><h1><?php echo $heading_title; ?></h1></div>
<div id="carousel<?php echo $module; ?>" class="b_carousel_fix">
	<section class="box-content">
		<ul id="boss_carousel<?php echo $module; ?>" class="carousel-content">
		<?php $i = 0; ?>
		<?php foreach ($banners as $banner) { ?>
			<?php if(($i%$num_row)==0){ ?> <li> <?php } ?><?php $i++; ?>
				<a href="<?php echo $banner['link']; ?>"><img class="img-responsive" src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a>
			<?php if((($i%$num_row)==0)||($i==count($banners))){ ?></li><?php } ?>
		<?php } ?>
		</ul>
		<a id="carousel_next<?php echo $module; ?>" class="prev nav_thumb" href="javascript:void(0)" title="prev"><i class="fa fa-angle-left"></i></a>
		<a id="carousel_prev<?php echo $module; ?>" class="next nav_thumb" href="javascript:void(0)" title="next"><i class="fa fa-angle-right"></i></a>
	</section>
</div>
</div>
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
		var image_width = <?php echo $image_width; ?>;
		var img_row = <?php echo $img_row;?>;
	}else{
		var image_width = 300;
		var img_row = 2;
	}
    $('#boss_carousel<?php echo $module; ?>').carouFredSel({
        auto: false,
        responsive: true,
        width: '100%',
		height: 'auto',
        prev: '#carousel_next<?php echo $module; ?>',
        next: '#carousel_prev<?php echo $module; ?>',
        swipe: {
        onTouch : true
        },
        items: {
            width: image_width,
            height: 'auto',
            visible: {
            min: 1,
            max: img_row,
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1000   //  The duration of the transition.
        },
		onCreate: function () {
			$(window).smartresize(function(){
				$('.bt-carousel .caroufredsel_wrapper').css("height",$('.bt-carousel .caroufredsel_wrapper').height()+1);	
				$('.bt-carousel .caroufredsel_wrapper').css("width",$('.bt-carousel .caroufredsel_wrapper').width()+1);	
			});
		}
    });
	$('.bt-carousel .caroufredsel_wrapper').css("height",$('.bt-carousel .caroufredsel_wrapper').height()+1);	
	$('.bt-carousel .caroufredsel_wrapper').css("width",$('.bt-carousel .caroufredsel_wrapper').width()+1);
});

//--></script>