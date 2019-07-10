<?php
function success($message){
    return' <div class="alert alert-success alert-dismissible fade show" role="alert" id="myAlert">
    <h4 class="alert-heading">SUCCESS!</h4>
    <p>'.$message.'</p>
    <a href="#" class="close">&times;</a>
  </div>';
}
function error($message){
    return' <div class="alert alert-danger alert-dismissible fade show" role="alert" id="myAlert">
    <h4 class="alert-heading">ERROR!</h4>
    <p>'.$message.'</p>
    <a href="#" class="close">&times;</a>
  </div>';
}
?>