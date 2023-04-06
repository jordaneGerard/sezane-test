<?php

namespace App\Entity;

use App\Repository\StoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StoreRepository::class)]
#[ORM\Index(name: "store_name_idx", columns: ["name"])]
class Store
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['store', 'manager'])]
    private int $id ;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['store', 'manager'])]
    private string $name;

    #[ORM\Column(type: 'float')]
    #[Groups(['store', 'manager'])]
    private float $latitude;

    #[ORM\Column(type: 'float')]
    #[Groups(['store', 'manager'])]
    private float $longitude;

    #[ORM\Column(type: 'string')]
    #[Groups(['store', 'manager'])]
    private string $address;

    #[ORM\Column(type: 'string')]
    #[Groups(['store', 'manager'])]
    private string $zipCode;

    #[ORM\Column(type: 'string')]
    #[Groups(['store', 'manager'])]
    private string $city;

    #[ORM\ManyToOne(inversedBy: 'Stores', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['store'])]
    private Manager $manager;

    #[ORM\OneToMany(mappedBy: 'store', targetEntity: ProductStore::class)]
    private iterable $productStores;

    public function __construct(
        string $name,
        float $latitude,
        float $longitude,
        string $address,
        string $zipCode,
        string $city,
        Manager $manager
    )
    {
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->address = $address;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->manager = $manager;
        $this->productStores = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getManager(): Manager
    {
        return $this->manager;
    }

    public function setManager(Manager $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return iterable|ProductStore[]
     */
    public function getProductStores(): iterable
    {
        return $this->productStores;
    }
}
