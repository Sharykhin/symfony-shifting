<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Contract\Service\Invoice\InvoiceRetrieverInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Contract\Service\User\UserRetrieverInterface;
use App\Contract\Service\Response\ResponseInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserInvoiceController
 * @package App\Controller\API
 */
class UserInvoiceController extends AbstractController
{
    /**
     * @Route("/users/{userId}/invoices", name="get_user_invoices", methods={"GET"}, requirements={"userId"="\d+"})
     *
     * @param Request $request
     * @param ResponseInterface $response
     * @param TranslatorInterface $translator
     * @param UserRetrieverInterface $userRetriever
     * @param InvoiceRetrieverInterface $invoiceRetriever
     * @param int $userId
     * @return Response
     */
    public function index(
        Request $request,
        ResponseInterface $response,
        TranslatorInterface $translator,
        UserRetrieverInterface $userRetriever,
        InvoiceRetrieverInterface $invoiceRetriever,
        int $userId
    ): Response
    {
        $user = $userRetriever->findById($userId);

        if (is_null($user)) {
            return $response->notFound($translator->trans('User with id %id% was not found', ['%id%' => $userId]));
        }

        $limit = (int) $request->query->get('limit', 10);
        $offset = (int) $request->query->get('offset', 0);
        $order = json_decode($request->query->get('order'), true);
        $criteria = ['user' => $userId];

        $invoices = $invoiceRetriever->getList($criteria, $order, $limit, $offset);
        $total = $invoiceRetriever->count($criteria);

        return $response->success($invoices, null, [
            'limit' => $limit,
            'offset' => $offset,
            'order' => $order,
            'count' => sizeof($invoices),
            'total' => $total,
        ]);

    }
}