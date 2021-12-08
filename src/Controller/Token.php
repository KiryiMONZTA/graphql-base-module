<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\Base\Controller;

use OxidEsales\GraphQL\Base\DataType\Filter\IDFilter;
use OxidEsales\GraphQL\Base\DataType\Pagination\Pagination;
use OxidEsales\GraphQL\Base\DataType\Sorting\TokenSorting;
use OxidEsales\GraphQL\Base\DataType\Token as TokenDataType;
use OxidEsales\GraphQL\Base\DataType\TokenFilterList;
use OxidEsales\GraphQL\Base\Service\Authentication;
use OxidEsales\GraphQL\Base\Service\TokenAdministration;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;
use TheCodingMachine\GraphQLite\Types\ID;

class Token
{
    /** @var TokenAdministration */
    private $tokenAdministration;

    /** @var Authentication */
    private $authentication;

    public function __construct(
        TokenAdministration $tokenAdministration,
        Authentication $authentication
    ) {
        $this->tokenAdministration = $tokenAdministration;
        $this->authentication      = $authentication;
    }

    /**
     * Query a customer's active JWT.
     * User with right 'VIEW_ANY_TOKEN' can query any customer's tokens.
     *
     * @Query
     * @Logged
     *
     * @return TokenDataType[]
     */
    public function tokens(
        ?TokenFilterList $filter = null,
        ?Pagination      $pagination = null,
        ?TokenSorting    $sort = null
    ): array {
        return $this->tokenAdministration->tokens(
            $filter ?? TokenFilterList::fromUserInput(
                new IDFilter(
                    $this->authentication->getUser()->id()
                )
            ),
            $pagination ?? new Pagination(),
            $sort ?? TokenSorting::fromUserInput(TokenSorting::SORTING_ASC)
        );
    }

    /**
     * Invalidate all tokens per customer.
     *  - Customer with right INVALIDATE_ANY_TOKEN can invalidate tokens for any customer Id.
     *  - Customer without special rights can invalidate only own tokens.
     * If no customerId is supplied, own Id is taken.
     *
     * @Mutation
     * @Logged
     */
    public function customerTokensDelete(?ID $customerId): int
    {
        return $this->tokenAdministration->customerTokensDelete($customerId);
    }

    /**
     * Invalidate all tokens for current shop.
     *
     * @Mutation
     * @Logged
     * @Right("INVALIDATE_ANY_TOKEN")
     */
    public function shopTokensDelete(): int
    {
        return $this->tokenAdministration->shopTokensDelete();
    }

    /**
     * Regenerates the JWT signature key.
     * This will invalidate all issued tokens for the current shop.
     * Only use if no other option is left.
     *
     * @Mutation
     * @Logged
     * @Right("REGENERATE_SIGNATURE_KEY")
     */
    public function regenerateSignatureKey(): bool
    {
        return $this->tokenAdministration->regenerateSignatureKey();
    }
}
