<?php
use yii\helpers\Url;
$this->title = "新增功能";
?>
<div class="dis-bread">
    <a href="<?php echo Url::home(); ?>">首页</a>>
    <a href="<?php echo Url::toRoute('default/index'); ?>">系统管理</a>>
    <a href="<?php echo Url::toRoute('func/index'); ?>" class="bolde">功能项管理</a>
</div>
<div class="dis-main dis-mainnr">
    <div class="d-titr">
        <a href="<?php echo Url::toRoute('func/index'); ?>">返回</a>
        <h3>功能项管理 -- 新增权限</h3>
    </div>
    <div class="row" style="margin:10px;">
        <div class="col-md-8">
            <!-- BEGIN FORM-->
            <form id="addFuncForm" name="addModulesForm" action="<?php echo Url::toRoute('func/save'); ?>" method="post" class="form-horizontal"
                  class="form-horizontal form-bordered form-label-stripped">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">功能名称</label>

                        <div class="col-md-9">
                            <input type="text" id="func[caption]" name="func[caption]" size="30" placeholder="请输入功能名称"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">父级功能</label>

                        <div class="col-md-5">
                            <select name="func[parent_id]" id="func[parent_id]" class="form-control">
                                <option value="-1">选择父级功能</option>
                                <option value="0"> ◥ 新建模块</option>
                                <optgroup label="功能列表">
                                    <?php foreach ( $funcList as $func ) { ?>
                                        <option value="<?php echo $func['id'] ?>">
                                            ⊕ <?php echo $func['caption'] ?></option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                            <span id="root_zone"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">模块ID</label>

                        <div class="col-md-9">
                            <input id="func[moduleid]" name="func[moduleid]" size="50" type="text" placeholder="请输入模块id"
                                   class="form-control"/>
                                                    <span>
                                                    注:后台功能模块的Module名称(小写),如：system </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">控制器ID</label>

                        <div class="col-md-9">
                            <input id="func[controllerid]" name="func[controllerid]" size="50" type="text" placeholder="请输入功能链接"
                                   class="form-control"/>
                                                    <span>
                                                     注:后台功能模块的Controll名称(小写),如：default </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">功能链接</label>

                        <div class="col-md-9">
                            <input id="func[url]" name="func[url]" size="50" type="text" placeholder="请输入功能链接"
                                   class="form-control"/>
                                                    <span>
                                                    注:后台功能模块的相对链接(以/开头),如:/system/default/index </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">显示类型</label>

                        <div class="col-md-5">
                            <select name="func[show_style]" id="func[show_style]" class="form-control">
                                <option value="menu">DIV</option>
                                <option value="button">IFrame</option>
                            </select>
                                                    <span class="help-block">
                                                    </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">功能排序</label>

                        <div class="col-md-9">
                            <input type="text" id="func[order_by]" name="func[order_by]" value="0" class="form-control">
                            <span>注:正序排列 </span>
                        </div>
                    </div>

                    <div class="form-group last">
                        <label class="control-label col-md-3">功能说明</label>

                        <div class="col-md-9">
                            <textarea rows="5" name="func[remark]" id="func[remark]" class="form-control span7"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">功能属性</label>

                    <div class="col-md-9">
                        <label class="checkbox inline">
                            <input type="radio" value="1" name="func[status]" checked> 显示
                        </label>
                        <label class="checkbox inline">
                            <input type="radio" value="0" name="func[status]"> 隐藏
                        </label>
                    </div>
                </div>
                <div class="form-actions">
                    <div>
                        <div class="col-md-offset-3 col-md-9">
                            <input type="hidden" id="func[id]" name="func[id]" value=""/>
                            <button type="submit" class="btn green"><i class="fa fa-check"></i> 保存</button>
                            <a href="<?php echo Url::toRoute('func/index'); ?>" class="btn default">取消</a>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
</div>