<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="cn">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		<title>冷爱百度关键字匹配工具</title>

		<meta name="description" content="冷爱 微信公众号" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="<?php echo (PUBLIC_PATH); ?>/Plugin/style/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo (PUBLIC_PATH); ?>/Plugin/style/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="<?php echo (PUBLIC_PATH); ?>/Plugin/style/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- ace styles -->

		<link rel="stylesheet" href="<?php echo (PUBLIC_PATH); ?>/Plugin/style/css/ace.min.css" />
		<link rel="stylesheet" href="<?php echo (PUBLIC_PATH); ?>/Plugin/style/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="<?php echo (PUBLIC_PATH); ?>/Plugin/style/css/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo (PUBLIC_PATH); ?>/Plugin/style/css/ace-ie.min.css" />
		<![endif]-->

		<!-- ace settings handler -->

		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/html5shiv.js"></script>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/respond.min.js"></script>
		<![endif]-->
		
		<!-- javascript footer -->
				<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
		<!-- <![endif]-->

		<!--[if IE]>
		<script type="text/javascript">
		 	window.jQuery || document.write("<script src='<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
		</script>
		<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/bootstrap.min.js"></script>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/excanvas.min.js"></script>
		<![endif]-->

		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/jquery.slimscroll.min.js"></script>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/jquery.easy-pie-chart.min.js"></script>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/jquery.sparkline.min.js"></script>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/flot/jquery.flot.min.js"></script>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/flot/jquery.flot.pie.min.js"></script>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/flot/jquery.flot.resize.min.js"></script>

		<!-- ace scripts -->

		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/ace-elements.min.js"></script>
		<script src="<?php echo (PUBLIC_PATH); ?>/Plugin/style/js/ace.min.js"></script>
	</head>
	<body>
<div class="navbar navbar-default" id="navbar">
	<div class="navbar-container" id="navbar-container">
		<div class="navbar-header pull-left">
			<a href="#" class="navbar-brand">
				<small>
					GIT
				</small>
			</a><!-- /.brand -->
		</div><!-- /.navbar-header -->

		<div class="navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<li class="light-blue">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<span class="user-info">
							Admin
						</span>

						<i class="icon-caret-down"></i>
					</a>

					<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						<li>
							<a href="<?php echo U('Admin/Index/signOut');?>">
								<i class="icon-off"></i>
								注销
							</a>
						</li>
					</ul>
				</li>
			</ul><!-- /.ace-nav -->
		</div><!-- /.navbar-header -->
	</div><!-- /.container -->
</div>
<div class="main-container" id="main-container">
	<div class="main-container-inner">
		<div class="sidebar" id="sidebar">

	<script type="text/javascript">
	
		try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
	
	</script>


	<ul class="nav nav-list">
		<li class="active">
		
			<a href="">
				<i class="icon-home"></i>
				<span class="menu-text"> 主页 </span>
			</a>
		</li>

		<li>
			<a href="javascript:void(0)">
				<i class="icon-list"></i>
				<span class="menu-text"> 匹配记录查询 </span>
			</a>
		</li>
		
				<li>
			<a href="javascript:void(0)">
				<i class="icon-list"></i>
				<span class="menu-text"> 关键字 </span>
			</a>
		</li>
				
				<li>
			<a href="javascript:void(0)">
				<i class="icon-list"></i>
				<span class="menu-text"> url </span>
			</a>
		</li>
		
						<li>
			<a href="javascript:void(0)">
				<i class="icon-list"></i>
				<span class="menu-text"> 查询 </span>
			</a>
		</li>





	</ul><!-- /.nav-list -->

	<script type="text/javascript">
	
		try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
	
	</script>
</div>
        <script type="text/javascript" language="javascript"> 
   		function iframeResize(iframe) {
	        iframe.height = $(window).height()-90;
	    }
		</script>
		<div class="main-content">
			<div class="breadcrumbs" id="breadcrumbs">
				<ul class="breadcrumb">
					<li><i class="icon-home home-icon"></i> <a href="javascript:void(0);">Home</a></li>
					<li class="active">主页</li>
				</ul>
			</div>
			<div id="content_main">
				<iframe src="" id="main_iframe" name="main_iframe"
					style="width: 100%;" frameborder="0" onload="iframeResize(this);"  scrolling="yes"></iframe>

			</div>
		</div>

	</div>
</div>
		<script type="text/javascript">
		/* 用户管理 */
		
		$('.nav.nav-list li').eq(1).click(function() {
			$('.nav.nav-list li').removeClass('active');
			$(this).addClass('active');
			$('#breadcrumbs ul li').eq(1).html('匹配记录查询');
			$('#main_iframe').attr("src","<?php echo U('Admin/Keyword/index');?>");
		});
		/* 微信管理 */
		$('.nav.nav-list li').eq(2).click(function() {
			$('.nav.nav-list li').removeClass('active');
			$(this).addClass('active');
			$('#breadcrumbs ul li').eq(1).html('关键字');
			$('#main_iframe').attr("src","<?php echo U('Admin/Keyword/showKeyword');?>");
		});
		
		 /* 订单管理 */
		$('.nav.nav-list li').eq(3).click(function() {
			$('.nav.nav-list li').removeClass('active');
			$(this).addClass('active');
			$('#breadcrumbs ul li').eq(1).html('url');
			$('#main_iframe').attr("src","<?php echo U('Admin/Keyword/showLink');?>");
		});
		/* 用户管理 */
		$('.nav.nav-list li').eq(4).click(function() {
			$('.nav.nav-list li').removeClass('active');
			$(this).addClass('active');
			$('#breadcrumbs ul li').eq(1).html('查询');
			$('#main_iframe').attr("src","<?php echo U('Admin/Keyword/showConsult');?>");
		});
		/* 微信管理 */
		$('.nav.nav-list li').eq(5).click(function() {
			$('.nav.nav-list li').removeClass('active');
			$(this).addClass('active');
			$('#breadcrumbs ul li').eq(1).html('微信管理');
			$('#main_iframe').attr("src","<?php echo U('Admin/Weixin/index');?>");
		});
		/* 扩展工具 */
		$('.nav.nav-list li').eq(6).click(function() {
			$('.nav.nav-list li').removeClass('active');
			$(this).addClass('active');
			$('#breadcrumbs ul li').eq(1).html('技术支持');
			$('#main_iframe').attr("src","<?php echo U('Admin/Util/index');?>");
		}); 
	
		</script>
		</body>
</html>