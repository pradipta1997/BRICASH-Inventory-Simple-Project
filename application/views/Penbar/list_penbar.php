<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                LIST PENERIMAAN BARANG VENDOR
                <span <?php echo $My_Controller->savePermission; ?>>
                    | <button type="button" id='addPenbar' class='btn btn-info'>
                        Add New <i class="fa fa-plus"></i>
                    </button>
                </span>
            </header>
            <div class="panel-body">
                <table id="tablePenbar" class="table table-bordered text-center" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Tanggal Terima Barang</th>
                            <th>No Referensi</th>
                            <th>Penerima Uker</th>
                            <th>Nama Vendor</th>
                            <th>Tipe Barang</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>No SN</th>
                            <th>Qty</th>
                            <th>Harga Barang</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody role="alert" aria-live="polite" aria-relevant="all"></tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<!--Modal for ADD -->
<div class="modal fade" id="formPenbar" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" class="form-horizontal group-border hover-stripped" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add/Edit Penerimaan Barang Vendor</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_tran" id="id_tran">
                    <div class='form-group'>
                        <label for='tgl_terima_barang' class='control-label'>Tanggal Terima Barang</label>
                        <input type='date' value="<?= date('Y-m-d') ?>" name="tgl_terima_barang" required class='form-control' id='tgl_terima_barang' />
                    </div>
                    <div class='form-group'>
                        <label for='no_referensi' class='control-label'>No Referensi</label>
                        <input type='text' name="no_referensi" required class='form-control' id='no_referensi' />
                    </div>
                    <div class="form-group">
                        <label for="id_vendor" class="control-label">Nama Vendor</label>
                        <select class="form-control select2" required name="id_vendor" id="id_vendor" style="width: 100%;">
                            <option value="">Select Vendor</option>
                            <?php foreach ($vendor as $vd) : ?>
                                <option value="<?php echo $vd->id_vendor; ?>"><?php echo $vd->nama_vendor; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_urut" class="control-label">Nama Barang</label>
                        <select class="form-control select2" required name="no_urut" id="no_urut" style="width: 100%;">
                            <option value="">Select Barang</option>
                            <?php foreach ($barang as $brg) : ?>
                                <option value="<?php echo $brg->no_urut; ?>"><?php echo $brg->nama_barang; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='no_sn' class='control-label'>No SN</label>
                        <input type='text' name="no_sn" required class='form-control' id='no_sn' />
                    </div>
                    <div class='form-group'>
                        <label for='harga_barang' class='control-label'>Harga Barang</label>
                        <input type='number' name="harga_barang" required class='form-control' id='harga_barang' />
                    </div>
                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea id="remark" class="form-control" name="remark"></textarea>
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

<script>
    const urlPenbar = '<?= site_url("Penbar/") ?>';
    let table;

    $(function() {
        if (!$.fn.DataTable.isDataTable('#tablePenbar')) {
            table = $('#tablePenbar').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                scrollX: true,
                dom: 'Bfrtip',
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],

                ajax: {
                    url: urlPenbar + "listPenbar",
                    type: "POST"
                },
                columnDefs: [{
                    targets: [0, -1],
                    orderable: false,
                }, ],
            });
        }

        $(".select2").select2({
            dropdownParent: $('#formPenbar'),
        });

        $('#addPenbar').on('click', function(e) {
            e.preventDefault();

            $('#form')[0].reset();
            $('#id_tran').val("");
            $('#id_vendor').val("").trigger('change');
            $('#no_urut').val("").trigger('change');
            $('#formPenbar').modal('show');
        });

    });

    function VPenbar(id_tran) {
        $.ajax({
            url: urlPenbar + 'viewPenbar/' + id_tran,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $('#id_tran').val(response[0].id_tran);
                $('#id_vendor').val(response[0].id_vendor).trigger('change');
                $('#no_urut').val(response[0].no_urut).trigger('change');
                $('#no_referensi').val(response[0].no_referensi);
                $('#tgl_terima_barang').val(response[0].tgl_terima_barang);
                $('#no_sn').val(response[0].no_sn);
                $('#harga_barang').val(response[0].harga_barang);
                $('#kon_barang').val(response[0].kon_barang).trigger('change');
                $('#remark').val(response[0].remark);
                $('#formPenbar').modal('show');
            }
        });
    }

    function activePenbar(id_tran) {
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
                        id_tran: id_tran
                    },
                    url: urlPenbar + "activePenbar",
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
            url: urlPenbar + 'formPenbar',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data) {
                Swal.fire(data.pesan, "", data.tipe).then((result) => {
                    table.ajax.reload(null, false);
                    $('#form')[0].reset();
                    $('#no_urut').val("").trigger('change');
                    $('#formPenbar').modal('hide');
                });
            },
        });
    });
</script>