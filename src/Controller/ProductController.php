<?php

namespace App\Controller;

use App\Repository\ProductStoreRepository;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="list all products with store and quantity by store",
     *     description="list all products with store and quantity by store",
     *     tags={"Product"},
     *     @OA\Response(response="202", description="Returns the list of stores matching the given name",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="stores", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="integer"),
     *                      @OA\Property(property="name", type="string"),
     *                      @OA\Property(property="quantity", type="integer"),
     *                  ),
     *             ),
     *         )
     *     ),
     * )
     */
    #[Route('/api/products', name: 'products_list', methods: ['GET'])]
    public function list(ProductStoreRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAllWithStoreQuantities();

        return new JsonResponse($products, JsonResponse::HTTP_CREATED);
    }
}
