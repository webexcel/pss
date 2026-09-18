<?php 

$image = file_get_contents('http://schooltree.in/bills/demoschprint.php?r=&adno=1393&name=BAVANIKA.V&fname=VIJAYARAMAN&std=LKG-A');
file_put_contents('./temp/demo.pdf', $image);

//$url = 'http://schooltree.in/bills/demoschprint.php?r=&adno=1393&name=BAVANIKA.V&fname=VIJAYARAMAN&std=LKG-A';
//$result = downloadFile($url,"/temp","demosch.pdf");

if ($result == true)
{
    echo "ok";
}
else
{
    echo "error";
}

function downloadFile($url,$toDir,$withName) {
    
    // open file in rb mode
    if ($fp_remote = fopen($url, 'rb')) {
     
        // local filename
        $local_file = $toDir ."/" . $withName;
     
         // read buffer, open in wb mode for writing
        if ($fp_local = fopen($local_file, 'wb')) {
            
            // read the file, buffer size 8k
            while ($buffer = fread($fp_remote, 8192)) {
     
                // write buffer in  local file
                fwrite($fp_local, $buffer);
            }
     
            // close local
            fclose($fp_local);
           
        }
        else
        {
			echo "error 1";
            // could not open the local URL
            fclose($fp_remote);
            return false;    
        }
        
        // close remote
        fclose($fp_remote);
        
        return true;
    }
    else
    {
        // could not open the remote URL
        return false;
    }
    
}
?>