<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{

    /** @var HttpClient\HttpClient $httpClient the http client instance to fetch data from the api */
    private $httpClient;
    /** @var Serializer\SerializerInterface $serializer the serializer instance to deserialize the json data from the api */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->httpClient = HttpClient::create();
        $this->serializer = $serializer;
    }

    public function findAll(): array
    {
        $response = $this->httpClient->request('GET', 'https://fakestoreapi.com/products');
        $data = $response->getContent();
        return $this->serializer->deserialize($data, Product::class.'[]', 'json');
    }

    public function findById(int $id): ?Product
    {
        $response = $this->httpClient->request('GET', "https://fakestoreapi.com/products/{$id}");
        $data = $response->getContent();
        return $this->serializer->deserialize($data, Product::class, 'json');
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
