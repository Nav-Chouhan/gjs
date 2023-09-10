<!DOCTYPE html>
<!-- saved from url=(0045)https://zaveribazaar.co.in/applink/gjs_invite -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wholesaler profile - Zaveri Bazaar</title>
  <link rel="stylesheet" href="/bootstrap.min.css">
  <link rel="stylesheet" href="/lightbox.min.css">
  <link rel="stylesheet" href="/slick.min.css">
  <link rel="stylesheet" href="/slick-theme.min.css">
  <link rel="stylesheet" href="/all.min.css">
  <link rel="stylesheet" href="/cropper.min.css">
  <style>
      .upload-image img {
          border: 1px dashed;
      }
      .text-center.upload-image {
          border: 1px solid;
/*                width: 50%;*/
          margin: 0 auto;
          padding: 50px 30px;
      }
      .form-heading {
          margin-bottom: 50px;
      }
      .form-group.user-name {
/*                width: 50%;*/
          margin: 0 auto;
          margin-top: 30px;
      }
      .remove-icon {
          position: absolute;
          top: 0px;
          right: 0;
          cursor: pointer;
          font-size: 30px;
          border: 1px solid;
          border-radius: 50%;
          padding: 1px 6px;
          line-height: 30px;
      }

      .upload-image {
          position: relative;
      }
  </style>
</head>
<body data-new-gr-c-s-check-loaded="14.1123.0" data-gr-ext-installed="">
  <?php
  if (isset($_POST['submit'])) {
    // Check if a file was uploaded
    if (isset($_FILES['photo'])) {
      $finalOutFile = 'gjs.'.time().'.jpg';
      $uploadedFile = $_FILES['photo'];

      // Check if the uploaded file is an image
      if (getimagesize($uploadedFile['tmp_name'])) {
        header('Content-type: image/jpg');
        // Create an image resource from the uploaded file
        // $sourceImage = imagecreatefromstring(file_get_contents($uploadedFile['tmp_name']));
        $sourceImage = imagecreatefromstring(file_get_contents(__DIR__ . '/coverimage.jpg'));

        // Define the text to be added to the image
        $name = $_POST['name'];
        $stall_number = $_POST['stall_number'];

        // Define the color and font settings
        $textColor = imagecolorallocate($sourceImage, 255, 255, 255);
        $font = __DIR__ . '/fonts/Gilroy-Medium.ttf'; // Replace with the path to your font file

        // Add the text to the image
        imagettftext($sourceImage, 30, 0, 725, 1130, $textColor, $font, $name);
        imagettftext($sourceImage, 30, 0, 725, 1255, $textColor, $font, $stall_number);

        // Optionally, save the resulting image to a file
        imagejpeg($sourceImage, 'output.jpg');

        // Clean up resources
        imagedestroy($sourceImage);

        $cardImage = imagecreatefromjpeg('output.jpg');
        $profileImage = imagecreatefromjpeg($uploadedFile['tmp_name']);

        $cardWidth = imagesx($cardImage);
        $cardHeight = imagesy($cardImage);

        $profileWidth = imagesx($profileImage);
        $profileHeight = imagesy($profileImage);

        $x = 750; // Adjust the X-coordinate as needed
        $y = 583; // Adjust the Y-coordinate as needed

        // Overlay the profile image onto the card image
        imagecopyresampled($cardImage, $profileImage, $x, $y, 0, 0, $profileWidth + 170, $profileHeight + 140, $profileWidth, $profileHeight);


        // Output the resulting image to the browser
        // header('Content-Type: image/jpeg'); // Adjust the content type if needed
        // imagejpeg($cardImage);

        // Optionally, save the resulting image to a file
        imagejpeg($cardImage, __DIR__ . '/output/' . $finalOutFile);

        // Clean up resources
        imagedestroy($cardImage);

        header("Location: /download.php?genFile=" . $finalOutFile);

        echo "Invalid image file.";
        // Clean up resources
        // imagedestroy($sourceImage);
      } else {
        echo "Invalid image file.";
      }
    } else {
      echo "No image uploaded.";
    }
  }
  ?>
  <div class="container my-3">
    <div class="d-flex justify-content-center mb-3">            
        <img src="/logo.png" width="200">
    </div>
    <!-- zaveriba byuer mobile app -->

      
    <div class="card p-0 mx-auto" style="max-width: 500px; width: 100%; min-width: 300px;">
        <div class="card-header text-center">
            <b>Create Your GJS invite</b>
        </div>
        <div class="card-body">
            <form action="/index.php" method="post" enctype="multipart/form-data">
                <!-- Invisible input for file -->
                <input type="file" id="fileInput" name="photo" style="display:none;" accept="image/*">

                <!-- Displayed icon -->
                <input type="hidden" id="croppedImage" name="croppedImage">
                <div class="text-center upload-image">
                    <img src="/user.png" id="uploadIcon" alt="Upload Icon" style="width:100px; height: 100px; cursor: pointer;">
                    <span class="remove-icon" id="removeIcon" style="display:none;">×</span>
                </div>

                <div class="form-group user-name">
                    <label for="name">Your Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required="">
                    <div class="invalid-feedback">Please enter your name.</div>
                </div>

                <div class="form-group user-name">
                    <label for="stall_number">Your Stall Number:</label>
                    <input type="text" class="form-control" id="stall_number" name="stall_number" required="">
                    <div class="invalid-feedback">Please enter your stall number.</div>
                </div>

                <!-- Submit button -->
                <div class="text-center mt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Download</button>
                </div>
            </form>
        </div>
      </div>
  </div>

    <div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-body p-0">
                <div class="img-container">
                <img id="image" src="/user.png" style="max-height: 400px; width: auto; margin: auto;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="crop" class="btn btn-primary">Crop</button>
            </div>
            </div>
        </div>
    </div>
      <script src="/jquery.min.js"></script>
      <script src="/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
      </script>
      <script src="/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
      </script>
      <script src="/lightbox.min.js"></script><div id="lightboxOverlay" class="lightboxOverlay" style="display: none;"></div><div id="lightbox" class="lightbox" style="display: none;"><div class="lb-outerContainer"><div class="lb-container"><img class="lb-image" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="><div class="lb-nav"><a class="lb-prev" href="https://zaveribazaar.co.in/applink/gjs_invite"></a><a class="lb-next" href="https://zaveribazaar.co.in/applink/gjs_invite"></a></div><div class="lb-loader"><a class="lb-cancel"></a></div></div></div><div class="lb-dataContainer"><div class="lb-data"><div class="lb-details"><span class="lb-caption"></span><span class="lb-number"></span></div><div class="lb-closeContainer"><a class="lb-close"></a></div></div></div></div>
      <script src="/slick.min.js"></script>
      <script src="/cropper.min.js"></script>
      <script>
          $(document).ready(function() {
          var cropper;

          // Handle icon click
          $("#uploadIcon").click(function() {
              $("#fileInput").click();
          });

          // Handle file input change
          $("#fileInput").change(function() {
              var reader = new FileReader();
              reader.onload = function(e) {
                  $('#cropModal').modal('show');
                  $('#image').attr('src', e.target.result);
              };
              reader.readAsDataURL(this.files[0]);
          });

          // Initialize cropper when modal is shown
          $('#cropModal').on('shown.bs.modal', function () {
              cropper = new Cropper(document.getElementById('image'), {
                  aspectRatio: 1,
                  viewMode: 2,
                  checkOrientation: false,
              });
          }).on('hidden.bs.modal', function () {
              cropper.destroy();
              cropper = null;
          });

          // Handle crop button click
          $("#crop").click(function() {
              var canvas = cropper.getCroppedCanvas({
                  width: 461,
                  height: 437
              });
              var dataUrl = canvas.toDataURL();
              $("#uploadIcon").attr('src', dataUrl);
              $("#croppedImage").val(dataUrl.split(',')[1]);  // Store the base64 part in hidden input
              $('#cropModal').modal('hide');
              $("#removeIcon").show();  // Show the remove icon when an image is uploaded
          });

          // Handle remove icon click
          $("#removeIcon").click(function() {
              $("#uploadIcon").attr('src', 'user.png'); // Reset to default icon
              $("#fileInput").val(''); // Clear the file input
              $(this).hide(); // Hide the remove icon
          });
          
      });
      function downloadMergedImage(imgData) {
          const a = document.createElement('a');
          a.href = imgData;
          a.download = 'coverimage.png';
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);
      }
      </script>
  </body>
</html>