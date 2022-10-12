<div class="box">
    <form action="<?= base_url('Laporanbarang/Cetaklaporan') ?>" method="post">
        <div class="box-header">
            <h3 class="box-title">LAPORAN PENGELUARAN BARANG</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Dari Tanggal Pengiriman</label>
                                <input type="date" name="tglstart" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Sampe Tanggal Pengiriman</label>
                                <input type="date" name="tglend" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kon_barang">Kondisi Barang</label>
                        <select name="kon_barang" id="kon_barang" class="form-control select2" style="width: 100%;">
                            <option value="All">All</option>
                            <option value="Bagus">Bagus</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Asal Uker</label>
                        <select class="form-control select2" name="asal_uker" id="asal_uker" style="width: 100%;">
                            <option value="">Select Asal Uker</option>
                            <?php foreach ($uker as $uk) : ?>
                                <option value="<?php echo $uk->id_uker; ?>"><?php echo $uk->nama_uker; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Tujuan Uker</label>
                        <select class="form-control select2" name="tujuan_uker" id="tujuan_uker" style="width: 100%;">
                            <option value="">Select Tujuan Uker</option>
                            <?php foreach ($uker as $uk) : ?>
                                <option value="<?php echo $uk->id_uker; ?>"><?php echo $uk->nama_uker; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_gbarang" class="control-label">Group Barang</label>
                        <select class="form-control select2" name="id_gbarang" onchange="ChainedLaporan('<?= base_url('Chained/Listsubgroupbarang/') ?>'+this.value, '#id_sgbarang', 'id_gbarang')" id="id_gbarang" style="width: 100%;">
                            <option value="">Select Group Barang</option>
                            <?php foreach ($gbarang as $gb) : ?>
                                <option value="<?php echo $gb->id_gbarang; ?>"><?php echo $gb->nama_gbarang; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_sgbarang" class="control-label">Subgroup Barang</label>
                        <select class="form-control select2" name="id_sgbarang" id="id_sgbarang" onchange="ChainedLaporan('<?= base_url('Chained/Listmerekbarang/') ?>'+this.value, '#id_merek', 'id_sgbarang')" style="width: 100%;">
                            <option value="">Select Subgroup Barang</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_merek" class="control-label">Merek Barang</label>
                        <select class="form-control select2" name="id_merek" id="id_merek" onchange="ChainedLaporan('<?= base_url('Chained/Listtipebarang/') ?>'+this.value, '#id_tipe_barang', 'id_merek')" style="width: 100%;">
                            <option value="">Select Merek Barang</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_tipe_barang" class="control-label">Tipe Barang</label>
                        <select class="form-control select2" name="id_tipe_barang" id="id_tipe_barang" onchange="ChainedLaporan('<?= base_url('Chained/Listbarang/') ?>'+this.value, '#no_urut', 'id_tipe_barang')" style="width: 100%;">
                            <option value="">Select Tipe Barang</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_urut" class="control-label">List Barang</label>
                        <select class="form-control select2" name="no_urut" id="no_urut" style="width: 100%;">
                            <option value="">Select Nama Barang</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer text-center">
            <input type="submit" value="Download" class="btn btn-primary text-center">
        </div>
    </form>
</div>

<script>
    function ChainedLaporan(url, id_tujuan, tipe, no_urut = null) {
        $.ajax({
            type: "POST",
            url: url,
            dataType: "JSON",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                if (tipe == 'id_gbarang' || tipe == 'id_gbarang' + no_urut) {
                    if (no_urut) {
                        $('#id_sgbarang' + no_urut).val(null).trigger('change');
                        $('#id_merek' + no_urut).val(null).trigger('change');
                        $('#id_tipe_barang' + no_urut).val(null).trigger('change');
                    } else {
                        $('#id_sgbarang').val(null).trigger('change');
                        $('#id_merek').val(null).trigger('change');
                        $('#id_tipe_barang').val(null).trigger('change');
                    }
                } else if (tipe == 'id_sgbarang') {
                    if (no_urut) {
                        $('#id_merek' + no_urut).val(null).trigger('change');
                        $('#id_tipe_barang' + no_urut).val(null).trigger('change');
                    } else {
                        $('#id_merek').val(null).trigger('change');
                        $('#id_tipe_barang').val(null).trigger('change');
                    }
                } else if (tipe == 'id_merek') {
                    if (no_urut) {
                        $('#id_tipe_barang' + no_urut).val(null).trigger('change');
                    } else {
                        $('#id_tipe_barang').val(null).trigger('change');
                    }
                }
                $(id_tujuan).html(response).show();
            },
        });
    }

    $(function() {
        $('.select2').select2();
    })
</script>