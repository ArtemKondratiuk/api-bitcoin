<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

final class CurrencyRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        public EntityManagerInterface $em,
    ) {
        parent::__construct($registry, Currency::class);
    }

    public function save(array $data): void
    {
        foreach ($data as $name => $value) {
            $currency = new Currency();
            $currency->setName($name);
            $currency->setSymbol($value['symbol']);
            $currency->setBuy($value['buy']);
            $currency->setSell($value['sell']);
            $currency->setDate(new \DateTimeImmutable());
            $this->em->persist($currency);
        }

        $this->em->flush();
    }

    public function findByRange(?string $from = null, ?string $to = null): array
    {
        $qb = $this->createQueryBuilder('c');

        if (null !== $from && null !== $to) {
            $qb->andWhere(':from <= c.date AND :to >= c.date')
                ->setParameter('from', $from)
                ->setParameter('to', $to);
        }

        return $qb->getQuery()->getResult();
    }
}
