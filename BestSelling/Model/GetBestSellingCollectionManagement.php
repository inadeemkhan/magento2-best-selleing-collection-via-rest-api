<?php
/**
 * Copyright © Nadeem Khan All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Nadeem\BestSelling\Model;

class GetBestSellingCollectionManagement implements \Nadeem\BestSelling\Api\GetBestSellingCollectionManagementInterface
{

    /**
     * {@inheritdoc}
     */
    public function getGetBestSellingCollection($param)
    {
        return 'hello api GET return the $param ' . $param;
    }
}

