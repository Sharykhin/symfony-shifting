<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     *
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60)
     *
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invoice", mappedBy="user")
     *
     */
    private $invoices;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $activated;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return User
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    /**
     * @param Invoice $invoice
     * @return User
     */
    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setUserId($this);
        }

        return $this;
    }

    /**
     * @param Invoice $invoice
     * @return User
     */
    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->contains($invoice)) {
            $this->invoices->removeElement($invoice);
            // set the owning side to null (unless already changed)
            if ($invoice->getUserId() === $this) {
                $invoice->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getActivated(): ?DateTimeImmutable
    {
        return $this->activated;
    }

    /**
     * @param DateTimeImmutable|null $activated
     * @return User
     */
    public function setActivated(?DateTimeImmutable $activated): self
    {
        $this->activated = $activated;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return null
     */
    public function eraseCredentials()
    {
       return null;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $this->roles[] = 'ROLE_USER';

        return array_unique($this->roles);
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = array_unique($roles);

        return $this;
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
       return $this->email;
    }
}
