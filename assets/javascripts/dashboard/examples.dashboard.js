
(function( $ ) {

	'use strict';

	/*
	Sales Selector
	*/
	$('#salesSelector').themePluginMultiSelect().on('change', function() {
		var rel = $(this).val();
		$('#salesSelectorItems .chart').removeClass('chart-active').addClass('chart-hidden');
		$('#salesSelectorItems .chart[data-sales-rel="' + rel + '"]').addClass('chart-active').removeClass('chart-hidden');
	});

	$('#salesSelector').trigger('change');

	$('#salesSelectorWrapper').addClass('ready');

	/*
	Flot: Sales 1
	*/
	var flotDashSales1 = $.plot('#flotDashSales1', flotDashSales1Data, {
		series: {
			lines: {
				show: true,
				lineWidth: 2
			},
			points: {
				show: true
			},
			shadowSize: 0
		},
		grid: {
			hoverable: true,
			clickable: true,
			borderColor: 'rgba(0,0,0,0.1)',
			borderWidth: 1,
			labelMargin: 15,
			backgroundColor: 'transparent'
		},
		yaxis: {
			min: 0,
			color: 'rgba(0,0,0,0.1)'
		},
		xaxis: {
			mode: 'categories',
			color: 'rgba(0,0,0,0)'
		},
		legend: {
			show: false
		},
		tooltip: true,
		tooltipOpts: {
			content: '%x: %y',
			shifts: {
				x: -30,
				y: 25
			},
			defaultTheme: false
		}
	});

	/*
	Flot: Sales 2
	*/
	var flotDashSales2 = $.plot('#flotDashSales2', flotDashSales2Data, {
		series: {
			lines: {
				show: true,
				lineWidth: 2
			},
			points: {
				show: true
			},
			shadowSize: 0
		},
		grid: {
			hoverable: true,
			clickable: true,
			borderColor: 'rgba(0,0,0,0.1)',
			borderWidth: 1,
			labelMargin: 15,
			backgroundColor: 'transparent'
		},
		yaxis: {
			min: 0,
			color: 'rgba(0,0,0,0.1)'
		},
		xaxis: {
			mode: 'categories',
			color: 'rgba(0,0,0,0)'
		},
		legend: {
			show: false
		},
		tooltip: true,
		tooltipOpts: {
			content: '%x: %y',
			shifts: {
				x: -30,
				y: 25
			},
			defaultTheme: false
		}
	});

	/*
	Liquid Meter
	*/
	$('#meterSales').liquidMeter({
		shape: 'circle',
		color: '#0088cc',
		background: '#F9F9F9',
		fontSize: '24px',
		fontWeight: '600',
		stroke: '#F2F2F2',
		textColor: '#333',
		liquidOpacity: 0.9,
		liquidPalette: ['#333'],
		speed: 3000,
		animate: !$.browser.mobile
	});
	$('#meterSales2').liquidMeter({
		shape: 'circle',
		color: '#0088cc',
		background: '#F9F9F9',
		fontSize: '24px',
		fontWeight: '600',
		stroke: '#F2F2F2',
		textColor: '#333',
		liquidOpacity: 0.9,
		liquidPalette: ['#333'],
		speed: 3000,
		animate: !$.browser.mobile
	});

	}).apply( this, [ jQuery ]);