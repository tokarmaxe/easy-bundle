<?php
declare(strict_types=1);

namespace Maxim\EasyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{
    public function get(): Response
    {
        return $this->json([
            'success' => true,
            'message' => "Easy bundle is working"
        ]);
    }
}