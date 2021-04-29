<?php


class ReadingBuilder {

    private $reading;

    public function __construct(DOMElement $reading) {
        $this->reading = $reading;
    }

    public function generate() {
        return new Reading($this->title(), $this->text());
    }

    private function title() {
        return $this->reading->getElementsByTagName("h3")->item(0);
    }

    private function text() {
        return $this->reading->childNodes->item(5);
    }
}