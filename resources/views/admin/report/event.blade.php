<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">ALL REPORT</h6>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <h3 class="text-sm text-center">Event/Venue Per Organization (Bar Chart)</h3>
                            <div class="card shadow-xs border mb-4">
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="chart-bars" class="chart-canvas" height="300px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <h3 class="text-sm text-center">Event/Venue Per Organization (Line Chart)</h3>
                            <div class="card shadow-xs border mb-4">
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="chart-line" class="chart-canvas" height="300px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <h3 class="text-sm text-center">Event/Venue Per Organization (Doughnut Chart)</h3>
                            <div class="card shadow-xs border mb-4">
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="chart-doughnut" class="chart-canvas" height="300px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- FOR BAR CHART --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data for the bar chart
            var events = {!! json_encode($events) !!}; // Assuming $events contains the event data per organization

            var organizationCounts = {}; // Object to store organization counts

            // Counting events per organization
            events.forEach(function(event) {
                var organization = event.organization;

                // Initialize count to 0 if organization doesn't exist in organizationCounts
                if (!organizationCounts[organization]) {
                    organizationCounts[organization] = 0;
                }

                // Increment count for the organization
                organizationCounts[organization]++;
            });

            // Extracting labels (organization names) and event counts from organizationCounts object
            var labels = Object.keys(organizationCounts);
            var eventCounts = Object.values(organizationCounts);

            var barData = {
                labels: labels,
                datasets: [{
                    label: 'Event Count',
                    data: eventCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            var barOptions = {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            // Render the bar chart
            var ctxBars = document.getElementById('chart-bars').getContext('2d');
            new Chart(ctxBars, {
                type: 'bar',
                data: barData,
                options: barOptions
            });
        });
    </script>
    {{-- FOR LINE CHART --}}

    {{-- FOR DOUGHNUT CHART --}}
    <script>
        var ctx = document.getElementById("chart-doughnut").getContext("2d");

        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: ["EGLD", "ETH", "SOL", "BTC"],
                datasets: [{
                    label: "Wallet",
                    cutout: 40,
                    backgroundColor: ["#c3e1ff", "#add4fc", "#78baff", "#419eff"],
                    data: [450, 200, 100, 220],
                    maxBarThickness: 6
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        bodyColor: '#1e293b',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        usePointStyle: true
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false
                        },
                        ticks: {
                            display: false
                        },
                    },
                },
            },
        });
    </script>
</x-app-layout>
