<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Product::class);
        $this->em = $em;
    }

    public function findOneByField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findBySku(array $values): ?Product
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p')
        ->from(Product::class, 'p')
        ->where($qb->expr()->in('p.sku', ':values'))
        ->setParameter('values', $values)->getFirstResult();

        return $qb->getQuery()->getResult();
    }

    public function storeBulk(array $products)
    {
        $errors = [];
        $new_products = [];
        $em = $this->getEntityManager();

        foreach ($products as $key => $value) {
            $already_exits = $this->findOneBy(['sku' => $value['sku']]);
            if ($already_exits) {
                $errors[] = ['product' => $value, 'message' => 'SKU_ALREADY_EXISTS'];
            } else {
                $new_product = new Product();
                $new_product->setSku($value['sku'])->setProductName($value['name']);
                $em->persist($new_product);
                $em->flush();
                $new_products[] = $new_product;
            }
        }

        return ['errors' => $errors, 'new_products' => $new_products];
    }

    public function updateBulk(array $products)
    {
        $errors = [];
        $products_updated = [];
        $em = $this->getEntityManager();

        foreach ($products as $key => $value) {
            $product_to_update = $this->findOneBy(['sku' => $value['sku']]);
            if (!$product_to_update) {
                $errors[] = ['product' => $value, 'message' => 'SKU_DOES_NOT_EXISTS'];
            } else {
                $product_to_update->setSku($value['sku'])->setProductName($value['name']);
                $em->persist($product_to_update);
                $em->flush();
                $products_updated[] = $value;
            }
        }

        return ['errors' => $errors, 'products_updated' => $products_updated];
    }
}
