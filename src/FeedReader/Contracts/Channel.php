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

class Channel
{

    /** @var  string */
    protected $title;
    /** @var  string */
    protected $description;
    /** @var  Carbon */
    protected $pubDate;
    /** @var  Image */
    protected $image;
    /** @var  Collection of Item object */
    protected $items;

    /**
     * Channel constructor.
     * @param string $title
     * @param string $description
     * @param Carbon $pubDate
     */
    public function __construct($title, $description, Carbon $pubDate)
    {
        $this->title = $title;
        $this->description = $description;
        $this->pubDate = $pubDate;

        $this->items = new Collection();
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
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items->toArray();
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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
     * @param Item $item
     * @return Channel
     */
    public function addItem(Item $item){
        $this->items->push($item);

        return $this;
    }

}