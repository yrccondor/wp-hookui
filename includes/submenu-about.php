<div class="wrap">
    <h1><?php _e('关于', 'hui');?></h1>
    <p class="hui-admin-img">
        <img src="<?php echo plugins_url('img/admin-about.jpg',__FILE__);?>">
    </p>
    <h2 style="font-size:19px;"><?php e_('感谢使用 WPHookUI', 'hui');?></h2>
    <p style="font-size:15px;"><?php e_('我是 AxtonYao，这个插件由我开发。我的网站是', 'hui');?><a href="https://axton.cc" target="_blank">axton.cc</a></p>
    <p style="font-size:15px;"><?php e_('对插件有任何疑问，建议先查阅 ', 'hui');?><a href="https://huidoc.flyhigher.top/" target="_blank"><?php e_('文档', 'hui');?></a></p>
    <p style="font-size:15px;"><?php e_('这个项目的Github地址是 ', 'hui');?><a href="https://github.com/yrccondor/wp-hookui" target="_blank">github.com/yrccondor/wp-hookui</a><br><?php e_('欢迎提出 issue 或 PR 。', 'hui');?></p>
    <br>
    <p style="font-size:12px;">WPHookUI <?php $hui_version = get_option('hui_version') echo $hui_version['version'].'.'.$hui_version['commit'];?></p>
    <br>
    <p style="font-size:17px;"><strong><?php e_('这个插件献给 Somebody', 'hui');?></strong></p>
</div>