<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_articles
 *
 * @copyright   (C) 2024 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */

$inline = "
jQuery(document).ready(function(){
    jQuery('.carousel-slick > :first-child').slick({
        infinite: true,
        dots: true,
        arrows: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
});
";

$inlineStyle = "
.slick-prev:before {
  color: gray;
}
.slick-next:before {
  color: gray;
}
.carousel-slick {
  figure {
    display: flex;
    justify-content: center;
  }
  h1, h2, h3, h4, h5, h6 {
    text-align: center;
  }
}
";

$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('mod_articles', 'mod_articles/mod-articles.css')
    ->registerAndUseStyle('mod_carousel-slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css')
    ->registerAndUseStyle('mod_carousel-slich-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css')
    ->registerAndUseScript('mod_carousel-slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js')
    ->addInlineScript($inline)
    ->addInlineStyle($inlineStyle);

if (!$list) {
    return;
}

$groupHeading = 'h4';

if ((bool) $module->showtitle) {
    $modTitle = $params->get('header_tag');

    if ($modTitle == 'h1') {
        $groupHeading = 'h2';
    } elseif ($modTitle == 'h2') {
        $groupHeading = 'h3';
    }
}

$layoutSuffix = $params->get('title_only', 0) ? '_titles' : '_items';
$pathLayoutModule = ModuleHelper::getLayoutPath('mod_articles', $params->get('layout', 'default') . $layoutSuffix);

?>
<?php if ($grouped) : ?>
    <?php foreach ($list as $groupName => $items) : ?>
        <div class="mod-articles-group">
            <<?php echo $groupHeading; ?>><?php echo Text::_($groupName); ?></<?php echo $groupHeading; ?>>
            <?php require $pathLayoutModule; ?>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <div class="carousel-slick">
        <?php $items = $list; ?>
        <?php require $pathLayoutModule; ?>
    </div>
<?php endif;
