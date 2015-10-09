<?php
class ControllerModuleBossManufacturer extends Controller {
	public function index($setting) {
		if(empty($setting)) return;
		static $module = 0;
		
		$data['heading_title'] = isset($setting['title'][$this->config->get('config_language_id')]) ? $setting['title'][$this->config->get('config_language_id')]:'';
		
		if (isset($this->request->get['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->get['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}
		
		$this->load->model('catalog/manufacturer');

		$data['manufacturers'] = array();

		$results = $this->model_catalog_manufacturer->getManufacturers();

		foreach ($results as $result) {
			$data['manufacturers'][] = array(
				'manufacturer_id' => $result['manufacturer_id'],
				'name'            => $result['name'],
				'href'            => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
			);
		}
		
		$data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_manufacturer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/boss_manufacturer.tpl', $data);
		} else {
			return $this->load->view('default/template/module/boss_manufacturer.tpl', $data);
		}
	}
}
?>