<?php
declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LegacyBridge
{
    public static function prepareLegacyScript(Request $request, Response $response, string $publicDirectory): string
    {
        if (false === $response->isNotFound()) {
            return '';
        }

        $legacyScriptFilename = "$publicDirectory/index-legacy.php";

        return $legacyScriptFilename;
    }
}
