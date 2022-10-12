<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                LIST JENIS TRANSAKSI
                <span <?php echo $My_Controller->savePermission; ?>>
                    | <button type="button" id='addJtran' class='btn btn-info'>
                        Add New <i class="fa fa-plus"></i>
                    </button>
                </span>
            </header>
            <div class="panel-body">
                <table id="tableJtran" class="table table-bordered" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Nama Jenis Transaksi</th>
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
<div class="modal fade" id="formJtran" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" class="form-horizontal group-border hover-stripped" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add/Edit Jenis Transaksi</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_jtran" id="id_jtran">
                    <div class='form-group'>
                        <label class='control-label'>Jenis Transaksi</label>
                        <input type='text' name="nama" id="nama" required class='form-control' />
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
    const urlJtran = '<?= site_url("Jtran/") ?>';
    let table;

    $(function() {
        if (!$.fn.DataTable.isDataTable('#tableJtran')) {
            table = $('#tableJtran').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                scrollX: true,
                dom: 'Bfrtip',
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],

                ajax: {
                    url: urlJtran + "listJtran",
                    type: "POST"
                },
                columnDefs: [{
                    targets: [0, -1],
                    orderable: false,
                }, ],
            });
        }

        $('#addJtran').on('click', function(e) {
            e.preventDefault();

            $('#form')[0].reset();
            $('#id_jtran').val("");
            $('#formJtran').modal('show');
        });

    });

    function VJtran(id_jtran) {
        $.ajax({
            url: urlJtran + 'viewJtran/' + id_jtran,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $('#id_jtran').val(response[0].id_jtran);
                $('#nama').val(response[0].nama_jtran);
                $('#formJtran').modal('show');
            }
        });
    }

    function activeJtran(id_jtran) {
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
                        id_jtran: id_jtran
                    },
                    url: urlJtran + "activeJtran",
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
            url: urlJtran + 'formJtran',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data) {
                Swal.fire(data.pesan, "", data.tipe).then((result) => {
                    table.ajax.reload(null, false);
                    $('#form')[0].reset();
                    $('#formJtran').modal('hide');
                });
            },
        });
    });
</script>