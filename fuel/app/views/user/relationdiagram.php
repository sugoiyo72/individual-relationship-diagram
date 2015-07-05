<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Individual Relationship Diagram</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

	<style type="text/css">
		body {
		 	padding-top: 50px; 
		 }
		 .graph-svg-component {
	    	background-color: beige;
	    	border: dimgray 1px solid;
	    	overflow: auto;
	    	width: 240px;
    		height: 240px;
		}
		.profile img, .profile a img {
			width: 100px;
			height: 100px;
			border: 0;
			border-radius: 50%;
		}
		.myProfile img {
			width: 50px;
			height: 50px;
			border: 0;
			border-radius: 50%;
		}
			.myProfile a {
			border: 0;
		}
		.introducerprofile a img {
			width: 50px;
			height: 50px;
			border: 0;
			border-radius: 50%;
		}
		input.text-box {
			width: 100%;
		}

	    /* WANT TO DO arrow http://bl.ocks.org/d3noob/5141278 */

		</style>
		<!-- CSS -->
			
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
	<script type="text/javascript">
		var target_user_id = <?php echo $introduced_user_id; ?>;
	</script>
		
</head>
<body>
	<header>
		<div class="container">
		<div id="logo"></div>
			<?php if (!empty($me)) : ?>
				<ul class="list-group">
					<li class="list-group-item pull-right"><a class="btn btn-warning" href="/user/logout">ログアウト</a></li>
					<li class="list-group-item pull-right"><a class="btn btn-warning" href="/user/contribute">友人知人を紹介する</a></li>
					<li class="list-group-item pull-right"><a class="myProfile" href="/user/profile/<?php echo $me['id']; ?>"><img src="<?php echo $me['url']; ?>"></img></a></li>
					<li class="list-group-item pull-right"><a class="btn btn-warning" href="/">TOP</a></li>
				</ul>
			<?php endif; ?>
		</div>
	</header>

    <!-- container for svg root element -->
	<div class="container">
		<div id="controlPanel" class="row">
			<div class="row">
				<div class="col-md-8">
					<div class="input-group">
					    <select id="relationshipData" class="form-control">
						    <option selected value="default">友人知人からの紹介</option>
						</select>
						<span class="input-group-btn">
				    		<button style="margin-left: 5px; margin-right:210px" class="btn btn-default" onclick="loadMoleculeExample()" type="button">Load Molecule</button>
				    	</span>
				    </div><!-- /input-group -->
				</div>
			</div>
		</div>
		<div id="irdDisplay" style="border: 1px solid black; background-color: #FFF" class="row"></div>
		<footer>
		    <p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
		    <p>
			    <a href="https://github.com/sugoiyo72/individual-relationship-diagram">Individual Relationship Diagram</a> is released under the MIT license.<br>
			    <small>Version: <?php echo IRD_VERSION; ?></small>
		    </p>
		</footer>
	</div>


	<!-- Javascript -->
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
	<script type="text/javascript" src="/assets/js/main.js"></script>
</body>
</html>
