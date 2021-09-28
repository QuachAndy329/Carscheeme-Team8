<?php
    // No login will be redirected to the home page
    if(!isset($_SESSION['USER'])) {
        header('Location: '.'index.php?page=login');
    }
    $arrRedRecord = [];
    $fh = fopen(url_data_manage,'r');
    $arrRedRecord = json_decode(fgets($fh));
    fclose($fh);
    $location = unserialize(localtion);
    if(isset($_GET['action']) && $_GET['action'] == 'delete') {
        $id = $_GET['id'];
        $arrRedRecord = array_filter($arrRedRecord, function($item) use ($id) {
            if($item->id != $id){
                return true;
            }
        });
        $fp = fopen(url_data_manage, 'w');
        fwrite($fp, json_encode($arrRedRecord));
        fclose($fp);
        header('Location: '.'index.php?page=manage');
    }
?>
<div class="container home">
    <h1 class="title">Manage</h1>
    <div class="row marginTopForm">
        <div class="col-md-12">
            <a href="index.php?page=manage-page&action=add" class="btn btn-success">Add</a>
        </div>
    </div>
    <div class="row marginTopForm">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Photo</th>
                        <th scope="col">Description</th>
                        <th scope="col">Location</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($arrRedRecord) && count($arrRedRecord) > 0){ ?>
                        <?php foreach($arrRedRecord as $key =>  $value){ ?>
                            <tr>
                                <td style="text-align: center;"><img width="80" height="80" src="<?php echo 'file/'.$value->file_name ?>" /></td>
                                <td><?php echo $value->description ?></td>
                                <td><?php echo $location[$value->location_id] ?></td>
                                <td><a href="index.php?page=manage-page&id=<?php echo $value->id ?>&action=edit">Update</a> | <a href="index.php?page=manage&id=<?php echo $value->id ?>&action=delete">Delete</a></td>
                            </tr>
                        <?php }?>
                    <?php }else{?>
                        <tr><td colspan="5" style="text-align:center">No record</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>