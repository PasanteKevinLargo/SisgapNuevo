<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Prewk\XmlStringStreamer;
use Prewk\XmlStringStreamer\Stream;
use Prewk\XmlStringStreamer\Parser;

class PdfController extends Controller
{
    public function PdfReader(){
        // Prepare our stream to be read with a 1kb buffer
        //$stream = new Stream\File("3108202001179003333300110010010000000170000001711.xml", 10024);
        $streamer = XmlStringStreamer::createStringWalkerParser("3108202001179003333300110010010000000170000001711.xml");
        $node='<estado>';
        while ($node = $streamer->getNode()) {
            // $node will be a string like this: "<customer><firstName>Jane</firstName><lastName>Doe</lastName></customer>"
            $simpleXmlNode = simplexml_load_string($node);
            return $simpleXmlNode->estado;
        }
    }
}
