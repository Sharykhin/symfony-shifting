<?php

namespace App\Controller\API;

use App\Contract\User\UserCreateInterface;
use App\Contract\User\UserRetrieverInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class UserController
 * @package App\Controller\API
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users/{userId}", name="get_user", methods={"GET"}, requirements={"userId"="\d+"})
     *
     * @param UserRetrieverInterface $userRetriever
     * @param int $userId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(
        UserRetrieverInterface $userRetriever,
        SerializerInterface $serializer,
        int $userId
    )
    {
        $user = $userRetriever->findById($userId);


        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter());
        $serializer = new Serializer(array($normalizer), array($encoder));


        return new Response($serializer->serialize($user, 'json', array(
            'groups' => array('public'),
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
        )), Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * @Route("/users", name="post_user", methods={"POST"})
     *
     * @param Request $request
     * @param UserCreateInterface $userCreate
     * @return JsonResponse
     */
    public function store(
        Request $request,
        UserCreateInterface $userCreate
    ) : JsonResponse
    {
        $user = $userCreate->create($request->request->all());
        return $this->json($user, JsonResponse::HTTP_CREATED);
    }
}
