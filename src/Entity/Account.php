<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $iban;

    /**
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @ORM\OneToMany(targetEntity=UserAccount::class, mappedBy="account")
     */
    private $userAccounts;

    public function __construct()
    {
        $this->userAccounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIban(): ?int
    {
        return $this->iban;
    }

    public function setIban(int $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * @return Collection|UserAccount[]
     */
    public function getUserAccounts(): Collection
    {
        return $this->userAccounts;
    }

    public function addUserAccount(UserAccount $userAccount): self
    {
        if (!$this->userAccounts->contains($userAccount)) {
            $this->userAccounts[] = $userAccount;
            $userAccount->setAccount($this);
        }

        return $this;
    }

    public function removeUserAccount(UserAccount $userAccount): self
    {
        if ($this->userAccounts->removeElement($userAccount)) {
            // set the owning side to null (unless already changed)
            if ($userAccount->getAccount() === $this) {
                $userAccount->setAccount(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->iban;
    }
}
