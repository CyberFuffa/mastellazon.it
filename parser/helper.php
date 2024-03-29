<?php
const MAIN_CONFIG_FILE = 'public/config.json';
const STORES_BASE_PATH = 'public/stores';
const STORE_CONFIG_FILE = 'config.json';
const STORE_LINK = 'https://www.amazon.it/s?me={SELLER}&tag=';

const PREFIX_SHIPPING_TITLE = 'Profilo del venditore di Amazon.it:';

$contributorsTags = [
    'siddolo-21',
    'fej08-21'
];

function loadUrl($url) {
    return file_get_contents($url);
}

function getContributorsTags() {
    global $contributorsTags;
    return json_encode($contributorsTags);
}

function sanitizeShippingTitle($title) {
    return trim(ucwords(strtolower(str_replace(PREFIX_SHIPPING_TITLE, '', $title))));
}

function getSlug($string) {
    return strtolower(preg_replace('/[^a-z\d]/i', '-', $string));
}

function getLink($sellerId) {
    return str_replace('{SELLER}', $sellerId, STORE_LINK);
}

function updateStore($storeData) {
    $storePath = STORES_BASE_PATH . DIRECTORY_SEPARATOR . $storeData['slug'];
    if (!is_dir($storePath)) {
        mkdir($storePath);
    }

    $storeConfigFile = $storePath . DIRECTORY_SEPARATOR . STORE_CONFIG_FILE;
    file_put_contents($storeConfigFile, json_encode($storeData, JSON_PRETTY_PRINT));
}

function updateMainConfig($mainConfig) {
    file_put_contents(MAIN_CONFIG_FILE, json_encode($mainConfig, JSON_PRETTY_PRINT));
}

function getMainConfig() {
    return json_decode(file_get_contents(MAIN_CONFIG_FILE));
}

function getCurrentStoresId() {
    $currentStores = [];
    $config = getMainConfig();
    foreach ($config->stores as $store) {
        $currentStores[] = $store->id;
    }

    return $currentStores;
}

function getCurrentStoresData($storeId) {
    $config = getMainConfig();
    foreach ($config->stores as $store) {
        if ($store->id == $storeId) {
            return $store;
        }
    }

    return NULL;
}

function makeInitials($name) {
    preg_match_all('#([A-Z]+)#', $name, $capitals);
    if (count($capitals[1]) >= 2) {
        return substr(implode('', $capitals[1]), 0, 1);
    }
    return strtoupper(substr($name, 0, 1));
}

function makeIndex($stores) {
    $index = [];
    foreach($stores as $store) {
        $initial = makeInitials($store->name);
        $index[$initial] = $initial;
    }

    ksort($index);
    
    return $index;
}