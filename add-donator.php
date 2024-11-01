<?php function add_donations() {
  if(isset($_GET['action']) && $_GET['action']=='edit') {
global $wpdb;
 $table = $wpdb->prefix . 'sdm_don'; 
 $rw = $wpdb->get_row( $wpdb->prepare( "select * FROM $table WHERE id = %d ", "$_GET[id]" ) );
$fname=$rw->fname; 
}
?>
 <div class="wrap">
 <h3>Add New Donators Details</h3>
 <form id="form1" name="form1" method="post" action="<?php the_permalink(); ?>">
  <table><tr>
  <td>  <label for="name"><strong>First Name</strong></label></td>
    <td><input type="text" name="fname" id="fname" size="50" maxlength="250" align="middle" width="250px" height="50px" value="<?php echo $rw->fname;?>" /></td> </tr>
    <tr>
  <td>  <label for="name"><strong>Last Name</strong></label></td>
    <td><input type="text" name="lname" id="lname" size="50" maxlength="250" align="middle" width="250px" height="50px" value="<?php echo $rw->lname;?>" /></td> </tr>
 <tr>
  <td><label for="name"><strong>Email</strong></label></td>
   <td> <input type="text" name="email" id="email" size="50" maxlength="250" align="middle" width="250px" height="50px" value="<?php echo $rw->email;?>"/></td>
   </tr>
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
  <td>  <input type="text" name="city" id="city" size="50" maxlength="250" align="middle" width="250px" height="50px" value="<?php echo $rw->city;?>"/></textarea></td>
  </tr>
  <tr>
 <td> <label for="name"><strong>Country</strong></label></td>
  <td>  <input type="text" name="country" id="country" size="50" maxlength="250" align="middle" width="250px" height="50px" value="<?php echo $rw->country;?>"/></textarea></td>
  </tr>
  <tr>
 <td> <label for="name"><strong>Pincode</strong></label></td>
  <td>  <input type="text" name="pincode" id="pincode" size="50" maxlength="250" align="middle" width="250px" height="50px" value="<?php echo $rw->pincode;?>"/></textarea></td>
  </tr>
  <tr>
  <td><label for="name"><strong>Phone Number</strong></label></td>
    <td><input type="text" name="phone" id="phone" value="<?php echo $rw->phone;?>" /></textarea></td></tr>
  <tr>
  <td><label for="name"><strong>Date</strong></label></td>
    <td><input type="text" name="date" id="date" value="<?php echo $rw->time;?>" />
    </textarea>YYYY/MM/DD</td>
  </tr>
    
  <tr><td>
  <label for="name"><strong>Mode</strong></label></td>
  <td>
    <select name="mode" id="mode">
      <option>Direct Deposite</option>
      <option>Online Donation</option>
      <option>Cheque</option>
      <option>By Cash</option>
      <option>By DD</option>
    </select></td></tr>
  
  <tr><td><label for="amount"><strong>Donation Amount</strong></label></td>
    <td><input type="text" name="amount" id="amount" value="<?php echo $rw->amount;?>" /></td></tr>
  <tr><td><input type="submit" name="button" id="button" value="Save" class="button-primary"/></td></tr>
   <input type="hidden" name="submitted-rec" id="submitted-rec" value="true" />
   </table>
</form>
</div>
<?php }
?><?php
if(isset($_POST['submitted-rec'])) {
//'address1'=>"$_POST[address1]", 'address2'=>"$_POST[address2]", 'city'=>"$_POST[city]", 'country'=>"$_POST[country]", 'pincode'=>"$_POST[pincode]", 'phone'=>"$_POST[phone]", 

global $wpdb;
$table = $wpdb->prefix . 'sdm_don';
if(isset($_GET['action']) && $_GET['action']=='edit')
{
$wpdb->update("$table", array('fname'=>"$_POST[fname]",'lname'=>"$_POST[lname]", 'email'=>"$_POST[email]",'address1'=>"$_POST[address1]",'address2'=>"$_POST[address2]",'city'=>"$_POST[city]",'country'=>"$_POST[country]",'pincode'=>"$_POST[pincode]",'phone'=>"$_POST[phone]",'time'=>"$_POST[date]" , 'mode'=>"$_POST[mode]", 'amount'=>"$_POST[amount]"),array( 'id' => "$_GET[id]" ), array('%s','%s','%s','%s','%s','%s','%s','%d','%s','%s','%s','%d'));
echo"<h3>Updated Successfully!!</h3>";
}
else
{
$wpdb->insert("$table", array('fname'=>"$_POST[fname]",'lname'=>"$_POST[lname]", 'email'=>"$_POST[email]",'address1'=>"$_POST[address1]",'address2'=>"$_POST[address2]",'city'=>"$_POST[city]",'country'=>"$_POST[country]",'pincode'=>"$_POST[pincode]",'phone'=>"$_POST[phone]",'time'=>"$_POST[date]" , 'mode'=>"$_POST[mode]", 'amount'=>"$_POST[amount]"), array('%s','%s','%s','%s','%s','%s','%s','%d','%s','%s','%s','%d'));
echo"<h3>Saved Successfully!!</h3>";
}
}
 ?>