<?php

namespace App\Service\Invoice;

use App\Contract\Factory\ViewModel\InvoiceViewModelFactoryInterface;
use App\Contract\Service\Invoice\InvoiceRetrieverInterface;
use App\Contract\Service\Invoice\InvoiceCreatorInterface;
use App\Contract\Factory\Entity\InvoiceFactoryInterface;
use App\Contract\Service\Serializer\SerializerInterface;
use App\Request\Type\Invoice\InvoiceCreateType;
use Doctrine\ORM\EntityManagerInterface;
use App\ViewModel\InvoiceViewModel;
use App\Entity\Invoice;
use DateTimeImmutable;
use App\Entity\User;
use Exception;

/**
 * Class DoctrineInvoiceManagerService
 * @package App\Service\Invoice
 */
class DoctrineInvoiceManagerService implements InvoiceCreatorInterface, InvoiceRetrieverInterface
{
    /** @var EntityManagerInterface $em */
    protected $em;

    /** @var InvoiceFactoryInterface $invoiceFactory */
    protected $invoiceFactory;

    /** @var InvoiceViewModelFactoryInterface $viewModelFactory */
    protected $viewModelFactory;

    /** @var SerializerInterface $serializer */
    protected $serializer;

    /**
     * DoctrineInvoiceManagerService constructor.
     * @param EntityManagerInterface $em
     * @param InvoiceFactoryInterface $invoiceFactory
     * @param InvoiceViewModelFactoryInterface $viewModelFactory
     * @param SerializerInterface $serializer
     */
    public function __construct(
        EntityManagerInterface $em,
        InvoiceFactoryInterface $invoiceFactory,
        InvoiceViewModelFactoryInterface $viewModelFactory,
        SerializerInterface $serializer
    )
    {
        $this->em = $em;
        $this->invoiceFactory = $invoiceFactory;
        $this->viewModelFactory = $viewModelFactory;
        $this->serializer = $serializer;
    }

    /**
     * @param int $id
     * @return InvoiceViewModel|null
     */
    public function findById(int $id): ?InvoiceViewModel
    {
        $invoice = $this->em->getRepository(Invoice::class)->find($id);
        if (is_null($invoice)) {
            return null;
        }

        return $this->viewModelFactory->create($this->serializer->normalize(
            $invoice,
            ['attributes' => ['id', 'amount', 'comment', 'createdAt']])
        );
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

        return $this->viewModelFactory->create($this->serializer->normalize(
            $invoice,
            ['attributes' => ['id', 'amount', 'comment', 'createdAt']]
        ));
    }
}