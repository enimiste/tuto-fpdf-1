<?php
/**
 * Created by PhpStorm.
 * User: e.nouni
 * Date: 14/03/2016
 * Time: 10:47
 */

use Com\NickelIT\SportFeedReader\Contracts\ReaderInterface;
use Com\NickelIT\SportFeedReader\DOMFeedReader;
use Com\NickelIT\SportFeedReader\SportPdf;
use Com\NickelIT\Support\IntegerMultSwitcher;

require_once 'vendor/autoload.php';

$sportFeeds = __DIR__ . '/data/sports.xml';

if ( file_exists( $sportFeeds ) ) {
	@unlink( $sportFeeds );
}

file_put_contents( $sportFeeds, file_get_contents( 'http://rss.nytimes.com/services/xml/rss/nyt/Business.xml' ) );

/** @var ReaderInterface $paser */
$paser = new DOMFeedReader();


$channel = $paser->parse( $sportFeeds );

$pdf = new SportPdf( $channel );
$pdf->process( new IntegerMultSwitcher( 2 ) );

$sportPdf = __DIR__ . '/data/sports.pdf';
if ( file_exists( $sportPdf ) ) {
	@unlink( $sportPdf );
}
$pdf->Output( $sportPdf, 'F' );