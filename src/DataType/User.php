<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\Base\DataType;

use OxidEsales\Eshop\Application\Model\User as EshopUserModel;
use OxidEsales\GraphQL\Base\Framework\UserDataInterface;

final class User implements UserDataInterface
{
    /** @var EshopUserModel */
    private $userModel;

    public function __construct(EshopUserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getEshopModel(): EshopUserModel
    {
        return $this->userModel;
    }

    public function getUserId(): string
    {
        return $this->userModel->getId();
    }
}
