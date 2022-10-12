<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">STOCK BARANG</header>
            <div class="panel-body">
                <table id="tableBarangGlob" class="table table-bordered" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Group Barang</th>
                            <th>Subgroup Barang</th>
                            <th>Merek Barang</th>
                            <th>Tipe Barang</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <?php
                        $no = 1;
                        foreach ($stockglobal as $bg) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $bg->nama_gbarang ?></td>
                                <td><?= $bg->nama_sgbarang ?></td>
                                <td><?= $bg->nama_merek ?></td>
                                <td><?= $bg->tipe_barang ?></td>
                                <td><?= $bg->kode_barang ?></td>
                                <td><?= $bg->nama_barang ?></td>
                                <td><?= $bg->Qty ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary" onclick="viewDetail(<?= $bg->no_urut ?>)" class="form-control">View Detail</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<div id="viewDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detail-stock-barang" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="detail-stock-barang">Detail Stock Barang</h4>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Uker</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody id="isiDetail"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    const url = '<?= site_url('Stockglobal/') ?>';

    $(function() {
        $('#tableBarangGlob').dataTable();
    })

    function viewDetail(no_urut) {
        $.ajax({
            type: "POST",
            url: url + 'detailStock',
            data: {
                no_urut: no_urut
            },
            dataType: "JSON",
            success: function(response) {
                let isiDetail = '';
                let no = 1;

                for (let i = 0; i < response.length; i++) {
                    const element = response[i];

                    isiDetail += `<tr>
                    <td>${no++}</td>
                    <td>${element.nama_uker}</td>
                    <td>${element.nama_barang}</td>
                    <td>${element.qty}</td>
                    </tr>`;
                }

                $('#isiDetail').html(isiDetail);
                $('#viewDetail').modal('show');
            }
        });
    }
</script>