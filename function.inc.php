<?php
function safe_value($con,$str)
{   if($str!='')
    return mysqli_real_escape_string($con,$str);
}
function category($val)
{
    switch ($val) {
  case "R":
    return"Roll";
  case "P":
    return"Paratha";
  case "FM":
    return"Full Meal";
  case "C":
    return"Cake";
  case "S":
    return"Snacks";
  case "SD":
    return"Soft Drink";
  case "IC":
    return"Ice-Cream";
  case "CR":
    return"Curry";
}
}
function item_name($id){
  $con=mysqli_connect("localhost","root","","project1");
  if (preg_match("/GLA@CT/", $id) != '') {
    $qrry = "SELECT * FROM `ct_items` WHERE Item_code='$id'";
    $res = mysqli_query($con, $qrry);
    $item = mysqli_fetch_assoc($res);
    return $item['I_name'];
  }
  else {
    return"no id found";
  }
}
function search($con,$t_name,$col_name='',$value='')
{   
    if($col_name!='' && $value!='')
    {
    return mysqli_query($con, "SELECT * FROM `$t_name` WHERE $col_name is like '%$value%'");
    }
    if($col_name='' && $value='')
    {
    return mysqli_query($con, "SELECT * FROM `$t_name`");
    }

}
function encryptionKey($username, $password, $ivseed = "!!!")
{
    $username = strtolower($username);
    return hash("sha1", $password . $username.$ivseed);
}

$ENCRYPTION_KEY =  encryptionKey("dummy1", "dummypass1", $ivseed = "!!!") ;
$ENCRYPTION_ALGORITHM = 'AES-256-CBC';
// Other cipher methods can be used. Identified what is available on your server
// by visiting: https://www.php.net/manual/en/function.openssl-get-cipher-methods.php
// END: Define some variable(s)

// BEGIN FUNCTIONS ***************************************************************** 
function EncryptThis($ClearTextData)
{
    // This function encrypts the data passed into it and returns the cipher data with the IV embedded within it.
    // The initialization vector (IV) is appended to the cipher data with 
    // the use of two colons serve to delimited between the two.
    global $ENCRYPTION_KEY;
    global $ENCRYPTION_ALGORITHM;
    $EncryptionKey = base64_decode($ENCRYPTION_KEY);
    $InitializationVector  = openssl_random_pseudo_bytes(openssl_cipher_iv_length($ENCRYPTION_ALGORITHM));
    $EncryptedText = openssl_encrypt($ClearTextData, $ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
    return base64_encode($EncryptedText . '::' . $InitializationVector);
}

function DecryptThis($CipherData)
{
    // This function decrypts the cipher data (with the IV embedded within) passed into it 
    // and returns the clear text (unencrypted) data.
    // The initialization vector (IV) is appended to the cipher data by the EncryptThis function (see above).
    // There are two colons that serve to delimited between the cipher data and the IV.
    global $ENCRYPTION_KEY;
    global $ENCRYPTION_ALGORITHM;
    $EncryptionKey = base64_decode($ENCRYPTION_KEY);
    list($Encrypted_Data, $InitializationVector) = array_pad(explode('::', base64_decode($CipherData), 2), 2, null);
    return openssl_decrypt($Encrypted_Data, $ENCRYPTION_ALGORITHM, $EncryptionKey, 0, $InitializationVector);
}

?>
