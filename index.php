<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>EatTogether</title>

  <?php
  include_once("components/imports.php");
  include_once("components/session.php");
  ?>

</head>

<body>

  <?php include_once("components/header.php"); ?>

  <div class="container text-center">

    <div class="row gy-3">

      <!-- ========== listing all users as cards ========== -->
      <?php
      $users = $userFunctions->showOtherUsers();

      foreach ($users as $user) {

        echo '
          <div class="col-md-auto">
            <div class="card card-index overflow-auto py-3">
              <img class="card-img-top img-fluid img-public mb-2" src="' . $user->picture . '" alt="Title">
              <h4 class="card-title">' . $user->screenName . '</h4>
              <div class="card-body overflow-auto">
                <div class="card-text">' . $user->publicMessage . '</div>
                </div>
                
              <!-- Modal trigger button -->
              <button type="button" class="btn btn-primary btn-sm col-6 mx-auto mt-4" data-bs-toggle="modal" data-bs-target="#modal' . $user->screenName . '">
                Message Me! :)
              </button>
            </div>
          </div>

          

          <!-- Modal Body -->
          <div class="modal fade" id="modal' . $user->screenName . '" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
          <form method="post">
          <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalTitleId">Your Message to ' . $user->screenName . '</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                      <textarea type="text" class="form-control" name="message" id="message"></textarea>
                    </div>
                    
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary" name="sendMessage" value="' . $user->id . '">Send</button>
                </div>
              </div>
            </form>
            </div>
          </div>
          ';
      }
      if (isset($_POST["sendMessage"])) {
        $userFunctions->sendPrivateMessage($_POST["message"], $_POST['sendMessage']);
      }
      ?>

    </div>
  </div>
  <!-- ========== end userlist ========== -->

  <?php include_once("components/footer.php"); ?>



  <!-- Optional: Place to the bottom of scripts -->
  <script>
    const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
  </script>
</body>

</html>