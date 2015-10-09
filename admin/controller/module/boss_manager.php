<?php
class ControllerModuleBossManager extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('module/boss_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('tool/image');
		
		$this->document->addStyle('view/stylesheet/bossthemes/boss_manager.css');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting('boss_manager', $this->request->post);	
			$this->saveXML(isset($this->request->post['xml'])?$this->request->post['xml']:'',isset($this->request->post['custom_color'])?$this->request->post['custom_color']:'');
			$this->saveXMLFont(isset($this->request->post['xml_font'])?$this->request->post['xml_font']:'',isset($this->request->post['custom_font'])?$this->request->post['custom_font']:'');
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('module/boss_manager', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');

		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');
		
		$data['arrstatus'] = array(
			"0" => $this->language->get('text_disabled'),
			"1" => $this->language->get('text_enabled')
		);
		
		$data['arrloading'] = array(
			"0" => $this->language->get('text_disabled'),
			"1" => $this->language->get('text_enabled')
		);
		
		$data['arrshow'] = array(
			"use_tab" => $this->language->get('text_tab'),
			"use_accordion" => $this->language->get('text_accordion')
		);
		$data['arrview'] = array(
			"grid" => $this->language->get('text_grid'),
			"list" => $this->language->get('text_list'),
			"both_list" => $this->language->get('text_both_list'),
			"both_grid" => $this->language->get('text_both_grid')
		);
		$data['arrgridview'] = array(
			"6_4_3" => $this->language->get('text_large'),
			"4_3_cs5" => $this->language->get('text_medium'),
			"3_cs5_2" => $this->language->get('text_small')
		);
		$data['arrusemenu'] = array(
			"default" => $this->language->get('text_default'),
			"megamenu" => $this->language->get('text_megamenu'),			
		);
		$data['token'] = $this->session->data['token'];
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
			'href'      => $this->url->link('module/boss_manager', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('module/boss_manager', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['boss_manager'] = array();
		
		$data['option'] = array();
		$data['layout'] = array();
		
		$data['footer_about'] = array();
		
		
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['boss_manager_footer_about'])) {
			$data['footer_about'] = $this->request->post['boss_manager_footer_about'];
		} elseif ($this->config->get('boss_manager_footer_about')) { 
			$data['footer_about'] = $this->config->get('boss_manager_footer_about');
		}
		
		$footer_about = $data['footer_about'];
		
		if (isset($footer_about['image_link']) && file_exists(DIR_IMAGE . $footer_about['image_link'])) {
			$data['about_image'] = $this->model_tool_image->resize($footer_about['image_link'], 100, 100);
		} else {
			$data['about_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['footer_shipping'] = array();
		
		if (isset($this->request->post['boss_manager_footer_shipping'])) {
			$data['footer_shipping'] = $this->request->post['boss_manager_footer_shipping'];
		} elseif ($this->config->get('boss_manager_footer_shipping')) { 
			$data['footer_shipping'] = $this->config->get('boss_manager_footer_shipping');
		}
		
		
		$data['footer_contact'] = array();
		
		if (isset($this->request->post['boss_manager_footer_contact'])) {
			$data['footer_contact'] = $this->request->post['boss_manager_footer_contact'];
		} elseif ($this->config->get('boss_manager_footer_contact')) { 
			$data['footer_contact'] = $this->config->get('boss_manager_footer_contact');
		}
		
		$data['footer_social'] = array();
		
		if (isset($this->request->post['boss_manager_footer_social'])) {
			$data['footer_social'] = $this->request->post['boss_manager_footer_social'];
		} elseif ($this->config->get('boss_manager_footer_social')) { 
			$data['footer_social'] = $this->config->get('boss_manager_footer_social');
		}
		
		$data['footer_payment'] = array();
		
		if (isset($this->request->post['boss_manager_footer_payment'])) {
			$data['footer_payment'] = $this->request->post['boss_manager_footer_payment'];
		} elseif ($this->config->get('boss_manager_footer_social')) { 
			$data['footer_payment'] = $this->config->get('boss_manager_footer_payment');
		}
		
		$data['footer_powered'] = array();
		
		if (isset($this->request->post['boss_manager_footer_powered'])) {
			$data['footer_powered'] = $this->request->post['boss_manager_footer_powered'];
		} elseif ($this->config->get('boss_manager_footer_powered')) { 
			$data['footer_powered'] = $this->config->get('boss_manager_footer_powered');
		}
		
		$boss_manager = array();

		if (isset($this->request->post['boss_manager'])) {
			$boss_manager = $this->request->post['boss_manager'];
		} elseif ($this->config->get('boss_manager')) { 
			$boss_manager = $this->config->get('boss_manager');
		}

		$data['boss_manager'] = $boss_manager;
		
		if(!empty($boss_manager)){
			$data['option'] = $boss_manager['option'];
			$data['status'] = $boss_manager['status'];
			$data['layout'] = $boss_manager['layout'];
			$data['other'] = $boss_manager['other'];
			$data['color'] = $boss_manager['color'];
		}
		
		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/boss_manager.tpl', $data));

	}
	protected function saveXML($groups,$customs) {
		//echo "<pre>"; print_r($customs); echo "</pre>";die();
		$xml = new DOMDocument('1.0','UTF-8');

		//create item_setting
		$root = $xml->createElement('items_setting');
		$xml->appendChild($root);	
		if(!empty($groups)){
			foreach($groups as $group){
				//create groups
				$groups_xml = $xml->createElement('groups');
				$root->appendChild($groups_xml);
				
				//create title		
				$title = $xml->createElement('title');
				$groups_xml->appendChild($title);
				//add value
				$title->appendChild($xml->createTextNode($group['title'][0]));
				if(isset($group['text'])){
					for($i=0; $i< count($group['text']) ; $i++){ 
						//create item
						$item = $xml->createElement('item');
						$groups_xml->appendChild($item);		
						
						//create text		
						$text = $xml->createElement('text');
						$item->appendChild($text);
						//add value
						$text->appendChild($xml->createTextNode($group['text'][$i]));
						
						//create name		
						$name = $xml->createElement('name');
						$item->appendChild($name);
						//add value
						$name->appendChild($xml->createTextNode($group['name'][$i]));
						
						//create class		
						$class = $xml->createElement('class');
						$item->appendChild($class);
						//add value
						$class->appendChild($xml->createTextNode($group['class'][$i]));
						
						//create value		
						$value = $xml->createElement('value');
						$item->appendChild($value);
						//add value
						$value->appendChild($xml->createTextNode($group['value'][$i]));
						
						//create style		
						$style = $xml->createElement('style');
						$item->appendChild($style);
						//add value
						$style->appendChild($xml->createTextNode($group['style'][$i]));
					}
				}
			}
		}
		//create customs
		$customs_xml = $xml->createElement('customs');
		$root->appendChild($customs_xml);
		if(!empty($customs)){
			foreach($customs as $custom){ 		
				//create item
				$item = $xml->createElement('item');
				$customs_xml->appendChild($item);		
				
				//create text		
				$text = $xml->createElement('text');
				$item->appendChild($text);
				//add value
				$text->appendChild($xml->createTextNode($custom['text']));
				
				//create class		
				$class = $xml->createElement('class');
				$item->appendChild($class);
				//add value
				$class->appendChild($xml->createTextNode($custom['class']));
				
				//create value		
				$value = $xml->createElement('value');
				$item->appendChild($value);
				//add value
				$value->appendChild($xml->createTextNode($custom['value']));
				
				//create important		
				$important = $xml->createElement('important');
				$item->appendChild($important);
				//add value
				$important->appendChild($xml->createTextNode($custom['important']));
				
				//create style		
				$style = $xml->createElement('style');
				$item->appendChild($style);
				//add value
				$style->appendChild($xml->createTextNode($custom['style']));
			}
		}
		//nice output
		$xml->formatOutput = true;
		$xml->save("../config_xml/color_setting.xml"); 
	}
	protected function saveXMLFont($groups,$customs) {
		//echo "<pre>"; print_r($customs); echo "</pre>";die();
		$xml = new DOMDocument('1.0','UTF-8');

		//create item_setting
		$root = $xml->createElement('items_setting');
		$xml->appendChild($root);	
		if(!empty($groups)){
			foreach($groups as $group){
				//create groups
				$groups_xml = $xml->createElement('groups');
				$root->appendChild($groups_xml);
				
				//create title		
				$title = $xml->createElement('title');
				$groups_xml->appendChild($title);
				//add value
				$title->appendChild($xml->createTextNode($group['title'][0]));
				if(isset($group['text'])){
					for($i=0; $i< count($group['text']) ; $i++){ 
						//create item
						$item = $xml->createElement('item');
						$groups_xml->appendChild($item);		
						
						//create text		
						$text = $xml->createElement('text');
						$item->appendChild($text);
						//add value
						$text->appendChild($xml->createTextNode($group['text'][$i]));
						
						//create style		
						$style = $xml->createElement('style');
						$item->appendChild($style);
						//add value
						$style->appendChild($xml->createTextNode($group['style'][$i]));
						
						//create size		
						$size = $xml->createElement('size');
						$item->appendChild($size);
						//add value
						$size->appendChild($xml->createTextNode($group['size'][$i]));
						
						//create weight		
						$weight = $xml->createElement('weight');
						$item->appendChild($weight);
						//add value
						$weight->appendChild($xml->createTextNode($group['weight'][$i]));
						
						//create transform		
						$transform = $xml->createElement('transform');
						$item->appendChild($transform);
						//add value
						$transform->appendChild($xml->createTextNode($group['transform'][$i]));
						
						//create class_name		
						$class_name = $xml->createElement('class_name');
						$item->appendChild($class_name);
						//add value
						$class_name->appendChild($xml->createTextNode($group['class_name'][$i]));
					}
				}
			}
		}
		//create customs
		$customs_xml = $xml->createElement('customs');
		$root->appendChild($customs_xml);
		if(!empty($customs)){
			foreach($customs as $custom){ 		
				//create item
				$item = $xml->createElement('item');
				$customs_xml->appendChild($item);		
				
				//create text		
				$text = $xml->createElement('text');
				$item->appendChild($text);
				//add value
				$text->appendChild($xml->createTextNode($custom['text']));
				
				//create style		
				$style = $xml->createElement('style');
				$item->appendChild($style);
				//add value
				$style->appendChild($xml->createTextNode($custom['style']));
				
				//create size		
				$size = $xml->createElement('size');
				$item->appendChild($size);
				//add value
				$size->appendChild($xml->createTextNode($custom['size']));
				
				//create weight		
				$weight = $xml->createElement('weight');
				$item->appendChild($weight);
				//add value
				$weight->appendChild($xml->createTextNode($custom['weight']));
				
				//create transform		
				$transform = $xml->createElement('transform');
				$item->appendChild($transform);
				//add value
				$transform->appendChild($xml->createTextNode($custom['transform']));
				
				//create class_name		
				$class_name = $xml->createElement('class_name');
				$item->appendChild($class_name);
				//add value
				$class_name->appendChild($xml->createTextNode($custom['class_name']));
			}
		}
		//nice output
		$xml->formatOutput = true;
		$xml->save("../config_xml/font_setting.xml"); 
	}
	public function changeTemplate(){
		
		$this->document->addStyle('view/stylesheet/bossthemes/boss_manager.css');
		if (isset($this->request->get['value']) && !empty($this->request->get['value'])) {
			$value = $this->request->get['value'];			
		} else {
			$value = 1;
		}
		
		if($value==1){
			$data['objXML'] = simplexml_load_file("../config_xml/theme_color_1.xml");
		}
	
		$json = array();			
	
		$json['output'] = $this->load->view('module/boss_changetemplate.tpl', $data);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_manager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
		
	public function install() 
	{
		$this->load->model('setting/setting');
		$this->load->model('localisation/language');			
		$languages = $this->model_localisation_language->getLanguages();
		
		$free_shipping_title = array();
		$free_shipping_content = array();
		$about_us_title = array();
		$about_us_content = array();
		$contact_us_title = array();
		$contact_us_content = array();
		$follow_us_title = array();
		$powered_content = array();
		
		foreach($languages as $language){
			$free_shipping_title{$language['language_id']} = '';
			$free_shipping_content{$language['language_id']} = '';					
			$about_us_title{$language['language_id']} = 'About Us';					
			$about_us_content{$language['language_id']} = '&lt;p&gt;Skort Maison Martin Margiela knot ponytail cami texture tucked t-shirt.&lt;span class=&quot;bold-italic&quot;&gt; Black skirt razor pleats plaited gold collar.&lt;/span&gt; Crop 90s spearminit indigo seam luxe washed out. Prada Saffiano cashmere crop sneaker chignon cami clutch cami texture Maison Martin Margiela knot ponytail.&lt;/p&gt;';
			$contact_us_title{$language['language_id']} = 'Contact us';					
			$contact_us_content{$language['language_id']} = '&lt;ul&gt;
	&lt;li&gt;&lt;i class=&quot;fa fa-map-marker&quot;&gt;&lt;/i&gt; &lt;span&gt; &amp;nbsp;249, Ung Van Khiem St., Binh Thanh Dist, HCMC.&lt;/span&gt;&lt;/li&gt;
	&lt;li&gt;&lt;i class=&quot;fa fa-phone&quot;&gt;&lt;/i&gt; &lt;span&gt;+084 0123 456 999&lt;/span&gt;&lt;/li&gt;
	&lt;li&gt;&lt;i class=&quot;fa fa-envelope-o&quot;&gt;&lt;/i&gt; &lt;span&gt;&lt;a href=&quot;mailto:support@codespot.vn&quot;&gt;support@codespot.vn&lt;/a&gt;&lt;/span&gt;&lt;/li&gt;
    &lt;/ul&gt;';
			$follow_us_title{$language['language_id']} = 'Follow us';	
			$powered_content{$language['language_id']} = '&lt;div id=&quot;powered&quot;&gt;  &lt;p&gt;&copy; 2015 Fashion Store. All rights Reserved.&lt;span&gt; Opencart Themes by &lt;a href=&quot;http://bossthemes.com&quot;&gt;Bossthemes&lt;/a&gt;.&lt;/span&gt;&lt;/p&gt;
&lt;/div&gt;';
		}
		$boss_manager = array(
			'boss_manager' => array ( 
				'status' => 1,
				'option' => array(
					'bt_scroll_top' => 1,
					'sticky_menu' => 1,
					'loading' => 1,
					'use_menu' => 'megamenu',
					'animation' => 1,
				),
				'layout' => array(
					'mode_css' => 'wide',
					'box_width' => 1200,
					'h_mode_css' => 'inherit',
					'h_box_width' => 1200,
					'f_mode_css' => 'inherit',
					'f_box_width' => 1200,
				),
				'header_link' => array(
					'language' => 1,
					'currency' => 1,
					'phone' => 1,
					'my_account' => 1,
					'wishlist' => 1,
					'shopping_cart' => 0,
					'checkout' => 0,
					'logo' => 1,
					'search' => 1,
					'cart_mini' => 1,
				),
				'footer_link' => array(
					'information' => 0,
					'contact_us' => 1,
					'return' => 0,
					'site_map' => 1,
					'brands' => 1,
					'gift_vouchers' => 0,
					'affiliates' => 1,
					'specials' => 1,
					'newsletter' => 1,					
				),
				'color' => 1,
				'other' => array(
					'pro_tab' => 'use_tab',
					'category_info' => 0,
					'refine_search' => 1,
					'view_pro' => 'both_grid',
					'grid_view' => '6_4_3',
				),
			),
			'boss_manager_footer_shipping' => array(
				'status' => 0,
				'contact_title' => $free_shipping_title,
				'contact_content' => $free_shipping_content,
			),
			'boss_manager_footer_about' => array(
				'status' => 1,
				'image_status' => 1,
				'image_link' => 'catalog/bt_comohos/logo.png',
				'image_url' => 'index.php?route=common/home',
				'about_title' => $about_us_title,
				'about_content' => $about_us_content,
			),
			'boss_manager_footer_contact' => array(
				'status' => 1,
				'contact_title' => $contact_us_title,
				'contact_content' => $contact_us_content,
			),
			'boss_manager_footer_social' => array(
				'status' => 1,
				'title' => $follow_us_title,
				'face_url' => 'https://www.facebook.com/',
				'pinterest_url' => 'https://www.pinterest.com/',
				'twitter_url' => 'https://twitter.com/',
				'googleplus_url' => 'https://plus.google.com/',				
				'rss_url' => 'https://www.rss.com/',		
				'youtube_url' => 'https://www.youtube.com/',				
			),
			'boss_manager_footer_payment' => array(
				'status' => 1,
				'visa_status' => 1,
				'visa_link' => '#',
				'master_status' => 1,
				'master_link' => '#',				
				'merican_status' => 1,				
				'merican_link' => '#',		
				'paypal_status' => 1,				
				'paypal_link' => '#',
				'dhl_status' => 1,				
				'dhl_link' => '#',				
			),
			'boss_manager_footer_powered' => $powered_content,
		);
		
		$this->model_setting_setting->editSetting('boss_manager', $boss_manager);		
	}
	private function deleteDataModule($code) {
		$this->load->model('extension/module');
		$this->load->model('setting/setting');
		// delete the module
		$this->model_extension_module->deleteModulesByCode($code);		
		$this->model_setting_setting->deleteSetting($code);
   	}
	private function uninstallModule($code) {			
    	$this->db->query("DELETE FROM " . DB_PREFIX . "extension WHERE code = '" . $this->db->escape($code) . "'");    	
   	}
	private function installModule($code) {	
		$this->load->model('user/user_group');		
		$this->uninstallModule($code);		
		$this->db->query("INSERT INTO " . DB_PREFIX . "extension SET type	= 'module', code = '" . $this->db->escape($code) . "'");	
		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'module/'.$code);
		
   	}
	private function getIdLayout($layout_name) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "layout WHERE LOWER(name) = LOWER('".$layout_name."')");
		return (int)$query->row['layout_id'];
	}
	private function checkModule($code) {					
		$result = $this->db->query("Select *from " . DB_PREFIX . "extension where code = '" . $this->db->escape($code) . "'");
		if($result->num_rows)
			return true;
		return false;
   	}
	public function addSampleData(){
		$module_code = $this->request->get['module_code'];
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		$json = array();
		$json['error'] = '';
		switch ($module_code) {
			case 'boss_alphabet':
				$code = 'boss_alphabet';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title = array();
				foreach($languages as $language){
					$title{$language['language_id']} = 'By Alphabet';
				}
				//create sample data and add module
				$sample_data = array(
					'name' => 'Alphabet Category',
					'code' => $code,
					'status' => 1,
					'title' => $title,
				);
				$this->model_extension_module->addModule($code, $sample_data);
				//get module_id
				$module_id = $this->db->getLastId();
				
				$layouts = array(
					0 =>  array(
						'layout_id' => $this->getIdLayout('category'), // categpry page		
						'position' => 'column_left',
						'sort_order' => 4,
					),
					1 =>  array(
						'layout_id' => $this->getIdLayout('product'), // product page		
						'position' => 'column_left',
						'sort_order' => 4,
					),
					2 =>  array(
						'layout_id' => $this->getIdLayout('manufacturer'), // manufacture page		
						'position' => 'column_left',
						'sort_order' => 4,
					),					
				);
				foreach($layouts as $layout){
					//add layout		
					$layout_module = array(
						'code'  => $code.'.'.$module_id,
						'position'  => $layout['position'],				
						'sort_order'  => $layout['sort_order'],
					);			
					$layout_id = $layout['layout_id']; 
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
				}
			break;
			
			case 'boss_manufacturer':
				$code = 'boss_manufacturer';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title = array();
				foreach($languages as $language){
					$title{$language['language_id']} = 'Manufacturer';
				}
				//create sample data and add module
				$sample_data = array(
					'name' => 'Manufacturer',
					'code' => $code,
					'status' => 1,
					'title' => $title,
				);
				$this->model_extension_module->addModule($code, $sample_data);
				//get module_id
				$module_id = $this->db->getLastId();
				
				$layouts = array(
					0 =>  array(
						'layout_id' => $this->getIdLayout('category'), // categpry page		
						'position' => 'column_left',
						'sort_order' => 3,
					),
					1 =>  array(
						'layout_id' => $this->getIdLayout('product'), // product page		
						'position' => 'column_left',
						'sort_order' => 3,
					),
					2 =>  array(
						'layout_id' => $this->getIdLayout('manufacturer'), // manufacture page		
						'position' => 'column_left',
						'sort_order' => 3,
					),					
				);
				foreach($layouts as $layout){
					//add layout		
					$layout_module = array(
						'code'  => $code.'.'.$module_id,
						'position'  => $layout['position'],				
						'sort_order'  => $layout['sort_order'],
					);			
					$layout_id = $layout['layout_id']; 
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
				}
			break;
			
			case 'boss_quickshop':
				$code = 'boss_quickshop';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title = array();
				foreach($languages as $language){
					$title{$language['language_id']} = 'Quick Shop';
				}
				
				//create sample data and add module
				$sample_data = array(
					'name' => 'Boss Quickshop',
					'code' => $code,
					'status' => 1,
					'title' => $title,
					'array_class_selected' => '.product-thumb, #product_related&gt;li&gt;div',
					'width' => 900,
				);
				
				$this->model_extension_module->addModule($code, $sample_data);
				//get module_id
				$module_id = $this->db->getLastId();
				
				$layouts = array(
					0 => array(
						'position' => 'content_top',
						'sort_order' => 0,
						'layout_id' => $this->getIdLayout('home'),  // home page
					),
					1 => array(
						'position' => 'content_top',
						'sort_order' => 0,
						'layout_id' => $this->getIdLayout('category'),   //category page
					),
					2 => array(
						'position' => 'content_top',
						'sort_order' => 0,
						'layout_id' => $this->getIdLayout('product'),   //product page
					),
				);
				
				foreach($layouts as $layout){
					//add layout		
					$layout_module = array(
						'code'  => $code.'.'.$module_id,
						'position'  => $layout['position'],				
						'sort_order'  => $layout['sort_order'],
					);			
					$layout_id = $layout['layout_id']; 
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
				}
			break;
			
			case 'boss_tagcloud':
				$code = 'boss_tagcloud';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title = array();
				foreach($languages as $language){
					$title{$language['language_id']} = 'Tags';
				}
				//create sample data and add module
				$sample_data = array(
					'name' => 'Tag Cloud',
					'code' => $code,
					'status' => 1,
					'title' => $title,										
					'limit' => 20,										
					'min_font_size' => 9,										
					'max_font_size' => 25,
					'font_weight' => 'normal',
				);
				$this->model_extension_module->addModule($code, $sample_data);
				//get module_id
				$module_id = $this->db->getLastId();
				
				$layouts = array(
					0 =>  array(
						'layout_id' => $this->getIdLayout('category'), // categpry page		
						'position' => 'column_left',
						'sort_order' => 6,
					),
					1 =>  array(
						'layout_id' => $this->getIdLayout('product'), // product page		
						'position' => 'column_left',
						'sort_order' => 6,
					),
					2 =>  array(
						'layout_id' => $this->getIdLayout('manufacturer'), // manufacture page		
						'position' => 'column_left',
						'sort_order' => 6,
					),					
				);
				foreach($layouts as $layout){
					//add layout		
					$layout_module = array(
						'code'  => $code.'.'.$module_id,
						'position'  => $layout['position'],				
						'sort_order'  => $layout['sort_order'],
					);			
					$layout_id = $layout['layout_id']; 
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
				}
			break;
			
			case 'boss_zoom':
				$code = 'boss_zoom';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title = array();
				foreach($languages as $language){
					$title{$language['language_id']} = 'Boss Zoom';
				}
				//create sample data and add module
				$sample_data = array(
					'name' => 'Zoom 1',
					'boss_zoom_thumb_image_width' => 550,
					'boss_zoom_thumb_image_heigth' => 652,
					'boss_zoom_addition_image_width' => 101,
					'boss_zoom_addition_image_heigth' => 125,
					'boss_zoom_zoom_image_width' => 600,
					'boss_zoom_zoom_image_heigth' => 711,
					'boss_zoom_zoom_area_width' => 450,
					'boss_zoom_zoom_area_heigth' => 480,
					'boss_zoom_position_zoom_area' => 'inside',
					'boss_zoom_adjustX' => 0,
					'boss_zoom_adjustY' => 0,
					'boss_zoom_title_image' => 0,
					'boss_zoom_title_opacity' => 0.5,
					'boss_zoom_tint' => '#FFF',
					'boss_zoom_tint_opacity' => 0.5,
					'boss_zoom_softFocus' => 0,
					'boss_zoom_lensOpacity' => 0.7,
					'boss_zoom_smoothMove' => 3,
					'status' => 1
				);
				$this->model_extension_module->addModule($code, $sample_data);
				//get module_id
				$module_id = $this->db->getLastId();
				
				$layouts = array(					
					0 =>  array(
						'layout_id' => $this->getIdLayout('product'), // product page		
						'position' => 'content_top',
						'sort_order' => 0,
					),
				);
				foreach($layouts as $layout){
					//add layout		
					$layout_module = array(
						'code'  => $code.'.'.$module_id,
						'position'  => $layout['position'],				
						'sort_order'  => $layout['sort_order'],
					);			
					$layout_id = $layout['layout_id']; 
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
				}
			break;
			
			case 'html':
				$code = 'html';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$module_description1 = array();
				$module_description2 = array();
				$module_description3 = array();
				$module_description4 = array();
				$module_description5 = array();
				$module_description6 = array();
				$module_description7 = array();
				$module_description8 = array();
				$module_description9 = array();
				$module_description10 = array();
				foreach($languages as $language){
					$module_description1[$language['language_id']]['title'] = '';
					$module_description2[$language['language_id']]['title'] = '';
					$module_description3[$language['language_id']]['title'] = '';
					$module_description4[$language['language_id']]['title'] = '';
					$module_description5[$language['language_id']]['title'] = '';
					$module_description6[$language['language_id']]['title'] = '';
					$module_description7[$language['language_id']]['title'] = '';
					$module_description8[$language['language_id']]['title'] = '';
					$module_description9[$language['language_id']]['title'] = '';
					$module_description10[$language['language_id']]['title'] = '';
					
					$module_description1[$language['language_id']]['description'] = '&lt;div class=&quot;bt-block-category not-animated&quot; data-animate=&quot;fadeInDown&quot; data-delay=&quot;200&quot;&gt;&lt;a href=&quot;#&quot;&gt;  &lt;img src=&quot;http://demo.bossthemes.com/comohos_supermarket2/image/catalog/bt_comohos/banner_category.jpg&quot; alt=&quot;banner&quot;&gt;&lt;/a&gt;  &lt;div class=&quot;block-title&quot;&gt;	&lt;h1&gt;Terdu Phare&lt;/h1&gt;
    &lt;h4&gt;Nullam Vitae Feugiat&lt;/h4&gt;
    &lt;a href=&quot;#&quot;&gt;Shop Now&lt;/a&gt;  &lt;/div&gt;
&lt;/div&gt;';
					$module_description2[$language['language_id']]['description'] = '&lt;div class=&quot;bt-banner-left not-animated&quot; data-animate=&quot;fadeInLeft&quot; data-delay=&quot;200&quot;&gt;&lt;a title=&quot;banner left&quot; href=&quot;#&quot;&gt;  &lt;img src=&quot;http://demo.bossthemes.com/comohos_supermarket2/image/catalog/bt_comohos/banner_left1.jpg&quot; alt=&quot;banner&quot;&gt;&lt;span class=&quot;image1&quot;&gt;&lt;img src=&quot;http://demo.bossthemes.com/comohos_supermarket2/image/catalog/bt_comohos/banner_left_1.png&quot; alt=&quot;banner&quot;&gt;&lt;/span&gt;&lt;span class=&quot;image2&quot;&gt;&lt;img src=&quot;http://demo.bossthemes.com/comohos_supermarket2/image/catalog/bt_comohos/banner_left_2.png&quot; alt=&quot;banner&quot;&gt;&lt;/span&gt;&lt;span class=&quot;bg-top&quot;&gt;&amp;nbsp;&lt;/span&gt; &lt;span class=&quot;bg-bottom&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/a&gt;&lt;/div&gt;';
					$module_description3[$language['language_id']]['description'] = '&lt;div class=&quot;bt-staticblock-freeshipping&quot;&gt;	&lt;div class=&quot;bt-staticblock not-animated&quot; data-animate=&quot;bounceIn&quot; data-delay=&quot;300&quot;&gt;	&lt;a href=&quot;#&quot; class=&quot;bt-staticblock-icon&quot;&gt;&lt;i class=&quot;fa fa-paper-plane&quot;&gt;&lt;/i&gt;&lt;/a&gt;	  &lt;div class=&quot;bt-shipping-info&quot;&gt;	    &lt;h2&gt;&lt;a href=&quot;#&quot;&gt;Return &amp;amp; exchange&lt;/a&gt;&lt;/h2&gt;


		&lt;p&gt;Vintage pastel tucked t-shirt leather cami&lt;/p&gt;


	  &lt;/div&gt;


	&lt;/div&gt;


	&lt;div class=&quot;bt-staticblock not-animated&quot; data-animate=&quot;bounceIn&quot; data-delay=&quot;400&quot;&gt;	&lt;a href=&quot;#&quot; class=&quot;bt-staticblock-icon&quot;&gt;&lt;i class=&quot;fa fa-truck&quot;&gt;&lt;/i&gt;&lt;/a&gt;	  &lt;div class=&quot;bt-shipping-info&quot;&gt;	  &lt;h2&gt;&lt;a href=&quot;#&quot;&gt;Free Shipping&lt;/a&gt;&lt;/h2&gt;


		&lt;p&gt;Loafer Jil Sander Vasari oversized boots&lt;/p&gt;


	  &lt;/div&gt;


	&lt;/div&gt;


	&lt;div class=&quot;bt-staticblock not-animated&quot; data-animate=&quot;bounceIn&quot; data-delay=&quot;500&quot;&gt;	&lt;a href=&quot;#&quot; class=&quot;bt-staticblock-icon&quot;&gt;&lt;i class=&quot;fa fa-tag&quot;&gt;&lt;/i&gt;&lt;/a&gt;	  &lt;div class=&quot;bt-shipping-info&quot;&gt;			 &lt;h2&gt; &lt;a href=&quot;#&quot;&gt;Member Discount&lt;/a&gt;&lt;/h2&gt;


		&lt;p&gt;Flats Cara D. dress knitwear leather luxe&lt;/p&gt;


	  &lt;/div&gt;


	&lt;/div&gt;


&lt;/div&gt;';
				$module_description4[$language['language_id']]['description'] = '&lt;div class=&quot;bt-block-sale&quot;&gt;		&lt;div class=&quot;block-item bt-item-1&quot;&gt;			&lt;div class=&quot;bt-staticblock-image&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img src=&quot;http://demo.bossthemes.com/comohos_supermarket2/image/catalog/bt_comohos/staticblock_img1.jpg&quot; alt=&quot;banner&quot;&gt;&lt;/a&gt;&lt;/div&gt;

			&lt;div class=&quot;bt-staticblock-title bt-title-1&quot;&gt;		&lt;span&gt;		&lt;i class=&quot;fa fa-star star-small&quot;&gt;&lt;/i&gt;&lt;i class=&quot;fa fa-star star-big&quot;&gt;&lt;/i&gt;&lt;i class=&quot;fa fa-star star-small&quot;&gt;&lt;/i&gt;		&lt;/span&gt;		&lt;h1&gt;Watches&lt;/h1&gt;

				&lt;h4&gt;Luxury Collection&lt;/h4&gt;

			&lt;/div&gt;

		&lt;/div&gt;

		&lt;div class=&quot;block-item bt-item-2&quot;&gt;			&lt;div class=&quot;bt-staticblock-image&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img src=&quot;http://demo.bossthemes.com/comohos_supermarket2/image/catalog/bt_comohos/staticblock_img2.jpg&quot; alt=&quot;banner&quot;&gt;&lt;/a&gt;&lt;/div&gt;

			&lt;div class=&quot;bt-staticblock-title bt-title-2&quot;&gt;				&lt;h3&gt;Sale Up To&lt;/h3&gt;

				&lt;h1&gt;&lt;span&gt;50&lt;/span&gt;&lt;sup&gt;%&lt;/sup&gt; Sneakers&lt;/h1&gt;

			&lt;/div&gt;

		&lt;/div&gt;

		&lt;div class=&quot;block-item bt-item-3&quot;&gt;			&lt;div class=&quot;bt-staticblock-image&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img src=&quot;http://demo.bossthemes.com/comohos_supermarket2/image/catalog/bt_comohos/staticblock_img3.jpg&quot; alt=&quot;banner&quot;&gt;&lt;/a&gt;&lt;/div&gt;

			&lt;div class=&quot;bt-staticblock-title bt-title-3&quot;&gt;				&lt;p&gt;Sale off  &lt;span&gt;50%&lt;/span&gt;  all week&lt;/p&gt;

				&lt;h1&gt;Boys Jeans&lt;/h1&gt;

				&lt;p&gt;25.12.2014 - 25.6.2015&lt;/p&gt;

			&lt;/div&gt;

		&lt;/div&gt;

	&lt;/div&gt;';
					$module_description5[$language['language_id']]['description'] = '&lt;div class=&quot;block-trending not-animated&quot; data-animate=&quot;fadeInLeft&quot; data-delay=&quot;200&quot;&gt;&lt;div class=&quot;box-heading&quot;&gt;&lt;h1&gt;Trending&lt;/h1&gt;
&lt;/div&gt;
&lt;div class=&quot;box-content&quot;&gt;&lt;ul&gt;
&lt;li&gt;&lt;a href=&quot;#&quot;&gt;Hug sale - 70% Off&lt;/a&gt;&lt;/li&gt;
&lt;li&gt;&lt;a href=&quot;#&quot;&gt;New Arrivals&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
&lt;/div&gt;
&lt;/div&gt;';
					$module_description6[$language['language_id']]['description'] = '&lt;div class=&quot;bt-banner-big-home&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img src=&quot;http://192.168.1.106/59_Q_Comohost/trunk/shoppingmall/image/catalog/bt_comohos/banner_big_home.jpg&quot; alt=&quot;banner&quot;&gt;&lt;/a&gt;&lt;/div&gt;';
					$module_description7[$language['language_id']]['description'] = '&lt;div class=&quot;bt-banner-home&quot;&gt;		&lt;div class=&quot;bt-item-left bt-banner-item&quot;&gt;			&lt;a href=&quot;#&quot;&gt;&lt;img src=&quot;http://192.168.1.106/59_Q_Comohost/trunk/shoppingmall/image/catalog/bt_comohos/banner_content_1.jpg&quot; alt=&quot;banner&quot;&gt;&lt;/a&gt;&lt;/div&gt;




		&lt;div class=&quot;bt-item-right bt-banner-item&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img src=&quot;http://192.168.1.106/59_Q_Comohost/trunk/shoppingmall/image/catalog/bt_comohos/banner_content_2.jpg&quot; alt=&quot;banner&quot;&gt;&lt;/a&gt;&lt;/div&gt;




	&lt;/div&gt;';
					$module_description8[$language['language_id']]['description'] = '&lt;div class=&quot;bt-block-purchase col-xs-12&quot; style=&quot;background-image: url(http://demo.bossthemes.com/comohos_shoppingmall/image/catalog/bt_comohos/bg_stactic_block.jpg);&quot;&gt;	&lt;div class=&quot;col-xs-12&quot;&gt;    		&lt;h1&gt;Do you love us yet?&lt;/h1&gt;
		&lt;h2&gt;Fashion is always of the time in which you live&lt;/h2&gt;
		&lt;a href=&quot;#&quot;&gt;Purchase This Theme&lt;/a&gt;	&lt;/div&gt;
&lt;/div&gt;';
					$module_description9[$language['language_id']]['description'] = '&lt;div class=&quot;banner-home-left bt-banner3&quot;&gt; &lt;a href=&quot;#&quot;&gt;&lt;img src=&quot;http://192.168.1.106/59_Q_Comohost/trunk/shoppingmall/image/catalog/bt_comohos/banner_small_home_2.jpg&quot; title=&quot;banner&quot; alt=&quot;banner&quot;&gt;&lt;span class=&quot;sale-info&quot;&gt;&lt;span class=&quot;sale-number&quot;&gt;50 &lt;sup&gt;%&lt;/sup&gt; &lt;sub&gt;OFF&lt;/sub&gt;&lt;/span&gt;&lt;span class=&quot;sale-text&quot;&gt;MEN&rsquo;S FASHION BOUTIQUE&lt;/span&gt;&lt;/span&gt;&lt;/a&gt;&lt;/div&gt;';
					$module_description10[$language['language_id']]['description'] = '&lt;div class=&quot;bt-block-theme-features&quot;&gt;  &lt;div class=&quot;container&quot;&gt;	&lt;div class=&quot;row&quot;&gt;	  &lt;div class=&quot;box-heading not-animated&quot; data-animate=&quot;fadeInUp&quot; data-delay=&quot;200&quot;&gt;		&lt;h1&gt;Theme Features&lt;/h1&gt;

	  &lt;/div&gt;

	  &lt;div class=&quot;box-content&quot;&gt;		&lt;div class=&quot;item-theme-features col-sm-3 col-xs-6 not-animated&quot; data-animate=&quot;fadeInUpBig&quot; data-delay=&quot;300&quot;&gt;		  &lt;a href=&quot;#&quot; class=&quot;image&quot;&gt;&lt;img src=&quot;http://demo.bossthemes.com/comohos_supermarket2/image/catalog/bt_comohos/InstallSampleData.jpg&quot; alt=&quot;Install Sample Data&quot; title=&quot;Install Sample Data&quot;&gt;&lt;/a&gt;		 &lt;a href=&quot;#&quot; class=&quot;title&quot;&gt;Install Sample Data&lt;/a&gt;&lt;/div&gt;

		&lt;div class=&quot;item-theme-features col-sm-3 col-xs-6 not-animated&quot; data-animate=&quot;fadeInUpBig&quot; data-delay=&quot;400&quot;&gt;		  &lt;a href=&quot;#&quot; class=&quot;image&quot;&gt;&lt;img src=&quot;http://demo.bossthemes.com/comohos_supermarket2/image/catalog/bt_comohos/LayoutComposer.jpg&quot; alt=&quot;Layout Composer&quot; title=&quot;Layout Composer&quot;&gt;		  &lt;/a&gt;	&lt;a href=&quot;#&quot; class=&quot;title&quot;&gt;Layout Composer&lt;/a&gt;	&lt;/div&gt;

		&lt;div class=&quot;item-theme-features col-sm-3 col-xs-6 not-animated&quot; data-animate=&quot;fadeInUpBig&quot; data-delay=&quot;500&quot;&gt;		  &lt;a href=&quot;#&quot; class=&quot;image&quot;&gt;&lt;img src=&quot;http://demo.bossthemes.com/comohos_supermarket2/image/catalog/bt_comohos/MegamenuComposer.jpg&quot; alt=&quot;Megamenu Composer&quot; title=&quot;Megamenu Composer&quot;&gt;	&lt;/a&gt;	  &lt;a href=&quot;#&quot; class=&quot;title&quot;&gt;Megamenu Composer	&lt;/a&gt;&lt;/div&gt;

&lt;a href=&quot;#&quot; class=&quot;title&quot;&gt;		&lt;/a&gt;&lt;div class=&quot;item-theme-features col-sm-3 col-xs-6 not-animated&quot; data-animate=&quot;fadeInUpBig&quot; data-delay=&quot;600&quot;&gt; &lt;a href=&quot;#&quot; class=&quot;image&quot;&gt;&lt;img src=&quot;http://demo.bossthemes.com/comohos_supermarket2/image/catalog/bt_comohos/UnlimitedFontsandColors.jpg&quot; alt=&quot;Unlimited Fontsand Colors&quot; title=&quot;Unlimited Fontsand Colors&quot;&gt;		  &lt;/a&gt;	&lt;a href=&quot;#&quot; class=&quot;title&quot;&gt;Unlimited Fontsand Colors&lt;/a&gt;	&lt;/div&gt;

	  &lt;/div&gt;

	&lt;/div&gt;

  &lt;/div&gt;

&lt;/div&gt;';
				}
				$contents = array(
					0 => array(
						'name' => 'Block Banner Category',
						'module_description' => $module_description1,
						'position' => 'content_top',
						'sort_order' => 1,
						'layout_id' => $this->getIdLayout('category'),  // category page
					),
					1 => array(
						'name' => 'Block Banner Category Left',
						'module_description' => $module_description2,
						'layout' => array(
							0 => array(
								'position' => 'column_left',
								'sort_order' => 7,
								'layout_id' => $this->getIdLayout('category'),  // category page
							),
							1 => array(
								'position' => 'column_left',
								'sort_order' => 7,
								'layout_id' => $this->getIdLayout('product'),  // category page
							),
						),
					),
					2 => array(
						'name' => 'Block Free Shipping',
						'module_description' => $module_description3,
						'position' => 'btslideshow',
						'sort_order' => 1,
						'layout_id' => $this->getIdLayout('home'),   //home page
					),
					3 => array(
						'name' => 'Block Watches',
						'module_description' => $module_description4,
						'position' => 'btslideshow',
						'sort_order' => 3,
						'layout_id' => $this->getIdLayout('home'),   //home page
					),
					4 => array(
						'name' => 'Block Trending',
						'module_description' => $module_description5,
						'position' => 'column_left',
						'sort_order' => 2,
						'layout_id' => $this->getIdLayout('home'),   //home page
					),
					5 => array(
						'name' => 'Block Fashion Women',
						'module_description' => $module_description6,
						'position' => 'content_top',
						'sort_order' => 2,
						'layout_id' => $this->getIdLayout('home'),   //home page
					),
					6 => array(
						'name' => 'Block Sale Up',
						'module_description' => $module_description7,
						'position' => 'content_top',
						'sort_order' => 4,
						'layout_id' => $this->getIdLayout('home'),   //home page
					),
					7 => array(
						'name' => 'Block Love Us Yet',
						'module_description' => $module_description8,
						'position' => 'btcontentmid',
						'sort_order' => 2,
						'layout_id' => $this->getIdLayout('home'),   //home page
					),
					8 => array(
						'name' => 'Block Men Fashion',
						'module_description' => $module_description9,
						'position' => 'column_right',
						'sort_order' => 3,
						'layout_id' => $this->getIdLayout('home'),   //home page
					),
					9 => array(
						'name' => 'Block Theme Features',
						'module_description' => $module_description10,
						'position' => 'btcontentbot',
						'sort_order' => 1,
						'layout_id' => $this->getIdLayout('home'),   //home page
					),
				);
				foreach($contents as $content){
					//create sample data and add module
					$sample_data = array(
						'name' => $content['name'],
						'code' => $code,
						'status' => 1,
						'module_description' => $content['module_description'],
					);
					$this->model_extension_module->addModule($code, $sample_data);
					//get module_id
					$module_id = $this->db->getLastId();
				
					if(isset($content['layout'])){
						foreach($content['layout'] as $layout){
							//add layout		
							$layout_module = array(
								'code'  => $code.'.'.$module_id,
								'position'  => $layout['position'],				
								'sort_order'  => $layout['sort_order'],
							);			
							$layout_id = $layout['layout_id']; 
							$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
						}
					}else{
						//add layout		
							$layout_module = array(
								'code'  => $code.'.'.$module_id,
								'position'  => $content['position'],				
								'sort_order'  => $content['sort_order'],
							);			
							$layout_id = $content['layout_id']; 
							$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
					}
				}
			break;
			
			case 'boss_menucategory':
				$code = 'boss_menucategory';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title = array();
				$title1 = array();
				$title2 = array();
				$title3 = array();
				$title4 = array();
				$title5 = array();
				$more_category = array();
				foreach($languages as $language){
					$more_category{$language['language_id']} = 'More Category';
					$title{$language['language_id']} = "Categories";
					$title1{$language['language_id']} = "Women's Clothing";
					$title2{$language['language_id']} = "Men's Clothing";
					$title3{$language['language_id']} = 'Eyeglasses';
					$title4{$language['language_id']} = 'Steel Watches';
					$title5{$language['language_id']} = 'Handbags';
				}
				//create sample data and add module
				$sample_data = array(
					'name' => 'Home Menu Category',
					'code' => $code,
					'status' => 1,					
					'title' => $title,										
					'alway_show' => 9,				
					'boss_menucategory_config' => array(
						'os6oj4rll8cwhfr' => array(
							'title' => $title1,
							'icon' => 'catalog/bt_comohos/icon_category_01.png',
							'category_id' => 20,
							'column' => 3,
							'sub_width' => 500,
							'bgimage' => 'catalog/bt_comohos/bg_submenu.png',
							'status' => 1,
							'sort_order' => 1,
						),
						'nofslo11l9chxgvi' => array(
							'title' => $title2,
							'icon' => 'catalog/bt_comohos/icon_category_03.png',
							'category_id' => 20,
							'column' => 2,
							'sub_width' => 300,
							'bgimage' => '',
							'status' => 1,
							'sort_order' => 2,
						),
						'b94urinqi24' => array(
							'title' => $title3,
							'icon' => 'catalog/bt_comohos/icon_category_07.png',
							'category_id' => 20,
							'column' => 1,
							'sub_width' => 220,
							'bgimage' => '',
							'status' => 1,
							'sort_order' => 3,
						),
						'iq2mscnzp2' => array(
							'title' => $title4,
							'icon' => 'catalog/bt_comohos/icon_category_09.png',
							'category_id' => 20,
							'column' => 1,
							'sub_width' => 220,
							'bgimage' => '',
							'status' => 1,
							'sort_order' => 4,
						),
						'sk6pvvx9bhf' => array(
							'title' => $title5,
							'icon' => 'catalog/bt_comohos/icon_category_11.png',
							'category_id' => 20,
							'column' => 1,
							'sub_width' => 220,
							'bgimage' => '',
							'status' => 1,
							'sort_order' => 5,
						),
					),
					
				);
				$this->model_extension_module->addModule($code, $sample_data);
				//get module_id
				$module_id = $this->db->getLastId();
				//edit module_id
				$sample_data_edit = $sample_data;
				$sample_data_edit['module_id'] = $module_id;				
				$this->model_extension_module->editModule($module_id, $sample_data_edit);
				
				$layouts = array(
					0 =>  array(
						'layout_id' => 9999, // all page		
						'position' => 'btheader',
						'sort_order' => 1,
					),
										
				);
				foreach($layouts as $layout){
					//add layout		
					$layout_module = array(
						'code'  => $code.'.'.$module_id,
						'position'  => $layout['position'],				
						'sort_order'  => $layout['sort_order'],
					);			
					$layout_id = $layout['layout_id']; 
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
				}
			break;
			case 'boss_facecomments':
				$code = 'boss_facecomments';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$this->load->model('setting/setting');
				$data = array(
					'boss_facecomments' => array(
						'status' => 1,
						'app_id' => '1679538022274729',
						'color_scheme' => 'light',
						'num_posts' => 5,
						'order_by' => 'reverse_time',
					),
				);
				
				$this->model_setting_setting->editSetting('boss_facecomments', $data);
			break;
			case 'boss_newmegamenu':
				$code = 'boss_newmegamenu';
				$this->deleteDataModule($code);
				$this->installModule($code);
				
				//create sample data and add module
				$sample_data = array(
					'name' => 'Megamenu',
					'code' => $code,
					'status' => 1,
					'boss_newmegamenu_module' => array(
						'menu_width' => 1170,
						'num_column' => 6,
						'module_id' => '',
						),
				);
				$this->model_extension_module->addModule($code, $sample_data);
				//get module_id
				$module_id = $this->db->getLastId();
				//edit module_id
				$sample_data_edit = array(
					'name' => 'Megamenu',
					'code' => $code,
					'status' => 1,
					'boss_newmegamenu_module' => array(
						'menu_width' => 1170,
						'num_column' => 6,
						'module_id' => $module_id,
						),
				);
				$this->model_extension_module->editModule($module_id, $sample_data_edit);
				
				$layouts = array(					
					0 =>  array(
						'layout_id' => 9999, // all page		
						'position' => 'btmainmenu',
						'sort_order' => 0,
					),
				);
				foreach($layouts as $layout){
					//add layout		
					$layout_module = array(
						'code'  => $code.'.'.$module_id,
						'position'  => $layout['position'],				
						'sort_order'  => $layout['sort_order'],
					);			
					$layout_id = $layout['layout_id']; 
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
				}
				
				
				$this->load->model('bossthemes/boss_newmegamenu');
				$this->model_bossthemes_boss_newmegamenu->createdb();
				
				$this->db->query("update " . DB_PREFIX . "megamenu SET module_id = '" . (int)$module_id . "'");
			break;
			
			case 'boss_revolutionslider':
					$code = 'boss_revolutionslider';
					$this->deleteDataModule($code);
					$this->installModule($code);
					
					//create sample data and add module
					$sample_data = array(
						'name' => 'Slideshow',
						'code' => $code,
						'status' => 1,
						'slider_id' => 28,
					);
					$this->model_extension_module->addModule($code, $sample_data);
					//get module_id
					$module_id = $this->db->getLastId();
					$layouts = array(					
						0 =>  array(
							'layout_id' => $this->getIdLayout('home'), // home page		
							'position' => 'btslideshow',
							'sort_order' => 1,
						),
										
					);
					foreach($layouts as $layout){
						//add layout		
						$layout_module = array(
							'code'  => $code.'.'.$module_id,
							'position'  => $layout['position'],				
							'sort_order'  => $layout['sort_order'],
						);			
						$layout_id = $layout['layout_id']; 
						$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
					}
					
					$this->load->model('bossthemes/boss_revolutionslider');
			
					$this->model_bossthemes_boss_revolutionslider->createdb();
					
				
			break;
			
			case 'bossblog':
				$code = 'bossblog';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$this->load->model('user/user_group');
		
				$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'bossblog/category');
				$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'bossblog/category');
				
				$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'bossblog/articles');
				$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'bossblog/articles');
				
				$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'bossblog/comment');
				$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'bossblog/comment');
				
				$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'bossblog/setting');
				$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'bossblog/setting');
				
				$this->load->model('setting/setting');  
				
				$this->model_setting_setting->deleteSetting('config_bossblog');
				$this->load->model('bossblog/bossblog');					
				$this->model_bossblog_bossblog->dropBlog();
				
				$this->load->model('bossblog/category');					
				$this->model_bossblog_category->checkBlogCategory();
				
				$this->load->model('bossblog/comment');					
				$this->model_bossblog_comment->checkBlogComment();
				
				$this->load->model('bossblog/articles');			
				$this->model_bossblog_articles->checkBlogArticle();
				
				$data = array(
					'config_bossblog_name'                  =>'Blog',
					'config_bossblog_limit'             	=>5,
					'config_bossblog_admin_limit'           =>5,
					'config_bossblog_comment_status'        =>1,
					'config_bossblog_approval_status'       =>0,
					'config_bossblog_image_category_width' 	=>880,
					'config_bossblog_image_category_height' =>295,
					'config_bossblog_image_article_width'   =>420,
					'config_bossblog_image_article_height'  =>300,
					'config_bossblog_image_title_width'  	=>98,
					'config_bossblog_image_title_height'  	=>70,
					'config_bossblog_image_related_width'   =>270,
					'config_bossblog_image_related_height'  =>193,                   
				);
				
				$this->model_setting_setting->editSetting('config_bossblog', $data);
				$special = array (
					'name' => 'Boss Blog',
					'layout_route' => array(
						0 => array (
							'store_id' => 0, 
							'route' => 'bossblog/%',
						),
					),
				);
        
				$this->addLayout($special);
        
				
			break;
			case 'blogcategory':
				$code = 'blogcategory';
				$b_check = $this->checkModule('bossblog');
				if(!$b_check){
					$json['error'] = '<i class="fa fa-check-circle"></i> Error! You must install the Boss - Blog module before.';
				}else{				
					$this->deleteDataModule($code);
					$this->installModule($code);
					
					//create sample data and add module
					$sample_data = array(
						'name' => 'Blog Category',
						'code' => $code,
						'status' => 1,
						'count' => 1
					);
					$this->model_extension_module->addModule($code, $sample_data);
					//get module_id
					$module_id = $this->db->getLastId();
					
					$layouts = array(
						0 =>  array(
							'layout_id' => $this->getIdLayout('Boss Blog'), // Blog page		
							'position' => 'column_left',
							'sort_order' => 2,
						),
										
					);
					foreach($layouts as $layout){
						//add layout		
						$layout_module = array(
							'code'  => $code.'.'.$module_id,
							'position'  => $layout['position'],				
							'sort_order'  => $layout['sort_order'],
						);			
						$layout_id = $layout['layout_id']; 
						$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
					}
				}
			break;
			case 'blogrecentcomment':
				$code = 'blogrecentcomment';
				$b_check = $this->checkModule('bossblog');
				if(!$b_check){
					$json['error'] = '<i class="fa fa-check-circle"></i> Error! You must install the Boss - Blog module before.';
				}else{				
					$this->deleteDataModule($code);
					$this->installModule($code);
					$title = array();
					foreach($languages as $language){
						$title{$language['language_id']} = 'Blog Recent Comment';
					}
					//create sample data and add module
					$sample_data = array(
						'name' => 'Blog Recent Comment',
						'code' => $code,
						'status' => 1,
						'title' => $title,
						'limit' => 3,
					);
					$this->model_extension_module->addModule($code, $sample_data);
					//get module_id
					$module_id = $this->db->getLastId();
					
					$layouts = array(					
						0 =>  array(
							'layout_id' => $this->getIdLayout('Boss Blog'), // Blog page		
							'position' => 'column_left',
							'sort_order' => 4,
						),
										
					);
					foreach($layouts as $layout){
						//add layout		
						$layout_module = array(
							'code'  => $code.'.'.$module_id,
							'position'  => $layout['position'],				
							'sort_order'  => $layout['sort_order'],
						);			
						$layout_id = $layout['layout_id']; 
						$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
					}
				}
			break;
			case 'blogrecentpost':
				$code = 'blogrecentpost';
				$b_check = $this->checkModule('bossblog');
				if(!$b_check){
					$json['error'] = '<i class="fa fa-check-circle"></i> Error! You must install the Boss - Blog module before.';
				}else{
					$this->deleteDataModule($code);
					$this->installModule($code);
					$title1 = array();
					foreach($languages as $language){
						$title1{$language['language_id']} = 'Blog Recent Post';
						$title2{$language['language_id']} = 'Recent Post';
					}
					//create sample data and add module
					$contents = array(
						0 => array(
							'name' => 'Blog Recent Post',
							'code' => $code,
							'status' => 1,
							'title' => $title1,
							'limit' => 3,
							'image_width' => 98,
							'image_height' => 70,
							'layout_id' => $this->getIdLayout('Boss Blog'), // product page
							'position' => 'column_left',
							'sort_order' => 3,
						),
						1 => array(
							'name' => 'Blog Footer Recent Post',
							'code' => $code,
							'status' => 1,
							'title' => $title2,
							'limit' => 3,
							'image_width' => 98,
							'image_height' => 70,
							'layout_id' => 9999, // all layout	
							'position' => 'btfootermid',
							'sort_order' => 1,
						),
						2 => array(
							'name' => 'Recent Post Home Content',
							'code' => $code,
							'status' => 1,
							'title' => $title2,
							'limit' => 1,
							'image_width' => 370,
							'image_height' => 264,
							'layout_id' => $this->getIdLayout('Boss Blog'), // product page
							'position' => 'column_left',
							'sort_order' => 3,
						),
					);
					foreach($contents as $content){
					//create sample data and add module
					$sample_data = array(
						'name' => $content['name'],
						'code' => $code,
						'status' => 1,
						'limit' => $content['limit'],
						'image_width' => $content['image_width'],
						'image_height' => $content['image_height'],
					);
					$this->model_extension_module->addModule($code, $sample_data);
					//get module_id
					$module_id = $this->db->getLastId();
				
					if(isset($content['layout'])){
						foreach($content['layout'] as $layout){
							//add layout		
							$layout_module = array(
								'code'  => $code.'.'.$module_id,
								'position'  => $layout['position'],				
								'sort_order'  => $layout['sort_order'],
							);			
							$layout_id = $layout['layout_id']; 
							$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
						}
					}else{
						//add layout		
							$layout_module = array(
								'code'  => $code.'.'.$module_id,
								'position'  => $content['position'],				
								'sort_order'  => $content['sort_order'],
							);			
							$layout_id = $content['layout_id']; 
							$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
					}
					}
				}
			break;
			case 'blogsearch':
				$code = 'blogsearch';
				$b_check = $this->checkModule('bossblog');
				if(!$b_check){
					$json['error'] = '<i class="fa fa-check-circle"></i> Error! You must install the Boss - Blog module before.';
				}else{
					$this->deleteDataModule($code);
					$this->installModule($code);
					
					//create sample data and add module
					$sample_data = array(
						'name' => 'Blog Search',
						'code' => $code,
						'status' => 1,
					);
					$this->model_extension_module->addModule($code, $sample_data);
					//get module_id
					$module_id = $this->db->getLastId();
					
					$layouts = array(					
						0 =>  array(
							'layout_id' => $this->getIdLayout('Boss Blog'), // product page		
							'position' => 'column_left',
							'sort_order' => 1,
						),
					);
					foreach($layouts as $layout){
						//add layout		
						$layout_module = array(
							'code'  => $code.'.'.$module_id,
							'position'  => $layout['position'],				
							'sort_order'  => $layout['sort_order'],
						);			
						$layout_id = $layout['layout_id']; 
						$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
					}
				}
			break;
			case 'blogtagcloud':
				$code = 'blogtagcloud';
				$b_check = $this->checkModule('bossblog');
				if(!$b_check){
					$json['error'] = '<i class="fa fa-check-circle"></i> Error! You must install the Boss - Blog module before.';
				}else{				
					$this->deleteDataModule($code);
					$this->installModule($code);
					$title = array();
					foreach($languages as $language){
						$title{$language['language_id']} = 'Tags';
					}
					//create sample data and add module
					$sample_data = array(
						'name' => 'Blog Tag Cloud',
						'code' => $code,
						'status' => 1,
						'blogtagcloud_module' => array(
							'title' => $title,
							'limit' => 20,
							'min_font_size' => 9,
							'max_font_size' => 25,
							'font_weight' => 'normal',
						),						
					);
					$this->model_extension_module->addModule($code, $sample_data);
					//get module_id
					$module_id = $this->db->getLastId();
					
					$layouts = array(					
						0 =>  array(
							'layout_id' => $this->getIdLayout('Boss Blog'), // product page		
							'position' => 'column_left',
							'sort_order' => 5,
						),
						1 =>  array(
							'layout_id' => $this->getIdLayout('home'), // product page		
							'position' => 'btfootermid',
							'sort_order' => 3,
						),
					);
					foreach($layouts as $layout){
						//add layout		
						$layout_module = array(
							'code'  => $code.'.'.$module_id,
							'position'  => $layout['position'],				
							'sort_order'  => $layout['sort_order'],
						);			
						$layout_id = $layout['layout_id']; 
						$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
					}
				}
			break;
			case 'boss_blogfeatured':
				$code = 'boss_blogfeatured';
				$b_check = $this->checkModule('bossblog');
				if(!$b_check){
					$json['error'] = '<i class="fa fa-check-circle"></i> Error! You must install the Boss - Blog module before.';
				}else{				
					$this->deleteDataModule($code);
					$this->installModule($code);
					$title = array();
					foreach($languages as $language){
						$title{$language['language_id']} = 'Latest News';
					}
					//create sample data and add module
					$sample_data = array(
						'name' => 'Blog Featured',
						'code' => $code,
						'status' => 1,
						'filter_blog' => 'latest',
						'title' => $title,
						'useslider' => 0,
						'limit' => 3,
						'limit_article' => 30,
						'limit_des' => 200,
						'image_width' => 368,
						'image_height' => 263,
					);
					$this->model_extension_module->addModule($code, $sample_data);
					//get module_id
					$module_id = $this->db->getLastId();
					
					$layouts = array(					
						0 =>  array(
							'layout_id' => $this->getIdLayout('home'), // product page		
							'position' => 'content_bottom',
							'sort_order' => 5,
						),
										
					);
					foreach($layouts as $layout){
						//add layout		
						$layout_module = array(
							'code'  => $code.'.'.$module_id,
							'position'  => $layout['position'],				
							'sort_order'  => $layout['sort_order'],
						);			
						$layout_id = $layout['layout_id']; 
						$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
					}
				}
			break;
			
			case 'boss_featured':
				$code = 'boss_featured';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title1 = array();
				$title2 = array();
				foreach($languages as $language){
					$title1{$language['language_id']} = 'New Arrival';
					$title2{$language['language_id']} = 'Best Selling';
				}
				
				//create content data and add module
				$contents = array(
					0 => array(
						'name'=> 'New Arrival Features',
						'title' => $title1,
						'type_product' => 'popular',
						'image_width' => 248,
						'image_height' => 294,
						'limit' => 6,
						'show_slider' => 1,
						'num_row' => 1,
						'per_row' => 3,
						'nav_type' => 0,
						'show_pro_large' => 0,
						'product_name' => '',
						'product_id' => '',
						'img_width' => 380,
						'img_height' => 380,
						'status' => 1,
						'position' => 'btcontenttop',
						'sort_order' => 2,
						'layout_id' => $this->getIdLayout('home'),  //home page
					),
					1 => array(
						'name'=> 'Best Seller Product',
						'title' => $title2,
						'type_product' => 'popular',
						'image_width' => 195,
						'image_height' => 231,
						'limit' => 10,
						'show_slider' => 1,
						'num_row' => 1,
						'per_row' => 5,
						'nav_type' => 0,
						'show_pro_large' => 0,
						'product_name' => '--- None ---',
						'product_id' => 0,
						'img_width' => 420,
						'img_height' => 498,
						'status' => 1,
						'position' => 'btcontentmid',
						'sort_order' => 3,
						'layout_id' => $this->getIdLayout('home'),  // home page
					),
				);
				foreach($contents as $content){
					//create sample data and add module
					$sample_data = array(
						'name' => $content['name'],
						'code' => $code,
						'title' => $content['title'],
						'type_product' => $content['type_product'],
						'image_width' => $content['image_width'],
						'image_height' => $content['image_height'],
						'limit' => $content['limit'],
						'show_slider' => $content['show_slider'],
						'num_row' => $content['num_row'],
						'per_row' => $content['per_row'],
						'nav_type' => $content['nav_type'],
						'show_pro_large' => $content['show_pro_large'],
						'product_name' => $content['product_name'],
						'product_id' => $content['product_id'],
						'img_width' => $content['img_width'],
						'img_height' => $content['img_height'],
						'status' => $content['status'],
					);
					$this->model_extension_module->addModule($code, $sample_data);
					//get module_id
					$module_id = $this->db->getLastId();
				
					if(isset($content['layout'])){
						foreach($content['layout'] as $layout){
							//add layout		
							$layout_module = array(
								'code'  => $code.'.'.$module_id,
								'position'  => $layout['position'],				
								'sort_order'  => $layout['sort_order'],
							);			
							$layout_id = $layout['layout_id']; 
							$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
						}
					}else{
						//add layout		
							$layout_module = array(
								'code'  => $code.'.'.$module_id,
								'position'  => $content['position'],				
								'sort_order'  => $content['sort_order'],
							);			
							$layout_id = $content['layout_id']; 
							$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
					}
				}
			break;
			
			case 'newslettersubscribe':
				$code = 'newslettersubscribe';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title = array();
				$sub_title = array();
				foreach($languages as $language){
					$title{$language['language_id']} = 'Newsletter Signup';
					$sub_title{$language['language_id']} = 'Enter your email and we\'ll send you a coupon with 10% off your next order. Add your text here';
				}
				//create sample data and add module
				$sample_data = array(
					'name' => 'NewsLetter Footer',
					'code' => $code,
					'status' => 1,
					'title' => $title,
					'sub_title' => $sub_title,
					'option_unsubscribe' => 0,
					'newslettersubscribe_mail_status' => 1,
					'newslettersubscribe_registered' => 1,
					
				);
				$this->model_extension_module->addModule($code, $sample_data);
				//get module_id
				$module_id = $this->db->getLastId();
				
				$layouts = array(					
					0 =>  array(
						'layout_id' => 9999, // all page		
						'position' => 'btnewsletter',
						'sort_order' => 1,
					),
				);
				foreach($layouts as $layout){
					//add layout		
					$layout_module = array(
						'code'  => $code.'.'.$module_id,
						'position'  => $layout['position'],				
						'sort_order'  => $layout['sort_order'],
					);			
					$layout_id = $layout['layout_id']; 
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
				}
			break;
			
			case 'boss_topcategory':
				$code = 'boss_topcategory';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title1= array();
				foreach($languages as $language){
					$title1{$language['language_id']} = 'All Categories';
				}
				
				//create sample data and add module
				$sample_data = array(
					'name' => 'Category Home',
					'title' => $title1,
					'image_width' => 174,
					'image_height' => 157,
					'show_slider' => 0,
					'per_row' => 5,
					'status' => 1,
					'boss_topcategory_check' => array(
						0 => 20,
						1 => 25,
						2 => 25,
						3 => 25,
						4 => 20,
					),
				);
				$this->model_extension_module->addModule($code, $sample_data);
				//get module_id
				$module_id = $this->db->getLastId();
				
				$layouts = array(
					0 =>  array(
						'layout_id' => $this->getIdLayout('home'), // home page		
						'position' => 'btcontentmid',
						'sort_order' => 1,
					),									
				);
				foreach($layouts as $layout){
					//add layout		
					$layout_module = array(
						'code'  => $code.'.'.$module_id,
						'position'  => $layout['position'],				
						'sort_order'  => $layout['sort_order'],
					);			
					$layout_id = $layout['layout_id']; 
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
				}
			break;
			case 'boss_filterproduct':
				$code = 'boss_filterproduct';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title1= array();
				$title2= array();
				$title3= array();
				$title4= array();
				$title5= array();
				foreach($languages as $language){
					$title1{$language['language_id']} = 'Staff Picks';
					$title2{$language['language_id']} = 'Random Picks';
					$title3{$language['language_id']} = 'Jackets';
					$title4{$language['language_id']} = 'T-Shirts';
					$title5{$language['language_id']} = 'Jeans';
				}
				
				//create sample data and add module
				$contents = array(
					0 => array(
						'name'=> 'Tab Column Right',
						'boss_filterproduct_module' => array(
							'tabs' => array(
								0 => array(
									'title' => $title1,
									'icon' => '',
									'type_product' => 'latest',
								),
								1 => array(
									'title' => $title2,
									'icon' => '',
									'type_product' => 'popular',
								),
							),
							'image_width' => 80,
							'image_height' => 95,
							'limit' => 3,
							'use_scrolling_panel' => 0,
							'numrow' => 3,
							'perrow' => 1,
							'use_tab' => 1,
							'column' => 1,
							'class_css' => 'column-noimage',
						),
						'status' => 1,
						'position' => 'column_right',
						'sort_order' => 1,
						'layout_id' => $this->getIdLayout('home'),  //home page
					),
					1 => array(
						'name'=> 'Collection',
						'boss_filterproduct_module' => array(
							'tabs' => array(
								0 => array(
									'title' => $title3,
									'icon' => 'catalog/bt_comohos/icon_1.png',
									'type_product' => 'popular',
								),
								1 => array(
									'title' => $title4,
									'icon' => 'catalog/bt_comohos/icon_2.png',
									'type_product' => 'popular',
								),
								2 => array(
									'title' => $title5,
									'icon' => 'catalog/bt_comohos/icon_3.png',
									'type_product' => 'popular',
								),
							),
							'image_width' => 80,
							'image_height' => 94,
							'limit' => 8,
							'use_scrolling_panel' => 0,
							'numrow' => 1,
							'perrow' => 4,
							'use_tab' => 1,
							'column' => 1,
							'class_css' => 'bt-product-list',
						),
						'status' => 1,
						'position' => 'content_bottom',
						'sort_order' => 1,
						'layout_id' => $this->getIdLayout('home'),  //home page
					),
				);
				foreach($contents as $content){
					//create sample data and add module
					$sample_data = array(
						'name' => $content['name'],
						'code' => $code,
						'boss_filterproduct_module' => $content['boss_filterproduct_module'],
						'status' => $content['status'],
					);
					$this->model_extension_module->addModule($code, $sample_data);
					//get module_id
					$module_id = $this->db->getLastId();
				
					if(isset($content['layout'])){
						foreach($content['layout'] as $layout){
							//add layout		
							$layout_module = array(
								'code'  => $code.'.'.$module_id,
								'position'  => $layout['position'],				
								'sort_order'  => $layout['sort_order'],
							);			
							$layout_id = $layout['layout_id']; 
							$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
						}
					}else{
						//add layout		
							$layout_module = array(
								'code'  => $code.'.'.$module_id,
								'position'  => $content['position'],				
								'sort_order'  => $content['sort_order'],
							);			
							$layout_id = $content['layout_id']; 
							$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
					}
				}
			break;
			case 'boss_testimonial':
				$code = 'boss_testimonial';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$this->load->model('catalog/boss_testimonial');
				$this->load->model('user/user_group');
				
				$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'catalog/boss_testimonial');
				$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'catalog/boss_testimonial');
				$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'catalog/boss_testimonial_setting');
				$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'catalog/boss_testimonial_setting');
				
				$data = array(
					
					'testimonial_admin_approved'                  =>1,
					'testimonial_default_rating'             =>3,
					'testimonial_all_page_limit'             =>20,
									   
				);
				
				$this->load->model('setting/setting');        
				$this->model_setting_setting->editSetting('testimonial', $data);
				$this->model_catalog_boss_testimonial->createDatabaseTables();
				$title = array();
				foreach($languages as $language){
					$title{$language['language_id']} = 'Testimonials';
				}
				//create sample data and add module
				$sample_data = array(
					'name' => 'Testimonials',
					'code' => $code,
					'status' => 1,
					'boss_testimonial_module' => array(
						'title' => $title,										
						'limit' => 3,										
						'limit_character' => 150,										
						'random' => 0,
						'auto_scroll' => 1,
						'show_name' => 1,						
						'show_subject' => 0,						
						'show_message' => 1,						
						'show_city' => 0,						
						'show_rating' => 0,						
						'show_date' => 1,						
						'show_image' => 1,						
						'show_all' => 0,						
						'show_write' => 0,						
					),
				);
				$this->model_extension_module->addModule($code, $sample_data);
				//get module_id
				$module_id = $this->db->getLastId();
				
				$layouts = array(
					0 =>  array(
						'layout_id' => $this->getIdLayout('home'), // home page		
						'position' => 'column_right',
						'sort_order' => 2,
					),										
				);
				foreach($layouts as $layout){
					//add layout		
					$layout_module = array(
						'code'  => $code.'.'.$module_id,
						'position'  => $layout['position'],				
						'sort_order'  => $layout['sort_order'],
					);			
					$layout_id = $layout['layout_id']; 
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
				}
			break;
			
			case 'boss_gallery':
				$code = 'boss_gallery';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title1= array();
				$description= array();
				foreach($languages as $language){
					$title1{$language['language_id']} = 'Brand & Clients';
					$description{$language['language_id']} = 'banner';
				}
				
				//create sample data and add module
				$sample_data = array(
					'name' => 'Brand Clients',
					'boss_gallery_title' => $title1,
					'status' => 1,
					'boss_gallery_image' => array(
						0 => array(
							'gallery_image_description' => $description,
							'link' => '#',
							'shopnow' => 1,
							'image' => 'catalog/bt_comohos/brand_1.png',
							'class' => 'ourbrand',
						),
						1 => array(
							'gallery_image_description' => $description,
							'link' => '#',
							'shopnow' => 1,
							'image' => 'catalog/bt_comohos/brand_2.png',
							'class' => 'ourbrand',
						),
						2 => array(
							'gallery_image_description' => $description,
							'link' => '#',
							'shopnow' => 1,
							'image' => 'catalog/bt_comohos/brand_3.png',
							'class' => 'ourbrand',
						),
						3 => array(
							'gallery_image_description' => $description,
							'link' => '#',
							'shopnow' => 1,
							'image' => 'catalog/bt_comohos/brand_4.png',
							'class' => 'ourbrand',
						),
					),
				);
				$this->model_extension_module->addModule($code, $sample_data);
				//get module_id
				$module_id = $this->db->getLastId();
				
				$layouts = array(
					0 =>  array(
						'layout_id' => $this->getIdLayout('home'), // home page		
						'position' => 'content_top',
						'sort_order' => 7,
					),									
				);
				foreach($layouts as $layout){
					//add layout		
					$layout_module = array(
						'code'  => $code.'.'.$module_id,
						'position'  => $layout['position'],				
						'sort_order'  => $layout['sort_order'],
					);			
					$layout_id = $layout['layout_id']; 
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
				}
			break;
			
			case 'boss_procate':
				$code = 'boss_procate';
				$this->deleteDataModule($code);
				$this->installModule($code);
				$title1= array();
				$title2= array();
				$title3= array();
				$title4= array();
				foreach($languages as $language){
					$title1{$language['language_id']} = 'Women\'s Clothing';
					$title2{$language['language_id']} = 'Men\'s Clothing';
					$title3{$language['language_id']} = 'Sale off';
					$title4{$language['language_id']} = 'Top Rated';
				}
				
				//create sample data and add module
				$contents = array(
					0 => array(
						'name'=> 'Women\'s Clothing',
						'boss_module_title'=> $title1,
						'boss_procate_module' => 'Women\'s Clothing',
						'boss_procate_id' => 20,
						'large_image' => 1,
						'image_large_width' => 370,
						'image_large_height' => 334,
						'image_width' => 148,
						'image_height' => 175,
						'limit' => 6,
						'show_slider' => 1,
						'per_row' => 4,
						'column_css' => 12,
						'type' => 0,
						'status' => 1,
						'position' => 'content_top',
						'sort_order' => 1,
						'layout_id' => $this->getIdLayout('home'),  //home page
					),
					1 => array(
						'name'=> 'Men\'s Clothing',
						'boss_module_title'=> $title2,
						'boss_procate_module' => '',
						'boss_procate_id' => 20,
						'large_image' => 1,
						'image_large_width' => 370,
						'image_large_height' => 334,
						'image_width' => 148,
						'image_height' => 175,
						'limit' => 9,
						'show_slider' => 1,
						'per_row' => 4,
						'column_css' => 12,
						'type' => 0,
						'status' => 1,
						'position' => 'content_top',
						'sort_order' => 3,
						'layout_id' => $this->getIdLayout('home'),  //home page
					),
					2 => array(
						'name'=> 'Procate Column 1',
						'boss_module_title'=> $title3,
						'boss_procate_module' => '',
						'boss_procate_id' => 20,
						'large_image' => 0,
						'image_large_width' => 200,
						'image_large_height' => 200,
						'image_width' => 80,
						'image_height' => 94,
						'limit' => 3,
						'show_slider' => 0,
						'per_row' => 1,
						'column_css' => 4,
						'type' => 1,
						'status' => 1,
						'position' => 'content_bottom',
						'sort_order' => 2,
						'layout_id' => $this->getIdLayout('home'),  //home page
					),
					3 => array(
						'name'=> 'Procate Column 2',
						'boss_module_title'=> $title4,
						'boss_procate_module' => '',
						'boss_procate_id' => 20,
						'large_image' => 0,
						'image_large_width' => 200,
						'image_large_height' => 200,
						'image_width' => 80,
						'image_height' => 94,
						'limit' => 3,
						'show_slider' => 0,
						'per_row' => 1,
						'column_css' => 4,
						'type' => 1,
						'status' => 1,
						'position' => 'content_bottom',
						'sort_order' => 3,
						'layout_id' => $this->getIdLayout('home'),  //home page
					),
				);
				foreach($contents as $content){
					//create sample data and add module
					$sample_data = array(
						'name' => $content['name'],
						'code' => $code,
						'boss_module_title'=> $content['boss_module_title'],
						'boss_procate_module' => $content['boss_procate_module'],
						'boss_procate_id' => $content['boss_procate_id'],
						'large_image' => $content['large_image'],
						'image_large_width' => $content['image_large_width'],
						'image_large_height' => $content['image_large_height'],
						'image_width' => $content['image_width'],
						'image_height' => $content['image_height'],
						'limit' => $content['limit'],
						'show_slider' => $content['show_slider'],
						'per_row' => $content['per_row'],
						'column_css' => $content['column_css'],
						'type' => $content['type'],
						'status' => $content['status'],
					);
					$this->model_extension_module->addModule($code, $sample_data);
					//get module_id
					$module_id = $this->db->getLastId();
				
					if(isset($content['layout'])){
						foreach($content['layout'] as $layout){
							//add layout		
							$layout_module = array(
								'code'  => $code.'.'.$module_id,
								'position'  => $layout['position'],				
								'sort_order'  => $layout['sort_order'],
							);			
							$layout_id = $layout['layout_id']; 
							$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
						}
					}else{
						//add layout		
							$layout_module = array(
								'code'  => $code.'.'.$module_id,
								'position'  => $content['position'],				
								'sort_order'  => $content['sort_order'],
							);			
							$layout_id = $content['layout_id']; 
							$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module SET layout_id = '" . (int)$layout_id . "', code = '" . $this->db->escape($layout_module['code']) . "', position = '" . $this->db->escape($layout_module['position']) . "', sort_order = '" . (int)$layout_module['sort_order'] . "'");
					}
				}
			break;
		}
	
		$json['output'] = '<i class="fa fa-check-circle"></i> Install module success! go to module page to see the changes';
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function addLayout($data) {
		$name=$this->db->escape($data['name']);
		$this->deleteLayout($name);
		$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET name = '" . $this->db->escape($data['name']) . "'");
		
		$layout_id = $this->db->getLastId();
		
		if (isset($data['layout_route'])) {
			foreach ($data['layout_route'] as $layout_route) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = '" . (int)$layout_id . "', store_id = '" . (int)$layout_route['store_id'] . "', route = '" . $this->db->escape($layout_route['route']) . "'");
			}	
		}
	}
	private function deleteLayout($layout_name) {
    	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout WHERE name = '".$layout_name."'");
    	if($query->num_rows){
    		$layout_id = $query->row['layout_id'];
    		$this->db->query("DELETE FROM " . DB_PREFIX . "layout WHERE layout_id = '" . (int)$layout_id . "'");
    		$this->db->query("DELETE FROM " . DB_PREFIX . "layout_route WHERE layout_id = '" . (int)$layout_id . "'");
    		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");
    		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . (int)$layout_id . "'");
    		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_layout WHERE layout_id = '" . (int)$layout_id . "'");	
    		}
   	}
}
?>