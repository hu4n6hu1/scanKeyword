<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>冷爱微信公众号管理系统</title>
        <link rel="stylesheet" href="<?php echo (PUBLIC_PATH); ?>/Install/css/install.css" />
    </head>
    <body>
        <div class="wrap">
            <div class="header">
			<h1 class="logo">冷爱微信公众号管理系统</h1>
			<div class="icon_install">安装向导</div>
			<div class="version">QQ:371522155 </div>  </div>
            <section class="section">
                
       

      <div class="step">
        <ul>
          <li class="current"><em>1</em>检测环境</li>
          <li><em>2</em>创建数据</li>
          <li><em>3</em>完成安装</li>
        </ul>
      </div>
      <div class="server">
        <table width="100%">
          <tr>
            <td class="td1">环境检测</td>
            <td class="td1" width="25%">推荐配置</td>
            <td class="td1" width="25%">当前状态</td>
            <td class="td1" width="25%">最低要求</td>
          </tr>
          <tr>
            <td>PHP版本</td>
            <td>>5.3</td>
            <td>
			  <?php if($phpversion==true ): ?><span class="correct_span">&radic;</span>
			   <?php else: ?> 
			    <span class="correct_span error_span">&radic;</span>版本过低<?php endif; ?>
			</td>
            <td>必须大于等于5.3</td>
          </tr>
          <tr>
            <td>pdo连接</td>
            <td>开启</td>
            <td>
			   <?php if($pdo==true ): ?><span class="correct_span">&radic;</span>
			   <?php else: ?> 
			    <span class="correct_span error_span">&radic;</span>不支持pdo<?php endif; ?>
			</td>
            <td>开启</td>
          </tr>
          <tr>
            <td>附件上传</td>
            <td>>2M</td>
            <td>
			 <?php if($UploadInfo > 2 ): ?><span class="correct_span">&radic;</span>
			   <?php else: ?> 
			    <span class="correct_span error_span">&radic;</span>上传文件大小太低<?php endif; ?>
			</td>
            <td>不限制</td>
          </tr>

          <tr>
            <td>GD库</td>
            <td>开启</td>
            <td>
			  <?php if($isSupportGd==true): ?><span class="correct_span">&radic;</span>
			   <?php else: ?> 
			    <span class="correct_span error_span">&radic;</span>GD库未开启<?php endif; ?>
			</td>
            <td>开启</td>
          </tr>
		  
		  <tr>
            <td>CURL库</td>
            <td>开启</td>
            <td>
			  <?php if($isSupportCurl==true): ?><span class="correct_span">&radic;</span>
			   <?php else: ?> 
			    <span class="correct_span error_span">&radic;</span>curl模块未开启<?php endif; ?>
			</td>
            <td>开启</td>
          </tr>
		  
		  <tr>
            <td>文件系统函数</td>
            <td>开启</td>
            <td>
			  <?php if($isSupportFile_put_contents==true): ?><span class="correct_span">&radic;</span>
			   <?php else: ?> 
			    <span class="correct_span error_span">&radic;</span>file_put_contents未开启<?php endif; ?>
			</td>
            <td>开启</td>
          </tr>
        </table>
        <table width="100%">
          <tr>
            <td class="td1">目录权限检查</td>
            <td class="td1" width="25%">读权限（R=4）</td>
            <td class="td1" width="25%">写权限(W=2)</td>
          </tr>
		  <tr>
            <td class="td1"><?php echo ($baseDir); ?> (<?php echo ($permission); ?>)</td>
            <td class="td1" width="25%">
			  <?php if($isReadable==true): ?><span class="correct_span">&radic;</span>
			   <?php else: ?> 
			    <span class="correct_span error_span">&radic;</span>没有读权限<?php endif; ?>
			</td>
			
			<td class="td1" width="25%">
			  <?php if($isWritable==true): ?><span class="correct_span">&radic;</span>
			   <?php else: ?> 
			    <span class="correct_span error_span">&radic;</span>没有写权限<?php endif; ?>
			</td>

      </table>
    </div>
    <div class="bottom tac"> <a href="/index.php/Install/Index/step1" class="btn">重新检测</a><a href="/index.php/Install/Index/step2" class="btn">下一步</a> </div>
            </section>
			</div>
        </div>
        <div class="footer">  2016-2017 <a href="http://www.google.com" target="_blank">冷爱微信公众号管理系统</a>  </div>
    </body>
</html>