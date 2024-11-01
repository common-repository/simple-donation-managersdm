<?php
/*
Plugin Name: Simple Donation Manager(SDM)
Plugin URI: http://wordpress.org/extend/plugins/sdm
Description: This is not just a plugin,which help the charitable trust organisations to keep the donations and receivers info.Also they can publish the same. 
Author: Sarankumar
Version: 1.0
Author URI: http://www.yatramantra.com/
*/
?><?php
  //Creating dashboard menus

function sdm_dashmenu(){
    add_menu_page( 'Donations', 'Donations', 'edit_others_posts', 'donations', 'cap_donations','', 6 );
	add_submenu_page( 'donations', 'Receivers','Receivers','edit_others_posts','receivers', 'receivers' ); 
	add_submenu_page( 'donations', 'Add Donation','Add Donation','edit_others_posts','add_donations', 'add_donations' ); 
	add_submenu_page( 'donations', 'Add Receiver','Add Receiver','edit_others_posts','add_receiver', 'add_receiver' ); 
}
add_action( 'admin_menu', 'sdm_dashmenu' );
// Load all the menu pages 
define( 'MYPLUGINNAME_PATH', plugin_dir_path(__FILE__) );
require MYPLUGINNAME_PATH . 'donations.php';
require MYPLUGINNAME_PATH . 'receivers.php';
require MYPLUGINNAME_PATH . 'add-donator.php';
require MYPLUGINNAME_PATH . 'add-receiver.php';
// Create database when plugin activated

//Activation hook so the DB is created when plugin is activated


/**
 Defining Custom Database Table
 * ============================================================================

 */

/**
 * $sdm_db_ver- holds current database version
 * and used on plugin update to sync database tables
 */
global $sdm_db_ver;
$sdm_db_ver = '1.0'; 

/**
 * will be called when user activates plugin first time
 * must create needed database tables
 */
function sdm_table_install()
{
    global $wpdb;
    global $sdm_db_ver;

    $table_name1 = $wpdb->prefix . 'sdm_don'; // do not forget about tables prefix
    $table_name2 = $wpdb->prefix . 'sdm_rec';
    // sql to create table
    
    $sql1 = "CREATE TABLE " . $table_name1 . " (
      id int(11) NOT NULL AUTO_INCREMENT,
      fname tinytext NOT NULL,
	   lname tinytext NOT NULL,
      email VARCHAR(100) NOT NULL,
      address1 VARCHAR(100),
	  address2 VARCHAR(100),
	  city VARCHAR(100),
	  country VARCHAR(100),
	  phone varchar(20),
	  pincode int(20),
	  time datetime DEFAULT '00-00-0000' NOT NULL,
	  mode varchar(20),
	  amount float (20),
      PRIMARY KEY  (id)
    );";
	$sql2 = "CREATE TABLE " . $table_name2 . " (
      id int(11) NOT NULL AUTO_INCREMENT,
       fname tinytext NOT NULL,
	   lname tinytext NOT NULL,
      address1 VARCHAR(100),
	  address2 VARCHAR(100),
	  city VARCHAR(100),
	  phone varchar(20),
	  pincode int(20),
	  time datetime DEFAULT '00-00-0000' NOT NULL,
	  add_info varchar(200),
	  amount float (20),
      PRIMARY KEY  (id)
    );";

    
    //  calling dbDelta which cant migrate database
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql1);
	dbDelta($sql2);

    // save current database version for later use (on upgrade)
    add_option('sdm_db_ver', $sdm_db_ver);

       
    
    $installed_ver = get_option('sdm_db_ver');
    if ($installed_ver != $sdm_db_ver) {
        $sql = "CREATE TABLE " . $table_name . " (
          id int(11) NOT NULL AUTO_INCREMENT,
          name tinytext NOT NULL,
      email VARCHAR(100) NOT NULL,
      address VARCHAR(100),
	  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	  mode varchar(20),
	  amount float (20),
      PRIMARY KEY  (id)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // notice that we are updating option, rather than adding it
        update_option('sdm_db_ver', $sdm_db_ver);
    }
}

register_activation_hook(__FILE__, 'sdm_table_install');


 /* shortcode for displying donation details on a page */

 
function register_shortcodes(){
   add_shortcode('donations', 'cap_donations_show');
   add_shortcode('beneficiaries','cap_receivers_show');
}
add_action( 'init', 'register_shortcodes');
 
  ?><?php function cap_donations_show(){ ?>
   <div class="wrap">
   <div class='tablenav-pages'>
 <table class="widefat">
<thead>
	<tr>
		<th>Sl No</th>
		<th>Name</th>
        <th>Email</th>
        <th>Address</th>
        
        <th>City</th>
    
        <th>Pinocde</th>
        <th>Phone</th>	
          <th>Date</th>		
		<th>Mode</th>
        <th>Amount</th>
	</tr>
</thead>
<tfoot>
    <tr>
	<th>Sl No</th>
		<th>Name</th>
        
        <th>Email</th>
        <th>Address</th>
                <th>City</th>
              <th>Pinocde</th>
        <th>Phone</th>	
        <th>Date</th>	
		<th>Mode</th>
        <th>Amount</th>
    </tr>
</tfoot>
<tbody><?php global $wpdb;
		    $table = $wpdb->prefix . 'sdm_don'; 
			$i=1;
   $data = $wpdb->get_results("SELECT * FROM $table", ARRAY_A) ;
   foreach($data as $post) { ?>
   
   <tr>
   <td><?php echo $i; ?></td>
     <td><?php echo $post['fname']." ".$post['lname']; ?></td>
     
         <td><?php echo $post['email']; ?></td>
     <td><?php echo $post['address1']." ".$post['address2']; ?></td>
      
       <td><?php echo $post['city']; ?></td>
                 <td><?php echo $post['pincode']; ?></td>
          <td><?php echo $post['phone']; ?></td>
     <td><?php echo $post['time']; ?></td>
     <td><?php echo $post['mode']; ?></td>
     <td><?php echo $post['amount']; ?></td>
   </tr>
   <?php 
   $i++;
   } ?>
</tbody>
</table>
</div>
   </div>
   <?php } 
  ?><?php function cap_receivers_show(){ ?>
   <div class="wrap">
   <div class='tablenav-pages'>
 <table class="widefat">
<thead>
	<tr>
		<th>Sl No</th>
		<th>FName</th>
        <th>LName</th>
        <th>Address1</th>
        <th>Address2</th>
        <th>City</th>
        <th>Pincode</th>
        <th>Phone</th>
        <th>Date</th>
         <th>Add Info</th>		
	    <th>Amount</th>
	</tr>
</thead>
<tfoot>
    <tr>
	<th>Sl No</th>
		<th>FName</th>
        <th>LName</th>
        <th>Address1</th>
        <th>Address2</th>
        <th>City</th>
        <th>Pincode</th>
        <th>Phone</th>
        <th>Date</th>
        <th>Add Info</th>			
	    <th>Amount</th>
    </tr>
</tfoot>
<tbody>
<?php global $wpdb;
		    $table = $wpdb->prefix . 'sdm_rec'; 
			$i=1;
   $data = $wpdb->get_results("SELECT * FROM $table", ARRAY_A) ;
   foreach($data as $post) { ?>
   
   <tr>
   <td><?php echo $i; ?></td>
     <td><?php echo $post['fname']; ?></td>
    <td> <?php echo $post['lname']; ?></td>
         <td><?php echo $post['address1']; ?></td>
         <td><?php echo $post['address2']; ?></td>
         <td><?php echo $post['city']; ?></td>
         <td><?php echo $post['pincode']; ?></td>
         <td><?php echo $post['phone']; ?></td>
     <td><?php echo $post['time']; ?></td>
     <td><?php echo $post['add_info']; ?></td>
     <td><?php echo $post['amount']; ?></td>
   </tr>
   <?php 
   $i++;
   } ?>
</tbody>
</table>
</div>
   </div>
   <?php } ?>