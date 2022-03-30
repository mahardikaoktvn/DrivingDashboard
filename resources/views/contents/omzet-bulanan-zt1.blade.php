<div class="row">
     <div class="col-md-12 col-sm-12 ">
         <div class="dashboard_graph">
             <div class="row x_title">
                 <div class="col-md-12">
                     <h3>Omzet Zone Time 1 Monthly</h3>
                 </div>
             </div>
             <div class="col-md-12 col-sm-12 ">
                 <canvas id="omzet-bulanan-zt1"></canvas>
                 <script>
                    var date = new Date();
                    var daftarBulananZT1 = getOmzetMonthlyZT1(2010, 10, 29);
                     const ctx_zt1 = document.getElementById('omzet-bulanan-zt1').getContext('2d');
                     const omzet_bulanan_zt1 = new Chart(ctx_zt1, {
                         type: 'line',
                         data: {
                             labels: getMonthName(daftarBulananZT1),
                             datasets: [{
                                 label: 'Omzet Member',
                                 data: parseOmzet(daftarBulananZT1).member,
                                 fill: false,
                                 borderColor: 'rgb(39, 149, 39)',
                                 tension: 0.1
                             },
                             {
                                 label: 'Omzet Guest',
                                 data: parseOmzet(daftarBulananZT1).guest,
                                 fill: false,
                                 borderColor: 'rgb(255, 0, 0)',
                                 tension: 0.1
                             },
                             {
                                 label: 'Omzet Total',
                                 data: parseOmzet(daftarBulananZT1).total,
                                 fill: false,
                                 borderColor: 'rgb(75, 192, 192)',
                                 tension: 0.1
                             }]
                         },
                     });
                 </script>
             </div>
             <div class="clearfix"></div>
         </div>
     </div>
 </div>
 <br />