<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\ArticleAuthorResponseDto;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ArticleAuthorStateProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $provider
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $data = $this->provider->provide($operation, $uriVariables, $context);
        $response = [];

        foreach ($data as $key => $value) {
            $article = new ArticleAuthorResponseDto();
            $article->setTitle($value->getTitle());
            $author = $value->getAuthor();

            if ($author) {
                $article->setAuthor(
                    $author->getFirstName().' '.$author->getLastName()
                );
            }
            else {
                $article->setAuthor(null);
            }

            $response[] = $article;
        }

        return $response;
    }
}
