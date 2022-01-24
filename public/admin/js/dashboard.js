$(document).ready(function () {
  $('.area-chart-mode').change(function() {
    const mode = $(this).val();
    const url = $(this).closest('.area-chart-section').attr('data-href');
    
    $.ajax({
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: url,
      data: {type: mode},
      success: function (data) {
        if (data.status == 200) {
          console.log(data);
          displayAreaChart(data.data, data.mode);
        } else {
          showErrorPopup();
        }
      },
      error: function () {
        console.log('error');
        showErrorPopup();
      },
    });
  });

  //trigger call change to get area chart data
  $('.area-chart-mode:eq(1)').change();

  //get bar chart data
  const barChartUrl =  $('.bar-chart-section').attr('data-href');
  $.ajax({
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: barChartUrl,
    success: function (data) {
      if (data.status == 200) {
        console.log(data);
        displayBarChart(data.data);
      } else {
        showErrorPopup();
      }
    },
    error: function () {
      showErrorPopup();
    },
  });

    //get pie chart data
    const pieChartUrl =  $('.pie-chart-section').attr('data-href');
    $.ajax({
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: pieChartUrl,
      success: function (data) {
        if (data.status == 200) {
          console.log(data);
          displayPieChart(data.data);
        } else {
          showErrorPopup();
        }
      },
      error: function () {
        showErrorPopup();
      },
    });
});

function showErrorPopup() {
  console.log('show');
  showNotifyPopup('fail', 'Thất bại', 'Đã có lỗi xảy ra trong quá trình lấy dữ liệu, vui lòng thử lại sau', 'fas fa-exclamation-triangle fa-3x');
}

function displayAreaChart(input, mode) {
  let labels = [], data = [];
  input.forEach(r => {
    labels.push(r.dates);
    data.push(r.total);
  });

  const maxValue = Math.max(...data);
  console.log({labels, data});

  let ctx = null;
  if (mode == 'week') {
    ctx = document.getElementById("area-chart-week");
    $('#area-chart-week').closest('.card-body').show();
    $('#area-chart-month').closest('.card-body').hide();
    $('#area-chart-quarter').closest('.card-body').hide();
  } else if (mode == 'month') {
    ctx = document.getElementById("area-chart-month");
    $('#area-chart-month').closest('.card-body').show();
    $('#area-chart-week').closest('.card-body').hide();
    $('#area-chart-quarter').closest('.card-body').hide();
  } else {
    ctx = document.getElementById("area-chart-quarter");
    $('#area-chart-quarter').closest('.card-body').show();
    $('#area-chart-week').closest('.card-body').hide();
    $('#area-chart-month').closest('.card-body').hide();
  }

  let myLineChart = new Chart(ctx, {
      type: "line",
      data: {
          labels,
          datasets: [
              {
                  label: "Tổng số hoá đơn",
                  lineTension: 0.3,
                  backgroundColor: "rgba(2,117,216,0.2)",
                  borderColor: "rgba(2,117,216,1)",
                  pointRadius: 5,
                  pointBackgroundColor: "rgba(2,117,216,1)",
                  pointBorderColor: "rgba(255,255,255,0.8)",
                  pointHoverRadius: 5,
                  pointHoverBackgroundColor: "rgba(2,117,216,1)",
                  pointHitRadius: 50,
                  pointBorderWidth: 2,
                  data,
              },
          ],
      },
      options: {
          scales: {
              xAxes: [
                  {
                      time: {
                          unit: "date",
                      },
                      gridLines: {
                          display: false,
                      },
                      ticks: {
                          maxTicksLimit: 15,
                      },
                  },
              ],
              yAxes: [
                  {
                      ticks: {
                          min: 0,
                          max: maxValue > 100 ? Math.ceil((maxValue+1)/100)*100 : Math.ceil((maxValue+1)/10)*10,
                          maxTicksLimit: 10,
                          minTicksLimit: 5
                      },
                      gridLines: {
                          color: "rgba(0, 0, 0, .125)",
                      },
                  },
              ],
          },
          legend: {
              display: false,
          },
      },
  });

  updateTime($('.area-chart-section'));
}

function displayBarChart(input) {
  let labels = [], data = [];
  input.forEach(r => {
    labels.push(r.item.name);
    data.push(parseInt(r.total));
  });

  const maxValue = Math.max(...data);
  console.log({labels, data});

  var ctx = document.getElementById("bar-chart");
  var myLineChart = new Chart(ctx, {
      type: "bar",
      data: {
          labels,
          datasets: [
              {
                  label: "Tổng số sản phẩm",
                  backgroundColor: "rgba(2,117,216,1)",
                  borderColor: "rgba(2,117,216,1)",
                  data,
              },
          ],
      },
      options: {
          scales: {
              xAxes: [
                  {
                      time: {
                          unit: "month",
                      },
                      gridLines: {
                          display: false,
                      },
                      ticks: {
                          maxTicksLimit: 6,
                      },
                  },
              ],
              yAxes: [
                  {
                      ticks: {
                          min: 0,
                          max: maxValue > 100 ? Math.ceil((maxValue+1)/100)*100 : Math.ceil((maxValue+1)/10)*10,
                          maxTicksLimit: 5,
                      },
                      gridLines: {
                          display: true,
                      },
                  },
              ],
          },
          legend: {
              display: false,
          },
      },
  });

  updateTime($('.bar-chart-section'));
}

function displayPieChart(input) {
  let labels = [], data = [];
  input.forEach(r => {
    labels.push(r.status);
    data.push(r.total);
  });

  console.log({labels, data});

  var ctx = document.getElementById("pie-chart");
  var myPieChart = new Chart(ctx, {
      type: "pie",
      data: {
          labels,
          datasets: [
              {
                  data,
                  backgroundColor: [
                      "#007bff",
                      "#dc3545",
                      "#ffc107",
                      "#28a745",
                  ],
              },
          ],
      },
  });

  updateTime($('.pie-chart-section'))
}

function updateTime(_parent) {
  const now = new Date();
  let [hour, minutes, month, day, year] = [
    now.getHours(), 
    now.getMinutes(), 
    now.getMonth(), 
    now.getDate(), 
    now.getFullYear()
  ];

  month += 1;
  let monthOfYear = month.toString();
  let minutesOfHour = minutes.toString();
  if (month < 10) {
    monthOfYear = '0' + month;
  } 
  if (minutes < 10) {
    minutesOfHour = '0' + minutes;
  }

  $(_parent).find('.updated-time').html(`${hour}:${minutesOfHour} ${day}/${monthOfYear}/${year}`)
}