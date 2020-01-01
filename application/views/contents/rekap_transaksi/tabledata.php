<style>
    #tablerekap{
        margin-top:10px;    
    }
    table th{
        padding:5px;
        background:cornflowerblue;
        color:white;
        
    }
    
    table td{
        padding:5px;
        background:white;
        color:black;
    }
</style>
<div class="col-md-12">
    <button class="btn btn-success pull-right" onclick="exportTableToExcel('tablerekap','Rekap Transaksi <?php echo date('d-m-Y')?>')">Export To Excel</button></div>
    <div class="col-md-12">
<table id="tablerekap" border="1" width="100%">
    <tr>
        <th>Tgl Transaksi</th>
        <th>Kasir</th>
        <th>Cara Bayar</th>
        <th>Nama Siswa</th>
        <th>Unit</th>
        <th>Kelas</th>
        <th>Periode</th>
        <th>Biaya Masuk</th>
        <th>Daftar Ulang</th>
        <th>SPP</th>
        <th>KS</th>
        <th>Catering</th>
        <th>Antar Jemput</th>
        <th>Rumah Berbagi</th>
        <th>School Support</th>
        <th>Jumlah</th>
    </tr>
    <tr>
        <td>1</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
    </div>
<script>
    function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>  