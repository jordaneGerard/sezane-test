<?php

namespace App\Entity;

use App\Repository\StoreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StoreRepository::class)]
class ProductStore
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: "Product")]
    #[ORM\JoinColumn(name: "product_id", referencedColumnName: "id")]
    private Product $product;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: "Store")]
    #[ORM\JoinColumn(name: "store_id", referencedColumnName: "id")]
    private Store $store;

    #[ORM\Column(type: "integer")]
    private int $quantity;

    public function __construct(Product $product, Store $store, int $quantity = 0)
    {
        $this->product = $product;
        $this->store = $store;
        $this->quantity = $quantity;
    }


    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function setStore(Store $store): self
    {
        $this->store = $store;

        return $this;
    }


    public function getStore(): Store
    {
        return $this->store;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
