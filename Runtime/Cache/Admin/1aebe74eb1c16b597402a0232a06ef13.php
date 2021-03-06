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
<div class="col-sm-12 widget-container-span">
	<div class="widget-box transparent">
		<div class="widget-body">
			<div class="widget-main padding-12 no-padding-left no-padding-right">
				<div class="tab-content padding-4">
					<div id="home1" class="tab-pane in active">
						<div class="row">
							<div class="col-xs-12 no-padding-right">
								<div class="table-responsive">
									<table id="sample-table-1"
										class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												
												
												
												<th>查询日期</th>
												<th>关键字</th>
												<th>对应的链接</th>
												<th>排行榜</th>
											</tr>
										</thead>

										<tbody>
										<?php if(is_array($recordList)): $i = 0; $__LIST__ = $recordList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$result): $mod = ($i % 2 );++$i;?><tr>
												
												
												<td><?php echo (date("Y-m-d H:i:s",$result["date"])); ?></td>
												<td><a target='_blank' href="http://www.baidu.com/s?wd=<?php echo ($result["keyword"]); ?>"><?php echo ($result["keyword"]); ?></a></td>
												<td><?php echo ($result["link"]); ?></td>
												<td><?php echo ($result["rank"]); ?></td>
												
											</tr><?php endforeach; endif; else: echo "" ;endif; ?>
										</tbody>
									</table>
									<div class="form-actions">							
										页数:<?php echo ($currentPage); ?>/<?php echo ($countPage); ?>	
										<a href="/index.php/Admin/Keyword/index/page/<?php echo ($previousPage); ?>">上一页</a>
										<a href="/index.php/Admin/Keyword/index/page/<?php echo ($nextPage); ?>">下一页</a>
								</div>

							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		

	</div>
</div>