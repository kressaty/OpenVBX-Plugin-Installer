<?php

	$ci = & get_instance();

	$ci->load->helper(array('form', 'url', 'file'));
	
	$config['upload_path'] = 'plugins/plugin_installer/workspace';
	$config['allowed_types'] = 'zip|tar|gz';
	$config['max_size']	= '2000';
	
	$ci->load->library('upload', $config);

	if ( ! $ci->upload->do_upload())
	{
		$error = $ci->upload->display_errors('<div>', '</div>');
		
	}	
	else
	{
		$data = $ci->upload->data();
		
		$zip = new ZipArchive;
		
	    $res = $zip->open($data['full_path']);
	    
	    if ($res === TRUE) {
	        $zip->extractTo('plugins');
	        $zip->close();
	        //echo 'ok';
	        
	    } else {
	        $zip_fail = 'Oops! Looks like we had an issue unzipping your plugin';
	    }
		
	}
	
	
?>

<div class="vbx-plugin">
	
	<h3>Install New Plugin</h3>
	<br />
		<div class="error-message" style="display: block;">
		<?php echo $error;?>
		<?php echo isset($zip_fail);?>
		</div>
	<br />
	<?php echo form_open_multipart('http://vbx.ripstyles.com/p/installer');?>
	
	<input type="file" name="userfile" size="20" />
	
	<br /><br />
	
	<input type="submit" value="Upload and Install Selected Zip Archive" />
	
	</form>
	<!--
	<br />
	<br />
	<h3>Manage Applets and Plugins</h3>
	<br />
	<?php
	
		// directory path can be either absolute or relative
		$directory = 'plugins';
		
		// open the specified directory and check if it's opened successfully 
		if ($handle = opendir($directory)) {
		
		   // keep reading the directory entries 'til the end 
		   while (false !== ($file = readdir($handle))) {
		
		      // just skip the reference to current and parent directory 
		      if ($file != "." && $file != "..") {
		         if (is_dir("$directory/$file")) {
		            // found a directory, do something with it? 
		            echo "[$file]<br>";
		         } else {
		            // found an ordinary file 
		            echo "$file<br>";
		         }
		      }
		   }
		
		   // ALWAYS remember to close what you opened 
		   closedir($handle);
		}
	
	?>-->
</div>