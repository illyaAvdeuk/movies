<?php
namespace Models;

use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;

/**
 * Class ImportHelper
 * @package Models
 */
class ImportHelper
{
    /**
     * @param $source
     * @return array
     * @throws Exception
     */
    public function parse($source)
    {
        $objReader = IOFactory::createReader('Word2007');
        $phpWord = $objReader->load($source);

        $data = [];
        foreach ($phpWord->getSections() as $section) {
            $arrays = $section->getElements();
            foreach ($arrays as $e) {
                if (get_class($e) === 'PhpOffice\PhpWord\Element\TextRun') {
                    foreach ($e->getElements() as $text) {
                        if (!empty($text->getText())) {
                            $data[] = $text->getText();
                        }
                    }
                }
            }
        }

        $text = implode(' ', $data);
        $text = str_replace([' :', ' ,', '  '], [':', ',', ' '], $text);
        $text = str_replace(['Title', 'Release  Year', 'Format', 'Stars'], ['|_Title_', '_Release Year_', '_Format_', '_Stars_'], $text);

        /** explode */
        $data = array_filter(explode('|', $text));
        foreach ($data as &$string) {
            $string = array_filter(explode('_', $string));
        }

        /** prepare movies data to array for upload*/
        $parsedMovies = [];
        foreach ($data as $movieOrder => $movie) {
            foreach ($movie as $index => $movieElement) {
                if ($movieElement === 'Title') {
                    $parsedMovies[$movieOrder]['title'] = $this->cleanString(($movie[$index + 1]));
                    unset($movie[$index + 1]);
                } elseif ($movieElement === 'Release Year') {
                    $parsedMovies[$movieOrder]['release_date'] = (int)filter_var($movie[$index + 1], FILTER_SANITIZE_NUMBER_INT);
                    unset($movie[$index + 1]);
                } elseif ($movieElement === 'Format') {
                    $parsedMovies[$movieOrder]['format'] = $this->cleanString(($movie[$index + 1]));
                    unset($movie[$index + 1]);
                } elseif ($movieElement === 'Stars') {
                    $parsedMovies[$movieOrder]['actors'] = $this->cleanString($movie[$index + 1]);
                    unset($movie[$index + 1]);
                }
            }
        }
        return $parsedMovies;
    }

    /**
     * @param string $string
     * @return string
     */
    private function cleanString(string $string) : string
    {
        $result = ltrim(htmlspecialchars_decode((str_replace([', ', '  ', ],[',', ' ', ],trim($string))), ENT_QUOTES),': ');

        /** remove non-printable characters */
        return preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $result);
    }
}