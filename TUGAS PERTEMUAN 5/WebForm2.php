<?php
$nama = $tugas = $uts = $uas = "";
$error = "";
$akhir = 0;
$grade = "";
$status = "";
$diproses = false;

if (isset($_POST['btn_proses'])) {
    $nama  = trim($_POST['nama'] ?? "");
    $tugas = $_POST['tugas'] ?? "";
    $uts   = $_POST['uts'] ?? "";
    $uas   = $_POST['uas'] ?? "";

    if ($nama === "" || $tugas === "" || $uts === "" || $uas === "") {
        $error = "Semua kolom wajib diisi.";
    } elseif (!is_numeric($tugas) || !is_numeric($uts) || !is_numeric($uas)) {
        $error = "Nilai harus berupa angka.";
    } else {
        $tugas = (float)$tugas;
        $uts   = (float)$uts;
        $uas   = (float)$uas;

        if ($tugas < 0 || $tugas > 100 || $uts < 0 || $uts > 100 || $uas < 0 || $uas > 100) {
            $error = "Nilai harus antara 0 sampai 100.";
        } else {
            $akhir = ($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4);

            if ($akhir >= 85)      $grade = "A";
            elseif ($akhir >= 70)  $grade = "B";
            elseif ($akhir >= 55)  $grade = "C";
            elseif ($akhir >= 40)  $grade = "D";
            else                   $grade = "E";

            $status = ($akhir >= 55) ? "LULUS" : "TIDAK LULUS";
            $diproses = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nilai Mahasiswa</title>
    <style>
      * { box-sizing: border-box; }
      body {
        background-color: #dde8ec;
        font-family: "Segoe UI", Arial, sans-serif;
        color: #14263a;
        text-align: center;
      }
      h1 { margin-bottom: 30px; }
      .container {
        background-color: white;
        width: 35%;
        min-width: 300px;
        margin: 40px auto;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(20, 38, 58, 0.15);
        text-align: left;
      }
      .input { display: flex; flex-direction: column; margin: 10px 0; }
      label { margin-bottom: 5px; font-weight: 600; }
      input {
        width: 100%;
        padding: 8px;
        border: 2px solid #c3d1d9;
        border-radius: 8px;
      }
      input:focus { outline: none; border-color: #2457f5; }
      .button {
        display: block;
        width: 100%;
        margin: 10px 0;
        padding: 10px;
        background: #14263a;
        border-radius: 8px;
        cursor: pointer;
        border: none;
        color: white;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        font-size: 13.33px;
      }
      .button:hover { background-color: #2457f5; }
      #hasil {
        margin-top: 15px;
        background: #f4f8fa;
        padding: 10px;
        border: 2px dashed #c3d1d9;
        border-radius: 8px;
      }
      #hasil b { background: #ffd84d; padding: 2px 6px; }
      .error { color: #c0392b; font-weight: 600; }
    </style>
  </head>

  <body>
    <h1>Form Nilai Mahasiswa</h1>
    <div class="container">
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="input">
          <label for="nama">Nama Mahasiswa</label>
          <input type="text" name="nama" id="nama" required
                 value="<?php echo htmlspecialchars($nama); ?>" />
        </div>

        <div class="input">
          <label for="tugas">Nilai Tugas (30%)</label>
          <input type="number" name="tugas" id="tugas" min="0" max="100" step="any" required
                 value="<?php echo htmlspecialchars((string)$tugas); ?>" />
        </div>

        <div class="input">
          <label for="uts">Nilai UTS (30%)</label>
          <input type="number" name="uts" id="uts" min="0" max="100" step="any" required
                 value="<?php echo htmlspecialchars((string)$uts); ?>" />
        </div>

        <div class="input">
          <label for="uas">Nilai UAS (40%)</label>
          <input type="number" name="uas" id="uas" min="0" max="100" step="any" required
                 value="<?php echo htmlspecialchars((string)$uas); ?>" />
        </div>

        <input type="submit" class="button" name="btn_proses" value="Hitung Nilai" />
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="button">Hapus</a>

        <div id="hasil">
          <?php
            if ($error !== "") {
                echo "<span class='error'>" . htmlspecialchars($error) . "</span>";
            } elseif ($diproses) {
                echo "Nama : " . htmlspecialchars($nama) . "<br>";
                echo "Nilai Akhir : " . number_format($akhir, 1) . "<br>";
                echo "Grade : " . $grade . "<br>";
                echo "Status : <b>" . $status . "</b>";
            } else {
                echo "Hasil perhitungan akan tampil di sini.";
            }
          ?>
        </div>
      </form>
    </div>
  </body>
</html>