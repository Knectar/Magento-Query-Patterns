<?php
/*
 * Copyright (C) 2011 by Knectar Design
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Resolves "Drop down" attributes to their text equivalents.
 * 
 * Only suitable for attributes with a source_model of NULL or
 * "eav/entity_attribute_source_table".
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

class Knectar_Select_Product_Values extends Knectar_Select_Entity
{

	public function __construct()
	{
		parent::__construct();

		$this->from(
			array('products' => $this->getTable('catalog/product').'_int'),
			array('product_id' => 'entity_id')
		);
		$this->join(
			array('attrs' => $this->getTable('eav/attribute')),
			'products.attribute_id=attrs.attribute_id',
			array('attribute_code')
		);
		$this->join(
			array('options' => $this->getTable('eav/attribute_option')),
			'(products.attribute_id=options.attribute_id) AND (products.value=options.option_id)',
			array() // no columns exported from this table
		);
		$this->join(
			array('values' => $this->getTable('eav/attribute_option_value')),
			'options.option_id=values.option_id',
			array('value')
		);
		$this->group('product_id')
			->group('products.attribute_id')
			->order('options.sort_order');
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
	 * Knectar_Select_Product_Values::enhanceProducts($collection, 'color');
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

