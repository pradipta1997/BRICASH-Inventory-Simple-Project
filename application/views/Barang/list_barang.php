<div class="row">
    <div class="col-sm-12">
        <section class="panel">

            <header class="panel-heading">
                LIST BARANG
                <span <?php echo $My_Controller->savePermission; ?>>
                    | <button type="button" id='addBarang' class='btn btn-info'>
                        Add New <i class="fa fa-plus"></i>
                    </button>
                </span>
            </header>

            <div class="panel-body">
                <table id="tableBarang" class="table table-bordered" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Group Barang</th>
                            <th>Subgroup Barang</th>
                            <th>Merek Barang</th>
                            <th>Tipe Barang</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all"></tbody>
                </table>
            </div>

        </section>
    </div>
</div>

<!-- ---------------------------------------------------------------------------------------------------------------------------- -->

<!--Modal for ADD -->
<div class="modal fade" id="formBarang" tabindex="-1" role="basic" aria-hidden="true">

    <div class="modal-dialog">
        <form id="form" class="form-horizontal group-border hover-stripped" method="post">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add/Edit Barang</h4>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label for="id_gbarang" class="control-label">Group Barang</label>
                        <select class="form-control select2" required name="id_gbarang" onchange="ChainedBarang('<?= base_url('Chained/Listsubgroupbarang/') ?>'+this.value, '#id_sgbarang', 'id_gbarang')" id="id_gbarang" style="width: 100%;">
                            <option value="">Select Group Barang</option>
                            <?php foreach ($gbarang as $gb) : ?>
                                <option value="<?php echo $gb->id_gbarang; ?>"><?php echo $gb->nama_gbarang; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_sgbarang" class="control-label">Subgroup Barang</label>
                        <select class="form-control select2" required name="id_sgbarang" id="id_sgbarang" onchange="ChainedBarang('<?= base_url('Chained/Listmerekbarang/') ?>'+this.value, '#id_merek', 'id_sgbarang')" style="width: 100%;">
                            <option value="">Select Subgroup Barang</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_merek" class="control-label">Merek Barang</label>
                        <select class="form-control select2" required name="id_merek" id="id_merek" onchange="ChainedBarang('<?= base_url('Chained/Listtipebarang/') ?>'+this.value, '#id_tipe_barang', 'id_merek')" style="width: 100%;">
                            <option value="">Select Merek Barang</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_tipe_barang" class="control-label">Tipe Barang</label>
                        <select class="form-control select2" required name="id_tipe_barang" id="id_tipe_barang" style="width: 100%;">
                            <option value="">Select Tipe Barang</option>
                        </select>
                    </div>

                    <div class='form-group'>
                        <label for='kode_barang' class='control-label'>Kode Barang</label>
                        <input type='text' name="kode_barang" required class='form-control' id='kode_barang' />
                    </div>

                    <div class='form-group'>
                        <label for='nama_barang' class='control-label'>Nama Barang</label>
                        <input type='text' name="nama_barang" required class='form-control' id='nama_barang' />
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="submit" value="Save" class="btn btn-success">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>

</div>
<!--Modal for ADD ends-->

<!-- ---------------------------------------------------------------------------------------------------------------------------- -->

<!--Modal for EDIT -->
<?php foreach ($barang as $brg) { ?>
    <div class="modal fade" id="editBarang<?= $brg->no_urut ?>" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">

            <form action="<?= base_url('Barang/formBarang') ?>" class="form-horizontal group-border hover-stripped" method="post">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Add/Edit Barang</h4>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="no_urut" value="<?= $brg->no_urut ?>">
                        <div class="form-group">
                            <label class="control-label">Group Barang</label>
                            <select class="form-control select2" required name="id_gbarang" onchange="ChainedBarang('<?= base_url('Chained/Listsubgroupbarang/') ?>'+this.value, '#id_sgbarang<?= $brg->no_urut ?>', 'id_gbarang', <?= $brg->no_urut ?>)" id="id_gbarang<?= $brg->no_urut ?>" style="width: 100%;">
                                <option value="">Select Group Barang</option>
                                <?php foreach ($gbarang as $gb) : ?>
                                    <option <?= $brg->id_gbarang == $gb->id_gbarang ? 'selected' : '' ?> value="<?php echo $gb->id_gbarang; ?>"><?php echo $gb->nama_gbarang; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Subgroup Barang</label>
                            <select class="form-control select2" required name="id_sgbarang" style="width: 100%;" id="id_sgbarang<?= $brg->no_urut ?>" onchange="ChainedBarang('<?= base_url('Chained/Listmerekbarang/') ?>'+this.value, '#id_merek<?= $brg->no_urut ?>', 'id_sgbarang', <?= $brg->no_urut ?>)">
                                <option value="">Select Subgroup Barang</option>
                                <?php
                                $sgbarang = $this->General->fetch_records("tbl_sgbarang", ['is_active' => 1, 'id_gbarang' => $brg->id_gbarang]);
                                foreach ($sgbarang as $sgb) {
                                ?>
                                    <option <?= $brg->id_sgbarang == $sgb->id_sgbarang ? 'selected' : '' ?> value="<?= $sgb->id_sgbarang ?>"><?= $sgb->nama_sgbarang ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Merek Barang</label>
                            <select class="form-control select2" required name="id_merek" id="id_merek<?= $brg->no_urut ?>" onchange="ChainedBarang('<?= base_url('Chained/Listtipebarang/') ?>'+this.value, '#id_tipe_barang<?= $brg->no_urut ?>', 'id_merek', <?= $brg->no_urut ?>)" style="width: 100%;">
                                <option value="">Select Merek Barang</option>
                                <?php
                                $mbarang = $this->General->fetch_records("tbl_merek", ['is_active' => 1, 'id_sgbarang' => $brg->id_sgbarang]);
                                foreach ($mbarang as $mb) {
                                ?>
                                    <option <?= $brg->id_merek == $mb->id_merek ? 'selected' : '' ?> value="<?= $mb->id_merek ?>"><?= $mb->nama_merek ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Tipe Barang</label>
                            <select class="form-control" required name="id_tipe_barang" id="id_tipe_barang<?= $brg->no_urut ?>" style="width: 100%;">
                                <option value="">Select Tipe Barang</option>
                                <?php
                                $tipebrg = $this->General->fetch_records("tbl_tipe_barang", ['is_active' => 1, 'id_merek' => $brg->id_merek]);
                                foreach ($tipebrg as $tb) {
                                ?>
                                    <option <?= $brg->id_tipe_barang == $tb->id_tipe_barang ? 'selected' : '' ?> value="<?= $tb->id_tipe_barang ?>"><?= $tb->tipe_barang ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class='form-group'>
                            <label for='kode_barang' class='control-label'>Kode Barang</label>
                            <input type='text' name="kode_barang" required class='form-control' value="<?= $brg->kode_barang ?>" />
                        </div>

                        <div class='form-group'>
                            <label class='control-label'>Nama Barang</label>
                            <input type='text' name="nama_barang" required class='form-control' value="<?= $brg->nama_barang ?>" />
                        </div>

                    </div>

                    <div class="modal-footer">
                        <input type="submit" value="Save" class="btn btn-success">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
<?php } ?>
<!--Modal for EDIT ends-->

<!-- ------------------------------------------------------------------------------------------------------------------------------------------ -->

<script>
    const urlBarang = '<?= site_url("Barang/") ?>';
    let table;

    $(function() {
        if (!$.fn.DataTable.isDataTable('#tableBarang')) {
            table = $('#tableBarang').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                scrollX: true,
                dom: 'Bfrtip',
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],

                ajax: {
                    url: urlBarang + "listBarang",
                    type: "POST"
                },
                columnDefs: [{
                    targets: [0, -1],
                    orderable: false,
                }, ],
            });
        }

        $('#addBarang').on('click', function(e) {
            e.preventDefault();

            $('#form')[0].reset();
            $('#no_urut').val("");
            $('#id_uker').val("").trigger('change');
            $('#id_gbarang').val("").trigger('change');
            $('#id_sgbarang').val("").trigger('change');
            $('#id_merek').val("").trigger('change');
            $('#id_tipe_barang').val("").trigger('change');
            $('#formBarang').modal('show');
        });

    });

    $('body').on('shown.bs.modal', '.modal', function() {
        $(this).find('select').each(function() {
            var dropdownParent = $(document.body);
            if ($(this).parents('.modal.in:first').length !== 0)
                dropdownParent = $(this).parents('.modal.in:first');
            $(this).select2({
                dropdownParent: dropdownParent
            });
        });
    });

    function activeBarang(no_urut) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    data: {
                        no_urut: no_urut
                    },
                    url: urlBarang + "activeBarang",
                    dataType: 'JSON',
                    success: function(response) {
                        if (response) {
                            Swal.fire(response, "", "success").then((result) => {
                                table.ajax.reload(null, false);
                            });
                        } else {
                            Swal.fire("Data gagal di delete!", "", "error");
                        }
                    },
                });
            }
        });
    }

    $("#form").on("submit", function(event) {
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: urlBarang + 'formBarang',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data) {
                Swal.fire(data.pesan, "", data.tipe).then((result) => {
                    location.reload();
                    $('#form')[0].reset();
                    $('#id_uker').val("").trigger('change');
                    $('#id_tipe_barang').val("").trigger('change');
                    $('#formBarang').modal('hide');
                });
            },
        });
    });

    function ChainedBarang(url, id_tujuan, tipe, no_urut = null) {
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
</script>