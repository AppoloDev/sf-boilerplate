<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Entity\User;
use AppoloDev\SFToolbox\Doctrine\Repository\Criteria\BuilderCriteria;
use AppoloDev\SFToolbox\Doctrine\Repository\Criteria\GroupAndOrderCriteria;
use AppoloDev\SFToolbox\Doctrine\Repository\Criteria\JoinCriteria;
use AppoloDev\SFToolbox\Doctrine\Repository\Criteria\SelectCriteria;
use AppoloDev\SFToolbox\Doctrine\Repository\Criteria\WhereCriteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    use BuilderCriteria;
    use GroupAndOrderCriteria;
    use WhereCriteria;
    use JoinCriteria;
    use SelectCriteria;

    protected static string $alias = 'u';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function querySearch(string $queryString): self
    {
        if ('' === $queryString) {
            return $this;
        }

        $this->searchIntoFields($queryString, ['firstname', 'lastname', 'email']);

        return $this;
    }
}
