<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

use Magento\Catalog\Api\Data\ProductTierPriceExtensionFactory;

\Magento\TestFramework\Helper\Bootstrap::getInstance()->reinitialize();

/** @var \Magento\TestFramework\ObjectManager $objectManager */
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

/** @var \Magento\Catalog\Api\CategoryLinkManagementInterface $categoryLinkManagement */
$categoryLinkManagement = $objectManager->create(\Magento\Catalog\Api\CategoryLinkManagementInterface::class);

$tierPrices = [];
/** @var \Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory $tierPriceFactory */
$tierPriceFactory = $objectManager->get(\Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory::class);
$tierPrices[] = $tierPriceFactory->create(
    [
        'data' => [
            'customer_group_id' => \Magento\Customer\Model\Group::CUST_GROUP_ALL,
            'qty' => 2,
            'value' => 8
        ]
    ]
);
$tierPrices[] = $tierPriceFactory->create(
    [
        'data' => [
            'customer_group_id' => \Magento\Customer\Model\Group::CUST_GROUP_ALL,
            'qty' => 5,
            'value' => 5
        ]
    ]
);
$tierPrices[] = $tierPriceFactory->create(
    [
        'data' => [
            'customer_group_id' => \Magento\Customer\Model\Group::NOT_LOGGED_IN_ID,
            'qty' => 3,
            'value' => 5
        ]
    ]
);
/** @var  $tpExtensionAttributes */
$tpExtensionAttributesFactory = $objectManager->create(ProductTierPriceExtensionFactory::class);
$tpExtensionAttributes = $tpExtensionAttributesFactory->create()->setPercentageValue(50);

$tierPrices[] = $tierPriceFactory->create(
    [
        'data' => [
            'customer_group_id' => \Magento\Customer\Model\Group::NOT_LOGGED_IN_ID,
            'qty' => 10
        ]
    ]
)->setExtensionAttributes($tpExtensionAttributes);

$tierPrices = [];
/** @var \Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory $tierPriceFactory */
$tierPriceFactory = $objectManager->get(\Magento\Catalog\Api\Data\ProductTierPriceInterfaceFactory::class);
$tierPrices[] = $tierPriceFactory->create(
    [
        'data' => [
            'customer_group_id' => \Magento\Customer\Model\Group::CUST_GROUP_ALL,
            'qty' => 2,
            'value' => 8
        ]
    ]
);
$tierPrices[] = $tierPriceFactory->create(
    [
        'data' => [
            'customer_group_id' => \Magento\Customer\Model\Group::CUST_GROUP_ALL,
            'qty' => 5,
            'value' => 5
        ]
    ]
);
$tierPrices[] = $tierPriceFactory->create(
    [
        'data' => [
            'customer_group_id' => \Magento\Customer\Model\Group::NOT_LOGGED_IN_ID,
            'qty' => 3,
            'value' => 5
        ]
    ]
);
/** @var  $tpExtensionAttributes */
$tpExtensionAttributesFactory = $objectManager->create(ProductTierPriceExtensionFactory::class);
$tpExtensionAttributes = $tpExtensionAttributesFactory->create()->setPercentageValue(50);

$tierPrices[] = $tierPriceFactory->create(
    [
        'data' => [
            'customer_group_id' => \Magento\Customer\Model\Group::NOT_LOGGED_IN_ID,
            'qty' => 10
        ]
    ]
)->setExtensionAttributes($tpExtensionAttributes);

/** @var $product \Magento\Catalog\Model\Product */
$product = $objectManager->create(\Magento\Catalog\Model\Product::class);
$product->isObjectNew(true);
$product->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE)
    ->setId(1)
    ->setAttributeSetId(4)
    ->setWebsiteIds([1])
    ->setName('Simple Product')
    ->setSku('simple')
    ->setPrice(10)
    ->setWeight(1)
    ->setShortDescription("Short description")
    ->setTaxClassId(0)
    ->setTierPrices($tierPrices)
    ->setDescription('Description with <b>html tag</b>')
    ->setMetaTitle('meta title')
    ->setMetaKeyword('meta keyword')
    ->setMetaDescription('meta description')
    ->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
    ->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
    ->setStockData(
        [
            'use_config_manage_stock'   => 1,
            'qty'                       => 100,
            'is_qty_decimal'            => 0,
            'is_in_stock'               => 1,
        ]
    )->setCanSaveCustomOptions(true)
    ->setHasOptions(true);

$oldOptions = [
    [
        'previous_group' => 'text',
        'title'     => 'Test Field',
        'type'      => 'field',
        'is_require' => 1,
        'sort_order' => 0,
        'price'     => 1,
        'price_type' => 'fixed',
        'sku'       => '1-text',
        'max_characters' => 100,
    ],
    [
        'previous_group' => 'date',
        'title'     => 'Test Date and Time',
        'type'      => 'date_time',
        'is_require' => 1,
        'sort_order' => 0,
        'price'     => 2,
        'price_type' => 'fixed',
        'sku'       => '2-date',
    ],
    [
        'previous_group' => 'select',
        'title'     => 'Test Select',
        'type'      => 'drop_down',
        'is_require' => 1,
        'sort_order' => 0,
        'values'    => [
            [
                'option_type_id' => -1,
                'title'         => 'Option 1',
                'price'         => 3,
                'price_type'    => 'fixed',
                'sku'           => '3-1-select',
            ],
            [
                'option_type_id' => -1,
                'title'         => 'Option 2',
                'price'         => 3,
                'price_type'    => 'fixed',
                'sku'           => '3-2-select',
            ],
        ]
    ],
    [
        'previous_group' => 'select',
        'title'     => 'Test Radio',
        'type'      => 'radio',
        'is_require' => 1,
        'sort_order' => 0,
        'values'    => [
            [
                'option_type_id' => -1,
                'title'         => 'Option 1',
                'price'         => 3,
                'price_type'    => 'fixed',
                'sku'           => '4-1-radio',
            ],
            [
                'option_type_id' => -1,
                'title'         => 'Option 2',
                'price'         => 3,
                'price_type'    => 'fixed',
                'sku'           => '4-2-radio',
            ],
        ]
    ]
];

$options = [];

/** @var \Magento\Catalog\Api\Data\ProductCustomOptionInterfaceFactory $customOptionFactory */
$customOptionFactory = $objectManager->create(\Magento\Catalog\Api\Data\ProductCustomOptionInterfaceFactory::class);

foreach ($oldOptions as $option) {
    /** @var \Magento\Catalog\Api\Data\ProductCustomOptionInterface $option */
    $option = $customOptionFactory->create(['data' => $option]);
    $option->setProductSku($product->getSku());

    $options[] = $option;
}

$product->setOptions($options);

/** @var \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryFactory */
$productRepositoryFactory = $objectManager->create(\Magento\Catalog\Api\ProductRepositoryInterface::class);
$productRepositoryFactory->save($product);

$categoryLinkManagement->assignProductToCategories(
    $product->getSku(),
    [2]
);
