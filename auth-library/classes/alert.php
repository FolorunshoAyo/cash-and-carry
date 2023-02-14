<?php
/**
 * Alert with icon and title
 */
function alert($icon, $title)
{
    echo "<script>
            Swal.fire({
            title: '$title',
            icon: '$icon',
            allowOutsideClick: false,
            allowEscapeKey: false,
            });	
	</script>";
}


/**
 * Alert with icon, title and message
 */
function alert_msg($icon, $title, $msg)
{
    echo "<script>
        Swal.fire({
        title: '$title',
        html: '$msg',
        icon: '$icon',
        allowOutsideClick: false,
        allowEscapeKey: false,
        });	
	</script>";
    
}

/**
 * Alert with icon, title, message and url
 */
function alert_msg_url($icon, $title, $msg, $url){

    echo "<script>
        Swal.fire({
        title: '$title',
        html: '$msg',
        icon: '$icon',
        allowOutsideClick: false,
        allowEscapeKey: false,
        }).then(function(){
            window.location.replace('$url');							
        })	
    </script>";
}


/**
 * Alert with icon, title
 */
function alert_back($icon, $title)
{
    echo "<script>
        Swal.fire({
        title: '$title',
        icon: '$icon',
        allowOutsideClick: false,
        allowEscapeKey: false,
        }).then(function(){
            window.history.back();							
        })	
    </script>";
    
}

/**
 * Toast with icon, title
 */
function toast($icon, $title) {
    if($icon == "error") {
        echo "<script>
        iziToast.$icon({
            title: '$title',
            timeout: 4000,
            backgroundColor: 'red',
            theme: 'dark',
            position: 'topRight'
        });
        </script>";
    }elseif($icon == "warning") {        
        echo "<script>
        iziToast.$icon({
            title: '$title',
            timeout: 4000,
            backgroundColor: 'orange',
            theme: 'dark',
            position: 'topRight'
        });
        </script>";
    }elseif($icon == "success") {
        echo "<script>
        iziToast.$icon({
            title: '$title',
            timeout: 4000,
            backgroundColor: 'green',
            theme: 'dark',
            position: 'topRight'
        });
        </script>";
    }elseif($icon == "info") {
        echo "<script>
        iziToast.$icon({
            title: '$title',
            backgroundColor: 'skyblue',
            timeout: 4000,
            theme: 'dark',
            position: 'topRight'
        });
        </script>";
    }else{
        echo "<script>
        iziToast.$icon({
            title: '$title',
            timeout: 4000,
            theme: 'dark',
            position: 'topRight'
        });
        </script>";
    }
  
}


/**
 * Toast with icon, title and message
 */
function toast_msg($icon, $title, $msg) {
    if($icon == "error") {
        echo "<script>
        iziToast.$icon({
            title: '$title',
            timeout: 4000,
            backgroundColor: 'red',
            theme: 'dark',
            position: 'topRight',
            message: '$msg'
        });
        </script>";
    }elseif($icon == "warning") {        
        echo "<script>
        iziToast.$icon({
            title: '$title',
            timeout: 4000,
            backgroundColor: 'orange',
            theme: 'dark',
            position: 'topRight',
            message: '$msg'
        });
        </script>";
    }elseif($icon == "success") {
        echo "<script>
        iziToast.$icon({
            title: '$title',
            timeout: 4000,
            backgroundColor: 'green',
            theme: 'dark',
            position: 'topRight',
            message: '$msg'
        });
        </script>";
    }elseif($icon == "info") {
        echo "<script>
        iziToast.$icon({
            title: '$title',
            timeout: 4000,
            backgroundColor: 'skyblue',
            theme: 'dark',
            position: 'topRight',
            message: '$msg'
        });
        </script>";
    }else{
        echo "<script>
        iziToast.$icon({
            title: '$title',
            timeout: 4000,
            theme: 'dark',
            position: 'topRight',
            message: '$msg'
        });
        </script>";
    }

   
}
?>