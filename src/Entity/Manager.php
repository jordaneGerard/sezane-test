<?php

namespace App\Entity;

use App\Repository\ManagerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ManagerRepository::class)]
class Manager
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['store', 'manager'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['store', 'manager'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['store', 'manager'])]
    private ?string $lastName = null;

    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: Store::class)]
    #[Groups(['manager'])]
    private Collection $Stores;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->Stores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection<int, Store>
     */
    public function getStores(): Collection
    {
        return $this->Stores;
    }

    public function addStore(Store $store): self
    {
        if (!$this->Stores->contains($store)) {
            $this->Stores->add($store);
            $store->setManager($this);
        }

        return $this;
    }

    public function removeStore(Store $store): self
    {
        if ($this->Stores->removeElement($store)) {
            // set the owning side to null (unless already changed)
            if ($store->getManager() === $this) {
                $store->setManager(null);
            }
        }

        return $this;
    }
}
