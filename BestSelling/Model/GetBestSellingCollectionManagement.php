<?php
/**
 * Copyright © Nadeem Khan All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Nadeem\BestSelling\Model;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestSellersCollectionFactory;

/**
 * Class GetBestSellingCollectionManagement
 * @package Nadeem\BestSelling\Model
 */
class GetBestSellingCollectionManagement implements \Nadeem\BestSelling\Api\GetBestSellingCollectionManagementInterface
{

    /**
     * @var CollectionFactory
     */
    protected $_productCollectionFactory;

    /**
     * @var BestSellersCollectionFactory
     */
    protected $_bestSellersCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * BestSellerProducts constructor.
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param Visibility $catalogProductVisibility
     * @param DateTime $dateTime
     * @param Data $helperData
     * @param HttpContext $httpContext
     * @param StoreManagerInterface $storeManager
     * @param BestSellersCollectionFactory $bestSellersCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Visibility $catalogProductVisibility,
        DateTime $dateTime,
        HttpContext $httpContext,
        StoreManagerInterface $storeManager,
        BestSellersCollectionFactory $bestSellersCollectionFactory,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_storeManager = $storeManager;
        $this->_bestSellersCollectionFactory = $bestSellersCollectionFactory;
    }

    /**
     * get collection of best-seller products
     * @return mixed
     */
    public function getGetBestSellingCollection()
    {
        $productIds = [];
        $bestSellers = $this->_bestSellersCollectionFactory->create()
            ->setPeriod('month');
        foreach ($bestSellers as $product) {
            $productIds[] = $product->getProductId();
        }
        $collection = $this->_productCollectionFactory->create()->addIdFilter($productIds);
        $collection->addMinimalPrice()
        ->addFinalPrice()
        ->addTaxPercents()
        ->addAttributeToSelect('*')
        ->addStoreFilter($this->getStoreId())
        ->setPageSize(count($productIds));
        
        return $collection->getData();
    }

    /**
     * get store ID
     * @return int
     */
    public function getStoreId(){
        return $this->_storeManager->getStore()->getId();
    }
}

