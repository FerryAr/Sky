<?php
$keyword = [
    'name' => 'keyword',
    'value' => $keyword,
    'placeholder' => 'Keyword...'
];
$submit = [
    'name' => 'submit',
    'value' => 'Cari',
    'type' => 'submit',
];
?>
<?= $layout ?>
<h1>Threads</h1>
<a href="<?= base_url('index.php/thread/create')?>" class="btn btn-primary">Buat Thread Baru</a>

<?= form_open('thread/index', ['class'=>'form_inline'])?>
<div>
    <?= form_input($keyword); ?>
</div>
<div class="ml-3">
    <?= form_submit($submit) ?>
</div>
<?=form_close()?>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Pelajaran</th>
            <th>Posted by</th>
            <?php 
            if($this->ion_auth->is_admin()) {
                echo "<th>Action</th";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($threads as $key=>$thread):?>
            <tr>
                <td><?=$offset+$key+1?></td>
                <td><a href="<?=base_url('index.php/thread/view/'.$thread->id) ?>">
                    <?= $thread->judul ?>
                </a>
                </td>
                <td><?= $thread->pelajaran ?></td>
                <td><?= $thread->first_name ?></td>
                <?php if ($this->ion_auth->is_admin()): ?>
                    <td>
                        <a href="<?= base_url('index.php/thread/update/'.$thread->id)?>">Update</a>
                        <a href="<?= base_url('index.php/thread/delete/'.$thread->id)?>">Delete</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
</body>
</html>