<?php
/**
 * @param string $string
 * @param string $start
 * @param string $end
 * @return string
 */
function get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0){
        return '';
    }
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;

    return substr($string, $ini, $len);
}

/**
 * @param array $products
 * @return string
 */
function create_output_string($products)
{
    foreach ($products as $key => $product){
        $products[$key] = implode("\t", $product);
    }
    $output = implode("\n", $products);

    return $output;
}

/**
 * Main function
 */
function main()
{
    $lines = file("files/e1.txt", FILE_IGNORE_NEW_LINES);
    $products = [];
    $header = ' ';
    foreach ($lines as $key => $line) {
        if($key == 0)
            $header = $line . "\n";
        if ($key <= 100 && $key != 0) {
            $products[$key] = explode("\t", $line);
        }
    }

    foreach ($products as $key => $product) {
        $html = file_get_contents($product[3]);
        $products[$key]['sku'] = get_string_between($html, 'SKU: <strong>', '</strong>');
    }
    $output = create_output_string($products);
    file_put_contents("files/output.txt", $header.$output);
}

main();
