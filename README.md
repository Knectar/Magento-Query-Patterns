Magento Query Patterns is a library of sub-query classes for everyday use in Magento queries.

##Installation

[Download the latest edition](https://github.com/Knectar/Magento-Query-Patterns/downloads)
and extract it to Magento's base folder.
The folder `/lib/Knectar` will be created.
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

Some classes provide more specific convenience functions, see
[the wiki](https://github.com/Knectar/Magento-Query-Patterns/wiki) for references.

##Distribution

This library is shared under the MIT license, meaning you are free to use it
for any purpose and free to include it in your extensions. Because other
extension authors might like to use the same library please do not modify any
source files directly, instead fork this project and submit your modifications
that way. Alternatively, to avoid confusion, extend the classes with your own in
a namespace other than `Knectar_`.
