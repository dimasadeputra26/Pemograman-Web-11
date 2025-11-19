<?php
// Tentukan target jumlah
$target = 25;

// Inisialisasi penghitung solusi
$count = 0;

echo "## ✨ Pasangan Nilai (x, y, z) yang Memenuhi Persamaan x + y + z = $target\n";
echo "--- \n";

// Loop untuk nilai x.
// Nilai minimum x adalah 1 (bilangan asli).
// Nilai maksimum x adalah 23, karena y dan z minimal 1, sehingga x = 25 - 1 - 1 = 23.
for ($x = 1; $x <= $target - 2; $x++) {
    
    // Loop untuk nilai y.
    // Nilai minimum y adalah 1 (bilangan asli).
    // Nilai maksimum y adalah (25 - x - 1), karena z minimal 1.
    $max_y = $target - $x - 1;
    for ($y = 1; $y <= $max_y; $y++) {
        
        // Hitung nilai z.
        // Karena x + y + z = 25, maka z = 25 - x - y.
        $z = $target - $x - $y;
        
        // Karena loop sudah memastikan bahwa x >= 1, y >= 1, dan z >= 1 
        // (melalui batas $max_y$ dan perhitungan $z$), 
        // kita tidak perlu lagi melakukan pengecekan bilangan asli.
        
        // Tampilkan pasangan nilai
        echo "x = $x, y = $y, z = $z\n";
        
        // Tambahkan hitungan solusi
        $count++;
    }
}

echo "--- \n";
echo "## 📊 Hasil Akhir\n";
echo "Jumlah penyelesaian: *$count*\n";
echo "?>";
?>