@extends('backend.layouts.dashboard')

@section('main')
<main class="content">
    <div class="container-fluid">

        <div class="header">
            <h1 class="header-title">
                Welcome back, Linda!
            </h1>
            <p class="header-subtitle">You have 24 new messages and 5 new notifications.</p>
        </div>

        <div class="row">
            <div class="col-xl-6 col-xxl-7">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <div class="card-actions float-right">
                            <a href="#" class="mr-1">
                                <i class="align-middle" data-feather="refresh-cw"></i>
                            </a>
                            <div class="d-inline-block dropdown show">
                                <a href="#" data-toggle="dropdown" data-display="static">
                                    <i class="align-middle" data-feather="more-vertical"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Recent Movement</h5>
                    </div>
                    <div class="card-body py-3">
                        <div class="chart chart-sm">
                            <canvas id="chartjs-dashboard-line"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Sales Today</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-dark">
                                                    <i class="align-middle" data-feather="truck"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="display-5 mt-1 mb-3">2.562</h1>
                                    <div class="mb-0">
                                        <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.65% </span> Less sales than usual
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Visitors Today</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-dark">
                                                    <i class="align-middle" data-feather="users"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="display-5 mt-1 mb-3">17.212</h1>
                                    <div class="mb-0">
                                        <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.50% </span> More visitors than usual
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Total Earnings</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-dark">
                                                    <i class="align-middle" data-feather="dollar-sign"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="display-5 mt-1 mb-3">$24.300</h1>
                                    <div class="mb-0">
                                        <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 8.35% </span> More earnings than usual
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Pending Orders</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="avatar">
                                                <div class="avatar-title rounded-circle bg-primary-dark">
                                                    <i class="align-middle" data-feather="shopping-cart"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="display-5 mt-1 mb-3">43</h1>
                                    <div class="mb-0">
                                        <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -4.25% </span> Less orders than usual
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="card-actions float-right">
                            <a href="#" class="mr-1">
                                <i class="align-middle" data-feather="refresh-cw"></i>
                            </a>
                            <div class="d-inline-block dropdown show">
                                <a href="#" data-toggle="dropdown" data-display="static">
                                    <i class="align-middle" data-feather="more-vertical"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Calendar</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="align-self-center w-100">
                            <div class="chart">
                                <div id="datetimepicker-dashboard"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <div class="card-actions float-right">
                            <a href="#" class="mr-1">
                                <i class="align-middle" data-feather="refresh-cw"></i>
                            </a>
                            <div class="d-inline-block dropdown show">
                                <a href="#" data-toggle="dropdown" data-display="static">
                                    <i class="align-middle" data-feather="more-vertical"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Current Visitors</h5>
                    </div>
                    <div class="card-body px-4">
                        <div id="world_map" style="height:350px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <div class="card-actions float-right">
                            <a href="#" class="mr-1">
                                <i class="align-middle" data-feather="refresh-cw"></i>
                            </a>
                            <div class="d-inline-block dropdown show">
                                <a href="#" data-toggle="dropdown" data-display="static">
                                    <i class="align-middle" data-feather="more-vertical"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Browser Usage</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="align-self-center w-100">
                            <div class="py-3">
                                <div class="chart chart-xs">
                                    <canvas id="chartjs-dashboard-pie"></canvas>
                                </div>
                            </div>

                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td><i class="fas fa-circle text-primary fa-fw"></i> Chrome</td>
                                        <td class="text-right">4401</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-circle text-warning fa-fw"></i> Firefox</td>
                                        <td class="text-right">4003</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-circle text-danger fa-fw"></i> IE</td>
                                        <td class="text-right">1589</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8 col-xxl-9 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="card-actions float-right">
                            <a href="#" class="mr-1">
                                <i class="align-middle" data-feather="refresh-cw"></i>
                            </a>
                            <div class="d-inline-block dropdown show">
                                <a href="#" data-toggle="dropdown" data-display="static">
                                    <i class="align-middle" data-feather="more-vertical"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Latest Tasks</h5>
                    </div>
                    <table id="datatables-dashboard-tasks" class="table table-striped my-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="d-none d-xl-table-cell">Start Date</th>
                                <th class="d-none d-xl-table-cell">End Date</th>
                                <th>Status</th>
                                <th class="d-none d-md-table-cell">Assignee</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Task Apollo</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-success">Done</span></td>
                                <td class="d-none d-md-table-cell">Carl Jenkins</td>
                            </tr>
                            <tr>
                                <td>Task Fireball</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-danger">Cancelled</span></td>
                                <td class="d-none d-md-table-cell">Bertha Martin</td>
                            </tr>
                            <tr>
                                <td>Task Hades</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-success">Done</span></td>
                                <td class="d-none d-md-table-cell">Stacie Hall</td>
                            </tr>
                            <tr>
                                <td>Task Nitro</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-warning">In progress</span></td>
                                <td class="d-none d-md-table-cell">Carl Jenkins</td>
                            </tr>
                            <tr>
                                <td>Task Phoenix</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-success">Done</span></td>
                                <td class="d-none d-md-table-cell">Bertha Martin</td>
                            </tr>
                            <tr>
                                <td>Task X</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-success">Done</span></td>
                                <td class="d-none d-md-table-cell">Stacie Hall</td>
                            </tr>
                            <tr>
                                <td>Task Romeo</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-success">Done</span></td>
                                <td class="d-none d-md-table-cell">Ashley Briggs</td>
                            </tr>
                            <tr>
                                <td>Task Wombat</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-warning">In progress</span></td>
                                <td class="d-none d-md-table-cell">Bertha Martin</td>
                            </tr>
                            <tr>
                                <td>Task Zircon</td>
                                <td class="d-none d-xl-table-cell">01/01/2018</td>
                                <td class="d-none d-xl-table-cell">31/06/2018</td>
                                <td><span class="badge badge-danger">Cancelled</span></td>
                                <td class="d-none d-md-table-cell">Stacie Hall</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-xxl-3 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <div class="card-actions float-right">
                            <a href="#" class="mr-1">
                                <i class="align-middle" data-feather="refresh-cw"></i>
                            </a>
                            <div class="d-inline-block dropdown show">
                                <a href="#" data-toggle="dropdown" data-display="static">
                                    <i class="align-middle" data-feather="more-vertical"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Monthly Sales</h5>
                    </div>
                    <div class="card-body d-flex w-100">
                        <div class="align-self-center chart chart-lg">
                            <canvas id="chartjs-dashboard-bar"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
@push('scripts')
<script>
	$(function() {
		// Line chart
		new Chart(document.getElementById("chartjs-dashboard-line"), {
			type: 'line',
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				datasets: [{
						label: "Orders",
						fill: true,
						backgroundColor: window.theme.primary,
						borderColor: window.theme.primary,
						borderWidth: 2,
						data: [3, 2, 3, 5, 6, 5, 4, 6, 9, 10, 8, 9]
					},
					{
						label: "Sales ($)",
						fill: true,
						backgroundColor: "rgba(0, 0, 0, 0.05)",
						borderColor: "rgba(0, 0, 0, 0.05)",
						borderWidth: 2,
						data: [5, 4, 10, 15, 16, 12, 10, 13, 20, 22, 18, 20]
					}
				]
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					display: false
				},
				tooltips: {
					intersect: false
				},
				hover: {
					intersect: true
				},
				plugins: {
					filler: {
						propagate: false
					}
				},
				elements: {
					point: {
						radius: 0
					}
				},
				scales: {
					xAxes: [{
						reverse: true,
						gridLines: {
							color: "rgba(0,0,0,0.0)"
						}
					}],
					yAxes: [{
						ticks: {
							stepSize: 5
						},
						display: true,
						gridLines: {
							color: "rgba(0,0,0,0)",
							fontColor: "#fff"
						}
					}]
				}
			}
		});
	});
</script>
<script>
	$(function() {
		// Pie chart
		new Chart(document.getElementById("chartjs-dashboard-pie"), {
			type: 'pie',
			data: {
				labels: ["Chrome", "Firefox", "IE", "Other"],
				datasets: [{
					data: [4401, 4003, 1589],
					backgroundColor: [
						window.theme.primary,
						window.theme.warning,
						window.theme.danger,
						"#E8EAED"
					],
					borderColor: "transparent"
				}]
			},
			options: {
				responsive: !window.MSInputMethodContext,
				maintainAspectRatio: false,
				legend: {
					display: false
				},
				cutoutPercentage: 75
			}
		});
	});
</script>
<script>
	$(function() {
		// Bar chart
		new Chart(document.getElementById("chartjs-dashboard-bar"), {
			type: 'bar',
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				datasets: [{
					label: "This year",
					backgroundColor: window.theme.primary,
					borderColor: window.theme.primary,
					hoverBackgroundColor: window.theme.primary,
					hoverBorderColor: window.theme.primary,
					data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79]
				}]
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						gridLines: {
							display: false
						},
						stacked: false,
						ticks: {
							stepSize: 20
						}
					}],
					xAxes: [{
						barPercentage: .75,
						platformPercentage: .5,
						stacked: false,
						gridLines: {
							color: "transparent"
						}
					}]
				}
			}
		});
	});
</script>
<script>
	$(function() {
		var mapData = {
			"US": 298,
			"SA": 200,
			"DE": 220,
			"FR": 540,
			"CN": 120,
			"AU": 760,
			"BR": 550,
			"IN": 200,
			"GB": 120,
		};
		$('#world_map').vectorMap({
			map: 'world_mill',
			backgroundColor: "transparent",
			zoomOnScroll: false,
			regionStyle: {
				initial: {
					fill: '#e4e4e4',
					"fill-opacity": 0.9,
					stroke: 'none',
					"stroke-width": 0,
					"stroke-opacity": 0
				}
			},
			series: {
				regions: [{
					values: mapData,
					scale: [window.theme.primary],
					normalizeFunction: 'polynomial'
				}]
			},
		});
		setTimeout(function() {
			$(window).trigger('resize');
		}, 350)
	})
</script>
<script>
	$(function() {
		$('#datatables-dashboard-tasks').DataTable({
			pageLength: 6,
			lengthChange: false,
			bFilter: false,
			autoWidth: false
		});
	});
</script>
<script>
	$(function() {
		$('#datetimepicker-dashboard').datetimepicker({
			inline: true,
			sideBySide: false,
			format: 'L'
		});
	});
</script>
@endpush


