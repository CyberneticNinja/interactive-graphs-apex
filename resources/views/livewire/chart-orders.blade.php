<div
    wire:ignore
    class="mt-4 bg-black text-white p-4 rounded-lg"
    x-data="{
        selectedYear: $wire.get('selectedYear'),
        lastYearOrders: $wire.get('lastYearOrders'),
        thisYearOrders: $wire.get('thisYearOrders'),
        init() {
            const barOptions = {
                chart: {
                    type: 'bar',
                    height: 700, 

                    toolbar: {
                        show: false
                    },
                    width: '700px'
                },
                series: [{
                    name: `${this.selectedYear - 1} Orders`,
                    data: this.lastYearOrders
                }, {
                    name: `${this.selectedYear} Orders`,
                    data: this.thisYearOrders
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
                    height: 700,
                                    width: '700px'

                },
                series: [this.lastYearOrders.reduce((a, b) => a + b, 0), this.thisYearOrders.reduce((a, b) => a + b, 0)],
                labels: ['Previous Year', 'Current Year'],
                legend: {
                    labels: {
                        colors: '#ffffff'
                    }
                }
            };

            const barChart = new ApexCharts(this.$refs.barCanvas, barOptions);
            const pieChart = new ApexCharts(this.$refs.pieCanvas, pieOptions);

            barChart.render();
            pieChart.render();

            Livewire.on('updateTheChart', () => {
                this.lastYearOrders = $wire.get('lastYearOrders');
                this.thisYearOrders = $wire.get('thisYearOrders');
                this.selectedYear = $wire.get('selectedYear');

                barChart.updateSeries([{
                    name: `${this.selectedYear - 1} Orders`,
                    data: this.lastYearOrders
                }, {
                    name: `${this.selectedYear} Orders`,
                    data: this.thisYearOrders
                }]);

                pieChart.updateSeries([
                    this.lastYearOrders.reduce((a, b) => a + b, 0),
                    this.thisYearOrders.reduce((a, b) => a + b, 0)
                ]);
            });
        }
    }">
    <span class="block mb-2">Year:
        <select name="selectedYear" id="selectedYear" class="border bg-black text-white p-2 rounded mb-4" wire:model.live="selectedYear">
            @foreach ($availableYears as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
    </span>
    
    <div class="my-6">
        <div class="mb-2">
            <span x-text="selectedYear"></span> Orders:
            <span x-text="thisYearOrders.reduce((a, b) => a + b, 0)"></span>
        </div>
        <div>
            <span x-text="selectedYear - 1"></span> Orders:
            <span x-text="lastYearOrders.reduce((a, b) => a + b, 0)"></span>
        </div>
    </div>

    <div class="flex justify-center space-x-4">
            <div id="barChart" x-ref="barCanvas"></div>
            <br/>
            <div id="pieChart" x-ref="pieCanvas"></div>
    </div>
</div>
