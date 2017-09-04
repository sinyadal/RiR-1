
<?php
$title = 'View Records';
include ("../inc/Check_Session.php");
include ("../inc/DataBaseConnection.php");
include ("../inc/Template.php");
redirectGuest();

// handle delete
if (isset($_POST['delete'])) {
    // delete transaction
}

$user = getUser();
$sql = "
SELECT e.*, u.User_Fullname 
FROM rir_expenses AS e 
LEFT JOIN rir_user AS u ON u.id = e.user_id
WHERE user_id = {$user->id};";
$rs = mysqli_query($db, $sql);
?>
<link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css" />
<link rel="stylesheet" href="../css/sweetalert2.min.css" />
<nav class="main-nav-outer" id="test"><!--main-nav-start-->
	<div>
        <ul class="main-nav">  <!--  This is For Navigation Menu-->
            <li class="small-logo"><a href="#header"><img src="../img/small-logo.png" alt=""></a></li>
            <li><a href="HomePage.php" target="_parent">Home</a></li>
            <li><a href="InsertRecord.php" target="_parent">Insert Record</a></li>
            <!-- li><a href="DeleteRecord.php" target="_parent">Delete Record </a></li -->
            <li><a class="active" href="ViewRecord.php" target="_parent">View Record </a></li>
            <!-- li><a href="EditRecord.php" target="_parent">Edit Record</a></li -->
            <li><a href="PrintRecord.php" target="_parent">Print Record </a></li>
            <li><a href="Log_Out_Comfirmation.php" target="_parent">Log Out </a></li>
        </ul>
        <a class="res-nav_click" href="#"><i class="fa-bars"></i></a>
    </div>
</nav><!--main-nav-end-->    
    
<header class="header" id="header"><!--header-start-->
	<div class="container">
        <ul class="we-create animated fadeInUp delay-1s">
            <li>View Record <br> See your records now!</li>
        </ul>
    	<figure class="logo animated fadeInDown delay-07s">
        	<a href="#"><img src="../img/logo.png" alt=""></a>
        <ul class="we-create animated fadeInUp delay-1s">
            <li class="RiR_Word">RiR</li>
        </ul>
        </figure>
    </div>
</header><!--header-end-->

<section class="main-section" id="service"><!--main-section-start--> <!--  This is for Content  -->
    <div class="container">
        <h2>Transaction Records</h2>
        <?php echo renderAlerts(); ?>
        <div class="row">
            <table id="transactions_table" class="table table-striped table-hover" data-page-length="25">
                <thead>
                    <tr>
                        <!--th data-orderable="false"></th-->
                        <!--th>#</th-->
                        <th>Transaction Date</th>
                        <th>User</th>
                        <th>Item</th>
                        <th>Amount</th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>
                <tfoot>

                </tfoot>
                <tbody>
                <?php
                $i = 1;
                while ($obj=mysqli_fetch_object($rs)):
                ?>
                <tr>
                    <!--td><input name="transaction_id" type="checkbox" value="<?php echo $obj->id; ?>" /></td-->
                    <!--td><?php echo $i; ?></td-->
                    <td><?php echo $obj->transaction_date; ?></td>
                    <td><?php echo $obj->User_Fullname; ?></td>
                    <td><?php echo $obj->item; ?></td>
                    <td><?php echo $obj->amount; ?></td>
                    <td>
                        <a href="EditRecord.php?id=<?php echo $obj->id; ?>"><i class="fa fa-pencil" title="Edit transaction"></i></a>
                        <a id="delete" data-id="<?php echo $obj->id; ?>" href=""><i class="fa fa-trash text-danger" title="Delete transaction"></i></a>
                    </td>
                </tr>
                <?php $i++; endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<script type="text/javascript" src="../DataTables/datatables.min.js"></script>
<script src="../js/sweetalert2.min.js"></script>
<script>
$(function(){
    $('table#transactions_table').DataTable({
        order: [[0, 'desc']]
    });

    $('a#delete').on('click', function(e){
        e.preventDefault();
        var link = $(this).attr('href');
        var id = $(this).data('id');
        swal({
            title: 'Are you sure?',
            text: "To delete this transaction!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function () {
            $.post(link, {delete: id}, function(){
                swal('Deleted!',
                    'Transaction has been deleted.',
                    'success');
                window.location = link;
            });
        })
    });
});
</script>