<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">STOCK BARANG</header>
            <div class="panel-body">
                <table id="tableBarangGlob" class="table table-bordered" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Nama Uker</th>
                            <th>Group Barang</th>
                            <th>Subgroup Barang</th>
                            <th>Merek Barang</th>
                            <th>Tipe Barang</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <?php
                        $no = 1;
                        foreach ($stockbarang as $bg) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $bg->nama_uker ?></td>
                                <td><?= $bg->nama_gbarang ?></td>
                                <td><?= $bg->nama_sgbarang ?></td>
                                <td><?= $bg->nama_merek ?></td>
                                <td><?= $bg->tipe_barang ?></td>
                                <td><?= $bg->kode_barang ?></td>
                                <td><?= $bg->nama_barang ?></td>
                                <td><?= $bg->qty ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script>
    $(function() {
        $('#tableBarangGlob').dataTable();
    })
</script>