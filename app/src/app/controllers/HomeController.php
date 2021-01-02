<?php


namespace App\Controllers;

use DOMDocument;
use Exception;

/**
 * Class HomeController
 * @package App\Controllers
 */
class HomeController extends Controller
{
    const TEST_XML = 'https://webtest.d0.acom.cloud/test/xml-examples/example-footwearnews.xml';

    /**
     * @throws Exception
     */
    public function index()
    {
        $file = file_get_contents(self::TEST_XML);
        $xml = new DOMDocument();
        $xml->loadXML($file);
        $channel = $xml->getElementsByTagName('channel')[0];
        $csvArray[] = [ "ASIN", "URL", "Amazon Url", "Product Name" ];
        foreach ( $channel->getElementsByTagName("item") as $item ) {
            $csvArray[] = [
                strip_tags($item->getElementsByTagName("productURL")[0]->nodeValue),
                strip_tags($item->getElementsByTagName("link")[0]->nodeValue),
                strip_tags($item->getElementsByTagName("productURL")[0]->nodeValue),
                strip_tags($item->getElementsByTagName("productHeadline")[0]->nodeValue)
            ];
        }

        $fp = fopen(date("Y-m-d").'.csv', 'w');

        foreach ($csvArray as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        echo $this->view->render('index');
    }

}