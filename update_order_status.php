<?php 
include 'db1.php';

$fetch=$_REQUEST['order_id'];
$temp=0;
echo $fetch;
if($temp==0)
{
    $sql="update orders set payment_status='Paid',order_status='Delivered' where order_id='$fetch'";
    // print_r($sql);
    // exit;
    $result = mysqli_query($conn,$sql);

    if($result){
      //  $temp = 1;
        echo "Yes";
    }
}
else{
    echo" <script>alert('Data Has Been already Updated')</script> ";
    
}
header('location:manage_orders.php');

?>