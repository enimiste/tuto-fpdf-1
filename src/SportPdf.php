<?php
/**
 * Created by PhpStorm.
 * User: e.nouni
 * Date: 14/03/2016
 * Time: 10:51
 */

namespace Com\Sport;


use Com\Sport\FeedReader\Contracts\Channel;
use Com\Sport\FeedReader\Contracts\Item;
use Com\Sport\Support\Contracts\SwitcherInterface;
use fpdf\FPDF_EXTENDED;
use Illuminate\Support\Collection;

class SportPdf extends FPDF_EXTENDED
{
    /**
     * @var Channel
     */
    private $channel;

    /*******************************************************************************
     *                               Public methods                                 *
     ******************************************************************************
     * @param Channel $channel
     * @param int $margin
     * @param string $orientation
     * @param string $unit
     * @param string $format
     */
    function __construct(Channel $channel, $margin = 10, $orientation = 'P', $unit = 'mm', $format = 'A4')
    {
        parent::__construct($margin, $orientation, $unit, $format);

        $this->channel = $channel;
    }

    /**
     * @param SwitcherInterface $switcher
     * @return bool
     */
    public function process(SwitcherInterface $switcher = null)
    {
        $channel = $this->channel;
        $this->AddPage();
        $this->_drawChannelImage($channel);
        $this->_drawChannelTitle($channel);
        $this->_drawChannelDescription($channel);
        $this->_drawChannelPubDate($channel);

        $this->_drawHorizontalSeparator();

        $this->SetAutoPageBreak(true, 10);//bottom margin : 10
        $this->SetMargins(10, 10, 10);//left, top and right margin is 10

        $this->_drawItems($channel->getItems(), $switcher);
        return true;
    }

    /**
     * @param Channel $channel
     */
    protected function _drawChannelImage(Channel $channel)
    {
        $this->Image($channel->getImage()->getUrl(), 60, 10, 90, 0, 'png');
        $this->Ln(30);
    }

    /**
     * @param $channel
     */
    protected function _drawChannelTitle(Channel $channel)
    {
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(39, 4, 214);//bleu pres du noire
        $this->Cell(0, 5, ucfirst($channel->getTitle()), 0, 2);
        $this->SetTextColor(0, 0, 0);//noire
    }

    /**
     * @param $channel
     */
    protected function _drawChannelDescription(Channel $channel)
    {
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, $channel->getDescription(), 0, 2);
    }

    /**
     * @param $channel
     */
    protected function _drawChannelPubDate(Channel $channel)
    {
        $this->Cell(35, 10, '', 0, 0);
        $this->SetFont('Arial', 'I', 12);
        $this->SetTextColor(151, 153, 153);//gris
        $this->Cell(0, 10, $channel->getPubDate()->toFormattedDateString(), 0, 1, 'R');
        $this->SetTextColor(0, 0, 0);//noire
    }

    protected function _drawHorizontalSeparator()
    {
        $this->SetDrawColor(119, 119, 120);
        $this->Cell(0, 0, '', 1, 1);//Draw a line
    }

    /**
     * @param array $items
     * @param SwitcherInterface $switcher
     */
    protected function _drawItems(array $items, SwitcherInterface $switcher = null)
    {
        $this->SetTextColor(255, 255, 255);
        $this->SetFillColor(119, 119, 119);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 14);
        $this->SetLineWidth(0.3);
        $this->Cell(45, 8, 'Title', 1, 0, 'C', true);
        $this->Cell(70, 8, 'Description', 1, 0, 'C', true);
        $this->Cell(35, 8, 'PubDate', 1, 0, 'C', true);
        $this->Cell(40, 8, 'Catégories', 1, 0, 'C', true);
        $this->Ln();
        /** @var Item $item */
        foreach ($items as $item) {
            if (!is_null($switcher)) $this->_drawItem($item, $switcher->can());
            else $this->_drawItem($item, false);
            if (!is_null($switcher)) $switcher->step();
        }
    }

    /**
     * @param Item $item
     * @param bool $switch
     */
    protected function _drawItem(Item $item, $switch = false)
    {
        if ($switch) {
            $this->SetTextColor(0, 0, 0);
            $this->SetFillColor(176, 247, 234);
        } else {
            $this->SetTextColor(0, 0, 0);
            $this->SetFillColor(255, 255, 255);
        }
        $this->SetFont('Arial', '', 10);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        $this->Cell(45, 8, substr($item->getTitle(), 0, 22), 1, 0, 'L', true);
        $this->Cell(70, 8, substr($item->getDescription(), 0, 40), 1, 0, 'L', true);
        $this->Cell(35, 8, $item->getPubDate()->toFormattedDateString(), 1, 0, 'C', true);
        $this->Cell(40, 8, substr(implode(', ', $item->getCategories()), 0, 20), 1, 0, 'L', true);
        $this->Ln();
    }


}