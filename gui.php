<?php
	require __DIR__ . '/vendor/autoload.php';
?>
<script type="text/javascript" src="<?php echo jsPath('amcharts.js') ?>"></script>

<?php

	use AmCharts\Chart;
	use AmCharts\Graph;
	use AmCharts\Manager as ChartManager;
	

	$logger = new Logger();
	$logger->buildXMLFile();

	$manager = ChartManager::getInstance();
	$manager->setAmChartsPath('./amcharts.js')->setImagesPath('./images/');
	$serial = new Chart\Serial();

	$dataProvider = Chart\DataProvider\Factory::fromFile(__DIR__ . '/data.xml');
	$serial->setDataProvider($dataProvider);
	$serial->setCategoryField('coin')->setStartDuration(1);
	$serial->categoryAxis()->setGridPosition('start')->setLabelRotation(90);
	$graph = new Graph\Column();
	$graph->fields()->setValueField('gain');
	$graph->setFillAlphas(80)->setLineAlpha(0)->setBalloonText('[[category]]: [[value]]');
	$serial->addGraph($graph);
	echo $serial->render();


	echo "<br />";
	echo number_format($logger->getTotal(),8);
