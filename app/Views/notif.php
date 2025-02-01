<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        fieldset {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h2 {
            margin: 0;
            color: #0056b3;
        }

        p, b {
            margin: 10px 0;
        }

        .delete-link {
            color: #ff4d4d;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .delete-link:hover {
            text-decoration: underline;
        }

        .center {
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Daftar Notifikasi Penerimaan</h1>

    <?php if (isset($data) && !empty($data)): ?>
        <?php foreach ($data as $row): ?>
            <fieldset>
                <div>
                    <h2>Nama: <?php echo esc($row['nama']); ?></h2>
                    <p>Judul Buku: <?php echo esc($row['judul']); ?></p>
                    <b>Tanggal Pinjam: <?php echo esc($row['tanggal_pinjam']); ?></b><br>
                    <b>Tanggal Kembali: <?php echo esc($row['tanggal_kembali']); ?></b>
                </div>
                <br>
                <hr><br>
                <a href="#" class="delete-link" data-id="<?php echo esc($row['id_user']); ?>">Hapus</a>
            </fieldset>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="center">Tidak ada notifikasi</p>
    <?php endif; ?>
<script>
    document.querySelectorAll('.delete-link').forEach(function(link) {
        link.addEventListener('click', async (event) => {
            event.preventDefault();
            
            const id = event.currentTarget.getAttribute('data-id');
            if (!confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
                return;
            }
            try {
                const response = await fetch(`/admin/notification/delete/${id}`, {
                    method: 'DELETE',
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const result = await response.json();
                if (result.status === 'success') {
                    location.reload();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                alert('Gagal menghapus data: ' + error.message);
            }
        });
    });
</script>
</body>
</html>