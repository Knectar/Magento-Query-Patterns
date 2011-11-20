<?php

/**
 * Resolves "Multiple Select" attributes to their text equivalents.
 * 
 * Only suitable for attributes with a backend_model of 
 * "eav/entity_attribute_backend_array"
 * 
 * Exports the following fields:
 * <ul>
 * <li>product_id</li>
 * <li>attribute_code</li>
 * <li>value</li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Product_Multivalues extends Knectar_Select_Entity
{

	public function __construct()
	{
		parent::__construct();

		$this->from(
			array('products' => $this->getTable('catalog/product').'_varchar'),
			array('product_id' => 'entity_id')
		);
		$this->join(
			array('attrs' => $this->getTable('eav/attribute')),
			'products.attribute_id=attrs.attribute_id',
			array('attribute_code')
		);
		$this->join(
			array('options' => $this->getTable('eav/attribute_option')),
			'(products.attribute_id=options.attribute_id) AND FIND_IN_SET(options.option_id, products.value)',
			array()
		);
		$this->join(
			array('values' => $this->getTable('eav/attribute_option_value')),
			'options.option_id=values.option_id',
			array('value' => 'GROUP_CONCAT(DISTINCT values.value ORDER BY options.sort_order)')
		);
		$this->group('product_id')
			->group('products.attribute_id');
	}

	/**
	 * Adds the column 'value' to {$select}
	 * 
	 * @deprecated Use {enhanceProducts} instead
	 *
	 * @param Varien_Db_Select $select
	 * @param string $tableName
	 * @param string $condition
	 * @param array $columns
	 * @param string $type
	 */
	public static function enhance(Varien_Db_Select $select, $tableName, $condition, $columns = null, $type = self::LEFT_JOIN)
	{
		$select->_join(
			$type,
			array($tableName => new self()),
			$condition,
			$columns ? $columns : 'value'
		);
	}

	/**
	 * Resolves an attribute value to it's string equivalent.
	 * 
	 * Specific to product collections only:
	 * <code>
	 * Knectar_Select_Product_Multivalues::enhanceProducts($collection, 'color');
	 * </code>
	 * 
	 * Individual products already have an equivalent function {getAttributeText()}:
	 * <code>
	 * $product->getAttributeText('size');
	 * </code>
	 * 
	 * @param Mage_Catalog_Model_Resource_Product_Collection $collection
	 * @param string $attribute A product attribute code like "color" or "size"
	 * @param unknown_type $field (Optional) Defaults to "{$attribute}_text"
	 * @param unknown_type $type (Optional) Defaults to "LEFT JOIN"
	 */
	public static function enhanceProducts(Mage_Catalog_Model_Resource_Product_Collection $collection, $attribute, $field = null, $type = self::LEFT_JOIN)
	{
		if (is_null($field)) {
			$field = $attribute . '_text';
		}
		$table = "{$attribute}_values";
		self::enhance(
			$collection->getSelect(),
			$table,
			"({$table}.attribute_code='{$attribute}') AND ({$table}.product_id=e.entity_id)",
			array($field=>'value'),
			$type
		);
	}

}

