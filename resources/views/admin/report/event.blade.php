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
                            <button onclick="generatePDF()">Download PDF</button>
                            <h3 class="text-sm text-center">Total Number of Events Per Organization (Bar Chart)</h3>
                            <div class="card shadow-xs border mb-4">
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="chart-event" width="800" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <h3 class="text-sm text-center">Total Events per Venue</h3>
                            <div class="card shadow-xs border mb-4">
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="chart-doughnut" class="chart-canvas" height="300px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="card-body">
                            <h3 class="text-sm text-center">Event/Venue Per Organization (Doughnut Chart)</h3>
                            <div class="card shadow-xs border mb-4">
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="chart-doughnut" class="chart-canvas" height="300px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    {{-- FOR BAR CHART --}}
    <script>
        var ctx = document.getElementById('chart-event').getContext('2d');
        var colors = Array.from({ length: {!! $events->count() !!} }, () => '#' + Math.floor(Math.random() * 16777215).toString(16));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($events->pluck('organization_name')) !!},
                datasets: [{
                    label: 'Number of Events',
                    backgroundColor: colors, // Use the array of colors here
                    data: {!! json_encode($events->pluck('total')) !!},
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1e293b',
                        bodyColor: '#1e293b',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        usePointStyle: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        function generatePDF() {
            var element = document.getElementById('chart-event');
        element.style.width = '800px'; // Set the width of the chart canvas
        element.style.height = '400px'; // Set the height of the chart canvas
        html2pdf().from(element).save();
        
        // Reset chart size after downloading
        element.style.width = '100%';
        element.style.height = '100%';
        }
    </script>

    {{-- FOR DOUGHNUT CHART --}}
    <script>
        var ctx = document.getElementById("chart-doughnut").getContext("2d");
        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: {!! json_encode($venueNames) !!},
                datasets: [{
                    label: "Number of Events",
                    data: {!! json_encode($totalEvents) !!},
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                    },
                    tooltip: {
                        backgroundColor: '#964B00',
                        bodyColor: '#1e293b',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        usePointStyle: true
                    }
                },
                scales: {
                    y: {
                        display: false,
                    },
                    x: {
                        display: false,
                    },
                },
            },
        });
    </script>
</x-app-layout>
