<?php
/** @noinspection PhpUnused */

namespace lpagedev\Helpers;

use Slim\Psr7\Response;

class SlimRouteHelper
{
    /**
     * @param Response $pResponse
     * @param string $pURL
     * @param int $pStatusCode
     *
     * @return Response
     */
    public static function Redirect(Response $pResponse, string $pURL, int $pStatusCode = 303): Response
    {
        $pResponse = $pResponse->withHeader('Location', $pURL);
        return $pResponse->withStatus($pStatusCode);
    }

    /**
     * @param Response $pResponse
     * @param mixed $pData
     * @param int $pStatusCode
     * @param bool $encode
     *
     * @return Response
     */
    public static function JsonResponse(Response $pResponse, mixed $pData, int $pStatusCode = 200, bool $encode = true): Response
    {
        $pResponse = $pResponse->withHeader('Content-Type', 'application/json');
        $data = (!is_string($pData) || $encode) ? json_encode($pData) : $pData;
        $pResponse->getBody()->write($data);
        return $pResponse->withStatus($pStatusCode);
    }

    /**
     * @param Response $pResponse
     * @param string $pFile
     * @param string $pFileName
     * @param string $pMimeType
     * @param int $pStatusCode
     *
     * @return Response
     */
    public static function FileResponse(Response $pResponse, string $pFile, string $pFileName = "file.txt", string $pMimeType = "text/text", int $pStatusCode = 200): Response
    {
        $data = file_get_contents($pFile);
        $pResponse = $pResponse->withHeader('Content-Type', $pMimeType);
        $pResponse = $pResponse->withHeader('Content-Disposition', 'attachment;filename="' . $pFileName . '"');
        $pResponse = $pResponse->withHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
        $pResponse = $pResponse->withHeader('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT');
        $pResponse = $pResponse->withHeader('Cache-Control', 'no-cache, must-revalidate, max-age=1');
        $pResponse = $pResponse->withHeader('Pragma', 'public');
        $pResponse->getBody()->write($data);
        return $pResponse->withStatus($pStatusCode);
    }
}
