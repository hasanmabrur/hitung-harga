<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Hitung Harga</title>
</head>
<body>
    <form>
        <div class="form">
            <div class="form-group">
                <label for="produk" class="label">Produk</label>
                <?php
                // koneksi ke database
                $conn = mysqli_connect("localhost", "root", "", "coba");

                // query untuk mengambil data produk
                $query = "SELECT * FROM produk";
                $result = mysqli_query($conn, $query);

                // membuat form select
                echo "<select class='form-control' name='produk' id='produk'>";
                while($row = mysqli_fetch_array($result)) {
                    echo "<option value='" . $row['id_produk'] . "'>" . $row['nama_produk'] . "</option>";
                }
                echo "</select>";

                mysqli_close($conn);
                ?>
            </div>
            <div class="form-group">
                <label for="Harga" class="label">Harga</label>
                <input type="text" class="form-control" name="Harga" id="Harga" readonly>
            </div>
            <div class="form-group">
                <label for="Diskon" class="label">Diskon</label>
                <input type="text" class="form-control" name="Diskon" id="Diskon">
            </div>
            <div class="form-group">
                <label for="Total" class="label">Total</label>
                <input type="text" class="form-control" name="Total" id="Total" readonly>
            </div>
        </div>
    </form>

<script>
// event onchange pada form select produk
document.getElementById('produk').onchange = function() {
    // mengambil data produk yang dipilih
    var id_produk = this.value;

    // mengirim request ke server untuk mengambil data harga_produk
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_harga.php?id_produk=' + id_produk, true);
    xhr.onload = function() {
        if (this.status == 200) {
            // menampilkan data harga_produk di form text harga
            document.getElementById('Harga').value = this.responseText;

            // mengisi form text total dengan harga jika form text diskon belum diisi
            var diskon = document.getElementById('Diskon').value;
            if (diskon == "") {
                document.getElementById('Total').value = this.responseText;
            }
        }
    }
    xhr.send();
}

// event oninput pada form text diskon
document.getElementById('Diskon').oninput = function() {
    // mengambil data harga dan diskon
    var harga = document.getElementById('Harga').value;
    var diskon = this.value;

    // menghitung total
    var total = 0;
    if (diskon == "") {
        total = harga;
    } else {
        if (diskon.includes("%")) {
            // mengkonversi diskon dari persen menjadi nilai angka
            var diskonAngka = parseFloat(diskon) / 100;
            total = harga - (harga * diskonAngka);
        } else {
            total = harga - diskon;
        }
    }

    // menampilkan total di form text total
    document.getElementById('Total').value = total;
}
</script>


</body>
</html>
