<?php

declare(strict_types=1);

namespace MageSuite\Changelog\Config\Changelog;

class Converter implements \Magento\Framework\Config\ConverterInterface
{

    /**
     * Convert dom node tree to array
     *
     * @param \DOMDocument $source
     * @return array
     */
    public function convert($source): array
    {
        $output = [];
        $xpath = new \DOMXPath($source);
        $nodes = $xpath->evaluate('/config/module');

        /** @var $node \DOMNode */
        foreach ($nodes as $node) {
            $nodeId = $node->getAttribute('id');

            $data = [];
            $data['id'] = $nodeId;
            $data['description'] = $node->getAttribute('description');
            $data['url'] = $node->getAttribute('url');

            $data['tags'] = [];

            foreach ($node->childNodes as $childNode) {
                if ($childNode->nodeType != XML_ELEMENT_NODE) {
                    continue;
                }

                foreach($childNode->childNodes as $tagNode){
                    if ($tagNode->nodeType != XML_ELEMENT_NODE) {
                        continue;
                    }
                    $tag = [];
                    $tag['version'] = $tagNode->getAttribute('version');
                    $tag['date'] = $tagNode->getAttribute('date');

                    $changes = [];
                    foreach($tagNode->childNodes as $changeNode){

                        if ($changeNode->nodeType != XML_ELEMENT_NODE) {
                            continue;
                        }

                        foreach($changeNode->childNodes as $changeDetails){
                            if ($changeDetails->nodeType != XML_ELEMENT_NODE) {
                                continue;
                            }

                            $changes[$changeDetails->nodeName] = $changeDetails->nodeValue;
                        }

                        $tag['changes'][] = $changes;
                        $changes = [];
                    }

                    $data['tags'][] = $tag;
                }
            }

            $output['module'][$nodeId] = $data;
        }

        return $output;
    }
}

