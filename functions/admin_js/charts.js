// Bar Chart: Top 5 users with most pins
fetch('../../db/admin_db/get_top_users.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Error parsing JSON:', text);
                throw new Error('Invalid JSON response');
            }
        });
    })
    .then(data => {
        if (!Array.isArray(data)) {
            console.error('Unexpected data format:', data);
            return;
        }

        const names = data.map(item => item.name);
        const counts = data.map(item => item.count);

        var options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Total Pins',
                data: counts
            }],
            xaxis: {
                categories: names
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#ffffff"]
                }
            },
            title: {
                text: 'Top 5 Users by Pin Count',
                align: 'center',
                style: {
                    color: '#ffffff'
                }
            },
            theme: {
                mode: 'dark'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    })
    .catch(error => {
        console.error('Error:', error);
        // Display a user-friendly error message in the chart container
        document.querySelector("#chart").innerHTML = 
            '<div style="color: #ff4444; padding: 20px; text-align: center;">' +
            'Error loading chart data. Please try refreshing the page.' +
            '</div>';
    });


// Radial Bar Chart

    var options = {
    series: [76, 67, 61, 90, 180, 124],
    chart: {
    height: 390,
    type: 'radialBar',
    },
    plotOptions: {
        radialBar: {
        offsetY: 0,
        startAngle: 0,
        endAngle: 270,
        hollow: {
            margin: 5,
            size: '30%',
            background: 'transparent',
            image: undefined,
            },
        dataLabels: {
            name: {
            show: false,
            },
            value: {
            show: false,
            }
        },
        barLabels: {
            enabled: true,
            useSeriesColors: true,
            offsetX: -8,
            fontSize: '16px',
            formatter: function(seriesName, opts) {
            return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
            },
        },
        }
    },
    colors: ['#1ab7ea', '#0084ff', '#39539E', '#0077B5', '#00A0DC', '#ff6c00'],
    labels: ['Art', 'Design', 'Fashion', 'Food', 'Photography', 'Travel'],
    responsive: [{
        breakpoint: 480,
        options: {
        legend: {
            show: false
        }
        }
    }]
};

var chart = new ApexCharts(document.querySelector("#chart1"), options);
chart.render();