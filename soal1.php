<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Saldo Bank</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type="number"] { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; border: 1px solid #aaa; border-radius: 4px; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; margin-top: 20px; }
        input[type="submit"]:hover { background-color: #45a049; }
        .result { margin-top: 30px; padding: 15px; border: 1px solid #007BFF; background-color: #e6f0ff; border-radius: 4px; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2>Kalkulator Saldo Bank X</h2>
    
    <form method="post" action="">
        <label for="saldo_awal">Saldo Awal (Rp.):</label>
        <input type="number" id="saldo_awal" name="saldo_awal" required value="<?php echo isset($_POST['saldo_awal']) ? $_POST['saldo_awal'] : '1000000'; ?>" min="0">

        <label for="n_bulan">Jangka Waktu (N Bulan):</label>
        <input type="number" id="n_bulan" name="n_bulan" required value="<?php echo isset($_POST['n_bulan']) ? $_POST['n_bulan'] : '12'; ?>" min="1">

        <input type="submit" name="hitung" value="Hitung Saldo Akhir">
    </form>

    <?php
    // Logika Perhitungan Saldo
    if (isset($_POST['hitung'])) {
        // Ambil input dari formulir
        $saldo_awal = (float)$_POST['saldo_awal'];
        $n_bulan    = (int)$_POST['n_bulan'];
        
        // Konstanta
        $batas_bunga_tinggi = 1100000; // Rp. 1.100.000,-
        $bunga_rendah_tahunan = 0.03;  // 3% p.a
        $bunga_tinggi_tahunan = 0.04;  // 4% p.a
        $biaya_admin_bulanan = 9000;   // Rp. 9.000,-
        
        // Saldo saat ini (akan diupdate di setiap iterasi)
        $saldo_akhir = $saldo_awal;

        if ($saldo_awal < 0 || $n_bulan <= 0) {
             echo '<div class="result error">Input Saldo Awal harus non-negatif dan Jangka Waktu (N) harus lebih dari 0.</div>';
        } else {
            // Proses Perhitungan Bulanan
            for ($bulan = 1; $bulan <= $n_bulan; $bulan++) {
                
                // 1. Tentukan tingkat bunga tahunan berdasarkan saldo terakhir
                if ($saldo_akhir < $batas_bunga_tinggi) {
                    $bunga_tahunan = $bunga_rendah_tahunan; // 3% p.a
                } else {
                    $bunga_tahunan = $bunga_tinggi_tahunan; // 4% p.a
                }
                
                // 2. Hitung bunga bulanan
                // Bunga dihitung dari saldo terakhir (saldo_akhir)
                // Bunga bulanan = Saldo * (Bunga Tahunan / 12)
                $bunga_bulanan = $saldo_akhir * ($bunga_tahunan / 12);
                
                // 3. Tambahkan bunga ke saldo
                $saldo_setelah_bunga = $saldo_akhir + $bunga_bulanan;
                
                // 4. Kurangi biaya administrasi bulanan
                $saldo_akhir = $saldo_setelah_bunga - $biaya_admin_bulanan;

                // Pastikan saldo tidak menjadi negatif (walaupun dalam konteks soal bank, ini mungkin perlu penanganan khusus, tapi di sini kita asumsikan saldo bisa saja negatif)
                
                // Opsional: Tampilkan detail perhitungan per bulan (bisa dihilangkan untuk output yang lebih ringkas)
                // echo "<p>Bulan $bulan: Saldo Awal Rp. " . number_format($saldo_akhir, 0, ',', '.') . "</p>";

            }

            // Tampilkan Hasil
            echo '<div class="result">';
            echo '<h3>Hasil Perhitungan</h3>';
            echo '<p>Saldo Awal: *Rp. ' . number_format($saldo_awal, 0, ',', '.') . '*</p>';
            echo '<p>Jangka Waktu (N): *' . $n_bulan . ' bulan*</p>';
            echo '<hr>';
            echo '<h4>Saldo Akhir Setelah ' . $n_bulan . ' Bulan:</h4>';
            echo '<p style="font-size: 1.5em; color: #007BFF;">*Rp. ' . number_format($saldo_akhir, 0, ',', '.') . '*</p>';
            echo '</div>';
        }
    }
    ?>
</div>

</body>
</html>