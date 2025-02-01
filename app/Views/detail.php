<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data) && !empty($data) ? esc($data['nama']) : 'Detail Buku' ?></title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .book-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .container {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            font-weight: 700;
        }

        label {
            font-weight: 600;
        }
    </style>
</head>
<body style="background-color: #f2f2f2;">
    <div class="container">
        <?php if (isset($data) && isset($data['status_data']) && $data['status_data'] == 'tidak'): ?>
            <div class="alert alert-danger" role="alert">
                Buku ini sedang dipinjam. Silakan cek ketersediaan buku di perpustakaan.
            </div>
        <?php else: ?>
            <?php if (!empty($data)): ?>
                <div class="row align-items-center">
                    <div class="col-md-6 text-center">
                        <img src="<?= base_url($data['image']) ?>" alt="Gambar Buku" class="book-image img-fluid">
                    </div>
                    <div class="col-md-6">
                        <h1 class="mt-3 mt-md-0">Buku: <?= esc($data['nama']) ?></h1>
                        <p><strong>Penerbit:</strong> <?= esc($data['deskripsi']) ?></p>
                        <button type="button" class="btn btn-success mt-3" data-toggle="modal" data-target="#peminjamanModal">
                            Pinjam Buku
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="peminjamanModal" tabindex="-1" aria-labelledby="peminjamanModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="peminjamanModalLabel">Peminjaman Buku</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="peminjamanForm" action="/member/detail/pinjam" method="post">
                                    <div class="form-group">
                                        <label for="judul">Judul Buku:</label>
                                        <input type="text" name="judul" id="judul" value="<?= esc($data['nama']) ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama Peminjam:</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="<?= session('masuk') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalPinjam">Tanggal Pinjam:</label>
                                        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalKembali">Tanggal Kembali:</label>
                                        <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                                            required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Pinjam</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-container mt-4">
                    <h2>Tambahkan Komentar</h2>
                    <form id="commentForm">
                        <div class="form-group">
                            <input type="text" class="form-control" id="namaKomentar" name="namaKomentar"
                                value="<?= htmlspecialchars($_SESSION['masuk']) ?>" required hidden>
                        </div>
                        <div class="form-group">
                            <label for="komentar">Komentar:</label>
                            <textarea class="form-control" id="komentar" name="komentar" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                    </form>
                </div>
            <?php else: ?>
                <h1 class="text-center">404</h1>
                <p class="text-center">Maaf, URL yang anda tuju tidak ditemukan.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <script>
        document.getElementById('peminjamanForm').addEventListener('submit', async function (e) {
            e.preventDefault();  // Perbaikan: Menggunakan 'e' untuk event preventDefault

            let judul = document.getElementById('judul').value;
            let namaPeminjam = document.getElementById('nama').value;
            let tanggalPinjam = document.getElementById('tanggal_pinjam').value;
            let tanggalKembali = document.getElementById('tanggal_kembali').value;

            // Perbaikan: Mengoreksi nama variabel dari 'namaPeminjamin' ke 'namaPeminjam' dan menambahkan &&
            let validates = judul.trim() !== '' && namaPeminjam.trim() !== '' && tanggalPinjam.trim() !== '' && tanggalKembali.trim() !== '';

            if (!validates) {
                alert('Form tidak valid, silakan periksa kembali.');
                return;
            }

            const formData = new FormData(e.target);  // Perbaikan: Menggunakan 'e.target' untuk mengambil form
            try {
                const response = await fetch(`<?= site_url("/member/detail/pinjam") ?>`, {
                    method: 'POST',
                    body: formData,
                });
                if (!response.ok) throw new Error('Gagal menyimpan data.');
                const result = await response.json();

                if (result.status === 'success') {
                    location.reload();
                    alert ("Berhasil meminjam Buku");
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                alert('Gagal menyimpan data: ' + error.message);
            }
        });
    </script>
</body>
</html>