<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User</title>
    <?php
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tabel_user"; 

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_user = $_POST['nama_user'];
        $tipe_user = $_POST['tipe_user']; 
        $alamat = $_POST['alamat'];       
        $telepon = $_POST['telepon'];     
    if (isset($_POST['id_user_hidden']) && !empty($_POST['id_user_hidden'])) { 
            $id_user = $_POST['id_user_hidden']; 
            $stmt = $conn->prepare("UPDATE `hitam` SET `Nama_user`=?, `Tipe_user`=?, `Alamat`=?, `Telepon`=? WHERE `ID_user`=?");
            $stmt->bind_param("ssssi", $nama_user, $tipe_user, $alamat, $telepon, $id_user);
    if ($stmt->execute()) {
                echo "
                <script>
                alert('Data Berhasil Diubah!!');
                window.location = 'index.php';
                </script>
                ";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $stmt = $conn->prepare("INSERT INTO `hitam` (`Nama_user`, `Tipe_user`, `Alamat`, `Telepon`) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama_user, $tipe_user, $alamat, $telepon);

            if ($stmt->execute()) {
                echo "
                <script>
                alert('Data Berhasil Ditambahkan!!');
                window.location = 'index.php';
                </script>
                ";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }

    else if (isset($_GET['aksi'])) {
        $id_get = $_GET['id']; 

        if ($_GET['aksi'] == "edit") {
        
            $stmt = $conn->prepare("SELECT `ID_user`, `Nama_user`, `Tipe_user`, `Alamat`, `Telepon` FROM `hitam` WHERE `ID_user`=?");
            $stmt->bind_param("i", $id_get);
            $stmt->execute();
            $result2 = $stmt->get_result();

            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_object();
                $id_user_edit = $row2->ID_user;
                $nama_user_edit = $row2->Nama_user;
                $tipe_user_edit = $row2->Tipe_user;
                $alamat_edit = $row2->Alamat;
                $telepon_edit = $row2->Telepon;
            } else {
                echo "<script>alert('Data tidak ditemukan untuk diedit.'); window.location='index.php';</script>";
            }
            $stmt->close();
        } else if ($_GET['aksi'] == "hapus") {
         
            $stmt = $conn->prepare("DELETE FROM `hitam` WHERE `ID_user`=?");
            $stmt->bind_param("i", $id_get);

            if ($stmt->execute()) {
                echo "
                <script>
                alert('Data Berhasil Dihapus!!');
                window.location = 'index.php';
                </script>
                ";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }


    $sql_select_all = "SELECT `ID_user`, `Nama_user`, `Tipe_user`, `Alamat`, `Telepon` FROM `hitam`";
    $result_all = $conn->query($sql_select_all);

    ?>
    <style>
        body {
            font-family: 'Inter', sans-serif; 
            background-color: #940303;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            min-height: 100vh; 
        }

        .container {
            width: 90%; 
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 12px; 
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); 
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-size: 2em;
            font-weight: bold;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px; 
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        form label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        form input[type="text"],
        form input[type="tel"],
        form select {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px; /
            width: 100%; 
            box-sizing: border-box; 
            transition: border-color 0.3s ease;
        }

        form input[type="text"]:focus,
        form input[type="tel"]:focus,
        form select:focus {
            border-color: #db0606;
            outline: none;
        }

        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center; 
            margin-top: 20px;
        }

        .buttons button {
            padding: 12px 25px;
            font-size: 16px;
            border: none;
            border-radius: 8px; 
            cursor: pointer;
            background-color: #db0606;
            color: #fff;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .buttons button:hover {
            background-color: #c00505;
            transform: translateY(-2px); 
        }

        .buttons a button {
            background-color: #6c757d; 
        }

        .buttons a button:hover {
            background-color: #5a6268;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        table th {
            background-color: #db0606;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table td:last-child {
            white-space: nowrap; 
        }

        table td a button {
            padding: 8px 12px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }

        table td a button:first-child {
            background-color: #007bff; 
            color: #fff;
        }

        table td a button:first-child:hover {
            background-color: #0056b3;
        }

        table td a button:last-child {
            background-color: #dc3545;
            color: #fff;
        }

        table td a button:last-child:hover {
            background-color: #c82333;
        }
        
      
        @media (max-width: 768px) {
            .container {
                margin: 15px;
                padding: 15px;
            }

            h2 {
                font-size: 1.8em;
            }

            form {
                padding: 15px;
            }

            .buttons {
                flex-direction: column;
                gap: 10px;
            }

            .buttons button {
                width: 100%;
            }

            table th, table td {
                padding: 10px;
                font-size: 0.9em;
            }
            
            table td a button {
                padding: 6px 10px;
                font-size: 0.8em;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 1.5em;
            }

            form input[type="text"],
            form input[type="tel"],
            form select {
                font-size: 14px;
                padding: 10px;
            }

            table th, table td {
                font-size: 0.8em;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Kelola User</h2>
        <form method="post" action="index.php">
            <?php
            if (!empty($id_user_edit)) {
                echo '<input type="hidden" name="id_user_hidden" value="' . htmlspecialchars($id_user_edit) . '">';
            }
            ?>
              <label for="tipe_user">Tipe User</label>
            <select id="tipe_user" name="tipe_user" required>
                <option value="">Pilih Tipe User</option>
              <option value="Kurir" <?php if(isset( $tipe_user_edit) and  $tipe_user_edit=="Kurir"){
              echo "selected";
            }
            ?> >Kurir</option>
              <option value="Gudang"  <?php if(isset( $tipe_user_edit) and  $tipe_user_edit=="Gudang"){
              echo "selected";
            }
            ?> >Gudang</option>
            </select>
            
            
            <label for="nama_user">Nama User</label>
            <input type="text" 
            id="nama_user" 
            name="nama_user"
            placeholder="Masukkan nama"
            <?php if(isset($nama2)){
              echo "value=\"$nama2\"";
            }
            ?>            
            />

            <label for="alamat">Alamat</label>
            <input
            type="text"
            id="alamat"
            name="alamat"
            placeholder="Masukkan alamat"
            <?php if(isset($alamat2)){
              echo "value=\"$alamat2\"";
            }
            ?>            
            />

            <label for="telepon">Telepon</label>
          <input
            type="text"
            id="telepon"
            name="telepon"
            placeholder="Masukkan nomor telepon"
            <?php if(isset($tlp2)){
              echo "value=\"$tlp2\"";
            }
            ?>            
            />

            <div class="buttons">
                <?php
                if (!empty($id_user_edit)) { 
                    echo '
                    <button type="submit">Ubah Data</button>
                    <a href="index.php"><button type="button">Kembali</button></a>
                    ';
                } else { 
                    echo '
                    <button type="submit">Tambah Data</button>
                    ';
                }
                ?>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Tipe User</th>
                    <th>Nama User</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_all->num_rows > 0) {
                    while ($row = $result_all->fetch_object()) {
                ?>
                        <tr>
                        <td><?=$row->ID_user?></td>
                        <td><?php echo  $row->Tipe_user;?></td>
                        <td><?=$row->Nama_user?></td>
                        <td><?=$row->Alamat?></td>
                        <td><?=$row->Telepon?></td>
                            <td>
                                <a href="?id=<?php echo htmlspecialchars($row->ID_user); ?>&aksi=edit"><button type="button">Edit</button></a>
                                <a href="?id=<?php echo htmlspecialchars($row->ID_user); ?>&aksi=hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><button type="button">Hapus</button></a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="6" style="text-align: center;">Tidak ada data user.</td></tr>';
                }
                $conn->close(); 
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
