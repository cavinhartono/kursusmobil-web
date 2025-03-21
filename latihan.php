<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Latihan ke-2</title>
  <link rel="stylesheet" href="css/latihan.css">
</head>

<body>
  <div class="container">
    <form method="POST" class="form">
      <div class="select-fill">
        <label for="mathematical-formula">Pilih Perhitungan:</label>
        <select id="mathematical-formula" name="mathematicalFormula">
          <option value="">-- Pilih salah satu</option>
          <option value="" disabled>Pertemuan 3</option>
          <option value="segitiga">Luas Segitiga</option>
          <option value="pythagoras">Pythagoras</option>
          <option value="lingkaran">Keliling Lingkaran</option>
          <option value="" disabled>Pertemuan 4</option>
          <option value="gaji_pokok">Gaji Pokok</option>
          <option value="nama_bulan">Nama Bulan</option>
          <option value="" disabled>Pertemuan 5</option>
          <option value="deretan_ganjil">Deret Ganjil</option>
          <option value="deretan_eksponensial">Deret Eksponensial</option>
          <option value="deretan_pola">Deret Pola Negatif-Positif</option>
          <option value="deretan_fibonacci">Deret Fibonacci</option>
        </select>
      </div>
      <div id="input-fill" class="input_fill"></div>
      <button type="submit" class="btn" name="submit">Hitung</button>
      <a href="./homepage.html" class="btn danger">Kembali</a>
    </form>
  </div>

  <?php
  include_once('./php/Fungsi.php');

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
      $formula = $_POST['mathematicalFormula'];

      switch ($formula) {
        case 'segitiga':
          $formulaTitle = "Hasil untuk Luas Segitiga";
          $a = isset($_POST['alas']) ? floatval($_POST['alas']) : 0;
          $t = isset($_POST['tinggi']) ? floatval($_POST['tinggi']) : 0;
          $result = 0.5 * $a * $t;
          break;
        case 'pythagoras':
          $formulaTitle = "Hasil untuk Pythagores";
          $a = isset($_POST['a']) ? floatval($_POST['a']) : 0;
          $b = isset($_POST['b']) ? floatval($_POST['b']) : 0;
          $result = sqrt(pow($a, 2) + pow($b, 2));
          break;
        case 'lingkaran':
          $formulaTitle = "Hasil untuk Kel. Lingkaran";
          $r = isset($_POST['r']) ? floatval($_POST['r']) : 0;
          $result = 2 * M_PI * $r;
          break;
        case 'gaji_pokok':
          $formulaTitle = "Hasil untuk Gaji Pokok";
          $nip = $_POST['nip'];
          $nama = $_POST['nama'];
          $golongan = isset($_POST['golongan']) ? strtoupper($_POST['golongan']) : '';
          $lamaKerja = isset($_POST['lama_kerja']) ? (int)$_POST['lama_kerja'] : 0;
          $result = hitungGajiPokok($lamaKerja, $golongan);
          break;
        case 'nama_bulan':
          $formulaTitle = "Hasil untuk Nama Bulan";
          $angka = isset($_POST['angka']) ? (int) $_POST['angka'] : 0;
          $result = mengambilNamaBulan($angka);
          break;
        case 'deretan_ganjil':
          $formulaTitle = "Hasil untuk Deret Ganjil";
          $result = deretanGanjil();
          break;
        case 'deretan_eksponensial':
          $formulaTitle = "Hasil untuk Deret Eksponensial";
          $result = deretanEksponensial();
          break;
        case 'deretan_pola':
          $formulaTitle = "Hasil untuk Deret Pola";
          $count = isset($_POST['count']) ? (int) $_POST['count'] : 0;
          $result = deretanPolaNegatifPositif($count);
          break;
        case 'deretan_fibonacci':
          $formulaTitle = "Hasil untuk Deret Fibonacci";
          $count = isset($_POST['count']) ? (int) $_POST['count'] : 0;
          $result = deretanFibonacci($count);
          break;
        default:
          $formulaTitle = "";
          $result = null;
          break;
      }
    }
  }
  ?>

  <?php if (isset($result)): ?>
    <div id="result-formula" class="result">
      <div class="detail">
        <h1 class="title"><?= $formulaTitle ?></h1>
        <?php if (in_array($formula, ['segitiga', 'pythagoras', 'lingkaran'])): ?>
          <!-- Rumus Matematika -->
          <details>
            <summary class="title">Langkah Pengerjaan</summary>
            <?php switch ($formula):
              case "segitiga": ?>
                <div>
                  <p class="text">
                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                      <mi>L</mi>
                      <mo>=</mo>
                      <mfrac>
                        <mn>1</mn>
                        <mn>2</mn>
                      </mfrac>
                      <mo>&#x22C5;</mo>
                      <mi>a</mi>
                      <mo>&#x22C5;</mo>
                      <mi>t</mi>
                    </math>
                  </p>
                  <p class="text">
                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                      <mi>L</mi>
                      <mo>=</mo>
                      <mfrac>
                        <mn>1</mn>
                        <mn>2</mn>
                      </mfrac>
                      <mo>&#x22C5;</mo>
                      <mi><?= $a ?></mi>
                      <mo>&#x22C5;</mo>
                      <mi><?= $t ?></mi>
                    </math>
                  </p>
                  <p class="text">
                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                      <mi>L</mi>
                      <mo>=</mo>
                      <mfrac>
                        <mn>1</mn>
                        <mn>2</mn>
                      </mfrac>
                      <mo>&#x22C5;</mo>
                      <mi><?= ($a * $t) ?></mi>
                    </math>
                  </p>
                </div>
                <?php break ?>
              <?php
              case "pythagoras": ?>
                <div>
                  <p class="text">
                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                      <mi>c</mi>
                      <mo>=</mo>
                      <msqrt>
                        <mrow>
                          <msup>
                            <mi>a</mi>
                            <mn>2</mn>
                          </msup>
                          <mo>+</mo>
                          <msup>
                            <mi>b</mi>
                            <mn>2</mn>
                          </msup>
                        </mrow>
                      </msqrt>
                    </math>
                  </p>
                  <p class="text">
                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                      <mi>c</mi>
                      <mo>=</mo>
                      <msqrt>
                        <mrow>
                          <msup>
                            <mi><?= pow($a, 2) ?></mi>
                          </msup>
                          <mo>+</mo>
                          <msup>
                            <mi><?= pow($b, 2) ?></mi>
                          </msup>
                        </mrow>
                      </msqrt>
                    </math>
                  </p>
                  <p class="text">
                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                      <mi>c</mi>
                      <mo>=</mo>
                      <msqrt>
                        <mrow>
                          <msup>
                            <mi><?= pow($a, 2) + pow($b, 2) ?></mi>
                          </msup>
                        </mrow>
                      </msqrt>
                    </math>
                  </p>
                </div>
                <?php break ?>
              <?php
              case "lingkaran": ?>
                <div>
                  <p class="text">
                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                      <mi>K</mi>
                      <mo>=</mo>
                      <mn>2</mn>
                      <mo>&#x22C5;</mo>
                      <mi>&#x03C0;</mi> <!-- Simbol pi -->
                      <mo>&#x22C5;</mo>
                      <mi>r</mi>
                    </math>
                  </p>
                  <p class="text">
                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                      <mi>K</mi>
                      <mo>=</mo>
                      <mn>2</mn>
                      <mo>&#x22C5;</mo>
                      <mi>&#x03C0;</mi> <!-- Simbol pi -->
                      <mo>&#x22C5;</mo>
                      <mi><?= $r ?></mi>
                    </math>
                  </p>
                  <p class="text">
                    <math xmlns="http://www.w3.org/1998/Math/MathML">
                      <mi>K</mi>
                      <mo>=</mo>
                      <mi><?= (2 * $r) ?></mi>
                      <mo>&#x22C5;</mo>
                      <mi>&#x03C0;</mi> <!-- Simbol pi -->
                    </math>
                  </p>
                </div>
                <?php break ?>
            <?php endswitch ?>
          </details>
          <h4 class="text"><?php echo (($result == floor($result) ? floor($result) : number_format((float) $result, 2, '.', ''))) ?> cm<sup>2</sup></h4>
        <?php else: ?>
          <?php if (is_string($result)): ?>
            <!-- Nama Bulan -->
            <p class="text"><?= $result ?></p>
          <?php else: ?>
            <?php if (is_array($result)): ?>
              <!-- Deretan -->
              <p class="text"><?= implode(" ", $result) ?></p>
            <?php else: ?>
              <table>
                <tr>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Gol.</th>
                  <th>Lama Kerja</th>
                  <th>Gaji Pokok</th>
                </tr>
                <tr>
                  <td align="right"><?= $nip ?></td>
                  <td><?= $nama ?></td>
                  <td align="center"><?= $golongan ?></td>
                  <td><?= date('Y') - $lamaKerja ?> tahun</td>
                  <td align="right">Rp <?= number_format($result, 2, ',', '.') ?></td>
                </tr>
              </table>
              <!-- Gaji Pokok -->
            <?php endif ?>
          <?php endif ?>
        <?php endif ?>
        <button id="close-modal" class="btn">Selesai</button>
      </div>
    </div>
  <?php endif ?>

  <script src="js/latihan.js"></script>
</body>

</html>