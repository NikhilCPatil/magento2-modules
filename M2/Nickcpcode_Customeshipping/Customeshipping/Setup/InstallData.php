<?php
/**
 * Created by PhpStorm.
 * User: nikhilp
 * Date: 11/6/18
 * Time: 11:41 PM
 */

namespace Nickcpcode\Customeshipping\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Backend\Price;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            Product::ENTITY,
            'custom_flat_rate',
            [
                'backend' => Price::class,
                'frontend' => '',
                'label' => 'Flatrate Shipping Price',
                'type' => 'decimal',
                'input' => 'price',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => false,
                'unique' => false,
                'apply_to' => Product\Type::TYPE_SIMPLE
            ]
        );

        $entityTypeId = $eavSetup->getEntityTypeId(Product::ENTITY);
        $attributeSetId = $eavSetup->getAttributeSetId($entityTypeId, 'Default');

        $attribute = $eavSetup->getAttribute($entityTypeId, 'custom_flat_rate');
        if ($attribute) {
            $eavSetup->addAttributeToGroup(
                $entityTypeId,
                $attributeSetId,
                'Product Details',
                $attribute['attribute_id'],
                35
            );
        }
    }
}
