 <div class="row">
     <div class="col-md-4 col-sm-4 ">
         <div class="dashboard_graph">
             <div class="row x_title">
                 <div class="col-md-12">
                     <h3>OMZET MTD</h3>
                 </div>
             </div>
             <div class="col-md-12 col-sm-12 ">
                <canvas id="mtd-omzet-zt"></canvas>
                <script>
                var date = new Date();
                var daftarMTDZTomzet = getOmzetMTDZT(2010, 10, 29);
                var xValues = ["ZT I", "ZT II", "ZT III"];
                var yValues = [parseOmzetZT(daftarMTDZTomzet).zt1, parseOmzetZT(daftarMTDZTomzet).zt2, parseOmzetZT(daftarMTDZTomzet).zt3];
                var barColors = [
                "#b91d47",
                "#00aba9",
                "#2b5797",
                "#e8c3b9",
                "#1e7145"
                ];
                new Chart("mtd-omzet-zt", {
                    type: 'pie',
                    data: {
                        labels: xValues,
                        datasets: [{
                        data: yValues,
                        backgroundColor: barColors
                        }]
                    },
                    options: {
                        plugins: {
                        datalabels: {
                            display: true,
                            align: 'bottom',
                            backgroundColor: '#ccc',
                            borderRadius: 3,
                            font: {
                            size: 18,
                            }
                        },
                        }
                    }
                });
                </script>
             </div>
             <div class="clearfix"></div>
         </div>
     </div>
 </div>
 <br />
