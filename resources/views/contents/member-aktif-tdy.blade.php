 <div class="row">
     <div class="col-md-4 col-sm-4 ">
         <div class="dashboard_graph">
             <div class="row x_title">
                 <div class="col-md-12">
                     <h2>Bulan Berjalan</h2>
                 </div>
             </div>
             <div class="col-md-12 col-sm-12 ">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id='myTable2'>
                        <tr>
                            <td>A</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>B</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>C</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>D</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>E</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>F</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <td>G</td>
                            <td>7</td>
                        </tr>
                        <tr>
                            <td>H</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>I</td>
                            <td>9</td>
                        </tr>
                        <tr>
                            <td>J</td>
                            <td>10</td>
                        </tr>
                    </tbody>
                </table>
             <script>
                var date = new Date();
                var daftarMemberActive2 = getActiveMemberTdy(2010, 10, 29);
                var nama = parseActive(daftarMemberActive2).nama;
                var jumlah = parseActive(daftarMemberActive2).jumlah;
                var x = document.getElementById("myTable2");
                var r=0;
                var anu=0;
                while(row=x.rows[r++]) {
                    row.cells[0].innerHTML=nama[anu];
                    row.cells[1].innerHTML=jumlah[anu];
                    anu+=1;
                }
             </script>
             </div>
             <div class="clearfix"></div>
         </div>
     </div>
 </div>
 <br />
