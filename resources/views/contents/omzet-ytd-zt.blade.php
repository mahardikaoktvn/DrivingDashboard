 <div class="row">
     <div class="col-md-4 col-sm-4 ">
         <div class="dashboard_graph">
             <div class="row x_title">
                 <div class="col-md-12">
                     <h3>OMZET YTD</h3>
                 </div>
             </div>
             <div class="col-md-12 col-sm-12 ">
                <canvas id="ytd-omzet-zt"></canvas>
                <script>
                var date = new Date();
                var daftarYTDZTomzet = getOmzetYTDZT(2010, 10, 29);
                var xValues = ["ZT I", "ZT II", "ZT III"];
                var yValues = [parseOmzetZT(daftarYTDZTomzet).zt1, parseOmzetZT(daftarYTDZTomzet).zt2, parseOmzetZT(daftarYTDZTomzet).zt3];
                var barColors = [
                "#b91d47",
                "#00aba9",
                "#2b5797",
                "#e8c3b9",
                "#1e7145"
                ];

                new Chart("ytd-omzet-zt", {
                type: "pie",
                data: {
                    labels: xValues,
                    datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                    }]
                }
                });
                </script>
             </div>
             <div class="clearfix"></div>
         </div>
     </div>
 </div>
 <br />
