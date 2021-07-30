<?php
declare(strict_types=1);

namespace App\Controller;

use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ImageController extends AbstractController
{
    #[Route(path: '/image-preview', methods: ['GET'])]
    public function preview(Request $request, FilterManager $filterManager, DataManager $dataManager): Response
    {
        $requestedPath = $request->get('path');
        $requestedSize = (int)(filter_var($request->get('w'), FILTER_SANITIZE_NUMBER_INT) ?? 150);

        $sourceFile = $dataManager->find('preview', $requestedPath);

        $filterConfig = [
            'filters' => [
                'scale' => [
                    'dim' => [$requestedSize, $requestedSize]
                ]
            ]
        ];

        $thumbnail = $filterManager->applyFilter($sourceFile, 'preview', $filterConfig);

        return new Response(content: $thumbnail->getContent(), headers: [
            'Content-Type' => $thumbnail->getMimeType()
        ]);
    }
}
