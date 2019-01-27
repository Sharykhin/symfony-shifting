<?php

namespace App\Controller\API;

use App\Contract\Service\Invoice\InvoiceCreatorInterface;
use App\Contract\Service\Validate\ValidateInterface;
use App\Request\Constraint\Invoice\InvoiceCreateConstraint;
use App\Request\Type\Invoice\InvoiceCreateType;
use App\ValueObject\ValidatorBag;
use App\ViewModel\InvoiceViewModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Contract\Service\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InvoiceController
 * @package App\Controller\API
 */
class InvoiceController extends AbstractController
{
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
    ) : Response
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