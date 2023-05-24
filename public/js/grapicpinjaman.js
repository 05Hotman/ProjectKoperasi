console.log(totalCustomers);
Highcharts.chart('container', {

    title: {
      text: 'U.S Solar Employment Growth by Job Category, 2010-2020',
      align: 'left'
    },

    subtitle: {
      text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>',
      align: 'left'
    },

    yAxis: {
      title: {
        text: 'Number of Employees'
      }
    },

    xAxis: {
        categories: months,
        accessibility: {
            rangeDescription: 'Range: January to December',
            enabled: true
        }
    },

    legend: {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle'
    },

    plotOptions: {
      series: {
        label: {
          connectorAllowed: false
        },
        pointStart: 1
      }
    },

    series: [{
        name: 'Costumers',
        data: [totalCustomers]
    }, {
      name: 'Simpanan',
      data: [10, 21, 3]
    }, {
      name: 'Sales & Distribution',
      data: [1, 43, 2]
    }, {
      name: 'Operations & Maintenance',
      data: [11, 8, 5]
    }, {
      name: 'Other',
      data: [2, 1, 2]
    }],

    responsive: {
      rules: [{
        condition: {
          maxWidth: 500
        },
        chartOptions: {
          legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom'
          }
        }
      }]
    }

  });












//     backup
// console.log(totalCustomers);
// Highcharts.chart('container', {

//     title: {
//       text: 'U.S Solar Employment Growth by Job Category, 2010-2020',
//       align: 'left'
//     },

//     subtitle: {
//       text: 'Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>',
//       align: 'left'
//     },

//     yAxis: {
//       title: {
//         text: 'Number of Employees'
//       }
//     },

//     xAxis: {
//       accessibility: {
//         rangeDescription: 'Range: 2010 to 2020'
//       }
//     },

//     legend: {
//       layout: 'vertical',
//       align: 'right',
//       verticalAlign: 'middle'
//     },

//     plotOptions: {
//       series: {
//         label: {
//           connectorAllowed: false
//         },
//         pointStart: 2010
//       }
//     },

//     series: [{
//       name: 'Costumers',
//       data: [totalCustomers]
//     }, {
//       name: 'Manufacturing',
//       data: [2]
//     }, {
//       name: 'Sales & Distribution',
//       data: [1]
//     }, {
//       name: 'Operations & Maintenance',
//       data: [11]
//     }, {
//       name: 'Other',
//       data: [2]
//     }],

//     responsive: {
//       rules: [{
//         condition: {
//           maxWidth: 500
//         },
//         chartOptions: {
//           legend: {
//             layout: 'horizontal',
//             align: 'center',
//             verticalAlign: 'bottom'
//           }
//         }
//       }]
//     }

//   });
