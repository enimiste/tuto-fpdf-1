<?php
/**
 * Created by PhpStorm.
 * User: e.nouni
 * Date: 14/03/2016
 * Time: 11:03
 */

namespace Com\Sport\FeedReader\Contracts;


use Carbon\Carbon;
use Illuminate\Support\Collection;

class Item
{

    /** @var  string */
    protected $title;
    /** @var  string */
    protected $description;
    /** @var  Carbon */
    protected $pubDate;
    /** @var  Collection of Categorie */
    protected $categories;

    /**
     * Item constructor.
     * @param string $title
     * @param string $description
     * @param Carbon $pubDate
     */
    public function __construct($title, $description, Carbon $pubDate)
    {
        $this->title = $title;
        $this->description = $description;
        $this->pubDate = $pubDate;

        $this->categories = new Collection();
    }

    /**
     * @return Categorie[]
     */
    public function getCategories()
    {
        return $this->categories->toArray();
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Carbon
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * @param Carbon $pubDate
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param Categorie $categorie
     * @return Item
     */
    public function addCategorie(Categorie $categorie)
    {
        $this->categories->push($categorie);

        return $this;
    }


}