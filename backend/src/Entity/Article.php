<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[Get()]
// #[GetCollection(
//     paginationItemsPerPage: 20,
//     paginationClientEnabled: true,
//     paginationClientItemsPerPage: true,
//     uriTemplate: '/articles-collection-simple',
//     name: 'collectionSimple'
// )]
// #[GetCollection(
//     paginationItemsPerPage: 20,
//     paginationClientEnabled: true,
//     paginationClientItemsPerPage: true,
//     uriTemplate: '/articles-collection-special',
//     name: 'collectionSpecial'
// )]
#[GetCollection(
    normalizationContext: ['groups' => ['read']]
)]
#[Post(
    denormalizationContext: ['groups' => ['write']],
    normalizationContext: ['groups' => ['read']]
)]
#[Put()]
#[Patch()]
#[Delete()]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'The title should not be empty')]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'The title should be at least 3 characters',
        maxMessage: 'The title cannot be longer 100 characters'
    )]
    #[Groups(['read', 'write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'The "content" should not be empty')]
    #[Groups(['read', 'write'])]
    private ?string $content = null;

    #[ORM\Column]
    #[Groups(['write'])]
    private ?\DateTimeImmutable $publishedAt = null;

    #[ORM\ManyToOne(inversedBy: 'article')]
    #[Groups(['read', 'write'])]
    private ?Author $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }
}
