<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nacky
 * Date: 12-4-23
 * Time: 下午11:35
 * To change this template use File | Settings | File Templates.
 */
?>
<div id="user_edit" align="left">
    <form id="user_form" action="" method="post" name="user">
        <span class="tmg">
            <marquee behavior=alternate>
                <?=GeneralMessage::formalMessage(1)?>
            </marquee>
        </span>
        <span class="emg"><?=empty($errorLog) ? "当前时间：" . date("Y年m月d日 l H:i:s A") : $errorLog?> </span>
        <span>
            真实姓名：
            <input name="user[name]" value="<?=$user->name?>">
            <h5>*该项非必填，但建议用户填上~</h5>
            <input id="userId" type="hidden" name="id" value="<?=$user->id?>">
        </span>
        <span>
            用户帐号：
            <input name="user[alias]" value="<?=$user->alias?>">
            <h5>*必填，作为显示使用~</h5>
        </span>
        <span>
            数字帐号：
            <input name="user[userAccount]" value="<?=$user->userAccount?>" readonly="readonly">
            <h5>*不可更改，唯一标识，可作登录帐号~</h5>
        </span>
          <span>
            身份标识：
           <input name="user[identityNo]" value="<?=$user->identityNo?>">
              <h5>*非必填，例如身份证号，学号等~</h5>
        </span>
         <span>
            用户电话：
            <input name="user[mobilePhone]" value="<?=$user->mobilePhone?>">
             <h5>*非必填，但建议用户填上~</h5>
        </span>
         <span>
            电子邮件：
            <input name="user[email]" value="<?=$user->email?>" readonly="readonly">
             <h5>*不可更改~，可用作登录帐号~</h5>
        </span>
        <span>
            用户角色：
            <select name="user[sex]">
                <option value="a">管理员</option>
                <option value="u">普通用户</option>
            </select>
            用户性别：
             <select name="user[sex]">
                 <option value="m">男</option>
                 <option value="w">女</option>
             </select>
            </span>
            <span>
            出生年月：
                <?php
                $this->widget('ext.my97DatePicker.JMy97DatePicker', array(
                    'name' => 'user[birthday]',
                    'value' => $user->birthday,
                    'options' => array('dateFmt' => 'yyyy-MM-dd'),
                    'htmlOptions' => array(
                        'id' => 'birthday',
                    )
                ));
                ?>
        </span>
        <span>
            详细地址：
            <textarea name="user[address]" cols="40px" rows="3">
                <?=$user->address?>
            </textarea>
        </span>
        <span>
            地址邮编：
            <input name="user[zipCode]" value="<?=$user->zipCode?>">
            <h5></h5>
        </span>
        <span>
            <input class="formButton" type="submit" value="提交">
            <input class="formButton" type="button" value="取消" onclick="hideById('user_edit')">
    </form>
</div>
