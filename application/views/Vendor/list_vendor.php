<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                LIST VENDOR
                <span <?php echo $My_Controller->savePermission; ?>>
                    | <button id='addVendor' class='btn btn-info'>
                        Add New <i class="fa fa-plus"></i>
                    </button>
                </span>
            </header>
            <div class="panel-body">
                <table style="width: 100%;" class="table table-bordered" id="tableVendor">
                    <thead>
                        <tr role="row">
                            <th>No</th>
                            <th>Nama Vendor</th>
                            <th>Telp Vendor</th>
                            <th>Alamat Vendor</th>
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
<div class="modal fade" id="formVendor" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" class="form-horizontal group-border hover-stripped" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add/Edit Vendor</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_vendor" id="id_vendor">
                    <div class='form-group'>
                        <label class='control-label'>Nama Vendor</label>
                        <input type='text' name="nama" id="nama" class='form-control' />
                    </div>
                    <div class='form-group'>
                        <label class='control-label'>Telp Vendor</label>
                        <input type='number' name="telp" id="telp" class='form-control' />
                    </div>
                    <div class='form-group'>
                        <label class='control-label'>Alamat Vendor</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="2"></textarea>
                    </div>
                    <div class='form-group'>
                        <label class='control-label'>Nama PIC</label>
                        <input type='text' name="namapic" id="namapic" class='form-control' />
                    </div>
                    <div class='form-group'>
                        <label class='control-label'>Telp PIC</label>
                        <input type='number' name="telppic" id="telppic" class='form-control' />
                    </div>
                    <div class='form-group'>
                        <label class='control-label'>Keterangan</label>
                        <textarea name="ket" id="ket" class="form-control" rows="2"></textarea>
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

<!--Modal for PIC -->
<div class="modal fade" id="PICvendor" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">PIC Vendor <b id="t_vendor"></b></h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <td style="width: 35%;">Nama PIC</td>
                            <td style="width: 5%;">:</td>
                            <td><b id="mnpic"></b></td>
                        </tr>
                        <tr>
                            <td style="width: 35%;">Telp PIC</td>
                            <td style="width: 5%;">:</td>
                            <td><b id="mtpic"></b></td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--Modal for PIC ends-->

<script>
    const urlVendor = '<?= site_url("Vendor/") ?>';
    let table;

    $(function() {
        if (!$.fn.DataTable.isDataTable('#tableVendor')) {
            table = $('#tableVendor').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                order: [],
                scrollX: true,
                dom: 'Bfrtip',
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],

                ajax: {
                    url: urlVendor + "listVendor",
                    type: "POST"
                },
                columnDefs: [{
                    targets: [0, -1],
                    orderable: false,
                }, ],
            });
        }

        $('#addVendor').on('click', function(e) {
            e.preventDefault();

            $('#form')[0].reset();
            $('#id_vendor').val("");
            $('#formVendor').modal('show');
        });

    });

    function VVendor(id_vendor) {
        $.ajax({
            url: urlVendor + 'viewVendor/' + id_vendor,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $('#id_vendor').val(response[0].id_vendor);
                $('#nama').val(response[0].nama_vendor);
                $('#telp').val(response[0].telp_vendor);
                $('#alamat').val(response[0].alamat_vendor);
                $('#namapic').val(response[0].nama_pic);
                $('#telppic').val(response[0].telp_pic);
                $('#ket').val(response[0].ket);
                $('#formVendor').modal('show');
            }
        });
    }

    function activeVendor(id_vendor) {
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
                        id_vendor: id_vendor
                    },
                    url: urlVendor + "activeVendor",
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
            url: urlVendor + 'formVendor',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function(data) {
                Swal.fire(data.pesan, "", data.tipe).then((result) => {
                    table.ajax.reload(null, false);
                    $('#form')[0].reset();
                    $('#formVendor').modal('hide');
                });
            },
        });
    });

    function Vpic(id_vendor) {
        $.ajax({
            url: urlVendor + 'viewVendor/' + id_vendor,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $('#t_vendor').text(response[0].nama_vendor);
                $('#mnpic').text(response[0].nama_pic);
                $('#mtpic').text(response[0].telp_pic);
                $('#PICvendor').modal('show');
            }
        });
    }
</script>