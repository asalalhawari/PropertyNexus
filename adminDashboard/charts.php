<?php
require("header.php");
require("navbar.php");
require("sidebar.php");
require("core.php");
?>
  <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <!-- Canvas for Pie Chart -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Pie Chart</div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="pieChart" style="width: 50%; height: 50%"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var pieChartCtx = document.getElementById("pieChart").getContext("2d");

            var myPieChart = new Chart(pieChartCtx, {
                type: "pie",
                data: {
                    datasets: [{
                        data: [50, 35, 15],
                        backgroundColor: ["#1d7af3", "#f3545d", "#fdaf4b"],
                        borderWidth: 0,
                    }],
                    labels: ["New Visitors", "Subscribers", "Active Users"],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        position: "bottom",
                        labels: {
                            fontColor: "rgb(154, 154, 154)",
                            fontSize: 11,
                            usePointStyle: true,
                            padding: 20,
                        },
                    },
                    tooltips: {
                        bodySpacing: 4,
                        mode: "nearest",
                        intersect: 0,
                        position: "nearest",
                        xPadding: 10,
                        yPadding: 10,
                        caretPadding: 10,
                    },
                    layout: {
                        padding: {
                            left: 20,
                            right: 20,
                            top: 20,
                            bottom: 20,
                        },
                    },
                },
            });
        });
    </script>