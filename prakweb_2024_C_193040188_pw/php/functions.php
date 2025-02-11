<?php
function koneksi()
{
    $conn = mysqli_connect("localhost", "root", "") or die("koneksi ke DB gagal");
    mysqli_select_db($conn, "buku") or die("Database salah!");

    return $conn;
}

function query($sql)
{
    $conn = koneksi();
    $result = mysqli_query($conn, "$sql");

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

//fungsi untuk menambahkan data di dalam database
function tambah($data)
{
    $conn = koneksi();

    $id = htmlspecialchars($data['id']);
    $Judul = htmlspecialchars($data['Judul']);
    $Pengarang = htmlspecialchars($data['Pengarang']);
    $Penerbit = htmlspecialchars($data['Penerbit']);
    $Jumlah_hal = htmlspecialchars($data['Jumlah_hal']);
    $Cover = htmlspecialchars($data['Cover']);

    $query = "INSERT INTO buku
                        VALUES
                        ('', '$Judul', '$Pengarang','$Penerbit','$Jumlah_hal','$Cover')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($apr)
{
    $conn = koneksi();
    mysqli_query($conn, "DELETE FROM buku WHERE id = $apr");

    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    $conn = koneksi();

    $apr = htmlspecialchars($data['id']);
    $display = htmlspecialchars($data['display']);
    $jenis_apparel = htmlspecialchars($data['jenis_apparel']);
    $merk = htmlspecialchars($data['merk']);
    $ukuran = htmlspecialchars($data['ukuran']);
    $harga = htmlspecialchars($data['harga']);

    $query = "UPDATE buku
                SET
                display = '$display',
                jenis_apparel = '$jenis_apparel',
                merk = '$merk',
                ukuran = '$ukuran',
                harga = '$harga'
                WHERE id_apparel = '$apr'
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function registrasi($data)
{
    $conn = koneksi();
    $username = strtolower(stripcslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username' ");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
            alert('username sudah digunakan');
        </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambah user baru
    $query_tambah = "INSERT INTO user VALUES('','$username','$password')";
    mysqli_query($conn, $query_tambah);

    return mysqli_affected_rows($conn);
}
