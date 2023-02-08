<?php
declare(strict_types=1);

namespace Maxim\EasyBundle\Controller;

use Maxim\EasyBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAction(): Response
    {
        $abc = $this->postRepository->find(1);
        return $this->json([
            'id' => $abc->getId(),
            'title' => $abc->getTitle()
        ]);
    }
}