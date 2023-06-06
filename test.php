<?php
const HANDLE = 0;
const TITLE = 1;
const BODY = 2;
const Vendor = 3;
const Published = 4;
const OptionName = 5;
const OptionValue = 6;
const SKU = 7;
const Variant_Grams = 8;
const Variant_Tracker = 9;
const Variant_Qty = 10;
const Variant_Policy = 11;
const Variant_Service = 12;
const Variant_Price = 13;
const Variant_Shipping = 14;
const Variant_Taxable = 15;
const Variant_Barcode = 16;
const SEO_Title = 17;
const SEO_Description = 18;
const Variant_Weight_Unit = 19;
const Deutschland = 20;
const Europaische_Union = 21;
const International = 22;
const Status = 23;


const TARGET_COLUMNS = [
    HANDLE => 'Handle',
    TITLE => 'Title',
    BODY => 'Body (HTML)',
    Vendor => 'Vendor',
    Published => 'Published',
    OptionName => 'Option1 Name',
    OptionValue => 'Option1 Value',
    SKU => 'Variant SKU',
    Variant_Grams => 'Variant Grams',
    Variant_Tracker => 'Variant Inventory Tracker',
    Variant_Qty => 'Variant Inventory Qty',
    Variant_Policy => 'Variant Inventory Policy',
    Variant_Service => 'Variant Fulfillment Service',
    Variant_Price => 'Variant Price',
    Variant_Shipping => 'Variant Requires Shipping',
    Variant_Taxable => 'Variant Taxable',
    Variant_Barcode => 'Variant Barcode',
    SEO_Title => 'SEO Title',
    SEO_Description => 'SEO Description',
    Variant_Weight_Unit => 'Variant Weight Unit',
    Deutschland => 'Included / Deutschland',
    Europaische_Union => 'Included / Europaische Union',
    International => 'Included / International',
    Status => 'Status'
];


$lines = [
    TARGET_COLUMNS
];

const ORIGIN_SKU = 0;
const ORIGIN_NAME = 6;
const ORIGIN_DESCRIPTION = 7;
const ORIGIN_STATUS = 10;
const ORIGIN_PRICE = 13;
const ORIGIN_URL_KEY = 17;
const ORIGIN_SE0_TITLE = 17;
const ORIGIN_SE0_DESCRIPTION = 19;
const ORIGIN_QTY = 47;
CONST ORIGIN_WEIGHT = 9;

//$csvRows = array_map('str_getcsv', file('export_catalog_product_full.csv'));
//unset($csvRows[0]);

$csvFile = file('export_catalog_product_full.csv');
$data = [];
foreach ($csvFile as $line) {
    $data[] = str_getcsv($line);
}



print_r($data[6]);die;

foreach ($csvRows as $index => $row) {
    if ($index > 3) {
        break;
    }
    print_r($row);
    $lines[] = [
        HANDLE => $row[ORIGIN_SKU],
        TITLE => $row[ORIGIN_NAME],
        BODY => $row[ORIGIN_DESCRIPTION],
        Vendor => 'WILKENS',
        Published => 'true',
        OptionName => 'Title',
        OptionValue => 'Default Title',
        SKU => $row[ORIGIN_SKU],
        Variant_Grams => (int)$row[ORIGIN_WEIGHT] * 100,
        Variant_Tracker => 'shopify',
        Variant_Qty => $row[ORIGIN_QTY],
        Variant_Policy => 'continue',
        Variant_Service => 'manual',
        Variant_Price => $row[ORIGIN_PRICE],
        Variant_Shipping => 'true',
        Variant_Taxable => 'true',
        Variant_Barcode => '',
        SEO_Title => $row[ORIGIN_SE0_TITLE],
        SEO_Description => $row[ORIGIN_SE0_DESCRIPTION],
        Variant_Weight_Unit => 'kg',
        Deutschland => 'true',
        Europaische_Union => 'true',
        International => 'true',
        Status => $row[ORIGIN_STATUS] === 1 ? 'active' : 'inactive',
    ];
}

$fp = fopen('product-export.csv', 'w');

foreach ($lines as $line) {
    fputcsv($fp, $line);
}

fclose($fp);
