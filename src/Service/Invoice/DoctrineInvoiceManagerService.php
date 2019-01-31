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
     * @param array $criteria
     * @param array|null|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function getList(array $criteria = [], ?array $orderBy = null, $limit = null, $offset = null): array
    {
        $invoices = $this->em->getRepository(Invoice::class)->findBy($criteria, $orderBy, $limit, $offset);

        return array_map(function (Invoice $invoice) {
             return $this->normalizeInvoice($invoice);
        }, $invoices);
    }

    /**
     * @param int $id
     * @return InvoiceViewModel|null
     */
    public function findById(int $id): ?InvoiceViewModel
    {
        /** @var Invoice $invoice */
        $invoice = $this->em->getRepository(Invoice::class)->find($id);

        if (is_null($invoice)) {
            return null;
        }

        return $this->viewModelFactory->create($this->normalizeInvoice($invoice));
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
            // TODO: think about some kind of factory to be able to test it
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

        return $this->viewModelFactory->create($this->normalizeInvoice($invoice));
    }

    /**
     * @param Invoice $invoice
     * @return array
     */
    protected function normalizeInvoice(Invoice $invoice): array
    {
        return $this->serializer->normalize(
            $invoice,
            ['id', 'amount', 'comment', 'createdAt']
        );
    }
}
