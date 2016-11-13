<?php

namespace api\modules\chart\models;

use Yii;
use yii\base\Object;
/*HEADER MONTH*/
class FusionChart extends Object
{
    public $caption;
    public $subcaption;
    public $xAxisName;
    public $yAxisName;
    public $palettecolors;
    public $bgColor;               
    public $showBorder;
    public $showCanvasBorder;
    public $usePlotGradientColor;
    public $plotBorderAlpha;
    public $legendBorderAlpha;
    public $legendBgAlpha;
    public $legendShadow;
    public $showHoverEffect;
    public $valueFontColor;
    public $rotateValues;
    public $placeValuesInside;
    public $divlineColor;
    public $divLineIsDashed;
    public $divLineDashLen;
    public $divLineGapLen;
    public $canvasBgColor;
    public $captionFontSize;
    public $subcaptionFontSize;
    public $subcaptionFontBold;

    public $useplotgradientcolor;
    public $showplotborder;
    public $showShadow;
    public $palette;
    public $labelDisplay;

    public function __construct()
    {
        $this->caption              = 'Caption';
        $this->xAxisName            = 'xAxisName';
        $this->yAxisName            = "Jumlah";
        $this->palettecolors        = "#b2d9f9,#f7c018,#94bf13,#ff9049,#069191,#d74a4a,#914b91,#5c882b,#0c93d8";
        $this->bgColor              = "#ffffff";               
        $this->showBorder           = 0;
        $this->showCanvasBorder     = 0;
        $this->usePlotGradientColor = 0;
        $this->plotBorderAlpha      = 10;
        $this->legendBorderAlpha    = 0;
        $this->legendBgAlpha        = 0;
        $this->legendShadow         = 0;
        $this->showHoverEffect      = 1;
        $this->valueFontColor       = "#00000";
        $this->rotateValues         = 1;
        $this->placeValuesInside    = 1;
        $this->divlineColor         = "#999999";
        $this->divLineIsDashed      = 1;
        $this->divLineDashLen       = 1;
        $this->divLineGapLen        = 1;
        $this->canvasBgColor        = "#ffffff";
        $this->captionFontSize      = 14;
        $this->subcaptionFontSize   = 14;
        $this->subcaptionFontBold   = 0;


        $this->useplotgradientcolor = 0;
        $this->showplotborder       = 0;
        $this->showShadow           = 0;
        $this->palette              = 4;

        $this->labelDisplay         = 'auto';
        $this->slantLabels          = 0;
        // $this->subcaption           = 'YYY';
    }

    public function getCaption()
    {
        return $this->caption;
    }
    public function setCaption($caption)
    {
        $this->caption = $caption;
        return $this;    
    }

    public function getSubCaption()
    {
        return $this->subcaption;
    }
    public function setSubCaption($subcaption)
    {
        $this->subcaption = $subcaption;
        return $this;    
    }

    public function getXAxisName()
    {
        return $this->xAxisName;
    }
    public function setXAxisName($xAxisName)
    {
        $this->xAxisName = $xAxisName;
        return $this;    
    }

    public function getYAxisName()
    {
        return $this->yAxisName;
    }
    public function setYAxisName($yAxisName)
    {
        $this->yAxisName = $yAxisName;
        return $this;    
    }

    public function getPalettecolors()
    {
        return $this->palettecolors;
    }
    public function setPalettecolors($palettecolors)
    {
        $this->palettecolors = $palettecolors;
        return $this;    
    }

    public function getBgColor()
    {
        return $this->bgColor;
    }
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;
        return $this;    
    }

    public function getShowBorder()
    {
        return $this->showBorder;
    }
    public function setShowBorder($showBorder)
    {
        $this->showBorder = $showBorder;
        return $this;    
    }

    public function getShowCanvasBorder()
    {
        return $this->showCanvasBorder;
    }
    public function setShowCanvasBorder($showCanvasBorder)
    {
        $this->showCanvasBorder = $showCanvasBorder;
        return $this;    
    }

    public function getUsePlotGradientColor()
    {
        return $this->usePlotGradientColor;
    }
    public function setUsePlotGradientColor($usePlotGradientColor)
    {
        $this->usePlotGradientColor = $usePlotGradientColor;
        return $this;    
    }

    public function getPlotBorderAlpha()
    {
        return $this->plotBorderAlpha;
    }
    public function setPlotBorderAlpha($plotBorderAlpha)
    {
        $this->plotBorderAlpha = $plotBorderAlpha;
        return $this;    
    }

    public function getLegendBorderAlpha()
    {
        return $this->legendBorderAlpha;
    }
    public function setLegendBorderAlpha($legendBorderAlpha)
    {
        $this->legendBorderAlpha = $legendBorderAlpha;
        return $this;    
    }

    public function getLegendBgAlpha()
    {
        return $this->legendBgAlpha;
    }
    public function setLegendBgAlpha($legendBgAlpha)
    {
        $this->legendBgAlpha = $legendBgAlpha;
        return $this;    
    }

    public function getLegendShadow()
    {
        return $this->legendShadow;
    }
    public function setLegendShadow($legendShadow)
    {
        $this->legendShadow = $legendShadow;
        return $this;    
    }

    public function getShowHoverEffect()
    {
        return $this->showHoverEffect;
    }
    public function setShowHoverEffect($showHoverEffect)
    {
        $this->showHoverEffect = $showHoverEffect;
        return $this;    
    }

    public function getValueFontColor()
    {
        return $this->valueFontColor;
    }
    public function setValueFontColor($valueFontColor)
    {
        $this->valueFontColor = $valueFontColor;
        return $this;    
    }

    public function getRotateValues()
    {
        return $this->rotateValues;
    }
    public function setRotateValues($rotateValues)
    {
        $this->rotateValues = $rotateValues;
        return $this;    
    }

    public function getPlaceValuesInside()
    {
        return $this->placeValuesInside;
    }
    public function setPlaceValuesInside($placeValuesInside)
    {
        $this->placeValuesInside = $placeValuesInside;
        return $this;    
    }

    public function getDivlineColor()
    {
        return $this->divlineColor;
    }
    public function setDivlineColor($divlineColor)
    {
        $this->divlineColor = $divlineColor;
        return $this;    
    }

    public function getDivLineIsDashed()
    {
        return $this->divLineIsDashed;
    }
    public function setDivLineIsDashed($divLineIsDashed)
    {
        $this->divLineIsDashed = $divLineIsDashed;
        return $this;    
    }

    public function getDivLineDashLen()
    {
        return $this->divLineDashLen;
    }
    public function setDivLineDashLen($divLineDashLen)
    {
        $this->divLineDashLen = $divLineDashLen;
        return $this;    
    }

    public function getDivLineGapLen()
    {
        return $this->divLineGapLen;
    }
    public function setDivLineGapLen($divLineGapLen)
    {
        $this->divLineGapLen = $divLineGapLen;
        return $this;    
    }

    public function getCanvasBgColor()
    {
        return $this->canvasBgColor;
    }
    public function setCanvasBgColor($canvasBgColor)
    {
        $this->canvasBgColor = $canvasBgColor;
        return $this;    
    }

    public function getCaptionFontSize()
    {
        return $this->captionFontSize;
    }
    public function setCaptionFontSize($captionFontSize)
    {
        $this->captionFontSize = $captionFontSize;
        return $this;    
    }

    public function getSubcaptionFontSize()
    {
        return $this->subcaptionFontSize;
    }
    public function setSubcaptionFontSize($subcaptionFontSize)
    {
        $this->subcaptionFontSize = $subcaptionFontSize;
        return $this;    
    }

    public function getSubcaptionFontBold()
    {
        return $this->subcaptionFontBold;
    }
    public function setSubcaptionFontBold($subcaptionFontBold)
    {
        $this->subcaptionFontBold = $subcaptionFontBold;
        return $this;    
    }

    public function getLabelDisplay()
    {
        return $this->labelDisplay;
    }
    public function setLabelDisplay($labelDisplay)
    {
        $this->labelDisplay = $labelDisplay;
        return $this;    
    }

    public function getSlantLabels()
    {
        return $this->slantLabels;
    }
    public function setSlantLabels($slantLabels)
    {
        $this->slantLabels = $slantLabels;
        return $this;    
    }

}
