<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="TestGal.css">
</head><body>

<!-- Trigger Image -->
<img id="myImg" src="gate1.jpg" alt="Gate View" style="width:100%;max-width:300px">

<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Close Button -->
  <span class="close">&times;</span>
  <!-- Modal Image -->
  <img class="modal-content" id="img01">
  <!-- Caption -->
  <div id="caption"></div>
</div>

<script>
  // Get elements
  var modal = document.getElementById("myModal");
  var img = document.getElementById("myImg");
  var modalImg = document.getElementById("img01");
  var captionText = document.getElementById("caption");

  // Show modal on image click
  img.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
  }

  // Close modal on X click
  var span = document.getElementsByClassName("close")[0];
  span.onclick = function() {
    modal.style.display = "none";
  }
</script>

</body>
</html> 