<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Frame\Gui;

/**
 *
 *
 * @package    app
 * @subpackage Frame\Gui
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class Content
{
    /**
     * function to load content header
     * @param string $header
     * @param null $button
     * @return string
     */
    public function contentHeader(string $header, $button = null): string
    {
        $result = '<div class="content-header">';
        $result .= '<div class="container-fluid">';
        $result .= '<div class="row col-lg mb-2">';
        $result .= '<div class="col-sm-6">';
        $result .= '<h1 class="text-dark">' . $header . '</h1>';
        $result .= '</div>';
        if (!empty($button)) {
            $result .= '<div class="col-sm-6">';
            $result .= '<div style="float: right">';
            $result .= $button;
            $result .= '</div>';
            $result .= '</div>';
        }
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div>';

        return $result;
    }

    /**
     * function to load content
     * @param $cardContent
     * @param string|null $button
     * @param string $message
     * @return string
     */
    public function content($cardContent, string $message = null, string $button = null): string
    {
        $result = '';
        if (!empty($button)) {
            $result .= $button;
            $result .= '</p>';
        }
        $result .= '<section class="content">';
        $result .= '<div class="container-fluid">';
        $result .= $message;
        $result .= '<div class="row col-lg">';
        $result .= $cardContent;
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</section>';

        return $result;
    }

    /**
     * function to load card header
     * @param string $title
     * @param null $button
     * @return string
     */
    public function cardHeader($title, $button = null): string
    {
        $result = '';
        $result .= '<div class="card-header">';
        $result .= '<h3 class="card-title">' . $title . '</h3>';
        if (!empty($button)) {
            $result .= $button;
        }
        $result .= '</div>';

        return $result;
    }

    /**
     * function to load card
     * @param $header
     * @param $content
     * @return string
     */
    public function card($header, $content): string
    {
        $view = '';
        $view .= '<div class="col-lg">';
        $view .= '<div class="card">';
        $view .= $header;
        $view .= $content;
        $view .= '</div>';
        $view .= '</div>';

        return $view;
    }
}
