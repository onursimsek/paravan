<?php

namespace Paravan\RequestBuilder;

trait XmlBuilder
{
    /**
     * @param \SimpleXMLElement $document
     * @param $data
     * @return \SimpleXMLElement
     */
    private function array2Xml(\SimpleXMLElement $document, $data): \SimpleXMLElement
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $child = $document->addChild($key);
                $this->array2Xml($child, $value);
            } else {
                $document->addChild($key, $value);
            }
        }

        return $document;
    }
}