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
- `$type` (Optional) One of the `Zend_Db_Select::*_JOIN` constants, the default is `LEFT_JOIN`.

##API

You might find the following classes useful. Each exports several columns such as "product_id" and "product_tags".

###Product Related Queries

- **Knectar_Select_Product_Multivalues**  
- - product_id  
- - attribute_code  
- - value  
*Best used on a collection like `Knectar_Select_Product_Multivalues::enhanceProducts($collection, 'color');`*

- **Knectar_Select_Product_Rating**  
- - product_id  
- - rating_summary *Individual percent value*  

- **Knectar_Select_Product_Tags**  
- - product_id *Product's entity ID.*  
- - product_tags *Comma-delimited tag names.*  

- **Knectar_Select_Product_Values**  
- - product_id  
- - attribute_code  
- - value  
*Best used on a collection like `Knectar_Select_Product_Values::enhanceProducts($collection, 'color');`*

###Store Specific Queries 

- **Knectar_Select_Store_Category**  
  Handy for finding stores that categories belong to.  
- - store_id *Store's entity ID, not store code.*  
- - category_id  
- - parent_id *ID of one category that owns category_id. If there are several parents only first is exported. NULL if no parent.*  

- **Knectar_Select_Store_Category_Name**  
  Same as Knectar_Select_Store_Category but also exports a name.  
- - store_id  
- - category_id  
- - parent_id  
- - category_name  

- **Knectar_Select_Store_Category_Duoname**  
  Same as Knectar_Select_Store_Category_Name but exports the parent's name too.  
- - store_id  
- - category_id  
- - parent_id  
- - category_name  
- - parent_category_name  

- **Knectar_Select_Store_Category_Trioname**  
  Same as Knectar_Select_Store_Category_Duoname but exports grand-parent's ID and name.  
- - store_id  
- - category_id  
- - parent_id  
- - grandparent_id  
- - category_name  
- - parent_category_name  
- - grandparent_category_name  

- **Knectar_Select_Store_Category_Product**  
  Lists all products per store. Similar to Knectar_Select_Store_Category but not all categories are certain to be included.  
- - store_id  
- - category_id  
- - parent_id  
- - product_id  

- **Knectar_Select_Store_Category_Product_Name**  
  Like Knectar_Select_Store_Category_Product with names exported.  
- - store_id  
- - category_id  
- - parent_id  
- - product_id  
- - product_name  
- - category_name  

- **Knectar_Select_Store_Category_Product_Duoname**  
  Same as Knectar_Select_Store_Category_Product_Name but exports parent category's name too.  
- - store_id  
- - category_id  
- - parent_id  
- - product_id  
- - product_name  
- - category_name  
- - parent_category_name  

- **Knectar_Select_Store_Category_Product_Trioname**  
  Same as Knectar_Select_Store_Category_Product_Duoname but exports grand-parent category's ID and name.  
- - store_id  
- - category_id  
- - parent_id  
- - grandparent_id  
- - product_id  
- - product_name  
- - category_name  
- - parent_category_name  
- - grandparent_category_name  
