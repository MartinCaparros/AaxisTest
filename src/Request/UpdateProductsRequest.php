<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateProductsRequest extends BaseRequest
{
    #[Assert\All(
        ['constraints' => [
            new Assert\Collection(
                fields: [
                    'sku' => [
                        new Assert\NotBlank(),
                        new Assert\Length(max: 50)
                    ],
                    'name' => [
                        new Assert\NotBlank()
                    ]
                ]
            )]
        ]
    )]
    protected $products;
}