<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                LIST PENERIMAAN BARANG CABANG
            </header>
            <div class="panel-body">
                <table id="tablePenbarcab" class="table table-bordered text-center" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Tanggal Kirim Barang</th>
                            <th>Tanggal Terima Barang</th>
                            <th>Dari Uker</th>
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
<div class="modal fade" id="formPenbarcab" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" class="form-horizontal group-border hover-stripped" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Penerimaan Barang Cabang</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_tran" id="id_tran">
                    <div class='form-group'>
                        <label for='tgl_terima_barang' class='control-label'>Tanggal Terima Barang</label>
                        <input type='date' value="<?= date('Y-m-d') ?>" name="tgl_terima_barang" required class='form-control' id='tgl_terima_barang' />
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
                        <label for="kon_barang">Kondisi Barang</label>
                        <select disabled name="kon_barang" id="kon_barang" class="form-control select2" style="width: 100%;">
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
    const urlPenbarcab = '<?= site_url("Penbarcab/") ?>';
    let table;

    $(function() {
        if (!$.fn.DataTable.isDataTable('#tablePenbarcab')) {
            table = $('#tablePenbarcab').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                scrollX: true,
                dom: 'Bfrtip',
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],

                ajax: {
                    url: urlPenbarcab + "listPenbarcab",
                    type: "POST"
                },
                columnDefs: [{
                    targets: [0, -1],
                    orderable: false,
                }, ],
            });
        }

        $(".select2").select2({
            dropdownParent: $('#formPenbarcab'),
        });

        $('#addPenbarcab').on('click', function(e) {
            e.preventDefault();

            $('#form')[0].reset();
            $('#id_tran').val("");
            $('#dari_uker').val("").trigger('change');
            $('#no_urut').val("").trigger('change');
            $('#formPenbarcab').modal('show');
        });

    });

    function VPenbarcab(id_tran) {
        $.ajax({
            url: urlPenbarcab + 'viewPenbarcab/' + id_tran,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $('#id_tran').val(response[0].id_tran);
                $('#dari_uker').val(response[0].dari_uker);
                $('#id_uker').val(response[0].dari_uker).trigger('change');
                $('#formPenbarcab').modal('show');
            }
        });
    }

    function activePenbarcab(id_tran) {
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
                    url: urlPenbarcab + "activePenbarcab",
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
            url: urlPenbarcab + 'formPenbarcab',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data) {
                Swal.fire(data.pesan, data.text, data.tipe).then((result) => {
                    table.ajax.reload(null, false);
                    $('#form')[0].reset();
                    $('#no_urut').val("").trigger('change');
                    $('#formPenbarcab').modal('hide');
                });
            },
        });
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