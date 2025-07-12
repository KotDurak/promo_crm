<?php

namespace App\Entity;

use App\Repository\OrganizationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
class Organization implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 64, unique: true)]
    private ?string $apiKey = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $apiKeyExpiredAt = null;
    private Collection $users;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $siteAddress = null;

    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: "owner_id", referencedColumnName: "id", nullable: true, onDelete: "SET NULL")]
    private ?User $owner = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }


    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function generateApiKey(): void
    {
        $this->apiKey = bin2hex(random_bytes(32));
        $this->apiKeyExpiredAt = (new \DateTime())->modify('+1 year');
    }

    public function isValidApiKey(): bool
    {
        return $this->apiKey &&
            (!$this->apiKeyExpiredAt || $this->apiKeyExpiredAt > new \DateTime());
    }

    public function getApiKeyExpiredAt():? \DateTimeInterface
    {
        return $this->apiKeyExpiredAt;
    }

    public function getRoles(): array
    {
        return ['ROLE_API', 'ROLE_OWNER'];
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->apiKey;
    }

    public function getSiteAddress(): ?string
    {
        return $this->siteAddress;
    }

    public function setSiteAddress(?string $address): self
    {
        $this->siteAddress = $address;

        return $this;
    }
}
