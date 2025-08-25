<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\ArticleRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CustomGetCollectionProvider implements ProviderInterface
{
    public function __construct(
        private ArticleRepository $articleRepository,
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private ProviderInterface $provider
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // return $this->articleRepository->findOneByTitle('Title One');
        $data = $this->provider->provide($operation, $uriVariables, $context);

        foreach ($data as $key => $value) {
            $value->setTitle(mb_strtoupper($value->getTitle()));
        }

        return $data;
    }
}
