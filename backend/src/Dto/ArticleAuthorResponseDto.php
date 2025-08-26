<?php

namespace App\Dto;

class ArticleAuthorResponseDto
{
    private ?string $title = null;

    private ?string $author = null;

    public function __construct()
    {
        
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): static
    {
        $this->author = $author;

        return $this;
    }
}