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
 * Foundation of all Knectar subqueries, this select class provides utility functions for dealing with EAV.
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

abstract class Knectar_Select_Entity extends Varien_Db_Select
{

    /**
	 * @var Mage_Core_Model_Resource
	 */
	protected $_resource;

	public function __construct($adapter = null)
	{
		$this->_resource = Mage::getSingleton('core/resource');
		if (is_null($adapter)) {
			$adapter = $this->_resource->getConnection('core_read');
		}
		parent::__construct($adapter);
	}

    public function getTable($modelEntity)
	{
		return $this->_resource->getTableName($modelEntity);
	}

	/**
	 * Join entity table for {$entity}.
	 * 
	 * @param string $tableAlias Shorthand name to be referred throughout the query
	 * @param string $entity Entity model name like 'core/store'
	 * @param string $cond SQL expression to match in ON clause
	 * @param string $join One of the predefined 'self::*_JOIN' consts
	 * @return Knectar_Select_Entity $this
	 */
	public function joinEntity($tableAlias, $entity, $cond, $cols=null, $join=self::INNER_JOIN, $schema=null)
	{
		$table = $this->getTable($entity);
		return $this->_join($join, array($tableAlias=>$table), $cond, $cols, $schema);
	}

	/**
	 * Join attribute table for {$entity}/{$attribute}
	 * 
	 * @param string $tableAlias Shorthand name to be referrred throughout the query
	 * @param string $entity Entity code like 'customer'
	 * @param string $attribute Attribute code like 'name'
	 * @param string $key Foreign table.field to match against
	 * @param string $storeKey Literal value or foreign table.field to match against. FALSE means explicitly NOT NULL. NULL means no match and might be unpredictable.
	 * @param string $fieldAlias Shorthand name to be referred throughout the query
	 * @param string $join One of the predefined 'self::*_JOIN' consts
	 * @return Knectar_Select_Entity $this
	 */
	public function joinAttribute($tableAlias, $entity, $attribute, $key, $storeKey=0, $fieldAlias=null, $join=self::INNER_JOIN, $schema=null)
	{
		/* @var $attribute Mage_Eav_Model_Entity_Attribute */
		$attributeType  = Mage::getModel('eav/entity_attribute')->loadByCode($entity, $attribute);
		$attributeTable = $attributeType->getBackendTable();
		$cond = sprintf('(`%1$s`.entity_type_id=%2$d) AND (`%1$s`.entity_id=%3$s) AND (`%1$s`.attribute_id=%4$d)', $tableAlias, $attributeType->getEntityTypeId(), $key, $attributeType->getId());
		if ($storeKey === false) {
			$cond .= sprintf(' AND (`%s`.store_id IS NOT NULL)', $tableAlias);
		}
		elseif (isset($storeKey)) {
			$cond .= sprintf(' AND (`%s`.store_id=%s)', $tableAlias, $storeKey);
		}
		if (isset($fieldAlias)) $fieldAlias = array($fieldAlias=>'value');
		return $this->_join($join, array($tableAlias=>$attributeTable), $cond, $fieldAlias, $schema);
	}

	/**
	 * A factory method that links a new sub-query with a collection's select object.
	 * 
	 * Implementations are expected to look like this:
	 * <code>
	 * $select->_join(
	 *     $type,
	 *     array($tableName => new self()),
	 *     $condition,
	 *     $columns ? $columns : 'default_column'
	 * );
	 * </code>
	 * 
	 * @abstract
	 * @param Varien_Db_Select $select Owning query object, usually retrieved by <code>$collection->getSelect()</code>
	 * @param string $tableName Requested name of sub-query, must not yet exist in {$select}.
	 * @param string $condition On clause of join statement
	 * @param array $columns Names of desired sub-query columns, or associative array to map them to new names, or NULL for all defaults.
	 * @param string $type See {Zend_Db_Select::*_JOIN}
	 */
	public static function enhance(Varien_Db_Select $select, $tableName, $condition, $columns = null, $type = self::LEFT_JOIN)
	{
		// Descendents MUST override this method
		die;
	}

}

