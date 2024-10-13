<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_mapbox
 *
 * @copyright   (C) 2024 pablop76, Inc. <https://web-service.com.pl>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
use Joomla\CMS\Language\Text;

$document = $this->app->getDocument();
$wa = $document->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('mod_mapbox');
$wa->useScript('mod_mapbox.custom');
$wa->useScript('mapbox');

$wa->useStyle('mod_mapbox.style');
$wa->useStyle('stylemapbox');

$tokenmapbox = $params->get('tokenmapbox', '');
$stylemapbox = $params->get('stylemapbox', 'mapbox://styles/mapbox/streets-v12');
$listofpoints = $params->get('listofpoints', '');
$zoommapbox = $params->get('zoommapbox', '1');
$geotitle = $params->get('geotitle', '');
$geodescription = $params->get('geodescription', '');
$markermapbox = $params->get('markermapbox', '');
$pointslistmapbox = $params->get('pointslistmapbox', '');

$document->addScriptOptions('mod_mapbox.vars', ['tokenmapbox' => $tokenmapbox]);
$document->addScriptOptions('mod_mapbox.vars', ['stylemapbox' => $stylemapbox]);
$document->addScriptOptions('mod_mapbox.vars', ['listofpoints' => $listofpoints]);
$document->addScriptOptions('mod_mapbox.vars', ['zoommapbox' => $zoommapbox]);
$document->addScriptOptions('mod_mapbox.vars', ['geotitle' => $geotitle]);
$document->addScriptOptions('mod_mapbox.vars', ['geodescription' => $geodescription]);
$document->addScriptOptions('mod_mapbox.vars', ['markermapbox' => $markermapbox]);
$document->addScriptOptions('mod_mapbox.vars', ['pointslistmapbox' => $pointslistmapbox]);

?>

<div id="map"></div>
<?php if ($pointslistmapbox) {?>

<div class="table-responsive">
<table class="table table-mapbox table-hover">
  <thead class="table-light">
    <tr>
      <th scope="col"><?php echo Text::_('MOD_MAPBOX_TABLE_ID')?></th>
      <th scope="col"><?php echo Text::_('MOD_MAPBOX_TABLE_TITLE') ?></th>
      <th scope="col"><?php echo Text::_('MOD_MAPBOX_TABLE_DESCRIPTION') ?></th>
      <th scope="col"><?php echo Text::_('MOD_MAPBOX_LONGITUDEMAPBOX') ?></th>
      <th scope="col"><?php echo Text::_('MOD_MAPBOX_LATITUDEMAPBOX') ?></th>
    </tr>
  </thead>
  <tbody>
  <?php
$points = $listofpoints;
for ($i = 0; $i <= count((array)$listofpoints)-1; $i++) {
    $point = $points->{"listofpoints" . $i};?>
    <tr>
      <th scope="row"><?php echo $i+1;?></th>
      <td><?php echo $point->geotitle; ?></td>
      <td><?php echo $point->geodescription; ?></td>
      <td class="longitude"><?php echo $point->longitudemapbox; ?></td>
      <td class="latitude"><?php echo $point->latitudemapbox; ?></td>
    </tr>
    <?php
}?>
  </tbody>
</table>
</div>

<?php
}
?>