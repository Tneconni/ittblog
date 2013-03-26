<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-4-23
 * Time: 下午11:35
 * To change this template use File | Settings | File Templates.
 */
?>

<div id="main-content" class="clear">
    <?php
    $this->widget('zii.widgets.grid.CGridView',
        array(
            'id' => 'user',
            'dataProvider' => $dataProvider,
            'columns' => array(
                'id',
                'name',
                'alias',
                'userAccount',
                array(
                    'class' => 'CDataColumn',
                    'header' => '性别',
                    'value' => '$data->sex=="m"?"男" :"女"',

                ),
                'email',
                'registerTime',
                'lastLoginTime',
                'lastIP',
                'status',
                'visitCount',
                array( // display a column with "delete" button only.
                    'class' => 'CButtonColumn',
                    'header' => '操作',
                    'buttons' => array(
                        'update' => array(
                            'label' => '编辑',
                            'url' => 'Yii::app()->createUrl("/user/userEdit",array("id"=>$data->id))',
                        ),
                        'delete' => array(
                            'label' => '删除',
                            'url' => 'Yii::app()->createUrl("/user/deleteUser",array("id"=>$data->id))',
                        ),
                    ),
                    'template' => '{update} {delete}',
                ),
            )));
    ?>
</div>
