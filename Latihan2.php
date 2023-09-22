
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
  <?php
      $data = ["Reza", "Adi", "Bagas", "Asep"];
    ?>
  <div class="container text-center">
  <div class="row">
    <?php
    for ($i=0; $i < 3; $i++) {
    ?>   
        <div class="col">
            <?php echo $data[$i]; //Reza ?>
        </div>
    <?php
    }
    ?>
    </div>
    <div class="row">
    <?php
            for ($i=0; $i < count($umur); $i++) {
    ?>
            <div class="col">
            <button type="button" class="btn btn-warning">
              <?php echo $umur[$i]; //Reza ?>
            </button>
      </div>
  <?php
    }
    ?>
    </div>
    <?php
    $nm = "Reza";
    $umr = 27;
    ?>
    <h1>Hello, <?php echo "Reza! "." Umur Anda adalah ". 20 . " Apa Anda ingin mempunyai uang yang banyak? "; ?></h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>