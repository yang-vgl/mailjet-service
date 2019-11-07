<?php

namespace App\Contracts;

interface LogContract
{

    public function doTrackEvent($category, $action, $name = false, $value = false);

    public function sendRequest($url, $method = 'GET', $data = null, $force = false);

    public function doTrackContentImpression($contentName, $contentPiece = 'Unknown', $contentTarget = false);

}
