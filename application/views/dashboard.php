<?php if(isset($_SESSION["error"])){?>
    <script>alert("<?=$_SESSION['error']?>")</script>
<?php }?>
<!-- start: page -->
<div class="row">
	<div class="col-md-6 col-lg-12 col-xl-6">
		<section class="panel">
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-8">
						<div class="chart-data-selector" id="salesSelectorWrapper">
							<h2>
								Messages in the last week:
								<strong>
									<select class="form-control" id="salesSelector">
										<option value="JSOFT Admin" selected>Message In</option>
										<option value="JSOFT Drupal" >Message Replied</option>
									</select>
								</strong>
							</h2>

							<div id="salesSelectorItems" class="chart-data-selector-items mt-sm">
								<!-- Flot: Sales JSOFT Admin -->
								<div class="chart chart-sm" data-sales-rel="JSOFT Admin" id="flotDashSales1" class="chart-active"></div>
								<script>

									var flotDashSales1Data = <?= $messageIn?>;

									// See: assets/javascripts/dashboard/examples.dashboard.js for more settings.

								</script>

								<!-- Flot: Sales JSOFT Drupal -->
								<div class="chart chart-sm" data-sales-rel="JSOFT Drupal" id="flotDashSales2" class="chart-hidden"></div>
								<script>

									var flotDashSales2Data = <?= $messageReplied?>;

									// See: assets/javascripts/dashboard/examples.dashboard.js for more settings.

								</script>
							</div>

						</div>
					</div>
					<div class="col-lg-4 text-center">
						<h2 class="panel-title mt-md">Percent Replied Total</h2>
						<div class="liquid-meter-wrapper liquid-meter-sm mt-lg">
							<div class="liquid-meter">
								<meter min="0" max="150" value="<?= $percentReplied?>" id="meterSales"></meter>
							</div>
						</div>
					</div>

					<div class="col-lg-4 text-center">
						<h2 class="panel-title mt-md">Percent Replied Today</h2>
						<div class="liquid-meter-wrapper liquid-meter-sm mt-lg">
							<div class="liquid-meter">
								<meter min="0" max="150" value="<?= $percentRepliedToday?>" id="meterSales2"></meter>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div class="col-md-6 col-lg-12 col-xl-6">
		<div class="row">
			<div class="col-md-12 col-lg-6 col-xl-6">
				<section class="panel panel-featured-left panel-featured-primary">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-primary">
									<i class="fa fa-life-ring"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<h4 class="title">Total Messages</h4>
									<div class="info">
										<strong class="amount"><?= $totalMessage?></strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase">(view all)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-12 col-lg-6 col-xl-6">
				<section class="panel panel-featured-left panel-featured-secondary">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-secondary">
									<i class="fa fa-usd"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<h4 class="title">Total Replied</h4>
									<div class="info">
										<strong class="amount"><?= $totalReplied?></strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase">(view all)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-12 col-lg-6 col-xl-6">
				<section class="panel panel-featured-left panel-featured-tertiary">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-tertiary">
									<i class="fa fa-shopping-cart"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<h4 class="title">Today's Messages</h4>
									<div class="info">
										<strong class="amount"><?= $todayMessage?></strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase">(view all)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-12 col-lg-6 col-xl-6">
				<section class="panel panel-featured-left panel-featured-quartenary">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-quartenary">
									<i class="fa fa-user"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<h4 class="title">Today's Replies</h4>
									<div class="info">
										<strong class="amount"><?= $todayReplied?></strong>
									</div>
								</div>
								<div class="summary-footer">
									<a class="text-muted text-uppercase">(view all)</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>
<!-- end: page -->