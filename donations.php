<?php function cap_donations()
{
//Our class extends the WP_List_Table class, so we need to make sure that it's there
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class R_List_Table extends WP_List_Table {

	/**
	 * Constructor, we override the parent to pass our own arguments
	 * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
	 */
	 function __construct() {
		 parent::__construct( array(
		'singular'=> 'donor', //Singular label
		'plural' => 'donors', //plural label, also this well be one of the table css class
		'ajax'	=> false //We won't support Ajax for this table
		) );
	 }// constructor ends here...
	function example_data(){
	/* -- Preparing your query -- */
	        global $wpdb;
		    $table = $wpdb->prefix . 'sdm_don'; 
   $example_data = $wpdb->get_results("SELECT * FROM $table", ARRAY_A) ;
	

 return $example_data;
 }

function get_columns(){
  $columns = array(
   'fname' => 'FName',
   'lname' => 'LName',
   'email' => 'Email',
   'address1' => 'Address1',
   'address2' => 'Address2',
   'city' => 'City',
   'country' => 'Country',
   'pincode' => 'Pincode',
   'phone' => 'Phone',
   'time' => 'Date',
   'mode' => 'Mode',
   'amount' => 'Amount',
  );
  return $columns;
}

function prepare_items() {
  $columns = $this->get_columns();
  $hidden = array();
  $sortable = array();
  $this->_column_headers = array($columns, $hidden, $sortable);
  $this->items = $this->example_data();
  
  $per_page = 15;
  $current_page = $this->get_pagenum();
  $total_items = count($this->example_data());

  // only ncessary because we have sample data
  $this->found_data = array_slice($this->example_data(),(($current_page-1)*$per_page),$per_page);

  $this->set_pagination_args( array(
    'total_items' => $total_items,                  //WE have to calculate the total number of items
    'per_page'    => $per_page                     //WE have to determine how many items to show on a page
  ) );
  $this->items = $this->found_data;
  
}
function column_default( $item, $column_name ) {
  switch( $column_name ) { 
    case 'fname':
	case 'lname':
    case 'email':
    case 'address1':
	case 'address2':
	case 'pincode':
	case 'city':
	case 'country':
	case 'phone':
	case 'time':
	case 'mode':
	case 'amount':
      return $item[ $column_name];
    default:
      return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
  }
}
	//###################3
	
	function column_fname($item) {
  $actions = array(
           'edit'      => sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>','add_donations','edit',$item['id']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id']),
        );

  return sprintf('%1$s %2$s',$item['fname'], $this->row_actions($actions) );
}
	 /**
 * Add extra markup in the toolbars before or after the list
 * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
 */
function extra_tablenav( $which ) {
	if ( $which == "top" ){
		//The code that goes before the table is here
		echo"<div id='icon-users' class='icon32'></div><h2>List of Donations received.</h2>";
	}
	if ( $which == "bottom" ){
		//The code that goes after the table is there
		//echo"Hi, I'm after the table";
	}
}// entra table nav enda here




}// end class def

//Prepare Table of elements
$wp_list_table = new R_List_Table();
$wp_list_table->prepare_items();
//Table of elements
$wp_list_table->display();

if(isset($_GET['action']) && $_GET['action']=='delete') {
//echo"deletion goes herde";
global $wpdb;
 $table = $wpdb->prefix . 'sdm_don'; 
$sql = $wpdb->prepare("DELETE FROM $table WHERE id = %d ", "$_GET[id]");
echo"<h3>Deleted Successfully </h3>";
   $wpdb->query($sql);
}


 }
	  ?>