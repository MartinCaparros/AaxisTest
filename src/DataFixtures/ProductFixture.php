<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setSku('NOTEB-MACBO-PRO-M3');
        $product->setProductName('MacBook Pro');
        $product->setDescription('Apple M3 Chip');

        $manager->persist($product);

        $product2 = new Product();
        $product2->setSku('NOTEB-MACBO-AIR-M2');
        $product2->setProductName('MacBook Air');
        $product2->setDescription('Apple M2 Chip');
        
        $manager->persist($product2);
        
        $manager->flush();
    }
}
