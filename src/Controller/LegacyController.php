<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LegacyController extends AbstractController
{
    public function __construct(readonly private ParameterBagInterface $parameterBag)
    {
        require_once "{$this->parameterBag->get('app.legacy_dir')}/__init__.php";
        require_once "{$this->parameterBag->get('app.legacy_dir')}/scripts/functions.php";
    }

    public function getParameterBag(): ParameterBagInterface
    {
        return $this->parameterBag;
    }

    #[Route(path: '/', name: 'legacy_main_index', methods: ['GET'])]
    public function mainIndex(): Response
    {
        $requestPath = '/index.php';
        $legacyScript = "{$this->parameterBag->get('app.legacy_dir')}/index.php";

        $_SERVER['PHP_SELF'] = $requestPath;
        $_SERVER['SCRIPT_NAME'] = $requestPath;
        $_SERVER['SCRIPT_FILENAME'] = $legacyScript;

        chdir(dirname($legacyScript));

        ob_start();
        require $legacyScript;
        $content = ob_get_clean();

        return new Response($content, 200, ['Content-Type' => 'text/html; charset=UTF-8']);
    }

    #[Route(path: '/action.php', name: 'legacy_main_action', methods: ['POST'])]
    public function mainAction(): Response
    {
        $requestPath = '/action.php';
        $legacyScript = "{$this->parameterBag->get('app.legacy_dir')}/action.php";

        $_SERVER['PHP_SELF'] = $requestPath;
        $_SERVER['SCRIPT_NAME'] = $requestPath;
        $_SERVER['SCRIPT_FILENAME'] = $legacyScript;

        chdir(dirname($legacyScript));

        ob_start();
        require $legacyScript;
        $content = ob_get_clean();

        return new Response($content, 200, ['Content-Type' => 'text/html; charset=UTF-8']);
    }
}
