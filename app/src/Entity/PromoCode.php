<?php

namespace App\Entity;

use App\Repository\PromoCodeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use http\Exception\InvalidArgumentException;

#[ORM\Entity(repositoryClass: PromoCodeRepository::class)]
#[ORM\Table(
    name: 'promo_code',
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'uniq_organization_code', columns: ['organization_id', 'code'])
    ]
)]
class PromoCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:100)]
    private string $code;

    #[ORM\ManyToOne(targetEntity: PromoCodeType::class, inversedBy: "promoCodes")]
    #[ORM\JoinColumn(nullable: false)]
    private PromoCodeType $promoCodeType;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $createdBy;


    #[ORM\ManyToOne(targetEntity: Organization::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Organization $organization;

    #[ORM\OneToMany(
        targetEntity: PromoCodePurchase::class,
        mappedBy: 'promoCode'
    )]
    private Collection $purchases;


    #[ORM\Column(
        type: Types::INTEGER,
        options: ['unsigned' => true, 'default' => 0]
    )]
    private int $registerCount = 0;

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

    public function getOrganization(): Organization
    {
        return $this->organization;
    }

    public function setOrganization(Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getRegisterCount(): int
    {
        return $this->registerCount;
    }

    public function setRegisterCount(int $count): self
    {
        if ($count < 0) {
            throw new InvalidArgumentException('RegisterCount не может быть отрицительным числом');
        }


        $this->registerCount = $count;

        return $this;
    }
}
