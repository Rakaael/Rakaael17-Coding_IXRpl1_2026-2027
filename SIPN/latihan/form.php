g <?php require 'navbar.php'?>
    
    <!--awal container--->
    <div class="container">
    
    <!--awal kolom--->
    <div class="container text-left">
      <div class="row align-items-center">
        
        <div class="g-col-md-8">
          <!--awal card--->
          <div class="card">
            <div class="card-body">
              <form action="" method="GET">
              
              <!--awal form--->
              <h4><center>Form Tambah Siswa</center></h4>
              
              <!--NIS--->
              <div class="mb-3">
                <h4>Data Profil Siswa</h4>
                  <input type="number" name="nis" class="form-control" id="exampleFormControlInput1" placeholder="Nomor Induk Siswa | Contoh: 12345678">
              </div>
              
              <!--Nama siswa--->
              <div class="mb-3">
                  <input type="text" name="nama" class="form-control" id="exampleFormControlInput1" placeholder="Nama Lengkap Siswa | Contoh: Alpira Virania">
              </div>
              
              <!--Kelas--->
              <div class="mb-3">
                  <input type="text" name="kelas" class="form-control" id="exampleFormControlInput1" placeholder="Kelas Siswa | Contoh: XI RPL 1">
              </div>
              
              <!--radios--->
              <p>Jenis Kelamin: </p>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" value="Laki-laki" id="radioDefault1">
                <label class="form-check-label" for="radioDefault1">
                  Laki-laki
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" value="Perempuan" id="radioDefault2" checked>
                <label class="form-check-label" for="radioDefault2">
                  Perempuan
                </label>
              </div> <br>
              
              <h4>Data Kredensial Akun (Tabel Users)</h4>
              
              <!--Email--->
              <div class="mb-3">
                  <input type="text" name="username" class="form-control" id="exampleFormControlInput1" placeholder="Username | Contoh: Fadhil_123">
              </div>
              
              <!--Password--->
              <div class="mb-3">
                  <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="Masukkan password">
              </div>
              
              <!--Tombol selesai-->
              <button type="submit" name="submit" class="btn btn-primary">Kirim</button>
              
              <!--Tombol batal--->
              <button type="button" name="batal" class="btn btn-secondary">Batal</button>
                <!--akhir form--->
                
                </form>
              </div>
            </div><br><br>
            <!--akhir card--->
            
            <!--awal hasil--->
            <h1>Output dari Form</h1>
            <?php
            $nis           = $_GET['nis'];
            $nama          = $_GET['nama'];
            $kelas         = $_GET['kelas'];
            $jenis_kelamin = $_GET['jenis_kelamin'];
            // $username      = $_GET['username'];
            $password      = $_GET['password'];
            
            echo "NIS = ".$nis."<br>";
            echo "Nama = ".$nama."<br>";
            echo "Kelas = ".$kelas."<br>";
            echo "Jenis kelamin = ".$jenis_kelamin."<br>";
            ?>
            <!--akhir hasil--->
            
          </div>
          
        </div>
      </div>
      <!--akhir kolom--->
    
    </div>
    <!--akhir container--->
    
    <?php require 'footer.php'?>