<?= $layout ?>
<h1>Buat Postingan Baru</h1>
<?php
    $judul = [
        'name' => 'judul',
    ];
    $isi = [
        'name' => 'isi',
        'id' => 'isi',
    ];
    $id_pelajaran = [
        'name' => 'id_pelajaran',
        'options' => $arrayPel,
        'selected' => null,
    ];
    $submit = [
        'name' => 'submit',
        'value' => 'Submit',
        'type' => 'submit',
        'class' => 'btn btn-primary',
    ];

    ?>
    <div class="container">
        <?= form_open_multipart('thread/create') ?>
            <?= form_label("Judul", "judul") ?>
            <?=form_input('judul')?>
            
            <br/>

            <?= form_label('Pelajaran', 'id_pelajaran') ?>
            <?= form_dropdown($id_pelajaran) ?>

            <br/>

            <?= form_label('Isi', 'isi') ?>
            <?= form_textarea($isi); ?>

            <br/>

            <?= form_submit($submit) ?>

        <?= form_close() ?>

    </div>
    <script src="<?= base_url('assets/js/jquery.min.js')?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js')?>"></script>
    <script src="<?= base_url('assets/ckeditor5/ckeditor.js')?>"></script>
    <script src="<?= base_url('assets/ckfinder/ckfinder.js')?>"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#isi'), {
                ckfinder: {
                    uploadUrl: "<?= base_url('thread/uploadImages') ?>",
                },
            }).then(editor=>{
                console.log(editor);
            }).catch(error=>{
                console.log(error);
            });
    </script>
</body>
</html>