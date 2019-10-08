<?php declare(strict_types=1);

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQl\DataObject;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;
use OxidEsales\GraphQl\Utility\AuthConstants;

/**
 * @Type()
 */
class User
{
    /** @var  string */
    private $id = '';

    /** @var  int|null */
    private $shopid = null;

    /** @var  string */
    private $username = '';

    /** @var  string */
    private $passwordhash = '';

    /** @var  string */
    private $firstname = '';

    /** @var  string */
    private $lastname = '';

    /** @var  string */
    private $usergroup = '';

    /** @var  Address */
    private $address;

    public function __construct(
        string $id,
        int $shopid,
        string $username,
        string $passwordhash,
        string $firstname,
        string $lastname,
        string $usergroup = AuthConstants::USER_GROUP_CUSTOMER,
        Address $address = null
    )
    {
        $this->id = $id;
        $this->shopid = $shopid;
        $this->username = $username;
        $this->passwordhash = $passwordhash;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->usergroup = $usergroup;
        $this->address = $address;
    }

    /**
     * @Field(outputType="ID")
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @Field()
     */
    public function getShopid(): ?int
    {
        return $this->shopid;
    }

    /**
     * @Field()
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @Field()
     */
    public function getPasswordhash(): string
    {
        return $this->passwordhash;
    }

    /**
     * @Field()
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @Field()
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @Field()
     */
    public function getUsergroup(): ?string
    {
        return $this->usergroup;
    }

    /**
     * @Field()
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

}
