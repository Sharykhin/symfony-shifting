<?php

namespace App\Service\Invoice;

use App\Contract\Factory\Entity\InvoiceFactoryInterface;
use App\Contract\Factory\Entity\ReportFactoryInterface;
use App\Contract\Factory\ViewModel\InvoiceViewModelFactoryInterface;
use App\Contract\Service\Invoice\InvoiceCreatorInterface;
use App\Contract\Service\Invoice\InvoiceRetrieverInterface;
use App\Entity\User;
use App\Request\Type\Invoice\InvoiceCreateType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use App\ViewModel\InvoiceViewModel;
use Exception;

class DoctrineInvoiceManagerService implements InvoiceCreatorInterface, InvoiceRetrieverInterface
{
    protected $em;

    protected $invoiceFactory;

    protected $reportFactory;

    protected $viewModelFactory;

    public function __construct(
        EntityManagerInterface $em,
        InvoiceFactoryInterface $invoiceFactory,
        ReportFactoryInterface $reportFactory,
        InvoiceViewModelFactoryInterface $viewModelFactory
    )
    {
        $this->em = $em;
        $this->invoiceFactory = $invoiceFactory;
        $this->reportFactory = $reportFactory;
        $this->viewModelFactory = $viewModelFactory;
    }

    public function findById(int $id): InvoiceViewModel
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param InvoiceCreateType $type
     * @return InvoiceViewModel
     * @throws Exception
     */
    public function create(InvoiceCreateType $type): InvoiceViewModel
    {
        /** @var User $user */
        $user = $this->em->getRepository(User::class)->find($type->userId);
        try {
            $this->em->beginTransaction();

            $date = new DateTimeImmutable('now');
            $invoice = $this->invoiceFactory->create();
            $invoice->setAmount($type->amount);
            $invoice->setComment($type->comment);
            $invoice->setCreatedAt($date);
            $invoice->setUser($user);

            $this->em->persist($invoice);

            $stmt = $this->em->getConnection()->prepare('CALL createOrUpdateReport(:userId, :date, :amount)');
            $stmt->execute([
                ':userId' => $type->userId,
                ':date' => $date->format('Y-m-d'),
                ':amount' => $type->amount
            ]);

            $this->em->flush();

            $this->em->commit();
        } catch (Exception $exception) {
            $this->em->rollback();
            throw $exception;
        }

        $invoiceViewModel = $this->viewModelFactory->create();
        $invoiceViewModel->setId($invoice->getId());
        $invoiceViewModel->setAmount($invoice->getAmount());
        $invoiceViewModel->setComment($invoice->getComment());
        $invoiceViewModel->setCreatedAt($date);

        return $invoiceViewModel;
    }
}
