<?php

function __autoload($class)
{
    $library = 'libraries/' . $class . '.php';
    if (file_exists($library)) {
        include $library;
        return;
    }

    foreach (scan('modules/') as $folder) {
        if (substr($folder, 0, 1) == '.') {
            continue;
        }

        if (file_exists('modules/' . $folder . '/' . $class . '.php')) {
            include_once('modules/' . $folder . '/' . $class . '.php');
        }
    }
}

function scan($strFolder)
{
    global $arrScanCache;

    // Add trailing slash
    if (substr($strFolder, -1, 1) != '/') {
        $strFolder .= '/';
    }

    // Load from cache
    if (isset($arrScanCache[$strFolder])) {
        return $arrScanCache[$strFolder];
    }

    $arrReturn = array();

    // Scan directory
    foreach (scandir($strFolder) as $strFile) {
        if ($strFile == '.' || $strFile == '..') {
            continue;
        }

        $arrReturn[] = $strFile;
    }

    $arrScanCache[$strFolder] = $arrReturn;

    return $arrReturn;
}