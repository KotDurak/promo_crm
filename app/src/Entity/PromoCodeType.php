<?php

namespace App\Entity;

use App\Repository\PromoCodeTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PromoCodeTypeRepository::class)]
#[ORM\Table(name: "promo_code_type",
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: "uniq_type_organization", columns: ["type", "organization_id"])
    ]
)]
class PromoCodeType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Это поле обязательно')]
    private string $name;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Это поле обязательно')]
    private int $cashback;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Это поле обязательно')]
    private string $type;

    #[ORM\ManyToOne(targetEntity: Organization::class, inversedBy: 'promoCodeTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private Organization $organization;


    #[ORM\Column(type: 'integer')]
    private int $organization_id;

    #[ORM\OneToMany(
        targetEntity: PromoCode::class,
        mappedBy: 'promoCodeType',
        cascade: ["persist", "remove"]
    )]
    private Collection $promoCodes;

    public function __construct()
    {
        $this->promoCodes = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getCashback(): int
    {
        return $this->cashback;
    }
    public function setCashback(int $cashback): self
    {
        $this->cashback = $cashback;
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

    /**
     * @return Collection|PromoCode[]
     */
    public function getPromoCodes(): Collection
    {
        return $this->promoCodes;
    }

    public function addPromoCode(PromoCode $promoCode): self
    {
        if (!$this->promoCodes->contains($promoCode)) {
            $this->promoCodes[] = $promoCode;
            $promoCode->setPromoCodeType($this);
        }
        return $this;
    }

    public function removePromoCode(PromoCode $promoCode): self
    {
        if ($this->promoCodes->removeElement($promoCode)) {
            if ($promoCode->getPromoCodeType() === $this) {
                $promoCode->setPromoCodeType(null);
            }
        }
        return $this;
    }

    public function getOrganizationId()
    {
        return $this->organization_id;
    }

    public function setOrganizationId(int $id): self
    {
        $this->organization_id = $id;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
