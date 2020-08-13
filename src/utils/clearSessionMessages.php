<?php

function clearSessionMessages() {
  unset($_SESSION['error']);
  unset($_SESSION['success']);
}
