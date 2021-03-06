<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-envelope ml-2 mr-3 fa-lg"></i></div>
                            Surat Kontrak Kerja
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid mt-n10">
        <div class="card mb-4">
            <div class="card-header">
                <button class='btn btn-primary btn-sm' type='button' data-toggle="modal" data-target="#tambahKontrakKerja"><i class="fa fa-plus mr-1"></i>Tambah Kontrak Kerja</button>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3 ml-4">
                        <label>Klien : </label>
                        <br>
                        <select class="form-control">
                            <option>Pilih Klien</option>
                            <option>Ilham</option>
                            <option>Dedy</option>
                        </select>
                    </div>
                    <div class="col-md-2 mt-2">
                        <label></label>
                        <button type="submit" class="btn btn-primary btn-block">Tampilkan</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="datatable">
                    <table class="table table-bordered table-hover" id="dataTableKontrakKerja" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No Surat</th>
                                <th>No Pemesanan</th>
                                <th>Nama Klien</th>
                                <th>Alamat</th>
                                <th>Biaya</th>
                                <th>Tgl Acara</th>
                                <th width=12%>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($skk as $items){     
                                    $date=date_create($items->TGLACARA_PEMESANAN);
                                    echo'
                                        <tr>
                                            <td>'.$items->NOMOR_SKK.'/VIII/SKK/'.date_format($date,"Y").'</td>
                                            <td>'.$items->NOMOR_PEMESANAN.'</td>
                                            <td>'.$items->NAMA_KLIEN.'</td>
                                            <td>'.$items->ALAMAT_PEMESANAN.'</td>
                                            <td>'.$items->BIAYA_PEMESANAN.'</td>
                                            <td>'.date_format($date,"d M Y").'</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning ml-1 editKontrakKerja" type="button" data-id="'. $items->NOMOR_SKK .'" data-toggle="modal" data-target="#editKontrakKerja"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-sm btn-dark ml-1" type="button" data-toggle="modal" data-target="#pdfModal"><i class="fa fa-print"></i></button>
                                            </td>
                                        </tr>
                                    ';
                                }
                            ?> 
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Tambah Surat Kontrak Kerja -->
            <div class="modal fade" id="tambahKontrakKerja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Surat Kontrak Kerja</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?= site_url('skk/store') ?>">
                                <div class="form-group">
                                    <label for="KontrakKerja">No Pemesanan</label>
                                    <br>
                                    <select class="form-control select-modal-width" id="KontrakKerja" name="NOMOR_PEMESANAN">
                                        <option>Pilih No Pemesanan</option>
                                        <?php
                                        foreach ($pemesanan as $item) {
                                            echo '
                                                <option value="' . $item->NOMOR_PEMESANAN . '">' . $item->NOMOR_PEMESANAN . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="NOMOR_SKK" class="form-control" value="<?= date('Ymds').'/III/SKK/2021' ?>">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Batal</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check mr-1"></i>Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Edit Surat Kontrak Kerja -->
            <div class="modal fade" id="editKontrakKerja" tabindex="-1" role="dialog" aria-labelledby="editKontrakKerja" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editKontrakKerja">Edit Surat Kontrak Kerja</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= site_url('skk/edit') ?>" method="post">
                                <div class="form-group">
                                    <label for="alamatAcara">No Surat</label>
                                    <input type="text" id="nomorSKK_edit" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="PemesananEdit">No Pemesanan</label>
                                    <br>
                                    <select class="form-control select-modal-width" id="nomorPemesanan_edit" name="NOMOR_PEMESANAN">
                                        <option>Pilih No Pemesanan</option>
                                        <?php
                                        foreach ($pemesanan as $item) {
                                            echo '
                                                <option value="' . $item->NOMOR_PEMESANAN . '">' . $item->NOMOR_PEMESANAN . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="nomorSKK_insert" name="NOMOR_SKK" class="form-control">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Batal</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check mr-1"></i>Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

             <!-- Modal View PDF -->
             <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" >Surat Kontrak Kerja</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <iframe id="pdfModal_src" src="<?= base_url('assets/pdf/surat_kontrak_kerja.pdf'); ?>" frameborder="0" width="100%" height="470px"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $().ready(function() {
        var table = $('#dataTableKontrakKerja').DataTable({
            ordering: false,
            "order": [
                [0, 'asc']
            ],
            fixedColumns: false
        });
    });
    $('#dataTableKontrakKerja tbody').on('click', '.editKontrakKerja', function() {
        const id = $(this).data('id');
        $.ajax({
            url: "<?= site_url('skk/ajxGet') ?>",
            type: "post",
            dataType: 'json',
            data: {
                NOMOR_SKK: id
            },
            success: res => {
                $('#nomorPemesanan_edit').val(res[0].NOMOR_PEMESANAN)          
                $('#nomorSKK_edit').val(res[0].NOMOR_SKK)       
                $('#nomorSKK_insert').val(res[0].NOMOR_SKK)
            }
        })
    });

    $('#dataTableKontrakKerja tbody').on('click', '.pdfModal', function() {
        const src = $(this).data("src")
        $('#pdfModal_src').attr('src', src);
    })
</script>