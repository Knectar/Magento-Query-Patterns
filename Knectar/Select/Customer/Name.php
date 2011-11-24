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
 * Queries all customers and their name parts and full names.
 * 
 * Exports the following fields:
 * <ul>
 * <li>customer_id</li>
 * <li>prefix</li>
 * <li>firstname</li>
 * <li>middlename</li>
 * <li>lastname</li>
 * <li>suffix</li>
 * <li>name</li>
 * </ul>
 * 
 * @author daniel@clockworkgeek.com
 * @copyright Copyright (c), 2011 Knectar Design
 */

class Knectar_Select_Customer_Name extends Knectar_Select_Customer
{

	public function __construct()
	{
		parent::__construct();

		$this->joinAttribute('pfix', 'customer', 'prefix', 'cust.entity_id', null, 'prefix', self::LEFT_JOIN);
		$this->joinAttribute('fname', 'customer', 'firstname', 'cust.entity_id', null, 'firstname');
		$this->joinAttribute('mname', 'customer', 'middlename', 'cust.entity_id', null, 'middlename', self::LEFT_JOIN);
		$this->joinAttribute('lname', 'customer', 'lastname', 'cust.entity_id', null, 'lastname');
		$this->joinAttribute('sfix', 'customer', 'suffix', 'cust.entity_id', null, 'suffix', self::LEFT_JOIN);

		$config = Mage::getSingleton('eav/config');
		$name = 'CONCAT_WS(" "';
		if ($config->getAttribute('customer', 'prefix')->getIsVisible()) {
			$name . ',NULLIF(TRIM(pfix.value), "")';
		}
		$name .= ',fname.value';
		if ($config->getAttribute('customer', 'middlename')->getIsVisible()) {
			$name . ',NULLIF(TRIM(mname.value), "")';
		}
		$name .= ',lname.value';
		if ($config->getAttribute('customer', 'suffix')->getIsVisible()) {
			$name . ',NULLIF(TRIM(sfix.value), "")';
		}
		$name .= ')';
		$this->columns(array('name' => $name));
	}

	/**
	 * Adds the columns 'prefix', 'firstname', 'middlename', 'lastname', 'suffix' and 'name' to {$select}
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
			$columns ? $columns : array('prefix', 'firstname', 'middlename', 'lastname', 'suffix', 'name')
		);
	}

}

