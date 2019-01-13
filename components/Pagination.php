<?php

/**
 * Class Pagination
 */
class Pagination
{
    /**
     * Max count of navigate links.
     * @var int
     */
    private $max = 10;

    /**
     * Parameter for page number.
     * @var string
     */
    private $index = 'page';

    /**
     * @var int
     */
    private $current_page;

    /**
     * Total amount records.
     * @var int
     */
    private $total;

    /**
     * Records per page.
     * @var int
     */
    private $limit;

    /**
     * Total amount of pages.
     * @var int
     */
    private $amount;

    /**
     * Current sort parameter.
     * @var string
     */
    private $sort;

    /**
     * Pagination constructor.
     * @param $total int
     * @param $currentPage int
     * @param $limit int
     * @param $index int
     * @param $sort string
     */
    public function __construct($total, $currentPage, $limit, $index, $sort)
    {
        $this->total = $total;
        $this->limit = $limit;
        $this->index = $index;
        $this->amount = $this->amount();
        $this->sort = $sort;
        $this->setCurrentPage($currentPage);
    }

    /**
     * Get html pagination.
     * @return string
     */
    public function get()
    {
        $links = null;
        $limits = $this->limits();
        $html = '';

        if ($limits[0] == $limits[1]) {
            return $html;
        }

        $html .= '<ul class="pagination">';
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            if ($page == $this->current_page) {
                $links .= '<li '
                            . 'class="page-item active disabled">'
                            . '<a class="page-link" href="#">'
                            . $page
                            . '</a>'
                            . '</li>';
            } else {
                $links .= $this->generateHtml($page);
            }
        }

        if (!is_null($links)) {
            $links = $this->generateHtml(1, '&laquo;') . $links;
            $links .= $this->generateHtml($this->amount, '&raquo;');
        }

        $html .= $links . '</ul>';
        return $html;
    }

    /**
     * @param $page
     * @param null $text
     * @return string
     */
    private function generateHtml(int $page, $text = null)
    {
        $style = 'style = "color: black;" ';
        $classLI = 'class = "page-item" ';
        $classA = 'class="page-link" ';

        $text = (!is_null($text)) ? $text : $page;

        if ($page == 1 && $this->current_page == 1) {
            $style = '';
            $classLI = 'class = "page-item disabled" ';
        }

        if ($page == $this->amount && $this->current_page == $this->amount) {
            $style = '';
            $classLI = 'class = "page-item disabled" ';
        }

        $currentURI = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
        $currentURI = preg_replace('~/page=[0-9]+~', '', $currentURI);


        if (!empty($this->sort)) {
            $href = ' href="' . $currentURI . $this->index . $page . '"';
        } else {
            $href = ' href="' . $currentURI . "sort=''/" . $this->index . $page . '"';
        }

        return '<li ' . $classLI . '>'
                . '<a' . $href . $classA . $style . '>'
                . $text
                . '</a>'
                . '</li>';
    }

    /**
     * @return array
     */
    private function limits()
    {
        $left = $this->current_page - round($this->max / 2, 0, PHP_ROUND_HALF_DOWN);
        $start = $left > 0 ? $left : 1;

        if ($start + $this->max <= $this->amount) {
            $end = $start > 1 ? $start + $this->max : $this->max;
        } else {
            $end = $this->amount;
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }

        return array($start, $end);
    }

    /**
     * Set current page.
     * @param $currentPage
     */
    private function setCurrentPage(int $currentPage)
    {
        $this->current_page = $currentPage;

        if ($this->current_page > 0) {
            if ($this->current_page > $this->amount) {
                $this->current_page = $this->amount;
            }
        } else {
            $this->current_page = 1;
        }
    }

    /**
     * @return int
     */
    private function amount()
    {
        return ceil($this->total / $this->limit);
    }

}
