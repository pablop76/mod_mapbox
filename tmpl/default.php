<?php
defined('_JEXEC') or die;

$document = $this->app->getDocument();
$wa = $document->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('mod_mapbox');
$wa->useScript('mod_mapbox.custom');
$wa->useScript('mapbox');

$wa->useStyle('mod_mapbox.style');
$wa->useStyle('stylemapbox');

$tokenmapbox = $params->get('tokenmapbox', '');
$stylemapbox = $params->get('stylemapbox', 'mapbox://styles/mapbox/streets-v12');
$longitudemapbox = $params->get('longitudemapbox', '-73,990593');
$latitudemapbox = $params->get('latitudemapbox', '40,740121');
$zoommapbox = $params->get('zoommapbox', '1');
$geotitle = $params->get('geotitle', '');
$geodescription = $params->get('geodescription', '');
$markermapbox = $params->get('markermapbox', '');

$document->addScriptOptions('mod_mapbox.vars', ['tokenmapbox' => $tokenmapbox]);
$document->addScriptOptions('mod_mapbox.vars', ['stylemapbox' => $stylemapbox]);
$document->addScriptOptions('mod_mapbox.vars', ['longitudemapbox' => $longitudemapbox]);
$document->addScriptOptions('mod_mapbox.vars', ['latitudemapbox' => $latitudemapbox]);
$document->addScriptOptions('mod_mapbox.vars', ['zoommapbox' => $zoommapbox]);
$document->addScriptOptions('mod_mapbox.vars', ['geotitle' => $geotitle]);
$document->addScriptOptions('mod_mapbox.vars', ['geodescription' => $geodescription]);
$document->addScriptOptions('mod_mapbox.vars', ['markermapbox' => $markermapbox]);

?>

<div id="map"></div>