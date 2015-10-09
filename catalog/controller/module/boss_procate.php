<?php
class ControllerModuleBossProcate extends Controller {
	public function index($setting) {
		static $module = 0;
		//echo '<pre>';print_r($setting);echo '</pre>';
		$this->load->language('module/boss_procate');
		
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['text_product'] = $this->language->get('text_product');
		$data['shop_now'] = $this->language->get('shop_now');
		
		$data['template'] = $this->config->get('config_template');
		
		
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('tool/image');
		
		$data['heading_title'] = isset($setting['boss_module_title'][$this->config->get('config_language_id')]) ? $setting['boss_module_title'][$this->config->get('config_language_id')]:'';
		
		$data['large_image'] = isset($setting['large_image'])?$setting['large_image']:0;
		$data['type'] = isset($setting['type'])?$setting['type']:0;
		$data['column_css'] = isset($setting['column_css'])?$setting['column_css']:12;
		
		$mainproduct = array();
		
		$data['product_datas'] = array();
		
		if(isset($setting['limit'])){
			$limit = $setting['limit'];
		}else{
			$limit = 8;
		}
		
		if(isset($setting['boss_procate_id'])){
		
			$category_id = $setting['boss_procate_id'];
			
				$results = array();
				
				$products = array();
				
				$category_info = $this->model_catalog_category->getCategory($category_id);
				
				$data_sort = array(
					'filter_category_id' => $category_id,
					'sort'  => 'pd.name',
					'order' => 'ASC',
					'start' => 0,
					'limit' => $limit
				);
				
				$results = $this->model_catalog_product->getProducts($data_sort);
				
				if(!empty($results)){				
					if(isset($setting['image_width'])){
						$image_width = $setting['image_width'];
					}else{
						$image_width = 180;
					}
					
					if(isset($setting['image_height'])){
						$image_height = $setting['image_height'];
					}else{
						$image_height = 220;
					}
					
					if(isset($setting['image_large_width'])){
						$image_large_width = $setting['image_large_width'];
					}else{
						$image_large_width = 420;
					}
					
					if(isset($setting['image_large_height'])){
						$image_large_height = $setting['image_large_height'];
					}else{
						$image_large_height = 560;
					}
				
					foreach ($results as $result) {
						if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
						} else {
							$image = false;
						}

						if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
							$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
						} else {
							$price = false;
						}
											
						if ((float)$result['special']) { 
							$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
						} else {
							$special = false;
						}
									
						if ($this->config->get('config_review_status')) {
							$rating = $result['rating'];
						} else {
							$rating = false;
						}
									
									
						$products[] = array(
							'product_id' => $result['product_id'],
							'thumb'   	 => $image,
							'name'    	 => $result['name'],
							'price'   	 => $price,
							'special' 	 => $special,
							'minimum' 	 => $result['minimum'],
							'rating'     => $rating,
							'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
							'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
						);
					}
				}
				$filter_data = array(
				'filter_category_id'  => $category_id,
				'filter_sub_category' => true
				);
				
				$catagory_name = array();
				
				$catagory_name = $this->model_catalog_category->getCategory($category_id);
				
				if (isset($catagory_name['image']) && $catagory_name['image']) {
					$image = $this->model_tool_image->resize($catagory_name['image'],$image_large_width, $image_large_height);
				} else {
					$image = false;
				}
				$data['product_datas'] = array(
					'name'     	 	 => $category_info['name'],
					'image'     	 => $image,
					'count'			 => $this->model_catalog_product->getTotalProducts($filter_data),
					'href'       	 => $this->url->link('product/category', 'path=' . $category_id),
					'products'       => $products,
					'mainproduct'    => $mainproduct,
				);
		}
	
		if(isset($image_width)){
			$data['image_width'] = $image_width;
		}else{
			$data['image_width'] = 200;
		}
		
		if(isset($setting['per_row'])){
			$data['per_row'] = $setting['per_row'];
		}else {
			$data['per_row'] = 3;
		}
		
		if(isset($setting['type_display'])){
			$data['type_display'] = $setting['type_display'];
		}else{
			$data['type_display'] = 'block';
		}
		
		if(isset($setting['show_slider'])){
			$data['show_slider'] = $setting['show_slider'];
		}else{
			$data['show_slider'] = true;
		}
		
		$data['module'] = $module++;
				
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_procate.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/boss_procate.tpl', $data);
		} else {
			return $this->load->view('default/template/module/boss_procate.tpl', $data);
		}
	}
}
?>