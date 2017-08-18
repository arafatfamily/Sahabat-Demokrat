<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/dropzone.css" rel="stylesheet">
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/css+js/dropzone.js"></script>
<?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'galeri-form',
        'method' => 'POST',
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true
        ),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        )
)); 
echo $form->errorSummary($model); ?>
<?php echo CHtml::hiddenField('uploadId', 'value', array('id' => 'hiddenInput')); ?>
    <div class="box-body">
        <div class="col-sm-6">
        <?php echo $form->labelEx($model,'nama');
            echo $form->textField($model,'nama',array('class'=>'form-control', 'placeholder'=>'Tulis Nama Album ...'));
            echo $form->error($model,'nama'); 
        ?>
        </div>
        <div class="col-sm-6"> 
        <!--?php 
            echo $form->labelEx($model,'status') . '</br>';
            echo $form->radioButtonList($model, 'status', array("P" => 'TERBIT',"D" => 'DRAFT'), array(
                'labelOptions' => array('class' => 'icheck-label form-label'),
                'separator' => ' ',));
            echo $form->error($model,'status'); 
        ?-->
        </div>
        <div class="col-sm-12"><div class="clearfix"></div></br>
            <div id="myId" class="dropzone"></div> 
        </div>
    </div><div class="clearfix"></div></br>
    <div class="box-footer">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'TAMBAH' : 'SIMPAN',array('class'=>'btn btn-block btn-flat btn-success')); ?>
    </div>
<?php $this->endWidget();
$ismode = "add";
if (!$model->isNewRecord) {
    $ismode = "edit";
}
?>
<script type="text/javascript">
Dropzone.options.myAwesomeDropzone = false;
Dropzone.autoDiscover = false;

var myDropzone = new Dropzone("div#myId",
        {
            thumbnailWidth: null,
            thumbnailHeight: null,
            url: "<?php echo Yii::app()->createUrl('galeri/insert'); ?>",
            init: function () {
                this.on("addedfile", function (file) {

                    var thumbnails = $("*[data-dz-thumbnail]");
                    for (var i = 0; i < thumbnails.length; i++) {
                        $(thumbnails[i]).css('max-width', '220px');
                    }
                });
                var thisDropzone = this;

                if ("<?php echo $model->album_id ?>" != "") {
                    $.getJSON('<?php echo Yii::app()->createUrl('galeri/loadalbum?id=' . $model->album_id . ''); ?>', function (data) {
                        $.each(data, function (key, value) {
                            var mockFile = {name: value.name, size: value.size, type: 'image/jpeg'}; 
                            thisDropzone.emit("addedfile", mockFile);
                            thisDropzone.emit("thumbnail", mockFile, "<?php echo Yii::app()->controller->createUrl('galeri/loadImg')?>/id/" + value.id);

                            thisDropzone.emit("complete", mockFile);

                            if ($('#hiddenInput').val() == 'value') {
                                $('#hiddenInput').val(value.id);
                            } else {
                                var before = $('#hiddenInput').val();
                                $('#hiddenInput').val(before + ',' + value.id);
                            }
                            var data = $('#hiddenInput').val();
                            var y = data.split(',');

                            $(".dz-remove").each(function (i) {
                                $(this).attr("value", y[i++]);
                            });
                            $(".dz-remove").click(function () {
                                var id = $(this).val();
                                var data = $('#hiddenInput').val();
                                var remove = data.split(',');
                                remove = jQuery.grep(remove, function (x) {
                                    return x != id;
                                });
                                $('#hiddenInput').val(remove.toString());
                                var token = '<?php echo Yii::app()->request->csrfToken; ?>';
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo Yii::app()->createUrl('galeri/deleteupload'); ?>',
                                    data: {YII_CSRF_TOKEN: token, fileId: id, type: 'Avatar'},
                                    success: function () {
                                        $('.allert').show();
                                    },
                                    error: function () {
                                        $('.error').show();
                                    },
                                });
                            });
                        });
                    });


                }
            },
            addRemoveLinks: true,
        }
)

myDropzone.on("success", function (file, response) {
    if ($('#hiddenInput').val() == 'value') {
        $('#hiddenInput').val(response);
    } else {
        var before = $('#hiddenInput').val();
        $('#hiddenInput').val(before + ',' + response);
    }
    var data = $('#hiddenInput').val();
    var y = data.split(',');

    $(".dz-remove").each(function (i) {
        $(this).attr("value", y[i++]);
    });
    $(".dz-remove").click(function () {
        var id = $(this).val();
        var data = $('#hiddenInput').val();
        var remove = data.split(',');
        remove = jQuery.grep(remove, function (value) {
            return value != id;
        });
        $('#hiddenInput').val(remove.toString());
        var token = '<?php echo Yii::app()->request->csrfToken; ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('galeri/deleteupload'); ?>',
            data: {YII_CSRF_TOKEN: token, fileId: id, type: 'Avatar'},
            success: function () {
                $('.allert').show();
            },
            error: function () {
                $('.error').show();
            },
        });
    });
});
</script>