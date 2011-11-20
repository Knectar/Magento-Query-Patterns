Magento Query Patterns is a library of sub-query classes for everyday use in Magento queries.

##Installation

Copy `Knectar` to the `lib/` folder of your Magento folder. 
Be careful to preserve the folder arrangement so that Magento's autoloader can work accurately.

##Usage

Query patterns are sub-queries and can be used anywhere Zend select objects can.
For convenience, the static method `enhance` is best.

```php
// this example adds a `product_tags` column
$collection = Mage::getResourceModel('catalog/product_collection');
Knectar_Select_Product_Tags::enhance($collection->getSelect(), 'tags', 'tags.product_id=e.entity_id');

foreach ($collection as $product) {
    echo $product->getProductTags(), "\n";
}
```

The parameters of `enhance` are:

- `$select` Must be an instance of `Varien_Db_Select`.
- `$tableName` The sub-query will be joined as this table. Must be unique for `$select`.
- `$condition` The ON clause for a JOIN statement, it will use the table name.
- `$columns` (Optional) Associative array of column names to add to the field list.
- `$type` (Optional) One of the [`Zend_Db_Select::*_JOIN`](http://framework.zend.com/manual/en/zend.db.select.html#zend.db.select.building.join) constants, the default is `LEFT_JOIN`.

Some classes provide more specific convenience functions, see [the wiki](https://github.com/Knectar/Magento-Query-Patterns/wiki) for references.
