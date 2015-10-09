<?php 
class ControllerBossthemesBossSearch extends Controller { 	
	public function index() {
		$this->document->addScript('catalog/view/javascript/bossthemes/selectbox/jquery.selectbox-0.2.min.js');
		
    	$this->language->load('bossthemes/boss_search');
		
		$this->load->model('catalog/category');
        
        if (isset($this->request->get['search'])) {
			$search = $this->request->get['search'];
		} else {
			$search = '';
		} 
        
        if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = 0;
		}
		
        $data['text_category'] = $this->language->get('text_category');
        
        $data['entry_search'] = $this->language->get('entry_search');
		  
    	$data['button_search'] = $this->language->get('button_search');
		
		$this->load->model('catalog/category');
		
		// 3 Level Category Search
		$data['categories'] = array();
					
		$categories_1 = $this->model_catalog_category->getCategories(0);
		
		foreach ($categories_1 as $category_1) {
			$level_2_data = array();
			
			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);
			
			foreach ($categories_2 as $category_2) {
				$level_3_data = array();
				
				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);
				
				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'category_id' => $category_3['category_id'],
						'name'        => $category_3['name'],
					);
				}
				
				$level_2_data[] = array(
					'category_id' => $category_2['category_id'],	
					'name'        => $category_2['name'],
					'children'    => $level_3_data
				);					
			}
			
			$data['categories'][] = array(
				'category_id' => $category_1['category_id'],
				'name'        => $category_1['name'],
				'children'    => $level_2_data
			);
		}
		
		$data['search'] = $search;
		$data['filter_category_id'] = $filter_category_id;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/bossthemes/boss_search.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/bossthemes/boss_search.tpl', $data);
		} else {
			return $this->load->view('default/template/bossthemes/boss_search.tpl', $data);
		}
  	}
}
?>