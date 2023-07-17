<?php

namespace App\Domain\User\Entity;

use App\Domain\User\Repository\UserRepository;
use AppoloDev\SFToolboxBundle\Domain\Entity\Concern\Authenticable\Authenticable;
use AppoloDev\SFToolboxBundle\Domain\Entity\Concern\Blockable\Blockable;
use AppoloDev\SFToolboxBundle\Domain\Entity\Concern\Blockable\BlockableInterface;
use AppoloDev\SFToolboxBundle\Domain\Entity\Concern\Deletable\Deletable;
use AppoloDev\SFToolboxBundle\Domain\Entity\Concern\Deletable\DeletableInterface;
use AppoloDev\SFToolboxBundle\Domain\Entity\Concern\Identifiable\Identifiable;
use AppoloDev\SFToolboxBundle\Domain\Entity\Concern\Timestampable\Timestampable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[UniqueEntity('email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface, BlockableInterface, DeletableInterface
{
    use Identifiable;
    use Authenticable;
    use Timestampable;
    use Blockable;
    use Deletable;

    #[ORM\Column(name: 'firstname', type: Types::STRING, length: 255)]
    private string $firstname;

    #[ORM\Column(name: 'lastname', type: Types::STRING, length: 255)]
    private string $lastname;

    #[ORM\Column(name: 'googleId', type: Types::STRING, length: 255, nullable: true)]
    private ?string $googleId;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastLogin = null;

    public function __construct()
    {
        $this
            ->setRoles(['ROLE_USER'])
            ->setPassword(uniqid())
        ;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    public function setGoogleId(?string $googleId): void
    {
        $this->googleId = $googleId;
    }

    /**
     * @param self $user
     */
    public function isEqualTo(UserInterface $user): bool
    {
        if ($user->isBlocked() || $user->isDeleted()) {
            return false;
        }

        return true;
    }

    public function getInitials(): string
    {
        return $this->getLastname()[0].$this->getFirstname()[0];
    }

    public function getFullName(): string
    {
        return $this->getLastname().' '.$this->getFirstname();
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }
}
