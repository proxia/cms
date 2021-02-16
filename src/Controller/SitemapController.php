<?php
declare(strict_types=1);

namespace App\Controller;

use App\Sitemap\Sitemap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SitemapController extends AbstractController
{
    public function __construct()
    {
        require_once(__DIR__ . '/../../public/__init__.php');
    }

    /**
     * @Route("/sitemap/save", methods={"POST"})
     */
    public function save(): Response
    {
        $siteMap = new Sitemap();
        $siteMap->clear();

        foreach ($_POST['row_id'] as $name) {
            list($entity, $id) = explode(":", $name);
            $object = new $entity($id);

            $siteMap->addItem($object);
        }

        return $this->redirect('/?module=CMS_Sitemap&mcmd=1&msg=1');
    }
}
