<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="col-8">
        <div class="row">
            <h2 class="my-3">Form Tambah Data Komik</h2>
            <form action="/komik/save" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); /*ini adalah fitur keamanan terbaru dari CI4 berfungsi u/ menghindari pembajakan input form dr hacker-
                jadi form ini hanya akan dapat diisi dari from ini saja tdk dpt dr hal lain. */ ?>
                <div class="row mb-3">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="judul" name="judul" autofocus value=<?= old('judul'); ?>>
                        <div id="validationServer05Feedback" class="invalid-feedback">
                            <?= $validation->getError('judul'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="penulis" name="penulis" value=<?= old('penulis'); ?>>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="penerbit" name="penerbit" value=<?= old('penerbit'); ?>>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                    <div class="col-sm-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" <?= ($validation->hasError('sampul')) ? 'is-invalid' : ''; ?> id="sampul" name="sampul">
                            <div class="invalid-feedback">
                                <?= $validation->getError('sampul'); ?>
                            </div>
                            <label class="custom-file-label" for="Sampul">Pilih gambar</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Data</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>