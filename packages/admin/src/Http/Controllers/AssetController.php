<?php

declare(strict_types=1);

namespace Tinoecom\Http\Controllers;

final class AssetController
{
    public function __invoke(string $file)
    {
        switch ($file) {
            case 'tinoecom.css':
                return $this->pretendResponseIsFile(__DIR__ . '/../../../public/tinoecom.css', 'text/css; charset=utf-8');
            case 'tinoecom.css.map':
                return $this->pretendResponseIsFile(__DIR__ . '/../../../public/tinoecom.css.map', 'text/css; charset=utf-8');
            case 'tinoecom.js':
                return $this->pretendResponseIsFile(__DIR__ . '/../../../public/tinoecom.js', 'application/javascript; charset=utf-8');
            case 'tinoecom.js.map':
                return $this->pretendResponseIsFile(__DIR__ . '/../../../public/tinoecom.js.map', 'application/json; charset=utf-8');
        }

        abort(404);
    }

    protected function getHttpDate(int $timestamp)
    {
        return sprintf('%s GMT', gmdate('D, d M Y H:i:s', $timestamp));
    }

    protected function pretendResponseIsFile(string $path, string $contentType)
    {
        abort_unless(
            file_exists($path) || file_exists($path = base_path($path)),
            404,
        );

        $cacheControl = 'public, max-age=31536000';
        $expires = strtotime('+1 year');

        $lastModified = filemtime($path);

        if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? '') === $lastModified) {
            return response()->noContent(304, [
                'Expires' => $this->getHttpDate($expires),
                'Cache-Control' => $cacheControl,
            ]);
        }

        return response()->file($path, [
            'Content-Type' => $contentType,
            'Expires' => $this->getHttpDate($expires),
            'Cache-Control' => $cacheControl,
            'Last-Modified' => $this->getHttpDate($lastModified),
        ]);
    }
}
