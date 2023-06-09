<?php


namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\PasswordHasher\Hasher\PlaintextPasswordHasher;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

  class EasyAdminSubscriber implements EventSubscriberInterface
  {

      private $entityManager;
      private $passwordEncoder;

      public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder)
      {
          $this->entityManager = $entityManager;
          $this->passwordEncoder = $passwordEncoder;
      }

      public static function getSubscribedEvents()
      {
          return [
              BeforeEntityPersistedEvent::class => ['addUser'],
              //BeforeEntityUpdatedEvent::class => ['updateUser'], //surtout utile lors d'un reset de mot passe plutôt qu'un réel update, car l'update va de nouveau encrypter le mot de passe DEJA encrypté ...
          ];
      }

      public function updateUser(BeforeEntityUpdatedEvent $event)
      {
          $entity = $event->getEntityInstance();

          if (!($entity instanceof User)) return;
          $entity->setUpdatedAt(new \DateTimeImmutable);

          //$this->setPassword($entity);
      }

      public function addUser(BeforeEntityPersistedEvent $event)
      {
          
        
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) return;

        $entity->setCreatedAt(new \DateTimeImmutable);

        $this->setPassword($entity);
      }

      /**
       * @param User $entity
       */
      public function setPassword(User $entity): void
      {
          $pass = $entity->getPassword();

          $entity->setPassword(
              $this->passwordEncoder->hashPassword(
                  $entity,
                  $pass
              )
          );
          $this->entityManager->persist($entity);
          $this->entityManager->flush();
      }

  }