<?php

namespace App\Http\Admin\Controller\User;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepository;
use App\Http\Admin\Voter\UserVoter;
use AppoloDev\SFToolboxBundle\Csv\CsvWriter;
use AppoloDev\SFToolboxBundle\Response\CsvFileResponse;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route(path: 'utilisateurs/exporter', name: 'user_export')]
#[IsGranted(UserVoter::EXPORT)]
class ExportUserController extends AbstractController
{
    /**
     * @throws CannotInsertRecord
     * @throws Exception
     */
    public function __invoke(
        Request $request,
        UserRepository $userRepository,
        #[MapQueryParameter] ?string $q,
    ): Response {
        $users = $userRepository
            ->getQB()
            ->querySearch($q)
            ->order('updatedAt', 'DESC')
            ->getResults()
        ;

        $csv = new CsvWriter();
        $csv->setHeaders(['Id', 'Nom', 'Prénom', 'Email']);
        $csv->setRows(array_map(function (User $user) {
            return [
                $user->getId(),
                $user->getLastname(),
                $user->getFirstname(),
                $user->getEmail(),
            ];
        }, $users));

        return new CsvFileResponse($csv->getContent(), (new AsciiSlugger())->slug('Liste des utilisateurs').'.csv');
    }
}
