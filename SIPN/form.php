<?php require 'navbar.php'; ?>


<!-- awal container -->
 <div class="container">

 <!-- awal columns -->
  <div class="container text-center">
  <div class="row align-items-start">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
      <!-- awal card -->
       <div class="card">
  <div class="card-body">
    <!-- awal form -->
     <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Email address</label>
  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
  <label>Jenis Kelamin</label><br>
        <input type="radio" name="jenis_kelamin" value="Laki-laki"> Laki-laki
        <input type="radio" name="jenis_kelamin" value="Perempuan"> Perempuan
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>
     <!-- akhir form -->
  </div>
</div>
       <!-- akhir card -->
    </div>
    <div class="col-md-2">
    </div>
  </div>
</div>
 <!-- akhir columns -->

</div>
    <!-- akhir container -->
    <?php require 'footer.php'; ?>