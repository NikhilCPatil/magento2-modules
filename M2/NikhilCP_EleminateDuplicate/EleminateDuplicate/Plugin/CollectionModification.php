<?php 

namespace NikhilCP\EleminateDuplicate\Plugin;

use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;

class CollectionModification 
{
    /**
     * aroundAddFieldToFilter method
     *
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $collection
     * @param \Closure                                                $proceed
     * @param                                                         $fields
     * @param null                                                    $condition
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function aroundAddFieldToFilter(ProductCollection $collection, \Closure $proceed, $fields, $condition = null)
    {
        // Here you can modify the collection
        $collection->setOrder('entity_id', 'DESC');

        return $fields ? $proceed($fields, $condition) : $collection;
    }
}