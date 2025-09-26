<?php
namespace Opencart\Admin\Model\Extension\AdvanceProductList\Module;
/**
 * Class AdvanceProductList
 *
 * Can be called from $this->load->model('extension/AdvanceProductList/module/AdvanceProductList');
 *
 * @package Opencart\Admin\Model\Extension\AdvanceProductList\Module
 */
class AdvanceProductList extends \Opencart\System\Engine\Model
{
	public function getDiscounts(int $product_id): array
	{
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_discount` WHERE `product_id` = '" . (int)$product_id . "' ORDER BY `quantity`, `priority`, `price`");

		return $query->rows;
	}

	public function getProducts(array $data = []): array
	{

		$sql = "SELECT p.*, pd.name, m.name AS manufacturer_name 
            FROM `" . DB_PREFIX . "product` p 
            LEFT JOIN `" . DB_PREFIX . "product_description` pd ON (p.product_id = pd.product_id)
            LEFT JOIN `" . DB_PREFIX . "manufacturer` m ON (p.manufacturer_id = m.manufacturer_id)";

		if (!empty($data['filter_model'])) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_code` `pc` ON (`p`.`product_id` = `pc`.`product_id`)";
		}

		$sql .= " WHERE `pd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_master_id'])) {
			$sql .= " AND `p`.`master_id` = '" . (int)$data['filter_master_id'] . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(`pd`.`name`) LIKE '" . $this->db->escape(oc_strtolower($data['filter_name']) . '%') . "'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND (LCASE(`p`.`model`) LIKE '" . $this->db->escape(oc_strtolower($data['filter_model']) . '%') . "' OR LCASE(`pc`.`value`) LIKE '" . $this->db->escape(oc_strtolower($data['filter_model']) . '%') . "')";
		}

		if (isset($data['filter_category_id']) && $data['filter_category_id'] !== '') {
			$sql .= " AND `p`.`product_id` IN (SELECT `p2c`.`product_id` FROM `" . DB_PREFIX . "product_to_category` `p2c` WHERE `p2c`.`category_id` = '" . (int)$data['filter_category_id'] . "')";
		}

		if (isset($data['filter_manufacturer_id']) && $data['filter_manufacturer_id'] !== '') {
			$sql .= " AND `p`.`manufacturer_id` = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		if (isset($data['filter_product_id']) && $data['filter_product_id'] !== '') {
			$sql .= " AND `p`.`product_id` = '" . (int)$data['filter_product_id'] . "'";
		}

		if (isset($data['filter_sku']) && $data['filter_sku'] !== '') {
			$sql .= " AND LCASE(`p`.`sku`) LIKE '" . $this->db->escape(oc_strtolower($data['filter_sku']) . '%') . "'";
		}

		if (isset($data['filter_date_added_from']) && $data['filter_date_added_from'] !== '') {
			$sql .= " AND DATE(`p`.`date_added`) >= '" . $this->db->escape($data['filter_date_added_from']) . "'";
		}

		if (isset($data['filter_date_added_to']) && $data['filter_date_added_to'] !== '') {
			$sql .= " AND DATE(`p`.`date_added`) <= '" . $this->db->escape($data['filter_date_added_to']) . "'";
		}

		if (isset($data['filter_date_modified_from']) && $data['filter_date_modified_from'] !== '') {
			$sql .= " AND DATE(`p`.`date_modified`) >= '" . $this->db->escape($data['filter_date_modified_from']) . "'";
		}

		if (isset($data['filter_date_modified_to']) && $data['filter_date_modified_to'] !== '') {
			$sql .= " AND DATE(`p`.`date_modified`) <= '" . $this->db->escape($data['filter_date_modified_to']) . "'";
		}




		if (isset($data['filter_price_from']) && $data['filter_price_from'] !== '') {
			$sql .= " AND `p`.`price` >= '" . (float)$data['filter_price_from'] . "'";
		}

		if (isset($data['filter_price_to']) && $data['filter_price_to'] !== '') {
			$sql .= " AND `p`.`price` <= '" . (float)$data['filter_price_to'] . "'";
		}

		if (isset($data['filter_quantity_from']) && $data['filter_quantity_from'] !== '') {
			$sql .= " AND `p`.`quantity` >= '" . (int)$data['filter_quantity_from'] . "'";
		}

		if (isset($data['filter_quantity_to']) && $data['filter_quantity_to'] !== '') {
			$sql .= " AND `p`.`quantity` <= '" . (int)$data['filter_quantity_to'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND `p`.`status` = '" . (int)$data['filter_status'] . "'";
		}

		$sql .= " GROUP BY `p`.`product_id`";

		$sort_data = [
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'm.name',
			'p.sort_order',
			'p.sku',
			'p.date_added',
			'p.date_modified'
		];

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY `pd`.`name`";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = [];

		$query = $this->db->query($sql);

		foreach ($query->rows as $key => $result) {
			$product_data[$key] = $result;

			$product_data[$key]['variant'] = $result['variant'] ? json_decode($result['variant'], true) : [];
			$product_data[$key]['override'] = $result['override'] ? json_decode($result['override'], true) : [];
		}

		return $product_data;
	}

	public function getTotalProducts(array $data = []): int
	{
		$sql = "SELECT COUNT(DISTINCT `p`.`product_id`) AS `total` FROM `" . DB_PREFIX . "product` `p` LEFT JOIN `" . DB_PREFIX . "product_description` `pd` ON (`p`.`product_id` = `pd`.`product_id`)";

		if (!empty($data['filter_model'])) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "product_code` `pc` ON (`p`.`product_id` = `pc`.`product_id`)";
		}

		$sql .= " WHERE `pd`.`language_id` = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_master_id'])) {
			$sql .= " AND `p`.`master_id` = '" . (int)$data['filter_master_id'] . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(`pd`.`name`) LIKE '" . $this->db->escape(oc_strtolower($data['filter_name']) . '%') . "'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND (LCASE(`p`.`model`) LIKE '" . $this->db->escape(oc_strtolower($data['filter_model']) . '%') . "' OR LCASE(`pc`.`value`) LIKE '" . $this->db->escape(oc_strtolower($data['filter_model']) . '%') . "')";
		}

		if (isset($data['filter_category_id']) && $data['filter_category_id'] !== '') {
			$sql .= " AND `p`.`product_id` IN (SELECT `p2c`.`product_id` FROM `" . DB_PREFIX . "product_to_category` `p2c` WHERE `p2c`.`category_id` = '" . (int)$data['filter_category_id'] . "')";
		}

		if (isset($data['filter_product_id']) && $data['filter_product_id'] !== '') {
			$sql .= " AND `p`.`product_id` = '" . (int)$data['filter_product_id'] . "'";
		}

		if (isset($data['filter_sku']) && $data['filter_sku'] !== '') {
			$sql .= " AND LCASE(`p`.`sku`) LIKE '" . $this->db->escape(oc_strtolower($data['filter_sku']) . '%') . "'";
		}

		if (isset($data['filter_date_added_from']) && $data['filter_date_added_from'] !== '') {
			$sql .= " AND DATE(`p`.`date_added`) >= '" . $this->db->escape($data['filter_date_added_from']) . "'";
		}

		if (isset($data['filter_date_added_to']) && $data['filter_date_added_to'] !== '') {
			$sql .= " AND DATE(`p`.`date_added`) <= '" . $this->db->escape($data['filter_date_added_to']) . "'";
		}

		if (isset($data['filter_date_modified_from']) && $data['filter_date_modified_from'] !== '') {
			$sql .= " AND DATE(`p`.`date_modified`) >= '" . $this->db->escape($data['filter_date_modified_from']) . "'";
		}

		if (isset($data['filter_date_modified_to']) && $data['filter_date_modified_to'] !== '') {
			$sql .= " AND DATE(`p`.`date_modified`) <= '" . $this->db->escape($data['filter_date_modified_to']) . "'";
		}

		if (isset($data['filter_manufacturer_id']) && $data['filter_manufacturer_id'] !== '') {
			$sql .= " AND `p`.`manufacturer_id` = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		if (isset($data['filter_price_from']) && $data['filter_price_from'] !== '') {
			$sql .= " AND `p`.`price` >= '" . (float)$data['filter_price_from'] . "'";
		}

		if (isset($data['filter_price_to']) && $data['filter_price_to'] !== '') {
			$sql .= " AND `p`.`price` <= '" . (float)$data['filter_price_to'] . "'";
		}

		if (isset($data['filter_quantity_from']) && $data['filter_quantity_from'] !== '') {
			$sql .= " AND `p`.`quantity` >= '" . (int)$data['filter_quantity_from'] . "'";
		}

		if (isset($data['filter_quantity_to']) && $data['filter_quantity_to'] !== '') {
			$sql .= " AND `p`.`quantity` <= '" . (int)$data['filter_quantity_to'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$sql .= " AND `p`.`status` = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return (int)$query->row['total'];
	}
	public function inlineEdit(int $product_id, string $field, $value, $special = ''): bool {
	$allowed = ['name', 'sku', 'model', 'price', 'quantity', 'manufacturer_id', 'image', 'date'];
		if (!in_array($field, $allowed)) return false;

    if ($field === 'name') {
        $this->db->query("UPDATE `" . DB_PREFIX . "product_description` 
            SET `name` = '" . $this->db->escape($value) . "'  WHERE `product_id` = '" . (int)$product_id . "'");
    } elseif ($field === 'image') {
        $this->db->query("UPDATE `" . DB_PREFIX . "product` 
            SET `image` = '" . $this->db->escape($value) . "' 
            WHERE `product_id` = '" . (int)$product_id . "'");
    } elseif ($field === 'manufacturer_id') {
        $this->db->query("UPDATE `" . DB_PREFIX . "product` 
            SET `manufacturer_id` = '" . (int)$value . "'  WHERE `product_id` = '" . (int)$product_id . "'");
    } elseif ($field === 'price') {
        $price = (float)$value;
        $this->db->query("UPDATE `" . DB_PREFIX . "product` 
             SET `price` = '" . $price . "'   WHERE `product_id` = '" . (int)$product_id . "'");

        $this->db->query("DELETE FROM `" . DB_PREFIX . "product_discount` 
                WHERE `product_id` = '" . (int)$product_id . "'");

        if ($special !== '' && is_numeric($special) && (float)$special > 0) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "product_discount`
            SET `product_id` = '" . (int)$product_id . "',
                `customer_group_id` = 1,
                `quantity` = 1,
                `priority` = 1,
                `price` = '" . (float)$special . "',
                `type` = 'fixed',
                `date_start` = '0000-00-00',
                `date_end` = '0000-00-00'");
        }
    } elseif ($field === 'date') {
        if (!is_array($value) || !isset($value['date_added']) || !isset($value['date_modified'])) return false;
        $date_added = $this->db->escape($value['date_added']);
        $date_modified = $this->db->escape($value['date_modified']);
        $this->db->query("UPDATE `" . DB_PREFIX . "product` SET `date_added` = '" . $date_added . "', `date_modified` = '" . $date_modified . "' WHERE `product_id` = '" . (int)$product_id . "'");
    } else {
        $this->db->query("UPDATE `" . DB_PREFIX . "product`
           SET `" . $this->db->escape($field) . "` = '" . $this->db->escape($value) . "'  WHERE `product_id` = '" . (int)$product_id . "'");
    }
        return true;
  }

}
