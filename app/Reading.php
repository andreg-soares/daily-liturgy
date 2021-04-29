<?php

/**
 * Algo que pode ser lido
 */
class Reading {
    private $title;
    private $text;

    public function __construct(DOMElement $title, DOMElement $text) {
        $this->title = $title;
        $this->text = $text;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getText() {
        return $this->text;
    }

    public function toArray() {
        return array(
            'title'=> HTMLUtils::removeBreak($this->title->nodeValue),
            'text' => HTMLUtils::DOMinnerHTML($this->text)
        );
    }
}