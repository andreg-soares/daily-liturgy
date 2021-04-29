<?php

class DailyLiturgy
{
    private $page;
    private $day;
    private $month;
    private $year;
    private $readingsDay;
    private $readingsOptional;

    public function __construct($day, $month, $year)
    {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->page = new DailyLiturgyPage($this->day, $this->month, $this->year);
        $this->initializeReadings();
    }

    private function initializeReadings()
    {
        $readings = $this->page->getReadings();
        $titlesReadingsOptional = $this->page->getTitlesReadingsOptional();

        $this->readingsDay = [];
        $this->readingsOptional = [];

        foreach ($readings as $reading) {
            if ($this->isReadingFacultative($reading, $titlesReadingsOptional)) {
                $this->readingsOptional[] = $reading;
            } else {
                $this->readingsDay[] = $reading;
            }
        }
    }

    private function isReadingFacultative(Reading $reading, $titlesReadingsFacultative)
    {
        $title = HTMLUtils::removeBreak($reading->getTitle()->nodeValue);
        return in_array($title, $titlesReadingsFacultative);
    }

    public function getReadingsDay()
    {
        return $this->readingsDay;
    }

    public function getReadingsOptional()
    {
        return $this->readingsOptional;
    }

    public function toArray()
    {
        if(is_null($this->page->getTitle())){
            return false;
        }
        return array(
            'title' => $this->page->getTitle(),
            'color_text' => $this->page->getColor(),
            'color' => HTMLUtils::color($this->page->getColor()),
            'date' => [
                'day' => $this->day,
                'month' => $this->month,
                'year' => $this->year,
            ],
            'readings_day_titles' => $this->generateArrayTitlesReadings($this->getReadingsDay()),
            'readings_day' => $this->generateArrayReadings($this->getReadingsDay()),

            'readings_day_optional_titles' => $this->generateArrayTitlesReadings($this->getReadingsOptional()),
            'readings_day_optional' => $this->generateArrayReadings($this->getReadingsOptional()),
            'reference' => $this->page->getUrl(),
            'author' => [
                'name'=> 'André Soares',
                'email'=> 'andreg.soares.dev@gmail.com'
            ]
        );
    }

    private function generateArrayReadings($readings)
    {
        $values = [];
        foreach ($readings as $reading) {
            $array = $reading->toArray();
            $values[] = [
                "title" => preg_replace('/<[^>]*>/', '', $array["title"]),
                "text" => preg_replace('/<[^>]*>/', '', $array["text"]),
            ];
        }
        return $values;
    }

    private function generateArrayTitlesReadings($readings)
    {
        $values = [];
        foreach ($readings as $reading) {
            $array = $reading->toArray();
            $values[] = preg_replace('/<[^>]*>/', '', $array["title"]);
        }
        return $values;
    }

}
