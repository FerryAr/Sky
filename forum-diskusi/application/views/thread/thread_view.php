<?= $layout ?>
<?php
    $hidden = [
        'id_thread' => $thread->id,
        'id_user' => $user[0]->id,
    ];
?>

<h1><?= $thread->judul ?></h1>
<div class="container">
    <?= $thread->isi ?>
    <small>
        <br/>
        Created by <a href="<?= base_url('user/view/'.$user[0]->id)?>"><?= $user[0]->first_name?></a> on <?= $pelajaran->pelajaran ?> at <?= $thread->created_at ?>
    </small>
    <div style="margin-left:auto">
        <h1><a href="<?= base_url('reply/create/'.$thread->id)?>" style="color:#16a085">Buat Reply</a></h1>
    </div>
</div>
<hr/>
    <h1 class="text-center">REPLY</h1>
    <hr>
    <?php foreach($reply as $r): ?>
        <div class="container" style="margin-top:30px;">
            <div class="flex-container">
                <div style="text-align:center">
                    <img src="<?= base_url("uploads/".$r->avatar) ?>" style="width:50px" /><br>
                    <small><strong><?= $r->first_name ?></strong></small><br>                
                    <small><?= $r->created_at ?></small>
                </div>
                <div style="margin-left:30px">
                    <?= $r->isi ?>
                </div>
            </div>
            <div style="float:right">
                <a href="<?= base_url('reply/edit/'.$r->id) ?>" style="color:#3498db" >Edit</a>
                <a href="<?= base_url('reply/delete/'.$r->id.'/'.$thread->id) ?>" style="color:#c0392b">Delete</a>
            </div>
        </div>
    <?php endforeach ?>

<script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>
