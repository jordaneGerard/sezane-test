<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['product'])]
    private int $id ;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product'])]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'store', targetEntity: ProductStore::class)]
    private iterable $productStores;
    
    public function __construct(string $name)
    {
        $this->name = $name;
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

    /**
     * @return iterable|ProductStore[]
     */
    public function getProductStores(): iterable
    {
        return $this->productStores;
    }

}
