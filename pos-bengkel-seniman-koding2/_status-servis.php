<?php  
    if ( $statusServisHistory == 1 ) {
        $sshView = "<span class='badge badge-secondary'>Antrian Servis Masuk</span>";

    } elseif ( $statusServisHistory == 2 ) {
        $sshView = "<span class='badge badge-warning'>Menunggu Sparepart</span>";

    } elseif ( $statusServisHistory == 3 ) {
        $sshView = "<span class='badge badge-info'>Sparepart Datang</span>";
                                    
    } elseif ( $statusServisHistory == 4 ) {
        $sshView = "<span class='badge badge-success'>Proses Servis</span>";
                                    
    } elseif ( $statusServisHistory == 5 ) {
        $sshView = "<span class='badge badge-primary'>Bisa Diambil</span>";
                                    
    } elseif ( $statusServisHistory == 6 ) {
        $sshView = "<span class='badge badge-dark'>Sudah Diambil</span>";
                                    
    }elseif ( $statusServisHistory == 7 ) {
        $sshView = "<span class='badge badge-danger'>Oper Teknisi Lain</span>";
                                    
    } elseif ( $statusServisHistory == 8 ) {
        $sshView = "<span class='badge badge-danger'>Tidak Bisa</span>";
                                    
    } elseif ( $statusServisHistory == 9 ) {
        $sshView = "<span class='badge badge-danger'>Komplain Garansi</span>";
                                    
    } else {
        $sshView = "<span class='badge badge-danger'>Cancel</span>";
    }
?>  