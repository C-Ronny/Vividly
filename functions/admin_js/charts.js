// Bar Chart: Top 5 users with the most pins

var options = {
  chart: {
      type: 'bar'
  },
  series: [{
      name: 'sales',
      data: [12.5,9.1,5,4,3]
  }],
  xaxis: {
      categories: ['John','Jane','Doe','Elon','Araba']
  }
}

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();


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