<?php

namespace App\Controller\API;

use App\Contract\Service\Invoice\InvoiceCreatorInterface;
use App\Request\Type\Invoice\InvoiceCreateType;
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
     */
    public function store(
        Request $request,
        InvoiceCreatorInterface $invoiceCreator,
        ResponseInterface $response
    ) : Response
    {
        $type = new InvoiceCreateType($request->request->all());
        $invoice = $invoiceCreator->create($type);

        return $response->created(['message' => 'pong']);
    }
}