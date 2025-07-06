<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_OWNER = 'owner';
    public const ROLE_USER = 'user';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type:"string", length:180, unique:true)]
    private string $email;

    #[ORM\Column(type:"string", length:255)]
    private string $name;

    #[ORM\Column(type:"string", length:50)]
    private string $role; // например 'owner' или 'employee'

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Organization $organization;

    #[ORM\OneToMany(targetEntity: PromoCode::class, mappedBy: "createdBy")]
    private Collection $promoCodesCreated;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank(groups: ['create'])]
    private ?string $password = null;


    public function __construct()
    {
        $this->promoCodesCreated = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
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

    public function getRole(): string
    {
        return $this->role;
    }
    public function setRole(string $role): self
    {
        $this->role = $role;
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
    public function getPromoCodesCreated(): Collection
    {
        return $this->promoCodesCreated;
    }

    public function addPromoCodeCreated(PromoCode $promoCode): self
    {
        if (!$this->promoCodesCreated->contains($promoCode)) {
            $this->promoCodesCreated[] = $promoCode;
            $promoCode->setCreatedBy($this);
        }
        return $this;
    }

    public function removePromoCodeCreated(PromoCode $promoCode): self
    {
        if ($this->promoCodesCreated->removeElement($promoCode)) {
            if ($promoCode->getCreatedBy() === $this) {
                $promoCode->setCreatedBy(null);
            }
        }
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {

        if (!empty(trim((string)$password))) {
            $this->password = $password;
        }

        return $this;
    }

    public function getRoles(): array
    {
        $roles = [];

        if ($this->role === self::ROLE_OWNER) {
            $roles[] = 'ROLE_OWNER';
        }

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function isOwner(): bool
    {
        return $this->role === self::ROLE_OWNER;
    }
}
