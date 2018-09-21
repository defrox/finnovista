<?php
$license=$this->get_license();
if(isset($_POST['remove_license'])){
	$license_key = (isset($_POST['license_key'])&& !empty($_POST['license_key']))? $_POST['license_key']: $license['license'];
	if($license_key!=''){
		global $wp_version;
		$args = array(
			'slug' => $this->slug,
			'key'=>$license_key,
			'url' =>home_url(),
			'email' =>get_bloginfo('admin_email')
		);
		$request = wp_remote_post($this->remote_path, array('body' => array('action' => 'remove','request' => serialize($args)),'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')));
		if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
			if($request['body'])
			{
				$result = json_decode($request['body']);
				if($result->status=='success'){
					$license['date'] = time();
					$license['license'] = "";
				}
				$license['status'] = false;
				update_option($this->LicenseName,$license);
				?>
				<div class="<?php if($result->status=='success') echo 'updated';else echo 'error';?>"><p><strong><?php echo $result->message;?></strong></p></div>
			<?php
			}

		}
	}else{
		?>
		<div class="error"><p><strong>No license key to remove</strong></p></div>
	<?php
	}


}
if(isset($_POST['add_license']) && isset($_POST['license_key']) && !empty($_POST['license_key'])){
	global $wp_version;
	$args = array(
		'slug' => $this->slug,
		'key'=>$_POST['license_key'],
		'url' =>home_url(),
		'email' =>get_bloginfo('admin_email')
	);
	$request = wp_remote_post($this->remote_path, array('body' => array('action' => 'active','request' => serialize($args)),'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')));
	if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
		if($request['body'])
		{
			$result = json_decode($request['body']);
			if($result->status=='success'){
				$license['status'] = true;
				$license['date'] = time();
			}else $license['status'] = false;
			$license['license'] = $_POST['license_key'];
			update_option($this->LicenseName,$license);
			?>
			<div class="<?php if($result->status=='success') echo 'updated';else echo 'error';?>"><p><strong><?php echo $result->message;?></strong></p></div>
		<?php

		}


	}

}
if(isset($_POST['re_add_license'])){
	global $wp_version;
	$args = array(
		'slug' => $this->slug,
		'key'=>$license['license'],
		'url' =>home_url(),
		'email' =>get_bloginfo('admin_email')
	);
	$request = wp_remote_post($this->remote_path, array('body' => array('action' => 'active','request' => serialize($args)),'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')));
	if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
		if($request['body'])
		{
			$result = json_decode($request['body']);
			if($result->status=='success'){
				$license['status'] = true;
				$license['date'] = time();
			}else $license['status'] = false;
			update_option($this->LicenseName,$license);
			?>
			<div class="<?php if($result->status=='success') echo 'updated';else echo 'error';?>"><p><strong><?php echo $result->message;?></strong></p></div>
		<?php

		}

	}
}

$status = (!empty($license['status']))?$license['status']:false;
$key = (!empty($license['license']))?$license['license']:'';
if($status && ($key!='' || !empty($key))){
	$k = strrpos($key,"-");
	if($k)
		for($i=0;$i<strlen($key);$i++){
			if($i<$k) $key[$i] = "*";
		}

}

?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2><?php _e('License','mega-slider');?></h2>
	<p>Please enter your license key to enable plugin update via wordpress admin. You can <a href="http://files.megadrupal.com/how-to-get-purchase-code.png">follow this steps</a> to get your license key</p>
	<form action="" method="post">
		<table class="form-table" id="modern-admin-icons-table">
			<tbody>

			<tr valign="top">
				<th scope="row"><label for="license_key"><?php _e('License Key','mega-slider');?></label></th>
				<td>
					<?php if($status!=false):?>
						<div><?php echo $key;?></div>
					<?php else:?>
						<input type="text" class="regular-text" id="license_key" value="<?php echo $key;?>" name="license_key">
					<?php endif;?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="status"><?php _e('Status','mega-slider');?></label></th>
				<td>

					<?php if($license['status']==true) echo "<b style='color: #008000'>OK</b>"; else echo "<b style='color: red'>FALSE</b>"?>

				</td>
			</tr>
			<tr valign="top">
				<th scope="row"></th>
				<td>
					<button type="submit" name="<?php if($status!=false) echo "re_add_license"; else echo "add_license";?>">
						<?php if($status!=false):?>
							<?php _e('Re-Active','mega-slider');?>
						<?php else:?>
							<?php _e('Active','mega-slider');?>
						<?php endif;?>
					</button>
					<button type="submit" name="remove_license"><?php _e('Remove','mega-slider');?></button>
				</td>

			</tr>
			</tbody>
		</table>
	</form>


</div>