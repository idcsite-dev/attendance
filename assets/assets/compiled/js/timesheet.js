$(document).ready(function () {
  $("#tbmTimesheet").load(site_url + "timesheet/tb_timesheet?q=0");

  $("#btnBulanTs").click(function () {
    let dt_href = $(this).attr("dt-href");
    let tahun = $("#lstTahunTS").val();
    let bulan = $("#lstBulanTS").val();
    let lstbulan = bulan + "|" + tahun;
    // alert(bulan);
    // return;

    if (tahun == "" || bulan == "") {
      alert("Data wajib dipilih");
      return;
    } else {
      window.location.href = dt_href + "?q=" + lstbulan;
    }
  });
});
