Knectar_Select is a library of sub-query classes for everyday use in Magento queries.

##Installation

Copy these files to the `lib/` folder of your Magento folder. 
Be careful to preserve the folder arrangement so that Magento's autoloader can find them accurately.

##Usage

For a collection simply join a select instance to the existing select using 
the usual `join*` functions.

    $collection = Mage::getResourceModel('catalog/product_collection');
    $collection->getSelect()->joinLeft(
        array('tags' => new Knectar_Select_Product_Tags()),
        'tags.product_id=e.entity_id',
        array('product_tags')
    );

In this example the subquery is placed in an array so a table alias (`tags`) can be specified.
The table alias and exported column (`tags.product_id`) is used in a join clause with the known entity table and primary key (`e.entity_id`).
The remaining exported columns (`product_tags`) are listed and will be in the final resultset.
