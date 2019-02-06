<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Request\Constraint\Invoice\InvoiceCreateConstraint;
use App\Contract\Service\Invoice\InvoiceRetrieverInterface;
use App\Contract\Service\Invoice\InvoiceCreatorInterface;
use App\Contract\Service\Validate\ValidateInterface;
use App\Contract\Service\Response\ResponseInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Request\Type\Invoice\InvoiceCreateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\ViewModel\InvoiceViewModel;
use App\ValueObject\ValidatorBag;

/**
 * Class InvoiceController
 * @package App\Controller\API
 */
class InvoiceController extends AbstractController
{

    /**
     * @Route("/invoices", name="get_invoices", methods={"GET"})
     *
     * @param Request $request
     * @param ResponseInterface $response
     * @param InvoiceRetrieverInterface $invoiceRetriever
     * @return Response
     */
    public function index(
        Request $request,
        ResponseInterface $response,
        InvoiceRetrieverInterface $invoiceRetriever
    ): Response
    {
        $limit = (int) $request->query->get('limit', 10);
        $offset = (int) $request->query->get('offset', 0);
        $orderBy = json_decode($request->query->get('order'), true);


        $invoices = $invoiceRetriever->getList([], $orderBy, $limit, $offset);
        $total = $invoiceRetriever->count();

        return $response->success($invoices, null, [
            'limit' => $limit,
            'offset' => $offset,
            'order' => $orderBy,
            'count' => sizeof($invoices),
            'total' => $total,
        ]);
    }

    /**
     * @Route("/invoices", name="post_invoices", methods={"POST"})
     *
     * @param Request $request
     * @param InvoiceCreatorInterface $invoiceCreator
     * @param ValidateInterface $validate
     * @param ResponseInterface $response
     * @return Response
     */
    public function store(
        Request $request,
        InvoiceCreatorInterface $invoiceCreator,
        ValidateInterface $validate,
        ResponseInterface $response
    ): Response
    {
        $type = new InvoiceCreateType($request->request->all());
        /** @var ValidatorBag $validatorBag */
        $validatorBag = $validate->validate(
            $type->toArray(),
            InvoiceCreateConstraint::class,
            ['creating']
        );

        if (!$validatorBag->isValid()) {
            return $response->badRequest($validatorBag->getErrors());
        }

        /** @var InvoiceViewModel $invoice */
        $invoice = $invoiceCreator->create($type);

        return $response->created($invoice);
    }
}
