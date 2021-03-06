<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Config\Model;

use Magento\Config\Model\Config\Structure;
use Magento\Config\Model\Config\StructureFactory;
use Magento\Framework\App\Config\ValueInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\App\Config\ValueFactory;
use Magento\Framework\App\ScopeInterface;
use Magento\Framework\App\ScopeResolverPool;
use Magento\Framework\Exception\RuntimeException;

/**
 * Creates a prepared instance of Value.
 *
 * @see ValueInterface
 */
class PreparedValueFactory
{
    /**
     * The scope resolver pool.
     *
     * @var ScopeResolverPool
     */
    private $scopeResolverPool;

    /**
     * The manager for system configuration structure.
     *
     * @var StructureFactory
     */
    private $structureFactory;

    /**
     * The factory for configuration value objects.
     *
     * @see ValueInterface
     * @var ValueFactory
     */
    private $valueFactory;

    /**
     * @param ScopeResolverPool $scopeResolverPool The scope resolver pool
     * @param StructureFactory $structureFactory The manager for system configuration structure
     * @param ValueFactory $valueFactory The factory for configuration value objects
     */
    public function __construct(
        ScopeResolverPool $scopeResolverPool,
        StructureFactory $structureFactory,
        ValueFactory $valueFactory
    ) {
        $this->scopeResolverPool = $scopeResolverPool;
        $this->structureFactory = $structureFactory;
        $this->valueFactory = $valueFactory;
    }

    /**
     * Returns instance of Value with defined properties.
     *
     * @param string $path The configuration path in format group/section/field_name
     * @param string $value The configuration value
     * @param string $scope The configuration scope (default, website, or store)
     * @param string|int|null $scopeCode The scope code
     * @return ValueInterface
     * @throws RuntimeException If Value can not be created
     * @see ValueInterface
     * @see Value
     */
    public function create($path, $value, $scope, $scopeCode = null)
    {
        try {
            /** @var Structure $structure */
            $structure = $this->structureFactory->create();
            /** @var Structure\ElementInterface $field */
            $field = $structure->getElement($path);
            /** @var ValueInterface $backendModel */
            $backendModel = $field instanceof Structure\Element\Field && $field->hasBackendModel()
                ? $field->getBackendModel()
                : $this->valueFactory->create();

            if ($backendModel instanceof Value) {
                $scopeId = 0;

                if ($scope !== ScopeInterface::SCOPE_DEFAULT) {
                    $scopeResolver = $this->scopeResolverPool->get($scope);
                    $scopeId = $scopeResolver->getScope($scopeCode)->getId();
                }

                $backendModel->setPath($path);
                $backendModel->setScope($scope);
                $backendModel->setScopeId($scopeId);
                $backendModel->setValue($value);
            }

            return $backendModel;
        } catch (\Exception $exception) {
            throw new RuntimeException(__('%1', $exception->getMessage()), $exception);
        }
    }
}
