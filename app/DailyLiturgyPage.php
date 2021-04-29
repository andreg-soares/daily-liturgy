<?php

include 'Page.php';

class DailyLiturgyPage extends Page {
    private $finder;
    private $url;

    public function __construct($dia, $mes, $ano) {
        $this->url = 'https://liturgiadiaria.cnbb.org.br/app/user/user/UserView.php?ano='.$ano.'&mes='.$mes.'&dia='.$dia;
        parent::__construct($this->url);
        $this->finder = $this->startFinder();
    }

    private function startFinder() {
        $html = $this->getHTML();
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        return new DomXPath($dom);
    }

    public function getTitle() {
        return HTMLUtils::removeBreak($this->finder->query("//h2")->item(0)->nodeValue);
    }

    public function getUrl() {
        return $this->url;
    }

    public function getColor() {
        $query = "descendant-or-self::*[contains(concat(' ', normalize-space(@class), ' '), ' container ')]/descendant::em";
        return HTMLUtils::colorText($this->finder->query($query)->item(0)->nodeValue);
    }

    public function getReadings() {
        $query = "descendant-or-self::*[@id = 'corpo_leituras']/div";
        $readings = [];
        $readingsDOM = $this->findReadings($query);
        foreach($readingsDOM as $reading)
            $readings[] = (new ReadingBuilder($reading))->generate();

        return $readings;
    }

    private function findReadings($query) {
        $readings = [];

        foreach($this->finder->query($query) as $node)
            $readings[] = $node;

        return $readings;
    }

    public function getTitlesReadingsOptional() {
        $query = "descendant-or-self::*[contains(concat(' ', normalize-space(@class), ' '), ' link_leituras ')]/descendant::*[contains(concat(' ', normalize-space(@class), ' '), ' list-group-item ')]";
        $readingsOptions = [];
        foreach ($this->finder->query($query) as $reading)
            $readingsOptions[] = HTMLUtils::removeBreak($reading->nodeValue);

        return $readingsOptions;
    }
}
