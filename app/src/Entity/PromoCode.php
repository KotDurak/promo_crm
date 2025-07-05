<?php

namespace App\Entity;

use App\Repository\PromoCodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoCodeRepository::class)]
class PromoCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:100, unique: true)]
    private string $code;

    #[ORM\ManyToOne(targetEntity: PromoCodeType::class, inversedBy: "promoCodes")]
    #[ORM\JoinColumn(nullable: false)]
    private PromoCodeType $promoCodeType;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $createdBy;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }
    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getPromoCodeType(): PromoCodeType
    {
        return $this->promoCodeType;
    }
    public function setPromoCodeType(?PromoCodeType $promoCodeType = null): self
    {
        $this->promoCodeType = $promoCodeType;
        return $this;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }
    public function setCreatedBy(?User $user = null): self
    {
        $this->createdBy = $user;
        return $this;
    }
}
