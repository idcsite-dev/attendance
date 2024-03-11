// site_url = "http://localhost:8080/payroll/";

// $.ajax({
//   type: "POST",
//   url: site_url + "dashboard/chartgaji",
//   data: {},
//   success: function (respone) {
//     alert(respone);
//     return;
//     var data = JSON.parse(respone);
//     // var staff = data.
//   },
// });

var barOptions = {
  series: [
    {
      name: "STAFF",
      data: [10982, 11978, 12323, 12442, 25444, 42354],
    },
    {
      name: "NON STAFF",
      data: [21243, 21564, 22344, 25344, 46345, 62354],
    },
  ],
  chart: {
    type: "bar",
    height: 350,
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: "55%",
      endingShape: "rounded",
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    show: true,
    width: 2,
    colors: ["transparent"],
  },
  xaxis: {
    categories: [
      "Okt 2023",
      "Sep 2023",
      "Nop 2023",
      "Des 2023",
      "Jan 2024",
      "Feb 2024",
    ],
  },
  yaxis: {
    // title: {
    //   text: "$ (thousands)",
    // },
  },
  fill: {
    opacity: 1,
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return "Rp.  " + val + " thousands";
      },
    },
  },
};

var bar = new ApexCharts(document.querySelector("#GrafikGaji"), barOptions);
bar.render();
