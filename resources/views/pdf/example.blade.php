<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Charts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</head>
<body class="bg-black text-white p-4">
    <h1 class="text-2xl mb-4">Order Charts for {{ $year }}</h1>

    <div class="my-6">
        <div class="mb-2">
            <span>{{ $year }} Orders: </span>
            <span>{{ array_sum($thisYearOrders) }}</span>
        </div>
        <div>
            <span>{{ $year - 1 }} Orders: </span>
            <span>{{ array_sum($lastYearOrders) }}</span>
        </div>
    </div>

    <div class="flex justify-center space-x-4">
        <div id="barChart" style="height: 700px; width: 700px;"></div>
        <div id="pieChart" style="height: 700px; width: 700px;"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const barOptions = {
                chart: {
                    type: 'bar',
                    height: 700,
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: '{{ $year - 1 }} Orders',
                    data: @json($lastYearOrders)
                }, {
                    name: '{{ $year }} Orders',
                    data: @json($thisYearOrders)
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    labels: {
                        style: {
                            colors: '#ffffff'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#ffffff'
                        }
                    }
                },
                legend: {
                    labels: {
                        colors: '#ffffff'
                    }
                }
            };

            const pieOptions = {
                chart: {
                    type: 'pie',
                    height: 700
                },
                series: [@json(array_sum($lastYearOrders)), @json(array_sum($thisYearOrders))],
                labels: ['Previous Year', 'Current Year'],
                legend: {
                    labels: {
                        colors: '#ffffff'
                    }
                }
            };

            const barChart = new ApexCharts(document.querySelector("#barChart"), barOptions);
            const pieChart = new ApexCharts(document.querySelector("#pieChart"), pieOptions);

            barChart.render();
            pieChart.render();
        });
    </script>
</body>
</html>
