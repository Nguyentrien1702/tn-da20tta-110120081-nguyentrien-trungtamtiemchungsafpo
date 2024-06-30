<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
   
</head>
<body>
    @include("nhanvien/header_nv")
    <main>
        <div class="container-fluid px-4">

            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body" style ="font-size: 22px; font-weight: bold;">TỔNG DOANH THU</div>
                        <div class="card-footer" style="text-align: right; font-size: 25px; font-weight: bold;">
                            <span id="tongdoanhthu"></span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body" style ="font-size: 22px; font-weight: bold;">TỔNG SỐ LIỀU VACCINE ĐÃ TIÊM</div>
                        <div class="card-footer" style="text-align: right; font-size: 25px; font-weight: bold;">
                            <span id="slmuitiem"></span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body" style ="font-size: 22px; font-weight: bold;">GÓI ĐĂNG KÝ ĐÃ HỦY</div>
                        <div class="card-footer" style="text-align: right; font-size: 25px; font-weight: bold;">
                            <span id="goidk_huy"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-md-6" style="text-align: center;">
                    <canvas id="chart_dk_huy" ></canvas>
                    <h4>Số lượng gói vaccine đăng ký và hủy theo tháng</h4>
                </div>
                <div class="col-xl-6 col-md-6" style="text-align: center;">
                    <div id="chart_div" style="height: 400px;"></div>
                    <h4>Số lượng mũi tiêm theo từng tháng</h4>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-xl-6 col-md-6" style="text-align: center;">
                    <div id="piechart" style=" height: 400px;"></div>
                    <h4>Tỉ lệ số lượng khách hàng theo từng giới tính</h4>
                </div>
                <div class="col-xl-6 col-md-6" style="text-align: center;">
                    <canvas id="vaccineChart"></canvas>
                    <h4>Số lượng mũi tiêm đã tiêm</h4>
                </div>
            </div>
            
        </div>
    </main>
    @include("nhanvien/footer_nv")
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchVaccineStatistics();
        fetchTotalRevenue();
        fetchChartData()
    });

    function fetchVaccineStatistics() {
        fetch('/Nhanvien/thongkemuitiem')
            .then(response => response.json())
            .then(data => {
                var labels = data.map(item => item.tenvc);
                var counts = data.map(item => item.total);

                var ctx = document.getElementById('vaccineChart').getContext('2d');
                var vaccineChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Số lượng mũi tiêm',
                            data: counts,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching vaccine statistics:', error));
    }
    function fetchTotalRevenue() {
        fetch('/Nhanvien/doanhthu')
            .then(response => response.json())
            .then(data => {
                document.getElementById('tongdoanhthu').innerText = dinhdanggia(data.doanhthu) + ' VND';
                document.getElementById('slmuitiem').innerText = data.slmuitiemdatiem + ' liều';
                document.getElementById('goidk_huy').innerText = data.goidk_huy + ' gói';
            })
            .catch(error => console.error('Error fetching total revenue:', error));
    }
    function dinhdanggia(input) {
        // Định dạng tiền tệ
        var currency = input.replace(/[^\d]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        // Trả về giá trị đã định dạng
        return currency;
    }
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Gọi Ajax để lấy dữ liệu 
        $.ajax({
            url: '/Nhanvien/gioitinh',
            dataType: 'json',
            success: function(data) {
                var chartData = [['Giới tính', 'Số lượng']].concat(data);

                var options = {
                    title: 'Tỉ lệ khách hàng theo giới tính',
                    is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(google.visualization.arrayToDataTable(chartData), options);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart_line);
    function drawChart_line() {
        $.ajax({
            url: '/Nhanvien/vaccinethang', // URL endpoint để lấy dữ liệu từng ngày
            dataType: 'json',
            success: function(data) {
                var chartData = [['Ngày', 'Số lượng mũi tiêm']];
                for (var i = 0; i < data.dates.length; i++) {
                    chartData.push([data.dates[i], data.totals[i]]);
                }

                var options = {
                    title: 'Số lượng mũi tiêm theo từng ngày',
                    curveType: 'function',
                    legend: { position: 'bottom' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                chart.draw(google.visualization.arrayToDataTable(chartData), options);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }
    function fetchChartData() {
        // Gọi AJAX để lấy dữ liệu từ route 'getChartData'
        fetch('/Nhanvien/getdkhuy')
            .then(response => response.json())
            .then(data => {
                // Chuẩn bị dữ liệu cho biểu đồ
                const months = data.map(item => item.ngay);
                const dangky = data.map(item => item.dangky);
                const huy = data.map(item => item.huy);

                // Vẽ biểu đồ bằng Chart.js
                var ctx = document.getElementById('chart_dk_huy').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [{
                            label: 'Đăng ký',
                            data: dangky,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Hủy',
                            data: huy,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }
</script>

</body>
</html>