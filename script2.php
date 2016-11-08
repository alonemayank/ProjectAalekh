<?php

// Script for splitting files into multiple parts based on articles <page> tag

    function processChunk()
    {
         GLOBAL $CHUNKS, $PAYLOAD, $ITEMCOUNT;
         if ('' == $PAYLOAD)
             return;
         $xp = fopen($file = "$CHUNKS.xml", "w");
         fwrite($xp, '<?xml version="1.0"?>'." \n");
             fwrite($xp, "<root>");
                 fwrite($xp, $PAYLOAD);
             fwrite($xp, "</root>");
         fclose($xp);
         echo "Written $file \n";
         $CHUNKS++;
         $PAYLOAD    = '';
         $ITEMCOUNT  = 0;
    }

    function startElement($xml, $tag, $attrs = array())
    {
        GLOBAL $PAYLOAD, $CHUNKS, $ITEMCOUNT, $CHUNKON;
        if (!($CHUNKS||$ITEMCOUNT))
            if ($CHUNKON == strtolower($tag))
                $PAYLOAD = '';
        $PAYLOAD .= "<$tag";
        foreach($attrs as $k => $v)
            $PAYLOAD .= " $k=".'"'.addslashes($v).'"';
        $PAYLOAD .= '>';
    }

    function endElement($xml, $tag)
    {
        GLOBAL $CHUNKON, $ITEMCOUNT, $ITEMLIMIT;
        dataHandler(null, "</$tag>");
        if ($CHUNKON == strtolower($tag))
             if (++$ITEMCOUNT >= $ITEMLIMIT)
                 processChunk();
    }

    function dataHandler($xml, $data)
    {
        GLOBAL $PAYLOAD;
        $PAYLOAD .= $data;
    }

    function defaultHandler($xml, $data)
    {
        // a.k.a. Wild Text Fallback Handler, or WTFHandler for short.
    }


    function CreateXMLParser($CHARSET, $bareXML = false)
    {
            $CURRXML = xml_parser_create($CHARSET);
            xml_parser_set_option( $CURRXML, XML_OPTION_CASE_FOLDING, false);
            xml_parser_set_option( $CURRXML, XML_OPTION_TARGET_ENCODING, $CHARSET);
            xml_set_element_handler($CURRXML, 'startElement', 'endElement');
            xml_set_character_data_handler($CURRXML, 'dataHandler');
            xml_set_default_handler($CURRXML, 'defaultHandler');
            if ($bareXML)
                xml_parse($CURRXML, '<?xml version="1.0"?>', 0);
            return $CURRXML;
    }

     function ChunkXMLBigFile($file, $tag = 'page', $howmany = 1)
    {
         GLOBAL $CHUNKON, $CHUNKS, $ITEMLIMIT;

         // Every chunk only holds $ITEMLIMIT "$CHUNKON" elements at most.
         $CHUNKON   = $tag;
         $ITEMLIMIT = $howmany;

         $xml = CreateXMLParser('UTF-8', false);

         $fp = fopen($file, "r");
         $CHUNKS  = 0;
         while(!feof($fp))
         {
              $chunk = fgets($fp, 10240);
              xml_parse($xml, $chunk, feof($fp));
         }
         xml_parser_free($xml);

         // Now, it is possible that one last chunk is still queued for processing.
         processChunk();
    }

// Supplying the file into function to split into separate files
     
     ChunkXMLBigFile('wiki.xml', 'page', 1);


     ?>