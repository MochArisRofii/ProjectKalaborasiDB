@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Card untuk Pie Chart -->
            <div class="card mb-4">
                <div class="card-header">Data Stok Produk</div>
                <div class="card-body">
                    <canvas id="produkPieChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Card untuk Donut Chart -->
            <div class="card mb-4">
                <div class="card-header">Data Produk Terjual</div>
                <div class="card-body">
                    <canvas id="produkDonutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Data untuk Pie Chart (stok produk)
        const produkPieData = {
            labels: @json($produkLabels), // Nama produk
            datasets: [{
                data: @json($produkStok), // Stok produk
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)', // Biru transparan
                    'rgba(255, 99, 132, 0.2)', // Merah transparan
                    'rgba(75, 192, 192, 0.2)', // Hijau mint transparan
                    'rgba(153, 102, 255, 0.2)', // Ungu transparan
                    'rgba(255, 159, 64, 0.2)', // Oranye transparan
                    'rgba(255, 205, 86, 0.2)', // Kuning transparan
                    'rgba(201, 203, 207, 0.2)', // Abu-abu transparan
                    'rgba(123, 239, 178, 0.2)', // Hijau muda transparan
                    'rgba(255, 99, 71, 0.2)', // Tomato transparan
                    'rgba(132, 60, 255, 0.2)' // Lavender transparan
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)', // Biru pekat
                    'rgba(255, 99, 132, 1)', // Merah pekat
                    'rgba(75, 192, 192, 1)', // Hijau mint pekat
                    'rgba(153, 102, 255, 1)', // Ungu pekat
                    'rgba(255, 159, 64, 1)', // Oranye pekat
                    'rgba(255, 205, 86, 1)', // Kuning pekat
                    'rgba(201, 203, 207, 1)', // Abu-abu pekat
                    'rgba(123, 239, 178, 1)', // Hijau muda pekat
                    'rgba(255, 99, 71, 1)', // Tomato pekat
                    'rgba(132, 60, 255, 1)' // Lavender pekat
                ],
                borderWidth: 1
            }]
        };

        // Data untuk Donut Chart (produk terjual)
        const produkDonutData = {
            labels: @json($produkTerjualLabels), // Nama produk terjual
            datasets: [{
                data: @json($produkTerjualJumlah), // Jumlah produk terjual
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)', // Biru transparan
                    'rgba(255, 99, 132, 0.2)', // Merah transparan
                    'rgba(75, 192, 192, 0.2)', // Hijau mint transparan
                    'rgba(153, 102, 255, 0.2)', // Ungu transparan
                    'rgba(255, 159, 64, 0.2)', // Oranye transparan
                    'rgba(255, 205, 86, 0.2)', // Kuning transparan
                    'rgba(201, 203, 207, 0.2)', // Abu-abu transparan
                    'rgba(123, 239, 178, 0.2)', // Hijau muda transparan
                    'rgba(255, 99, 71, 0.2)', // Tomato transparan
                    'rgba(132, 60, 255, 0.2)' // Lavender transparan
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)', // Biru pekat
                    'rgba(255, 99, 132, 1)', // Merah pekat
                    'rgba(75, 192, 192, 1)', // Hijau mint pekat
                    'rgba(153, 102, 255, 1)', // Ungu pekat
                    'rgba(255, 159, 64, 1)', // Oranye pekat
                    'rgba(255, 205, 86, 1)', // Kuning pekat
                    'rgba(201, 203, 207, 1)', // Abu-abu pekat
                    'rgba(123, 239, 178, 1)', // Hijau muda pekat
                    'rgba(255, 99, 71, 1)', // Tomato pekat
                    'rgba(132, 60, 255, 1)' // Lavender pekat
                ],
                borderWidth: 1
            }]
        };

        // Konfigurasi dan render Pie Chart
        const ctxPie = document.getElementById("produkPieChart").getContext("2d");
        new Chart(ctxPie, {
            type: "pie",
            data: produkPieData,
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)', // Tooltip background lebih gelap
                        titleColor: '#fff', // Warna judul tooltip
                        bodyColor: '#fff' // Warna isi tooltip
                    }
                }
            }
        });

        // Konfigurasi dan render Donut Chart
        const ctxDonut = document.getElementById("produkDonutChart").getContext("2d");
        new Chart(ctxDonut, {
            type: "doughnut",
            data: produkDonutData,
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)', // Tooltip background lebih gelap
                        titleColor: '#fff', // Warna judul tooltip
                        bodyColor: '#fff' // Warna isi tooltip
                    }
                }
            }
        });
    });
</script>
@endsection
