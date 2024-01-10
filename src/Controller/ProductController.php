<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use App\Request\StoreProductsRequest;
use App\Request\UpdateProductsRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api', name: 'api_')]
class ProductController extends AbstractController
{
    private $productRepository;
    private $em;

    public function __construct(ProductRepository $productRepository, EntityManagerInterface $em)
    {
        $this->productRepository = $productRepository;
        $this->em = $em;
    }

    #[Route('/products', name: 'get_all_products', methods:['GET'])]
    public function getAll(Request $request): Response
    {
        $products = $this->productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/products/getById/{id}', name: 'get_product_by_id', methods:['GET'])]
    public function getById(Request $request): Response
    {
        $product = $this->productRepository->find($request->get('id'));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $data = $serializer->normalize($product, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'sku']]);
        
        return new JsonResponse(['status' => 'sucess', 'data' => $data], 200);
    }

    #[Route('/product/single/store', name: 'store_product')]
    public function store(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new_product = $form->getData();
            $this->em->persist($new_product);
            $this->em->flush();
            return $this->redirect('/api/products');
        } else {
            return $this->render('product/create.html.twig', [
                'form' => $form->createView(),
                'error' => ''
            ]);
        }
    }

    #[Route('/products/store', name: 'store_product', methods: ['POST'])]
    public function storeBulk(StoreProductsRequest $request): Response
    {
        $products = $this->productRepository->storeBulk($request->getRequest()->toArray()['products']);

        return new JsonResponse($products);
    }

    #[Route('/products/delete', name: 'delete_product', methods:['DELETE'])]
    public function delete(Request $request): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/products/update', name: 'update_product', methods:['PUT'])]
    public function update(UpdateProductsRequest $request): Response
    {
        $products = $this->productRepository->updateBulk($request->getRequest()->toArray()['products']);

        return new JsonResponse($products);
    }
}
