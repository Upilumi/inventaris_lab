<?php

function log_activity($icon, $warna, $aktivitas, $pengguna)
{
    global $conn;

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO log_aktivitas
        (icon, warna, aktivitas, pengguna)
        VALUES (?,?,?,?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $icon,
        $warna,
        $aktivitas,
        $pengguna
    );

    mysqli_stmt_execute($stmt);
}