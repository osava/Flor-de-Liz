<?php
class ControllerModuleBossProcate extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/boss_procate');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('extension/module');
		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('boss_procate', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
						
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['category'])) {
			$data['error_category'] = $this->error['category'];
		} else {
			$data['error_category'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}
		
		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}
		
		if (isset($this->error['width_large'])) {
			$data['error_large_width'] = $this->error['width_large'];
		} else {
			$data['error_large_width'] = '';
		}
		
		if (isset($this->error['height_large'])) {
			$data['error_large_height'] = $this->error['height_large'];
		} else {
			$data['error_large_height'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_procate', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/boss_procate', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/boss_procate', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['token'] = $this->session->data['token'];
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		
		//button
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_add_tab'] = $this->language->get('button_add_tab');
		
		//module
		$data['module_stt'] = $this->language->get('module_stt');
		$data['module_setting'] = $this->language->get('module_setting');
		$data['module_tab'] = $this->language->get('module_tab');
		$data['text_module'] = $this->language->get('text_module');
		
		//entry 
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_image_large'] = $this->language->get('entry_image_large');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_width_column'] = $this->language->get('entry_width_column');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_img_large'] = $this->language->get('entry_img_large');
		$data['entry_row'] = $this->language->get('entry_row');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_scrolling'] = $this->language->get('entry_scrolling');
		$data['entry_properrow'] = $this->language->get('entry_properrow');
		$data['entry_get_prolarge'] = $this->language->get('entry_get_prolarge');
		$data['entry_column_css'] = $this->language->get('entry_column_css');
		$data['entry_show_large_img'] = $this->language->get('entry_show_large_img');
		$data['entry_type'] = $this->language->get('entry_type');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['entry_description'] = $this->language->get('entry_description');
		
		//tab  
		$data['tab_stt'] = $this->language->get('tab_stt');
		$data['tab_title'] = $this->language->get('tab_title');
		$data['tab_get_product'] = $this->language->get('tab_get_product');
		$data['tab_large_product'] = $this->language->get('tab_large_product');
				
		//load text position
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		$data['text_center'] = $this->language->get('text_center');
		$data['text_left'] = $this->language->get('text_left');
		$data['text_right'] = $this->language->get('text_right');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
		$data['text_navarrow'] = $this->language->get('text_navarrow');
		$data['text_navpag'] = $this->language->get('text_navpag');
		$data['text_navboth'] = $this->language->get('text_navboth');
		$data['entry_nav'] = $this->language->get('entry_nav');
		
		
		$data['arrstatus'] = array(
			"0" => $this->language->get('text_disabled'),
			"1" => $this->language->get('text_enabled')
		);
		
		$data['arrlargeimg'] = array(
			"0" => $this->language->get('text_hide'),
			"1" => $this->language->get('text_show')
		);
		
		$data['arrtypes'] = array(
			"0" => $this->language->get('type_1'),
			"1" => $this->language->get('type_2')
		);
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		//echo '<pre>';print_r($module_info);die();echo '</pre>';
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['boss_module_title'])) {
			$data['boss_module_title'] = $this->request->post['boss_module_title'];
		} elseif (!empty($module_info)) {
			$data['boss_module_title'] = $module_info['boss_module_title'];
		} else {
			$data['boss_module_title'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = 0;
		}
		
		if (isset($this->request->post['large_image'])) {
			$data['large_image'] = $this->request->post['large_image'];
		} elseif (!empty($module_info)) {
			$data['large_image'] = $module_info['large_image'];
		} else {
			$data['large_image'] = 0;
		}
		
		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($module_info)) {
			$data['type'] = $module_info['type'];
		} else {
			$data['type'] = 0;
		}
		
		if (isset($this->request->post['show_slider'])) {
			$data['show_slider'] = $this->request->post['show_slider'];
		} elseif (!empty($module_info)) {
			$data['show_slider'] = $module_info['show_slider'];
		} else {
			$data['show_slider'] = 1;
		}
		
		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 5;
		}

		if (isset($this->request->post['column_css'])) {
			$data['column_css'] = $this->request->post['column_css'];
		} elseif (!empty($module_info)) {
			$data['column_css'] = $module_info['column_css'];
		} else {
			$data['column_css'] = 5;
		}
		
		if (isset($this->request->post['image_width'])) {
			$data['image_width'] = $this->request->post['image_width'];
		} elseif (!empty($module_info)) {
			$data['image_width'] = $module_info['image_width'];
		} else {
			$data['image_width'] = 200;
		}	
			
		if (isset($this->request->post['image_height'])) {
			$data['image_height'] = $this->request->post['image_height'];
		} elseif (!empty($module_info)) {
			$data['image_height'] = $module_info['image_height'];
		} else {
			$data['image_height'] = 200;
		}

		if (isset($this->request->post['image_large_width'])) {
			$data['image_large_width'] = $this->request->post['image_large_width'];
		} elseif (!empty($module_info)) {
			$data['image_large_width'] = $module_info['image_large_width'];
		} else {
			$data['image_large_width'] = 200;
		}	
			
		if (isset($this->request->post['image_large_height'])) {
			$data['image_large_height'] = $this->request->post['image_large_height'];
		} elseif (!empty($module_info)) {
			$data['image_large_height'] = $module_info['image_large_height'];
		} else {
			$data['image_large_height'] = 200;
		}
		
		if (isset($this->request->post['per_row'])) {
			$data['per_row'] = $this->request->post['per_row'];
		} elseif (!empty($module_info)) {
			$data['per_row'] = $module_info['per_row'];
		} else {
			$data['per_row'] = 4;
		}
		
		if (isset($this->request->post['boss_procate_id'])) {
			$data['boss_procate_id'] = $this->request->post['boss_procate_id'];
		} elseif (!empty($module_info)) {
			$data['boss_procate_id'] = $module_info['boss_procate_id'];
		} else {
			$data['boss_procate_id'] = 0;
		}
		
		$category_info = $this->model_catalog_category->getCategory($data['boss_procate_id']);
		
		if (!empty($category_info)){
			$data['boss_procate_module'] = $category_info['name'];
		}else{
			$data['boss_procate_module'] = '--- None ---';
		}

		//load categories
		$this->load->model('catalog/category');
		
		$categories = $this->model_catalog_category->getCategories(0);
		
		foreach($categories as $category){
			$data['categories'][$category['category_id']] = $category['name'];
		}
			
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_procate.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_procate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (!isset($this->request->post['boss_procate_id'])) {
			$this->error['category'] = $this->language->get('error_category');
		}
		
		if (!$this->request->post['image_width']) {
			$this->error['width'] = $this->language->get('error_width');
		}
		
		if (!$this->request->post['image_height']) {
			$this->error['height'] = $this->language->get('error_height');
		}
		
		if (!$this->request->post['image_large_width']) {
			$this->error['width_large'] = $this->language->get('error_large_width');
		}
		
		if (!$this->request->post['image_large_height']) {
			$this->error['height_large'] = $this->language->get('error_large_height');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

}
?>