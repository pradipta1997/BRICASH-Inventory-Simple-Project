<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                LIST TIPE BARANG
                <span <?php echo $My_Controller->savePermission; ?>>
                    | <button type="button" id='addTipebarang' data-toggle='modal' class='btn btn-info'>
                        Add New <i class="fa fa-plus"></i>
                    </button>
                </span>
            </header>
            <div class="panel-body">
                <table id="tableTipebarang" class="table table-bordered" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Nama Group Barang</th>
                            <th>Nama Subgroup Barang</th>
                            <th>Nama Merek Barang</th>
                            <th>Nama Tipe Barang</th>
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

<!--Modal for ADD -->
<div class="modal fade" id="formTipebarang" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" class="form-horizontal group-border hover-stripped" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add/Edit Tipe Barang</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_tipe_barang" id="id_tipe_barang">
                    <div class="form-group">
                        <label for="id_merek" class="control-label">Merek Barang</label>
                        <select class="form-control select2" required name="id_merek" id="id_merek" style="width: 100%;">
                            <option value="">Select Merek Barang</option>
                            <?php foreach ($mbarang as $mb) : ?>
                                <option value="<?php echo $mb->id_merek; ?>"><?php echo $mb->nama_gbarang . " | " . $mb->nama_sgbarang . " | " . $mb->nama_merek; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='nama' class='control-label'>Nama Tipe Barang</label>
                        <input type='text' name="nama" required class='form-control' id='nama' />
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
    const urlTipebarang = '<?= site_url("Tipebarang/") ?>';
    let table;

    $(function() {
        if (!$.fn.DataTable.isDataTable('#tableTipebarang')) {
            table = $('#tableTipebarang').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                scrollX: true,
                dom: 'Bfrtip',
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],

                ajax: {
                    url: urlTipebarang + "listTipebarang",
                    type: "POST"
                },
                columnDefs: [{
                    targets: [0, -1],
                    orderable: false,
                }, ],
            });
        }

        $('#addTipebarang').on('click', function(e) {
            e.preventDefault();

            $('#form')[0].reset();
            $('#id_tipe_barang').val("");
            $('#id_merek').val("").trigger('change');
            $('#formTipebarang').modal('show');
        });

        $(".select2").select2({
            dropdownParent: $('#formTipebarang'),
        });
    });

    function VTipebarang(id_tipe_barang) {
        $.ajax({
            url: urlTipebarang + 'viewTipebarang/' + id_tipe_barang,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $('#id_tipe_barang').val(response[0].id_tipe_barang);
                $('#id_merek').val(response[0].id_merek).trigger('change');
                $('#kode_barang').val(response[0].kode_barang);
                $('#nama').val(response[0].tipe_barang);
                $('#formTipebarang').modal('show');
            }
        });
    }

    function activeTipebarang(id_tipe_barang) {
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
                        id_tipe_barang: id_tipe_barang
                    },
                    url: urlTipebarang + "activeTipebarang",
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
            url: urlTipebarang + 'formTipebarang',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data) {
                Swal.fire(data.pesan, "", data.tipe).then((result) => {
                    table.ajax.reload(null, false);
                    $('#form')[0].reset();
                    $('#formTipebarang').modal('hide');
                });
            },
        });
    });
</script>