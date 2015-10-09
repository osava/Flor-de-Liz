<?php  
class ControllerModuleBossQuickshop extends Controller {
	public function index($setting) {
		if(empty($setting)) return;
		$data['selecters'] = array();
		$data['selecters'] = explode(",", html_entity_decode($setting['array_class_selected'], ENT_QUOTES, 'UTF-8'));
		
		$data['text'] = isset($setting['title'][$this->config->get('config_language_id')]) ? $setting['title'][$this->config->get('config_language_id')] : '';
			
		$data['width'] =  $setting['width'];
				
		$data['seo_data'] = array();
		
		$this->load->model('catalog/product');
		
		$datas = $this->db->query("SELECT `query`, `keyword`  FROM `" . DB_PREFIX . "url_alias`");
		
		foreach ($datas->rows as $dataf) {
			if(preg_match("/product_id/i", $dataf['query'])){
				$data['seo_data'][]= array(
					'query' => $dataf['query'],
					'keyword' => $dataf['keyword']
				);
			}
		}	
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_quickshop.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/boss_quickshop.tpl', $data);
		} else {
			return $this->load->view('default/template/module/boss_quickshop.tpl', $data);
		}
	}
}
?>