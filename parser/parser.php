<?php
require_once 'parser/simple_html_dom.php';
require_once 'parser/helper.php';

const URL_SHIPPING = 'https://www.amazon.it/sp?_encoding=UTF8&seller={SELLER}&t=shipping';

function parseShipping($sellerId) {
    $storeData = ['id' => $sellerId];
    $url = str_replace('{SELLER}', $sellerId, URL_SHIPPING);
    $buffer = loadUrl($url);
    $dom = new simple_html_dom();
    $dom->load($buffer);
    $titleDom = $dom->find('title', 0);
    if ($titleDom) {
        $title = sanitizeShippingTitle($titleDom->plaintext);
        $storeData['name'] = $title;
        $storeData['slug'] = getSlug($title);
        $storeData['link'] = getLink($sellerId);
    }

    $feedbackDom = $dom->find('#seller-feedback-summary', 0);
    if ($feedbackDom) {
        $storeData['feedback'] = $feedbackDom->outertext;
    }

    return $storeData;
}

$mainConfig = [
    'stores' => []
];

$stores = yaml_parse_file('stores.yml', 0);

foreach ($stores['stores'] as $store) {
    $storeData = parseShipping($store);
    $mainConfig['stores'][] = $storeData;
    updateStore($storeData);
}

updateMainConfig($mainConfig);