<?php
namespace App\Application;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserApp
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $userRepo
     */
   public function __construct(
       UserPasswordEncoderInterface $passwordEncoder,
       UserRepository $userRepo
   ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepo = $userRepo;
   }

    /**
     * @param User $user
     * @throws ORMException
     * @throws OptimisticLockException
     */
   public function registrationUser(User $user):void
   {
       $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
       $user->setPassword($password);
       $user->clearPlainPassword();

       $this->userRepo->saveUser($user);
   }
}
