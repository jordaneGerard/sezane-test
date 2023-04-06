<?php

namespace App\Controller;

use App\DTO\CreateStoreRequestDTO;
use App\UseCase\CreateStoreUseCase;
use App\UseCase\SearchStoreByNameUseCase;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use OpenApi\Annotations as OA;

class StoreController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer
    ) {
      
    }
    
    /**
     * @OA\Post(
     *      path="/api/store",
     *      tags={"Store"},
     *      summary="Create a new store",
     *      description="Create store request body",
     *      operationId="createStore",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Create store request body",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name","latitude", "longitude", "address", "zipCode", "city", "managerId"},
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      example="My Store"
     *                  ),
     *                  @OA\Property(
     *                      property="latitude",
     *                      type="float",
     *                      example=48.870885
     *                  ),
     *                  @OA\Property(
     *                      property="longitude",
     *                      type="float",
     *                      example=2.331130
     *                  ),
     *                  @OA\Property(
     *                      property="address",
     *                      type="string",
     *                      example="12 rue de la Paix"
     *                  ),
     *                  @OA\Property(
     *                      property="city",
     *                      type="string",
     *                      example="Paris"
     *                  ),
     *                  @OA\Property(
     *                      property="managerId",
     *                      type="integer",
     *                      example=1
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="My Store"
     *              ),
     *              @OA\Property(
     *                  property="latitude",
     *                  type="float",
     *                  example=48.870885
     *               ),
     *               @OA\Property(
     *                  property="longitude",
     *                  type="float",
     *                  example=2.331130
     *               ),
     *               @OA\Property(
     *                  property="address",
     *                  type="string",
     *                  example="12 rue de la Paix"
     *               ),
     *               @OA\Property(
     *                  property="city",
     *                  type="string",
     *                  example="Paris"
     *               ),
     *               @OA\Property(
     *                  property="managerId",
     *                  type="integer",
     *                  example=1
     *               )
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="errors",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(
     *                          property="property",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="message",
     *                          type="string"
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(response="404", description="Manager not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Manager not found"),
     *         )
     *     ),
     * )
     */
    #[Route('/api/store', name: 'store_create', methods: ['POST'])]
    public function create(Request $request, CreateStoreUseCase $createStoreUseCase): JsonResponse
    {
        $storeCreateRequestDto = $this->serializer->deserialize(
            $request->getContent(),
            CreateStoreRequestDTO::class,
            'json'
        );

        try {
            $store = $createStoreUseCase->execute($storeCreateRequestDto);
            $result = $this->serializer->serialize($store, 'json', ['groups' => 'store']);

            return new JsonResponse($result, JsonResponse::HTTP_CREATED, [], true);
            
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/store/search-name",
     *     summary="Search stores by name",
     *     description="Retrieve a paginated list of stores that match the specified name.",
     *     tags={"Store"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="The name of the store to search for",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             default = ""
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="The page number of the results to display",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             default=1
     *         )
     *     ),
     *     @OA\Response(response="202", description="Returns the list of stores matching the given name",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="integer"),
     *                      @OA\Property(property="name", type="string"),
     *                      @OA\Property(property="latitude", type="float"),
     *                      @OA\Property(property="longitude", type="float"),
     *                      @OA\Property(property="adresse", type="string"),
     *                      @OA\Property(property="zipCode", type="string"),
     *                      @OA\Property(property="city", type="string"),
     *                      @OA\Property(property="manager", type="object",
     *                          @OA\Property(property="id", type="integer"),
     *                          @OA\Property(property="firstName", type="string"),
     *                          @OA\Property(property="lastName", type="string"),
     *                      ),
     *                  ),
     *              ),
     *             @OA\Property(property="metadata", type="object",
     *                  @OA\Property(property="total_count", type="integer"),
     *                  @OA\Property(property="current_page", type="integer"),
     *                  @OA\Property(property="page_count", type="integer"),
     *              ),
     *         )
     *     ),
     *     @OA\Response(response="404", description="Store not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Store not found"),
     *         )
     *     ),
     * )
     */
    #[Route('/api/store/search-name', name: 'store_search_name', methods: ['GET'])]
    public function searchByName(Request $request, SearchStoreByNameUseCase $searchStoreByNameUseCase):JsonResponse
    {
        $name = trim($request->query->get('name', ''));
        $page = $request->query->getInt('page', 1);

        $result = $searchStoreByNameUseCase->execute($name, $page);

        $data = json_decode($this->serializer->serialize($result, 'json', ['groups' => 'store']));
        
        $metadata = [
            'total_count' => $result->getTotalItemCount(),
            'current_page' => $result->getCurrentPageNumber(),
            'page_count' => $result->getPageCount(),
        ];


        return new JsonResponse(
            [
                'data' => $data,
                'metadata' => $metadata,
            ],
            JsonResponse::HTTP_ACCEPTED
        );
    }
}
