<?php  
class ControllerModuleBossCarousel extends Controller {
	public function index($setting) {//echo'<pre>';print_r($setting);echo'</pre>';die();
		if(empty($setting)) return;
		static $module = 0;
		$data['heading_title'] = (isset($setting['title'][$this->config->get('config_language_id')]) && $setting['title'][$this->config->get('config_language_id')])?$setting['title'][$this->config->get('config_language_id')]:'';
		if(isset($setting['banner_id'])){
		
			$this->load->model('design/banner');
			$this->load->model('tool/image');
			
			$this->document->addScript('catalog/view/javascript/bossthemes/touchSwipe.min.js');
			$this->document->addScript('catalog/view/javascript/bossthemes/carouFredSel-6.2.1.js');
			
			$data['limit'] = isset($setting['limit'])?$setting['limit']:6;
			
			$data['banners'] = array();
			
			$results = $this->model_design_banner->getBanner($setting['banner_id']);
			  
			foreach ($results as $result) {
				if (file_exists(DIR_IMAGE . $result['image'])) {
					$data['banners'][] = array(
						'title' => $result['title'],
						'link'  => $result['link'],
						'image' => $this->model_tool_image->resize($result['image'], isset($setting['image_width'])?$setting['image_width']:80, isset($setting['image_height'])?$setting['image_height']:80)
					);
				}
			}
			$data['img_row'] = $setting['img_row'];
			$data['num_row'] = $setting['num_row'];
			$data['image_width'] = $setting['image_width'];
			$data['module'] = $module++; 
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_carousel.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/boss_carousel.tpl', $data);
			} else {
				return $this->load->view('default/template/module/boss_carousel.tpl', $data);
			}
		}
	}
}
?>