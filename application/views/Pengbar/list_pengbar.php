<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                LIST PENGELUARAN BARANG
                <span <?php echo $My_Controller->savePermission; ?>>
                    | <button type="button" id='addPengbar' class='btn btn-info'>
                        Add New <i class="fa fa-plus"></i>
                    </button>
                </span>
            </header>
            <div class="panel-body">
                <table id="tablePengbar" class="table table-bordered text-center" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Tanggal Kirim Barang</th>
                            <th>Tujuan Uker</th>
                            <th>Tipe Barang</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>No SN</th>
                            <th>Qty</th>
                            <th>Kondisi Barang</th>
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
<div class="modal fade" id="formPengbar" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" class="form-horizontal group-border hover-stripped" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add/Edit Pengeluaran Barang</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_tran" id="id_tran">
                    <div class='form-group'>
                        <label for='tgl_kirim_barang' class='control-label'>Tanggal Kirim Barang</label>
                        <input type='date' value="<?= date('Y-m-d') ?>" name="tgl_kirim_barang" required class='form-control' id='tgl_kirim_barang' />
                    </div>
                    <div class='form-group'>
                        <label for='no_sn' class='control-label'>No SN</label>
                        <input type='text' name="no_sn" onkeyup="cariNosn(this.value)" required class='form-control' id='no_sn' />
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class='form-group' style="margin-right: 5px;">
                                <label for='gbrg' class='control-label'>Group Barang</label>
                                <input type='text' readonly name="gbrg" required class='form-control' id='gbrg' />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class='form-group'>
                                <label for='sgbrg' class='control-label'>Subgroup Barang</label>
                                <input type='text' readonly name="sgbrg" required class='form-control' id='sgbrg' />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class='form-group' style="margin-right: 5px;">
                                <label for='mbrg' class='control-label'>Merek Barang</label>
                                <input type='text' readonly name="mbrg" required class='form-control' id='mbrg' />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class='form-group'>
                                <label for='tpbrg' class='control-label'>Tipe Barang</label>
                                <input type='text' readonly name="tpbrg" required class='form-control' id='tpbrg' />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class='form-group' style="margin-right: 5px;">
                                <label for='kdbrg' class='control-label'>Kode Barang</label>
                                <input type='text' readonly name="kdbrg" required class='form-control' id='kdbrg' />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class='form-group'>
                                <label for='nmbrg' class='control-label'>Nama Barang</label>
                                <input type='hidden' name="no_urut" required class='form-control' id='no_urut' />
                                <input type='text' readonly name="nmbrg" required class='form-control' id='nmbrg' />
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='hbrg' class='control-label'>Harga Barang</label>
                        <input type='text' readonly name="hbrg" required class='form-control' id='hbrg' />
                    </div>
                    <div class="form-group">
                        <label for="id_uker">Uker Tujuan</label>
                        <select name="id_uker" id="id_uker" class="form-control select2" style="width: 100%;">
                            <option value="">Select Uker</option>
                            <?php foreach ($uker as $uk) { ?>
                                <option value="<?= $uk->id_uker ?>"><?= $uk->nama_uker ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kon_barang">Kondisi Barang</label>
                        <select name="kon_barang" id="kon_barang" class="form-control select2" style="width: 100%;">
                            <option value="Bagus">Bagus</option>
                            <option value="Rusak">Rusak</option>
                        </select>
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
    const urlPengbar = '<?= site_url("Pengbar/") ?>';
    let table;

    $(function() {
        if (!$.fn.DataTable.isDataTable('#tablePengbar')) {
            table = $('#tablePengbar').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                scrollX: true,
                dom: 'Bfrtip',
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],

                ajax: {
                    url: urlPengbar + "listPengbar",
                    type: "POST"
                },
                columnDefs: [{
                    targets: [0, -1],
                    orderable: false,
                }, ],
            });
        }

        $(".select2").select2({
            dropdownParent: $('#formPengbar'),
        });

        $('#addPengbar').on('click', function(e) {
            e.preventDefault();

            $('#form')[0].reset();
            $('#id_tran').val("");
            $('#no_urut').val("").trigger('change');
            $('#id_uker').val("").trigger('change');
            $('#formPengbar').modal('show');
        });

    });

    function VPengbar(id_tran) {
        $.ajax({
            url: urlPengbar + 'viewPengbar/' + id_tran,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $('#id_tran').val(response[0].id_tran);
                $('#tgl_kirim_barang').val(response[0].tgl_kirim_barang);
                $('#no_sn').val(response[0].no_sn);
                $('#gbrg').val(response[0].nama_gbarang);
                $('#sgbrg').val(response[0].nama_sgbarang);
                $('#mbrg').val(response[0].nama_merek);
                $('#tpbrg').val(response[0].tipe_barang);
                $('#kdbrg').val(response[0].kode_barang);
                $('#no_urut').val(response[0].no_urut);
                $('#nmbrg').val(response[0].nama_barang);
                $('#hbrg').val(response[0].harga_barang);
                $('#id_uker').val(response[0].id_uker).trigger('change');
                $('#kon_barang').val(response[0].kon_barang).trigger('change');
                $('#remark').val(response[0].remark);
                $('#formPengbar').modal('show');
            }
        });
    }

    function activePengbar(id_tran) {
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
                    url: urlPengbar + "activePengbar",
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

        if ($('#id_uker').val() == '') {
            Swal.fire("Pilih uker tujuan!", "", "info");
        } else {
            $.ajax({
                type: "POST",
                url: urlPengbar + 'formPengbar',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function(data) {
                    Swal.fire(data.pesan, "", data.tipe).then((result) => {
                        table.ajax.reload(null, false);
                        $('#form')[0].reset();
                        $('#no_urut').val("").trigger('change');
                        $('#formPengbar').modal('hide');
                    });
                },
            });
        }
    });

    function cariNosn(isinya) {
        $.ajax({
            type: "POST",
            url: urlPengbar + "cariNosn",
            data: {
                no_sn: isinya
            },
            dataType: "json",
            success: function(response) {
                if (response) {
                    $('#no_urut').val(response.no_urut);
                    $('#gbrg').val(response.nama_gbarang);
                    $('#sgbrg').val(response.nama_sgbarang);
                    $('#mbrg').val(response.nama_merek);
                    $('#tpbrg').val(response.tipe_barang);
                    $('#kdbrg').val(response.kode_barang);
                    $('#nmbrg').val(response.nama_barang);
                    $('#hbrg').val(response.harga_barang);
                } else {
                    $('#no_urut').val('-');
                    $('#gbrg').val('-');
                    $('#sgbrg').val('-');
                    $('#mbrg').val('-');
                    $('#tpbrg').val('-');
                    $('#kdbrg').val('-');
                    $('#nmbrg').val('-');
                    $('#hbrg').val('-');
                }
            }
        });
    }
</script>