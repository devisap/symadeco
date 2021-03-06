<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-list ml-2 mr-3 fa-lg"></i></div>
                            Daftar Pemesanan
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid mt-n10">
        <div class="card mb-4">
            <div class="card-header">
                <button class='btn btn-primary btn-sm' type='button' data-toggle="modal" data-target="#tambahModalPemesanan"><i class="fa fa-plus mr-1"></i>Tambah Pemesanan</button>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3 ml-4">
                        <label>Marketing : </label>
                        <br>
                        <select class="form-control" name="">
                            <option>Pilih Marketing</option>
                            <option value="1">Marketing A</option>
                            <option value="2">Marketing B</option>
                            <option value="3">Marketing C</option>
                        </select>
                    </div>
                    <div class="col-md-3 ml-4">
                        <label>Status : </label>
                        <br>
                        <select class="form-control">
                            <option>Semua Status</option>
                            <option>Baru</option>
                            <option>Cek Lokasi</option>
                            <option>Booking</option>
                            <option>Deal</option>
                            <option>Dikirim</option>
                            <option>Produksi</option>
                            <option>Dibongkar</option>
                            <option>Selesai</option>
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
                    <table class="table table-bordered table-hover" id="dataTableKlien" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No Pemesanan</th>
                                <th>Nama Klien</th>
                                <th>Marketing</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th>Biaya</th>
                                <th>Tgl Acara</th>
                                <th>Status</th>
                                <th width="11%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($pesanan as $items) {
                                $status = $items->STATUS_PEMESANAN;
                                $showstat = $status == 0 ? '<div class="badge badge-green badge-pill">Baru</div>' : ($status == 1 ? '<div class="badge badge-teal badge-pill">Cek Lokasi</div>' : ($status == 2 ? '<div class="badge badge-yellow badge-pill">Booking</div>' : ($status == 3 ? '<div class="badge badge-purple badge-pill">Deal</div>' : ($status == 4 ? '<div class="badge badge-purple-soft badge-pill">Dikirim</div>' : ($status == 5 ? '<div class="badge badge-cyan-soft badge-pill">Produksi</div>' : ($status == 6 ? '<div class="badge badge-cyan badge-pill">Dibongkar</div>' : ($status == 7 ? '<div class="badge badge-blue badge-pill">Selesai</div>' : '')))))));
                                $date = date_create($items->TGLACARA_PEMESANAN);

                                echo '
                                        <tr>
                                            <td>' . $items->NOMOR_PEMESANAN . '</td>
                                            <td>' . $items->NAMA_KLIEN . '</td>
                                            <td>' . $items->NAMA_PENGGUNA . '</td>
                                            <td>' . $items->ALAMAT_PEMESANAN . '</td>
                                            <td>' . $items->TELP_KLIEN . '</td>
                                            <td>Rp ' . number_format($items->BIAYA_PEMESANAN, 0, ',', '.') . '</td>
                                            <td>' . date_format($date, "d M Y") . '</td>
                                            <td>
                                                ' . $showstat . '
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-warning editPesanan ml-1 mt-1" data-id="' . $items->NOMOR_PEMESANAN . '" type="button" data-toggle="modal" data-target="#editPesanan"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-sm btn-green statusModal ml-1 mt-1" data-id="' . $items->NOMOR_PEMESANAN . '" type="button" data-toggle="modal" data-target="#statusModal"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-sm btn-dark ml-1 mt-1" type="button" data-toggle="modal" data-target="#pdfModal"><i class="fa fa-print"></i></button>
                                            </td>
                                        </tr>
                                    ';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal Tambah Pemesanan -->
            <div class="modal fade" id="tambahModalPemesanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Pemesanan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?= site_url('pemesanan/store') ?>">
                                <div class="form-group">
                                    <label for="namaKlien">Klien</label>
                                    <br>
                                    <select class="form-control" id="namaKlien" name="ID_KLIEN">
                                        <?php
                                        foreach ($klien as $item) {
                                            echo '
                                                <option value="' . $item->ID_KLIEN . '">' . $item->NAMA_KLIEN . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="namaMarketing">Marketing</label>
                                    <br>
                                    <select class="form-control " id="namaMarketing" name="ID_PENGGUNA">
                                        <?php
                                        foreach ($pengguna as $item) {
                                            echo '
                                                <option value="' . $item->ID_PENGGUNA . '">' . $item->NAMA_PENGGUNA . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="namaPaket">Paket</label>
                                    <br>
                                    <select class="form-control" id="namaPaket" name="ID_PAKET">
                                        <?php
                                        foreach ($paket as $item) {
                                            echo '
                                                <option value="' . $item->ID_PAKET . '">' . $item->NAMA_PAKET . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="uangMukalien">Uang Muka</label>
                                    <input type="number" name="UANGMUKA_PEMESANAN" class="form-control" placeholder="Masukan Uang Muka">
                                </div>
                                <div class="form-group">
                                    <label for="biaya">Biaya</label>
                                    <input type="number" name="BIAYA_PEMESANAN" class="form-control" placeholder="Masukan Biaya">
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <input type="text" name="DESKRIPSI_PEMESANAN" class="form-control" placeholder="Masukan Deskripsi">
                                </div>
                                <div class="form-group">
                                    <label for="alamatAcara">Alamat Acara</label>
                                    <input type="text" name="ALAMAT_PEMESANAN" class="form-control" placeholder="Masukan Alamat Acara">
                                </div>
                                <div class="form-group">
                                    <label for="tanggalAcara">Tanggal Acara</label>
                                    <input name="TGLACARA_PEMESANAN" class="form-control" id="tanggalAcara" type="text" placeholder="Masukkan Tanggal" />
                                </div>
                                <div class="form-group">
                                    <label for="tanggalSelesai">Tanggal Selesai</label>
                                    <input name="TGLSELESAI_PEMESANAN" class="form-control" id="tanggalSelesai" type="text" placeholder="Masukkan Tanggal" />
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="NOMOR_PEMESANAN" class="form-control" value="<?= date('YmdHis') ?>">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Batal</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check mr-1"></i>Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Edit Pemesanan -->
            <div class="modal fade" id="editPesanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Pemesanan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?= site_url('pemesanan/edit') ?>">
                                <div class="form-group">
                                    <label for="namaKlien">Klien</label>
                                    <br>
                                    <select class="form-control select-modal-width" id="namaKlien" name="ID_KLIEN">
                                        <?php
                                        foreach ($klien as $item) {
                                            echo '
                                                <option value="' . $item->ID_KLIEN . '">' . $item->NAMA_KLIEN . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="namaMarketing">Marketing</label>
                                    <br>
                                    <select class="form-control select-modal-width" id="namaMarketing" name="ID_PENGGUNA">
                                        <?php
                                        foreach ($pengguna as $item) {
                                            echo '
                                                <option value="' . $item->ID_PENGGUNA . '">' . $item->NAMA_PENGGUNA . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="namaPaket">Paket</label>
                                    <br>
                                    <select class="form-control select-modal-width" id="namaPaket" name="ID_PAKET">
                                        <?php
                                        foreach ($paket as $item) {
                                            echo '
                                                <option value="' . $item->ID_PAKET . '">' . $item->NAMA_PAKET . '</option>
                                            ';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="uangMuka">Uang Muka</label>
                                    <input type="text" id="uangMuka_edit" name="UANGMUKA_PEMESANAN" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="biaya">Biaya</label>
                                    <input type="text" id="biaya_edit" name="BIAYA_PEMESANAN" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <input type="text" id="deskripsi_edit" name="DESKRIPSI_PEMESANAN" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="alamatAcara">Alamat Acara</label>
                                    <input type="text" id="alamat_edit" name="ALAMAT_PEMESANAN" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="tglAcara_edit">Tanggal Acara</label>
                                    <input name="TGLACARA_PEMESANAN" class="form-control" id="tglAcara_edit" type="text" />
                                </div>
                                <div class="form-group">
                                    <label for="tglSelesai_edit">Tanggal Selesai</label>
                                    <input name="TGLSELESAI_PEMESANAN" class="form-control" id="tglSelesai_edit" type="text" />
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="idPemesanan_edit" name="NOMOR_PEMESANAN" class="form-control">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Batal</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check mr-1"></i>Simpan</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Status Aktif -->
            <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Status</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="<?= site_url('pemesanan/edit') ?>" method="post">
                            <div class="modal-body">
                                <select class="form-control select-modal-width">
                                    <option value="0">Baru</option>
                                    <option value="1">Cek Lokasi</option>
                                    <option value="2">Booking</option>
                                    <option value="3">Deal</option>
                                    <option value="4">Dikirim</option>
                                    <option value="5">Produksi</option>
                                    <option value="6">Dibongkar</option>
                                    <option value="7">Selesai</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="nomorPesanan_edit" name="NOMOR_PEMESANAN" class="form-control">
                                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Batal</button>
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
                            <h5 class="modal-title" >Daftar Pemesanan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <iframe id="pdfModal_src" src="<?= base_url('assets/pdf/form_pemesanan.pdf'); ?>" frameborder="0" width="100%" height="470px"></iframe>
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
<script type="text/javascript">
    //datepicker
    $('#tanggalAcara').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggalSelesai').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#editTanggalAcara').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#editTanggalSelesai').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });
</script>
<script>
    $().ready(function() {
        var table = $('#dataTableKlien').DataTable({
            ordering: false,
            "order": [
                [0, 'asc']
            ],
            fixedColumns: false
        });
    });
    $('#dataTableKlien tbody').on('click', '.editPesanan', function() {
        const id = $(this).data('id');
        $.ajax({
            url: "<?= site_url('pemesanan/ajxGet') ?>",
            type: "post",
            dataType: 'json',
            data: {
                NOMOR_PEMESANAN: id
            },
            success: res => {
                $('#idKlien_edit').val(res[0].ID_KLIEN)
                $('#idPaket_edit').val(res[0].ID_PAKET)
                $('#idPengguna_edit').val(res[0].ID_PENGGUNA)
                $('#uangMuka_edit').val(res[0].UANGMUKA_PEMESANAN)
                $('#biaya_edit').val(res[0].BIAYA_PEMESANAN)
                $('#deskripsi_edit').val(res[0].DESKRIPSI_PEMESANAN)
                $('#alamat_edit').val(res[0].ALAMAT_PEMESANAN)
                $('#tglAcara_edit').val(res[0].TGLACARA_PEMESANAN)
                $('#tglSelesai_edit').val(res[0].TGLSELESAI_PEMESANAN)
                $('#idPemesanan_edit').val(res[0].NOMOR_PEMESANAN)
            }
        })
    });
    $('#dataTableKlien tbody').on('click', '.statusModal', function() {
        const id = $(this).data('id');
        $('#nomorPesanan_edit').val(id)
    });

    $('#dataTableKlien tbody').on('click', '.pdfModal', function() {
        const src = $(this).data("src")
        $('#pdfModal_src').attr('src', src);
    })
</script>