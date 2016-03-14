<?php
/**
 * Created by PhpStorm.
 * User: e.nouni
 * Date: 14/03/2016
 * Time: 11:03
 */

namespace Com\NickelIT\SportFeedReader\Contracts;


interface ReaderInterface
{

    /**
     * @param string $path
     * @return Channel
     */
    function parse($path);
}