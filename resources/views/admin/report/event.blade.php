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
                            {{-- <button onclick="generatePDF()">Download PDF</button>
                            <a href="{{ route('userCountTable') }}">Download Users</a> --}}
                            <button>
                                <a href="{{ route('TotalNumberOfEventsPerOrganization') }}" target="_blank">Show PDF
                                </a></button>
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
                            {{-- <button onclick="generatePDF()">Download PDF</button>
                            <a href="{{ route('userCountTable') }}">Download Users</a> --}}
                            <button>
                                <a href="{{ route('TotalNumberOfEventsPerOrganization') }}" target="_blank">Show
                                    PDF </a></button>
                            <h3 class="text-sm text-center">Number of Events Per Month</h3>
                            <select id="year-select">
                                <option value="2023">2023</option>
                                <option value="2023" selected>2024</option>
                            </select>
                            <div class="card shadow-xs border mb-4">
                                <div class="card-body p-3">
                                    <div class="chart" id="myChart">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            {{-- <button onclick="generatePDF()">Download PDF</button>
                            <a href="{{ route('userCountTable') }}">Download Users</a> --}}
                            <button>
                                <a href="{{ route('NumberOfEventsPerOrganizationPerVenue') }}" target="_blank">Show PDF
                                </a></button>
                                
                            <h3 class="text-sm text-center">Total Number of Events of Organization Per Venues (Bar
                                Chart)</h3>
                            <div class="card shadow-xs border mb-4">
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="perOrgEvent" width="800" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="card-body">
                                    <h3 class="text-sm text-center">Total Events per Venue</h3>
                                    <div class="card shadow-xs border mb-4">
                                        <div class="card-body p-3">
                                            <button><a href="{{ route('TotalEventsPerVenue') }}" target="_blank">Show
                                                    PDF</a></button>
                                            <div class="chart">
                                                <canvas id="chart-doughnut" class="chart-canvas"
                                                    height="300px"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h3 class="text-sm text-center" style="margin-bottom:22px;">Total Events per Venue</h3>
                                <div class="card shadow-xs border mb-4">
                                    <div class="card-body">
                                        {{-- <select id="term-select">
                                            <option value="first">First Term</option>
                                            <option value="second">Second Term</option>
                                            <option value="third">Third Term</option>
                                        </select> --}}
                                        <div class="chart">
                                            <canvas id="chart-line" class="chart-canvas" height="300px"></canvas>
                                        </div>
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
        {{--
        <x-app.footer /> --}}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    {{-- FOR BAR CHART --}}
    <script>
        var ctx = document.getElementById('chart-event').getContext('2d');
        var colors = Array.from({
            length: {!! $events->count() !!}
        }, () => '#' + Math.floor(Math.random() * 16777215).toString(16));

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

    {{-- BAR CHART NUMBER OF EVENTS BY ORGANIZATION PER VENUE --}}
    <script>
        var ctx = document.getElementById('perOrgEvent').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($venuesPerOrg) !!},
                datasets: {!! json_encode($chartData) !!}
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1e293b',
                        bodyColor: '#1e293b',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        usePointStyle: true,
                        // Adjust the size of the tooltip
                        callbacks: {
                            // Use label callback to return desired text
                            label: function(tooltipItem) {
                                var value = tooltipItem.formattedValue;
                                return 'No. of Events: ' + value; // Example HTML formatting
                            },
                            // Remove title
                            title: function() {
                                return '';
                            }
                        }
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
            var element = document.getElementById('perOrgEvent');
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
        // Total Events per Venue
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

        var ctx = document.getElementById("chart-doughnut2").getContext("2d");
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

    {{-- LineChart --}}
    <script>
        var ctx = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(45,168,255,0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(45,168,255,0.0)');
        gradientStroke1.addColorStop(0, 'rgba(45,168,255,0)'); //blue colors

        var gradientStroke2 = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke2.addColorStop(1, 'rgba(119,77,211,0.4)');
        gradientStroke2.addColorStop(0.7, 'rgba(119,77,211,0.1)');
        gradientStroke2.addColorStop(0, 'rgba(119,77,211,0)'); //purple colors

        new Chart(ctx, {
            plugins: [{
                beforeInit(chart) {
                    const originalFit = chart.legend.fit;
                    chart.legend.fit = function fit() {
                        originalFit.bind(chart.legend)();
                        this.height += 40;
                    }
                },
            }],
            type: "line",
            data: {
                labels: {!! json_encode($datesOfEventsPerRole) !!},
                datasets: [{
                        label: "Student",
                        tension: 0,
                        borderWidth: 2,
                        pointRadius: 3,
                        borderColor: "#2ca8ff",
                        pointBorderColor: '#2ca8ff',
                        pointBackgroundColor: '#2ca8ff',
                        backgroundColor: gradientStroke1,
                        fill: true,
                        data: {!! json_encode($studentData) !!},
                        maxBarThickness: 6

                    },
                    {
                        label: "Faculty",
                        tension: 0,
                        borderWidth: 2,
                        pointRadius: 3,
                        borderColor: "#ff0000", // You can set the color here
                        pointBorderColor: '#ff0000',
                        pointBackgroundColor: '#ff0000',
                        fill: false, // Set to false for a line without fill
                        data: {!! json_encode($facultyData) !!},
                        maxBarThickness: 6
                    },
                    {
                        label: "Staff",
                        tension: 0,
                        borderWidth: 2,
                        pointRadius: 3,
                        borderColor: "#832bf9",
                        pointBorderColor: '#832bf9',
                        pointBackgroundColor: '#832bf9',
                        backgroundColor: gradientStroke2,
                        fill: true,
                        data: {!! json_encode($staffData) !!},
                        maxBarThickness: 6
                    },
                    {
                        label: "Outsider",
                        tension: 0,
                        borderWidth: 2,
                        pointRadius: 3,
                        borderColor: "#832bf9",
                        pointBorderColor: '#832bf9',
                        pointBackgroundColor: '#832bf9',
                        backgroundColor: gradientStroke2,
                        fill: true,
                        data: {!! json_encode($outsiderData) !!},
                        maxBarThickness: 6
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 6,
                            boxHeight: 6,
                            padding: 20,
                            pointStyle: 'circle',
                            borderRadius: 50,
                            usePointStyle: true,
                            font: {
                                weight: 400,
                            },
                        },
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#1e293b',
                        bodyColor: '#1e293b',
                        borderColor: '#e9ecef',
                        borderWidth: 1,
                        pointRadius: 2,
                        usePointStyle: true,
                        boxWidth: 8,
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
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [4, 4]
                        },
                        ticks: {
                            // callback: function(value, index, ticks) {
                            //     // console.log(index);
                            //     return parseInt(value).toLocaleString() + ' EUR';
                            // },
                            display: true,
                            padding: 10,
                            color: '#b2b9bf',
                            font: {
                                size: 12,
                                family: "Noto Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#64748B"
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [4, 4]
                        },
                        ticks: {
                            display: true,
                            color: '#b2b9bf',
                            padding: 20,
                            font: {
                                size: 12,
                                family: "Noto Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#64748B"
                        }
                    },
                },
            },
        });
    </script>

    {{-- Monthly Event --}}
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const labels = @json($monthlyLabels); // Convert PHP array to JSON for JavaScript
        //     const datasets = @json($datasets);

        //     const data = {
        //         labels: labels,
        //         datasets: datasets.map(function(dataset) {
        //             return {
        //                 label: dataset.label,
        //                 data: dataset.data,
        //                 backgroundColor: dataset.backgroundColor,
        //                 borderColor: dataset.borderColor,
        //                 borderWidth: dataset.borderWidth,
        //                 barThickness: 40, // Adjust the bar thickness as needed
        //                 maxBarThickness: 10 // Maximum bar thickness
        //             };
        //         })
        //     };

        //     const config = {
        //         type: 'bar',
        //         data: data,
        //         options: {
        //             indexAxis: 'y',
        //             plugins: {
        //                 tooltip: {
        //                     callbacks: {
        //                         label: function(context) {
        //                             return 'No. of Events: ' + context.parsed.y;
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     };

        //     // Get the context of the canvas element we want to select
        //     const ctx = document.getElementById('myChart').getContext('2d');
        //     new Chart(ctx, config);
        // });

        // JavaScript code
        var options = {
            series: <?php echo json_encode($datasets); ?>,
            chart: {
                type: 'bar',
                height: 430
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    barWidth: '0%', // Adjust the width of the bars here (percentage or number)
                    dataLabels: {
                        position: 'top',
                    },
                }
            },
            dataLabels: {
                enabled: true,
                offsetX: -6,
                style: {
                    fontSize: '12px',
                    colors: ['#fff']
                }
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['#fff']
            },
            // tooltip: {
            //     shared: true,
            //     intersect: false
            // },
            xaxis: {
                categories: <?php echo json_encode($monthlyLabels); ?>,
                labels: {
                    rotate: -45,
                    formatter: function(val) {
                        return val.split(' ')[0]; // Show only year part
                    }
                }
            },
        };

        var chart = new ApexCharts(document.querySelector("#myChart"), options);
        chart.render();
    </script>

    // <script>
    //     // Define a function to fetch data and update the chart
    //     function fetchDataAndUpdateChart(year) {
    //         var url = "{{ route('countEventPerOrgReport') }}";
    //         var queryParams = `?year=${encodeURIComponent(year)}`; // Encode query parameters

    //         fetch(url + queryParams, {
    //                 method: 'GET',
    //                 headers: {
    //                     'Content-Type': 'application/json',
    //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //                 }
    //             })
    //             .then(response => {
    //                 // Check if response is JSON
    //                 console.log(response.headers.get('content-type')); 
    //                 if (response.headers.get('content-type').includes('application/json')) {
    //                     return response.json();
    //                 } else {
    //                     throw new Error('Unexpected response format');
    //                 }
    //             })
    //             .then(data => {
    //                 // Assuming 'chart' is your ApexCharts instance
    //                 chart.updateOptions({
    //                     xaxis: {
    //                         categories: data.venues // Update categories (labels) if needed
    //                     }
    //                 });
    //                 chart.updateSeries([{
    //                     data: data.events // Update series data
    //                 }]);
    //             })
    //             .catch(error => {
    //                 console.error('Error fetching or updating data:', error);
    //             });
    //     }

    //     // Initialize the chart
    //     var options = {
    //         series: [],
    //         chart: {
    //             type: 'bar',
    //             height: 430,
    //             // Other chart options
    //         },
    //         // Other ApexCharts options
    //     };

    //     var chart = new ApexCharts(document.querySelector("#chart-container"), options);
    //     chart.render();

    //     // Add onchange event listener to the select element
    //     document.getElementById('year-select').addEventListener('change', function() {
    //         var selectedYear = this.value;
    //         fetchDataAndUpdateChart(selectedYear);
    //     });
    // </script>
</x-app-layout>
