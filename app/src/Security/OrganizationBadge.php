<?php

namespace App\Security;

use App\Entity\Organization;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\BadgeInterface;

class OrganizationBadge implements BadgeInterface
{
    public function __construct(private Organization $organization)
    {

    }

    public function getOrganization(): Organization
    {
        return $this->organization;
    }

    public function isResolved(): bool
    {
        return true;
    }
}
