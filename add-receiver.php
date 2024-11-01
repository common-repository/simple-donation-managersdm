<?php 
  function add_receiver() {  
  if(isset($_GET['action']) && $_GET['action']=='edit') {
global $wpdb;
 $table = $wpdb->prefix . 'sdm_rec'; 
 $rw = $wpdb->get_row( $wpdb->prepare( "select * FROM $table WHERE id = %d ", "$_GET[id]" ) );
$fname=$rw->fname; 

   
}

   ?>

 <div class="wrap">
 <h3>Add New Receiver Details</h3>
 <form id="form1" name="form1" method="post" action="<?php the_permalink(); ?>">

  <table>
 <tr>
  <td>  <label for="name"><strong>First Name</strong></label></td>
    <td><input type="text" name="fname" id="fname" size="50" maxlength="250" align="middle" width="250px" height="50px" value="<?php echo $rw->fname;?>"  /></td> </tr>
    <tr>
  <td>  <label for="name"><strong>Last Name</strong></label></td>
    <td><input type="text" name="lname" id="lname" size="50" maxlength="250" align="middle" width="250px" height="50px" value="<?php echo $rw->lname;?>" /></td> </tr>

  <tr>
 <td> <label for="name"><strong>Address(1st Line)</strong></label></td>
  <td>  <input type="text" name="address1" id="address1" size="50" maxlength="250" align="middle" width="250px" height="50px" value="<?php echo $rw->address1;?>"/></textarea></td>
  </tr>
  <tr>
 <td> <label for="name"><strong>Address(2nd Line)</strong></label></td>
  <td>  <input type="text" name="address2" id="address2" size="50" maxlength="250" align="middle" width="250px" height="50px" value="<?php echo $rw->address2;?>"/></textarea></td>
  </tr>
  <tr>
 <td> <label for="name"><strong>Town/City</strong></label></td>
  <td>  <input type="text" name="city" id="city" size="50" maxlength="250" align="middle" width="250px" height="50px"value="<?php echo $rw->city;?>"/></textarea></td>
  </tr>
  <tr>
<tr>
 <td> <label for="name"><strong>Pincode</strong></label></td>
  <td>  <input type="text" name="pincode" id="pincode" size="50" maxlength="250" align="middle" width="250px" height="50px" value="<?php echo $rw->pincode;?>"/></textarea></td>
  </tr>
  <tr>
  <td><label for="name"><strong>Phone Number</strong></label></td>
    <td><input type="text" name="phone" id="phone" value="<?php echo $rw->phone;?>"/></textarea></td></tr>
  <tr>
 <td>
  <label for="date"> <span style="font-weight: bold">Date</span></label></td>
  <td>  <input type="text" name="date" id="date" value="<?php echo $rw->time;?>" />
  </textarea>YYYY/MM/DD</td>
 </tr>
  
<tr>
 <td>
 <label for="purpose"> <span style="font-weight: bold">Additional Info</span></label></td>
   <td> <textarea  name="add_info" id="add_info" cols="45" rows="2"   /><?php echo $rw->add_info;?></textarea></td>
 </tr>
<tr>
 <td>
    <label for="amount"><span style="font-weight: bold">Amount</span></label></td>
   <td> <input type="text" name="amount" id="amount" value="<?php echo $rw->amount;?>" /></td>
 </tr>
 <tr>
 <td>  <input type="submit" name="save" id="save" value=" <?php if(isset($_GET['action']) && $_GET['action']=='edit')
  echo 'update';
   else 
   echo 'save';?> " 
  class="button-primary"/></td>
 
 </tr>
 <tr> <td><?php // if($tbl_insert_try=true) ?>
   </td></tr>
    <input type="hidden" name="submitted" id="submitted" value="true" />
    </table>
</form>
</div><?php 
}



if(isset($_POST['submitted']) && !empty($_POST['fname'])) {
//
 global $wpdb;
 $table = $wpdb->prefix . 'sdm_rec';

 if(isset($_GET['action']) && $_GET['action']=='edit')
{
 $wpdb->update("$table", array('fname'=>"$_POST[fname]",'lname'=>"$_POST[lname]",'address1'=>"$_POST[address1]",'address2'=>"$_POST[address2]",'city'=>"$_POST[city]",'pincode'=>"$_POST[pincode]",'phone'=>"$_POST[phone]",'time'=>"$_POST[date]" , 'amount'=>"$_POST[amount]",'add_info'=>"$_POST[add_info]" ),array( 'id' => "$_GET[id]" ), array('%s','%s','%s','%s','%s','%d','%s','%s','%d','%s'));
echo" Updated successfully";
}
else
{
 $wpdb->insert("$table", array('fname'=>"$_POST[fname]",'lname'=>"$_POST[lname]",'address1'=>"$_POST[address1]",'address2'=>"$_POST[address2]",'city'=>"$_POST[city]",'pincode'=>"$_POST[pincode]",'phone'=>"$_POST[phone]",'time'=>"$_POST[date]" , 'amount'=>"$_POST[amount]",'add_info'=>"$_POST[add_info]" ), array('%s','%s','%s','%s','%s','%d','%s','%s','%d','%s'));

echo "Successfully added new Data";
}

}

?>