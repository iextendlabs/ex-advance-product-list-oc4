<?php

namespace Opencart\Admin\Controller\Extension\AdvanceProductList\Module;

/**
 * Class AdvanceProductList   advance_product_list
 *
 * @package  Opencart\Admin\Controller\Extension\OptionQuantity\Module
 */
class AdvanceProductList extends \Opencart\System\Engine\Controller
{
	/**
	 * Index 
	 *
	 * @return void
	 */

	public function index(): void
	{
		$this->load->language('extension/advance_product_list/module/advance_product_list');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/advance_product_list/module/advance_product_list', 'user_token=' . $this->session->data['user_token'])
		];

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['module_advance_product_list_status'] = $this->config->get('module_advance_product_list_status');

		$data['list'] = $this->load->controller('extension/advance_product_list/module/advance_product_list.productList');



		$data['action'] = $this->url->link('extension/advance_product_list/module/advance_product_list.save', 'user_token=' . $this->session->data['user_token']);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/advance_product_list/module/advance_product_list', $data));
	}

	public function productList(): void
	{
		$this->load->language('extension/advance_product_list/module/product');

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_product_id'])) {
			$filter_product_id = $this->request->get['filter_product_id'];
		} else {
			$filter_product_id = '';
		}
		

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = '';
		}

		if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = '';
		}

		if (isset($this->request->get['filter_manufacturer_id'])) {
			$filter_manufacturer_id = $this->request->get['filter_manufacturer_id'];
		} else {
			$filter_manufacturer_id = '';
		}
		
		if (isset($this->request->get['filter_price_from'])) {
			$filter_price_from = $this->request->get['filter_price_from'];
		} else {
			$filter_price_from = '';
		}

		if (isset($this->request->get['filter_price_to'])) {
			$filter_price_to = $this->request->get['filter_price_to'];
		} else {
			$filter_price_to = '';
		}

		if (isset($this->request->get['filter_quantity_from'])) {
			$filter_quantity_from = $this->request->get['filter_quantity_from'];
		} else {
			$filter_quantity_from = '';
		}

		if (isset($this->request->get['filter_quantity_to'])) {
			$filter_quantity_to = $this->request->get['filter_quantity_to'];
		} else {
			$filter_quantity_to = '';
		}

		// New date filters
		if (isset($this->request->get['filter_date_added_from'])) {
			$filter_date_added_from = $this->request->get['filter_date_added_from'];
		} else {
			$filter_date_added_from = '';
		}

		if (isset($this->request->get['filter_date_added_to'])) {
			$filter_date_added_to = $this->request->get['filter_date_added_to'];
		} else {
			$filter_date_added_to = '';
		}

		if (isset($this->request->get['filter_date_modified_from'])) {
			$filter_date_modified_from = $this->request->get['filter_date_modified_from'];
		} else {
			$filter_date_modified_from = '';
		}

		if (isset($this->request->get['filter_date_modified_to'])) {
			$filter_date_modified_to = $this->request->get['filter_date_modified_to'];
		} else {
			$filter_date_modified_to = '';
		}

		if (isset($this->request->get['filter_sku'])) {
			$filter_sku = $this->request->get['filter_sku'];
		} else {
			$filter_sku = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';
		

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}


		if (isset($this->request->get['filter_manufacturer_id'])) {
			$url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
		}

		if (isset($this->request->get['filter_price_from'])) {
			$url .= '&filter_price_from=' . $this->request->get['filter_price_from'];
		}

		if (isset($this->request->get['filter_price_to'])) {
			$url .= '&filter_price_to=' . $this->request->get['filter_price_to'];
		}

		if (isset($this->request->get['filter_quantity_from'])) {
			$url .= '&filter_quantity_from=' . $this->request->get['filter_quantity_from'];
		}

		if (isset($this->request->get['filter_quantity_to'])) {
			$url .= '&filter_quantity_to=' . $this->request->get['filter_quantity_to'];
		}

		// Add new date filters to URL
		if (isset($this->request->get['filter_date_added_from'])) {
			$url .= '&filter_date_added_from=' . $this->request->get['filter_date_added_from'];
		}

		if (isset($this->request->get['filter_date_added_to'])) {
			$url .= '&filter_date_added_to=' . $this->request->get['filter_date_added_to'];
		}

		if (isset($this->request->get['filter_date_modified_from'])) {
			$url .= '&filter_date_modified_from=' . $this->request->get['filter_date_modified_from'];
		}

		if (isset($this->request->get['filter_date_modified_to'])) {
			$url .= '&filter_date_modified_to=' . $this->request->get['filter_date_modified_to'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/advance_product_list/module/advance_product_list', 'user_token=' . $this->session->data['user_token'])
		];

		$data['add'] = $this->url->link('catalog/product.form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['copy'] = $this->url->link('catalog/product.copy', 'user_token=' . $this->session->data['user_token']);
		$data['delete'] = $this->url->link('catalog/product.delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->load->controller('extension/advance_product_list/module/advance_product_list.getList');

		$data['filter_action'] = $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token']);
		$data['filter_name'] = $filter_name;
		$data['filter_product_id'] = $filter_product_id;
		$data['filter_model'] = $filter_model;
		$data['filter_sku'] = $filter_sku;
		$data['filter_category_id'] = $filter_category_id;
		$data['filter_manufacturer_id'] = $filter_manufacturer_id;
		$data['filter_price_from'] = $filter_price_from;
		$data['filter_price_to'] = $filter_price_to;
		$data['filter_quantity_from'] = $filter_quantity_from;
		$data['filter_date_added_from'] = $filter_date_added_from;
		$data['filter_date_added_to'] = $filter_date_added_to;
		$data['filter_date_modified_from'] = $filter_date_modified_from;
		$data['filter_date_modified_to'] = $filter_date_modified_to;
		$data['filter_quantity_to'] = $filter_quantity_to;
		$data['filter_status'] = $filter_status;
		$data['filter_category'] = '';
		$data['filter_manufacturer'] = '';

		// Category
		if (!empty($filter_category_id)) {
			$this->load->model('catalog/category');

			$category_info = $this->model_catalog_category->getCategory($filter_category_id);

			$data['filter_category'] = !empty($category_info['name']) ? (!empty($category_info['path']) ? implode(' > ', [$category_info['path'], $category_info['name']]) : $category_info['name']) : '';
		}


		// Manufacturer
		if (!empty($filter_manufacturer_id)) {
			$this->load->model('catalog/manufacturer');

			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($filter_manufacturer_id);

			$data['filter_manufacturer'] = !empty($manufacturer_info['name']) ? $manufacturer_info['name'] : '';
		}


		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/advance_product_list/module/product', $data));
	}


	public function list(): void
	{
		$this->load->language('extension/advance_product_list/module/product');

		$this->response->setOutput($this->load->controller('extension/advance_product_list/module/advance_product_list.getList'));
	}

	public function getList(): string
	{
		if (isset($this->request->get['filter_reset']) && $this->request->get['filter_reset']) {
			// Return empty product list on reset
			$data['products'] = [];
			$data['pagination'] = '';
			$data['results'] = '';
			$data['sort_name'] = '';
			$data['sort_manufacturer'] = '';
			$data['sort_model'] = '';
			$data['sort_sku'] = '';
			$data['sort_price'] = '';
			$data['sort_quantity'] = '';
			$data['sort_order'] = '';
			$data['sort'] = '';
			$data['order'] = '';
			return $this->load->view('extension/advance_product_list/module/product_list', $data);
		}

		

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_product_id'])) {
			$filter_product_id = $this->request->get['filter_product_id'];
		} else {
			$filter_product_id = '';
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = '';
		}

		if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = '';
		}

		if (isset($this->request->get['filter_manufacturer_id'])) {
			$filter_manufacturer_id = $this->request->get['filter_manufacturer_id'];
		} else {
			$filter_manufacturer_id = '';
		}

		if (isset($this->request->get['filter_price_from'])) {
			$filter_price_from = $this->request->get['filter_price_from'];
		} else {
			$filter_price_from = '';
		}

		if (isset($this->request->get['filter_price_to'])) {
			$filter_price_to = $this->request->get['filter_price_to'];
		} else {
			$filter_price_to = '';
		}

		if (isset($this->request->get['filter_quantity_from'])) {
			$filter_quantity_from = $this->request->get['filter_quantity_from'];
		} else {
			$filter_quantity_from = '';
		}

		if (isset($this->request->get['filter_quantity_to'])) {
			$filter_quantity_to = $this->request->get['filter_quantity_to'];
		} else {
			$filter_quantity_to = '';
		}

		// New date filters
		if (isset($this->request->get['filter_date_added_from'])) {
			$filter_date_added_from = $this->request->get['filter_date_added_from'];
		} else {
			$filter_date_added_from = '';
		}

		if (isset($this->request->get['filter_date_added_to'])) {
			$filter_date_added_to = $this->request->get['filter_date_added_to'];
		} else {
			$filter_date_added_to = '';
		}

		if (isset($this->request->get['filter_date_modified_from'])) {
			$filter_date_modified_from = $this->request->get['filter_date_modified_from'];
		} else {
			$filter_date_modified_from = '';
		}

		if (isset($this->request->get['filter_date_modified_to'])) {
			$filter_date_modified_to = $this->request->get['filter_date_modified_to'];
		} else {
			$filter_date_modified_to = '';
		}

		if (isset($this->request->get['filter_sku'])) {
			$filter_sku = $this->request->get['filter_sku'];
		} else {
			$filter_sku = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = (string)$this->request->get['sort'];
		} else {
			$sort = 'pd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = (string)$this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}

		if (isset($this->request->get['filter_manufacturer_id'])) {
			$url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
		}

		if (isset($this->request->get['filter_price_from'])) {
			$url .= '&filter_price_from=' . $this->request->get['filter_price_from'];
		}

		if (isset($this->request->get['filter_price_to'])) {
			$url .= '&filter_price_to=' . $this->request->get['filter_price_to'];
		}

		if (isset($this->request->get['filter_quantity_from'])) {
			$url .= '&filter_quantity_from=' . $this->request->get['filter_quantity_from'];
		}

		if (isset($this->request->get['filter_quantity_to'])) {
			$url .= '&filter_quantity_to=' . $this->request->get['filter_quantity_to'];
		}



		// Add new date filters to URL
		if (isset($this->request->get['filter_date_added_from'])) {
			$url .= '&filter_date_added_from=' . $this->request->get['filter_date_added_from'];
		}

		if (isset($this->request->get['filter_date_added_to'])) {
			$url .= '&filter_date_added_to=' . $this->request->get['filter_date_added_to'];
		}

		if (isset($this->request->get['filter_date_modified_from'])) {
			$url .= '&filter_date_modified_from=' . $this->request->get['filter_date_modified_from'];
		}

		if (isset($this->request->get['filter_date_modified_to'])) {
			$url .= '&filter_date_modified_to=' . $this->request->get['filter_date_modified_to'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['action'] = $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token'] . $url);

		// Product
		$data['products'] = [];

		$filter_data = [
			'filter_product_id'      => $filter_product_id,
			'filter_name'            => !empty($filter_name) ? '%' . $filter_name . '%' : '',
			'filter_sku'             => !empty($filter_sku) ? '%' . $filter_sku . '%' : '',
			'filter_model'           => !empty($filter_model) ? '%' . $filter_model . '%' : '',
			'filter_category_id'     => !empty($filter_category_id) ? $filter_category_id : '',
			'filter_manufacturer_id' => !empty($filter_manufacturer_id) ? $filter_manufacturer_id : '',
			'filter_price_from'      => $filter_price_from,
			'filter_price_to'        => $filter_price_to,
			'filter_quantity_from'   => $filter_quantity_from,
			'filter_quantity_to'     => $filter_quantity_to,
			'filter_status'          => $filter_status,
			// New date filters
			'filter_date_added_from' => $filter_date_added_from,
			'filter_date_added_to' => $filter_date_added_to,
			'filter_date_modified_from' => $filter_date_modified_from,
			'filter_date_modified_to' => $filter_date_modified_to,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit'                  => $this->config->get('config_pagination_admin')
		];

		$this->load->model('catalog/product');

		// Image
		$this->load->model('tool/image');

		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {
			if ($result['image'] && is_file(DIR_IMAGE . html_entity_decode($result['image'], ENT_QUOTES, 'UTF-8'))) {
				$image = $result['image'];
			} else {
				$image = 'no_image.png';
			}

			$special = '';

			$product_discounts = $this->model_catalog_product->getDiscounts($result['product_id']);

			foreach ($product_discounts as $product_discount) {
				if (($product_discount['date_start'] == '0000-00-00' || strtotime($product_discount['date_start']) < time()) && ($product_discount['date_end'] == '0000-00-00' || strtotime($product_discount['date_end']) > time())) {
					$special = $this->currency->format($product_discount['price'], $this->config->get('config_currency'));

					break;
				}
			}

			// Format dates for display
			$date_added = date($this->language->get('date_format_short'), strtotime($result['date_added']));
			$date_modified = date($this->language->get('date_format_short'), strtotime($result['date_modified']));

			$data['products'][] = [
				'image'   => $this->model_tool_image->resize($image, 40, 40),
				'price'   => $this->currency->format($result['price'], $this->config->get('config_currency')),
				'special' => $special,
				'edit'    => $this->url->link('catalog/product.form', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $result['product_id'] . ($result['master_id'] ? '&master_id=' . $result['master_id'] : '') . $url),
				'variant' => (!$result['master_id'] ? $this->url->link('catalog/product.form', 'user_token=' . $this->session->data['user_token'] . '&master_id=' . $result['product_id'] . $url) : ''),
				'view'    => HTTP_CATALOG . 'index.php?route=product/product&product_id=' . $result['product_id'],
				'date_added_formatted' => $date_added,
				'date_modified_formatted' => $date_modified
			] + $result;
		}

		$url = '';

		

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}

		if (isset($this->request->get['filter_manufacturer_id'])) {
			$url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
		}

		if (isset($this->request->get['filter_price_from'])) {
			$url .= '&filter_price_from=' . $this->request->get['filter_price_from'];
		}

		if (isset($this->request->get['filter_price_to'])) {
			$url .= '&filter_price_to=' . $this->request->get['filter_price_to'];
		}

		if (isset($this->request->get['filter_quantity_from'])) {
			$url .= '&filter_quantity_from=' . $this->request->get['filter_quantity_from'];
		}

		if (isset($this->request->get['filter_quantity_to'])) {
			$url .= '&filter_quantity_to=' . $this->request->get['filter_quantity_to'];
		}

		if (isset($this->request->get['filter_date_added_from'])) {
			$url .= '&filter_date_added_from=' . $this->request->get['filter_date_added_from'];
		}
		if (isset($this->request->get['filter_date_added_to'])) {
			$url .= '&filter_date_added_to=' . $this->request->get['filter_date_added_to'];
		}
		if (isset($this->request->get['filter_date_modified_from'])) {
			$url .= '&filter_date_modified_from=' . $this->request->get['filter_date_modified_from'];
		}
		if (isset($this->request->get['filter_date_modified_to'])) {
			$url .= '&filter_date_modified_to=' . $this->request->get['filter_date_modified_to'];
		}

		if(isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		$data['sort_name'] = $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.name' . $url);
		$data['sort_manufacturer'] = $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token'] . '&sort=m.name' . $url);
		$data['sort_model'] = $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.model' . $url);
		$data['sort_sku'] = $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.sku' . $url);
		$data['sort_price'] = $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.price' . $url);
		$data['sort_quantity'] = $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.quantity' . $url);
		$data['sort_order'] = $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.sort_order' . $url);
		$data['sort_date_added'] = $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.date_added' . $url);
		$data['sort_date_modified'] = $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token'] . '&sort=p.date_modified' . $url);

		$url = '';

		

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}

		if (isset($this->request->get['filter_manufacturer_id'])) {
			$url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
		}

		if (isset($this->request->get['filter_price_from'])) {
			$url .= '&filter_price_from=' . $this->request->get['filter_price_from'];
		}

		if (isset($this->request->get['filter_price_to'])) {
			$url .= '&filter_price_to=' . $this->request->get['filter_price_to'];
		}

		if (isset($this->request->get['filter_quantity_from'])) {
			$url .= '&filter_quantity_from=' . $this->request->get['filter_quantity_from'];
		}

		if (isset($this->request->get['filter_quantity_to'])) {
			$url .= '&filter_quantity_to=' . $this->request->get['filter_quantity_to'];
		}

		if (isset($this->request->get['filter_date_added_from'])) {
			$url .= '&filter_date_added_from=' . $this->request->get['filter_date_added_from'];
		}
		if (isset($this->request->get['filter_date_added_to'])) {
			$url .= '&filter_date_added_to=' . $this->request->get['filter_date_added_to'];
		}
		if (isset($this->request->get['filter_date_modified_from'])) {
			$url .= '&filter_date_modified_from=' . $this->request->get['filter_date_modified_from'];
		}
		if (isset($this->request->get['filter_date_modified_to'])) {
			$url .= '&filter_date_modified_to=' . $this->request->get['filter_date_modified_to'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $product_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/advance_product_list/module/advance_product_list.list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($product_total - $this->config->get('config_pagination_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $product_total, ceil($product_total / $this->config->get('config_pagination_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/advance_product_list/module/product_list', $data);
	}

	public function save(): void
	{
		$this->load->language('extension/advance_product_list/module/advance_product_list');
		$this->load->model('setting/setting');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_setting_setting->editSetting('module_advance_product_list', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect(
				$this->url->link('extension/advance_product_list/module/advance_product_list', 'user_token=' . $this->session->data['user_token'])
			);
		}
	}
}
