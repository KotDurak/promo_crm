<?php

namespace App\Entity;

use App\Repository\PromoCodePurchaseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoCodePurchaseRepository::class)]
#[ORM\Table(
    name: 'promo_code_purchase',
    indexes: [
        new ORM\Index(name: 'idx_purchase_date', columns: ['purchase_date'])
    ]
)]
class PromoCodePurchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'float')]
    private float $fullPrice;

    #[ORM\Column(type: 'float')]
    private float $cashback;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $purchaseDate;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $promoCodeOwner;

    #[ORM\ManyToOne(targetEntity: PromoCode::class)]
    private PromoCode $promoCode;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullPrice(): float
    {
        return $this->fullPrice;
    }

    public function setFullPrice(float $fullPrice): self
    {
        $this->fullPrice = $fullPrice;
        return $this;
    }

    public function getCashback(): float
    {
        return $this->cashback;
    }

    public function setCashback(float $cashback): self
    {
        $this->cashback = $cashback;
        return $this;
    }

    public function getPurchaseDate(): \DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(\DateTimeInterface $purchaseDate): self
    {
        $this->purchaseDate = $purchaseDate;
        return $this;
    }

    public function getPromoCodeOwner(): ?User
    {
        return $this->promoCodeOwner;
    }

    public function setPromoCodeOwner(?User $promoCodeOwner): self
    {
        $this->promoCodeOwner = $promoCodeOwner;
        return $this;
    }

    public function getPromoCode(): PromoCode
    {
        return $this->promoCode;
    }

    public function setPromoCode(PromoCode $promoCode): self
    {
        $this->promoCode = $promoCode;
        return $this;
    }
}
