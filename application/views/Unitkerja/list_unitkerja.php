<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                LIST UNIT KERJA
                <span <?php echo $My_Controller->savePermission; ?>>
                    | <button type="button" id='addUnitkerja' class='btn btn-info'> Add New <i class="fa fa-plus"></i></button>
                </span>
            </header>
            <div class="panel-body">
                <table id="tableUnitkerja" class="table table-bordered" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Kode Uker</th>
                            <th>Nama Uker</th>
                            <th>Keterangan</th>
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
<div class="modal fade" id="formUnitkerja" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" class="form-horizontal group-border hover-stripped" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add Unit Kerja</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_uker" id="id_uker">
                    <div class='form-group'>
                        <label class='control-label'>Kode Uker</label>
                        <input type='number' id="kode" name="kode" required class='form-control' />
                    </div>
                    <div class='form-group'>
                        <label class='control-label'>Nama Uker</label>
                        <input type='text' id="nama" name="nama" required class='form-control' />
                    </div>
                    <div class='form-group'>
                        <label class='control-label'>Keterangan</label>
                        <textarea id="ket" name="ket" class="form-control" rows="2"></textarea>
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
    const urlUnitkerja = '<?= site_url("Unitkerja/") ?>';
    let table;

    $(function() {
        if (!$.fn.DataTable.isDataTable('#tableUnitkerja')) {
            table = $('#tableUnitkerja').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                scrollX: true,
                dom: 'Bfrtip',
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],

                ajax: {
                    url: urlUnitkerja + "listUnitkerja",
                    type: "POST"
                },
                columnDefs: [{
                    targets: [0, -1],
                    orderable: false,
                }, ],
            });
        }

        $('#addUnitkerja').on('click', function(e) {
            e.preventDefault();

            $('#form')[0].reset();
            $('#id_uker').val("");
            $('#formUnitkerja').modal('show');
        });
    });

    function VUnitkerja(id_uker) {
        $.ajax({
            url: urlUnitkerja + 'viewUnitkerja/' + id_uker,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $('#id_uker').val(response[0].id_uker);
                $('#kode').val(response[0].kode_uker);
                $('#nama').val(response[0].nama_uker);
                $('#ket').val(response[0].ket_uker);
                $('#formUnitkerja').modal('show');
            }
        });
    }

    function activeUnitkerja(id_uker) {
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
                        id_uker: id_uker
                    },
                    url: urlUnitkerja + "activeUnitkerja",
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
            url: urlUnitkerja + 'formUnitkerja',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data) {
                Swal.fire(data.pesan, "", data.tipe).then((result) => {
                    table.ajax.reload(null, false);
                    $('#form')[0].reset();
                    $('#formUnitkerja').modal('hide');
                });
            },
        });
    });
</script>