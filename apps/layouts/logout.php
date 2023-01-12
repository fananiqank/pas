<?php
session_start();
$hs="../../";
session_destroy();

echo "<script>location.href='$hs';</script>";
