<?php

namespace App\Service\Invoice;

use App\Contract\Factory\Entity\InvoiceFactoryInterface;
use App\Contract\Factory\Entity\ReportFactoryInterface;
use App\Contract\Service\Invoice\InvoiceCreatorInterface;
use App\Contract\Service\Invoice\InvoiceRetrieverInterface;
use App\Entity\Report;
use App\Entity\User;
use App\Request\Type\Invoice\InvoiceCreateType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use App\ViewModel\InvoiceViewModel;

class DoctrineInvoiceManagerService implements InvoiceCreatorInterface, InvoiceRetrieverInterface
{
    protected $em;

    protected $invoiceFactory;

    protected $reportFactory;

    public function __construct(
        EntityManagerInterface $em,
        InvoiceFactoryInterface $invoiceFactory,
        ReportFactoryInterface $reportFactory
    )
    {
        $this->em = $em;
        $this->invoiceFactory = $invoiceFactory;
        $this->reportFactory = $reportFactory;
    }

    public function findById(int $id): InvoiceViewModel
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param InvoiceCreateType $type
     * @return InvoiceViewModel
     */
    public function create(InvoiceCreateType $type): InvoiceViewModel
    {
        /** @var User $user */
        $user = $this->em->getRepository(User::class)->find($type->userId);

        $date = new DateTimeImmutable('now');
        $invoice = $this->invoiceFactory->create();
        $invoice->setAmount($type->amount);
        $invoice->setComment($type->comment);
        $invoice->setCreatedAt($date);
        $invoice->setUser($user);

        //$this->em->persist($invoice);
        // TODO: run the procedure
//        $report = $this->em->getRepository(Report::class)->findOneBy([
//            'user' => $type->userId,
//            'date' => $date,
//        ]);
//
//        if (is_null($report)) {
//
//        }
    }
}