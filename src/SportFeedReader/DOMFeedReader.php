<?php
/**
 * Created by PhpStorm.
 * User: e.nouni
 * Date: 14/03/2016
 * Time: 11:25
 */

namespace Com\NickelIT\SportFeedReader;


use Carbon\Carbon;
use Com\NickelIT\SportFeedReader\Contracts\Categorie;
use Com\NickelIT\SportFeedReader\Contracts\Channel;
use Com\NickelIT\SportFeedReader\Contracts\Image;
use Com\NickelIT\SportFeedReader\Contracts\Item;
use Com\NickelIT\SportFeedReader\Contracts\ReaderInterface;

class DOMFeedReader implements ReaderInterface
{

    /**
     * @param string $path
     * @return Channel
     */
    function parse($path)
    {
        $xml = new \DOMDocument();
        $xml->load($path);
        /** @var \DOMNode $xmlChannel */
        $xmlChannel = $xml->getElementsByTagName('channel')->item(0);

        $channel = new Channel(
            $xmlChannel->getElementsByTagName('title')->item(0)->textContent,
            $xmlChannel->getElementsByTagName('description')->item(0)->textContent,
            Carbon::parse($xmlChannel->getElementsByTagName('pubDate')->item(0)->textContent)
        );

        $xmlImage = $xmlChannel->getElementsByTagName('image')->item(0);
        $channel->setImage(new Image(
            $xmlImage->getElementsByTagName('title')->item(0)->textContent,
            $xmlImage->getElementsByTagName('url')->item(0)->textContent
        ));

        $items = $xmlChannel->getElementsByTagName('item');

        foreach ($items as $xmlItem) {
            $item = new Item(
                $xmlItem->getElementsByTagName('title')->item(0)->textContent,
                $xmlItem->getElementsByTagName('description')->item(0)->textContent,
                Carbon::parse($xmlItem->getElementsByTagName('pubDate')->item(0)->textContent)
            );
            $item->addCategorie(new Categorie(
                $xmlItem->getElementsByTagName('category')->item(0)->textContent
            ));
            $channel->addItem($item);

        }

        return $channel;
    }
}