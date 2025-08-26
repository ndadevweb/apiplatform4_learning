<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\ArticleAuthorResponseDto;
use App\Entity\Article;
use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;

class ArticleAuthorStateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function process(mixed $dtoInput, Operation $operation, array $uriVariables = [], array $context = []): ArticleAuthorResponseDto
    {
        $author = new Author();
        $author->setFirstName($dtoInput->getFirstName());
        $author->setLastName($dtoInput->getLastName());

        $article = new Article();
        $article->setTitle($dtoInput->getTitle());
        $article->setContent($dtoInput->getContent());
        $article->setPublishedAt(new \DateTimeImmutable());
        $article->setAuthor($author);

        $this->entityManager->persist($article);
        $this->entityManager->persist($author);

        $this->entityManager->flush();

        $articleDto = new ArticleAuthorResponseDto();
        $articleDto->setTitle($article->getTitle());
        $articleDto->setAuthor($author->getFirstName().' '.$author->getLastName());

        return $articleDto;
    }
}
