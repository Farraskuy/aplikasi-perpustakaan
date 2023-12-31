<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>


<div class="bg-white rounded p-3 px-4 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6 d-flex align-items-center gap-3">
            <a href="/admin/anggota" class="btn bg-white border border-3"><i class="fa-regular fa-arrow-left fa-lg"></i> </a>
            <h5 class="m-0">Detail Anggota</h5>
        </div>
        <div class="col-md-6 d-flex justify-content-end align-items-center gap-3">

            <span class="fs-5 fw-semibold text-dark border-end pe-3">Aksi</span>
            <div class="btn-group" role="group" aria-label="Basic example">
                <button style="min-width: 80px;" class="btn btn-warning text-white fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#edit"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                <button style="min-width: 80px;" class="btn btn-danger text-white fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#hapusSatu"><i class="fa-regular fa-trash-xmark"></i> Hapus</button>
            </div>

        </div>
    </div>
</div>
<div class="bg-white rounded p-3 px-4">
    <div class="row g-0">
        <div class="col-md-4 col-xl-3 row flex-column align-items-center">
            <div class="p-3 w-100 col-4" style="height: 400px;">
                <img src="/upload/anggota/<?= $data['foto'] ?>" class="w-100 h-100" style="object-fit: contain;">
            </div>
        </div>
        <div class="col-md-8 col-xl-9 d-flex justify-content-center">
            <div class="container-fluid py-4 ">
                <div class="row">
                    <div class="col-12">
                        <h5 class="m-0"><?= $data['nama'] ?></h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm">
                        <table class=" table-borderless">
                            <tbody>
                                <tr>
                                    <th class="ps-2 pe-3 py-1 ">Username</th>
                                    <td>: <?= $data['username'] ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-2 pe-3 py-1 ">Email</th>
                                    <td>: <?= $data['email'] ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-2 pe-3 py-1 ">Nama</th>
                                    <td>: <?= $data['nama'] ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-2 pe-3 py-1 ">Nomor Telepon</th>
                                    <td>: <?= $data['nomor_telepon'] ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-2 pe-3 py-1 ">Agama</th>
                                    <td>: <?= $data['agama'] ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-2 pe-3 py-1 ">Jenis Kelamin</th>
                                    <td>: <?= $data['jenis_kelamin'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-auto">
                        <table class=" table-borderless">
                            <tbody class="text-secondary">
                                <tr>
                                    <th class="ps-2 pe-3 py-1">Ditambahkan Pada</th>
                                    <td>: <?= formatTanggal($data['created_at']) . ' ' . date('H:i', strtotime($data['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-2 pe-3 py-1">Diperbarui Pada</th>
                                    <td>: <?= formatTanggal($data['updated_at']) . ' ' . date('H:i', strtotime($data['updated_at'])) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row flex-column">
                    <div class="col">
                        <h6 class="fw-bold">Alamat</h6>
                        <p><?= $data['alamat'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- modal -->
<div class="modal fade" id="hapusSatu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus anggota ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger text-white"><i class="fa-regular fa-trash-xmark"></i> Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<!-- reset password -->
<div class="modal fade" id="reset" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="/admin/anggota/reset/<?= $data['id_anggota'] ?>" method="post">

            <?= csrf_field() ?>

            <input type="hidden" name="_method" value="PUT">

            <div class="modal-header">
                <h1 class="modal-title fs-5">Reset Password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 mt-1 row">
                    <label for="password" class="col-sm-3 form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control <?= isset($validation['password']) ? 'is-invalid' : '' ?>" value="<?= old('password') ?>" name="password" id="password" autofocus>
                        <div class="invalid-feedback"><?= isset($validation['password']) ? $validation['password'] : '' ?></div>
                    </div>
                </div>
                <div class="mb-3 mt-1 row">
                    <label for="password_confirm" class="col-sm-3 form-label">Konfirmasi Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control <?= isset($validation['password_confirm']) ? 'is-invalid' : '' ?>" value="<?= old('password_confirm') ?>" name="password_confirm" id="password_confirm">
                        <div class="invalid-feedback"><?= isset($validation['password_confirm']) ? $validation['password_confirm'] : '' ?></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#edit">Batal</button>
                <button type="submit" class="btn btn-warning text-white">Reset</button>
            </div>
        </form>
    </div>
</div>

<!-- edit data -->
<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="fotolama" value="<?= $data['foto'] ?>">
            <?= csrf_field() ?>

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Edit Anggota</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="modal-devider">Data Login</p>
                <div class="mb-3 mt-1 row">
                    <label for="username" class="col-sm-3 form-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= isset($validation['username']) ? 'is-invalid' : '' ?>" value="<?= old('username', $data['username']) ?>" name="username" id="username" autofocus>
                        <div class="invalid-feedback"><?= isset($validation['username']) ? $validation['username'] : '' ?></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-3 form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control <?= isset($validation['email']) ? 'is-invalid' : '' ?>" value="<?= old('email', $data['email']) ?>" name="email" id="email" autofocus>
                        <div class="invalid-feedback"><?= isset($validation['email']) ? $validation['email'] : '' ?></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col d-flex justify-content-end">
                        <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#reset">Reset Password</button>
                    </div>
                </div>
                <p class="modal-devider">Data Anggota</p>
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-3 form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= isset($validation['nama']) ? 'is-invalid' : '' ?>" value="<?= old('nama', $data['nama']) ?>" name="nama" id="nama" autofocus>
                        <div class="invalid-feedback"><?= isset($validation['nama']) ? $validation['nama'] : '' ?></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nomor_telepon" class="col-sm-3 form-label">Nomor Telepon</label>
                    <div class="col-sm-9">
                        <input type="tel" class="form-control <?= isset($validation['nomor_telepon']) ? 'is-invalid' : '' ?>" value="<?= old('nomor_telepon', $data['nomor_telepon']) ?>" name="nomor_telepon" id="nomor_telepon" autofocus>
                        <div class="invalid-feedback"><?= isset($validation['nomor_telepon']) ? $validation['nomor_telepon'] : '' ?></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="agama" class="col-sm-3 form-label">Agama</label>
                    <div class="col-sm-9">
                        <select class="form-select <?= isset($validation['agama']) ? 'is-invalid' : '' ?>" id="agama" name="agama" aria-label="Default select example">
                            <option value="" <?= old('agama',  $data['agama']) == '' ? 'selected' : '' ?>>Pilih agama</option>
                            <option value="Islam" <?= old('agama',  $data['agama']) == 'Islam' ? 'selected' : '' ?>>Islam</option>
                            <option value="Kristen" <?= old('agama',  $data['agama']) == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                            <option value="Protestan" <?= old('agama',  $data['agama']) == 'Protestan' ? 'selected' : '' ?>>Protestan</option>
                            <option value="Hindu" <?= old('agama',  $data['agama']) == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                            <option value="Buddha" <?= old('agama',  $data['agama']) == 'Buddha' ? 'selected' : '' ?>>Buddha</option>
                            <option value="Konghucu" <?= old('agama',  $data['agama']) == 'Konghucu' ? 'selected' : '' ?>>Konghucu</option>
                            <option value="Lainnya" <?= old('agama',  $data['agama']) == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                        <div class="invalid-feedback"><?= isset($validation['agama']) ? $validation['agama'] : '' ?></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="jenis_kelamin" class="col-sm-3 form-label">Jenis Kelamin</label>
                    <div class="col-sm-9">
                        <select class="form-select <?= isset($validation['jenis_kelamin']) ? 'is-invalid' : '' ?>" id="jenis_kelamin" name="jenis_kelamin" aria-label="Default select example">
                            <option value="" <?= old('jenis_kelamin', $data['jenis_kelamin']) == '' ? 'selected' : '' ?>>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" <?= old('jenis_kelamin', $data['jenis_kelamin']) == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= old('jenis_kelamin', $data['jenis_kelamin']) == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                        <div class="invalid-feedback"><?= isset($validation['jenis_kelamin']) ? $validation['jenis_kelamin'] : '' ?></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="foto" class="col-sm-3 form-label">Foto</label>
                    <div class="col-sm-9">
                        <input class="form-control <?= isset($validation['foto']) ? 'is-invalid' : '' ?>" name="foto" type="file" id="foto" onchange="ubahPreview(this)">
                        <div class="invalid-feedback"><?= isset($validation['foto']) ? $validation['foto'] : '' ?></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <p>Preview</p>
                        <div style="height: 150px;" class="w-100 border rounded-3 text-center p-3">
                            <img class="w-100 h-100 sampulPreview" style="object-fit: contain;" src="/upload/anggota/<?= $data['foto'] ?>" alt="default sampul">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="alamat" class="col-sm-3 form-label">Alamat</label>
                    <div class="col-sm-9">
                        <textarea class="form-control <?= isset($validation['alamat']) ? 'is-invalid' : '' ?>" name="alamat" id="alamat" rows="3"><?= old('alamat', $data['alamat']) ?></textarea>
                        <div class="invalid-feedback"><?= isset($validation['alamat']) ? $validation['alamat'] : '' ?></div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning text-white"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
            </div>
        </form>
    </div>
</div>






<?= $this->endSection(); ?>