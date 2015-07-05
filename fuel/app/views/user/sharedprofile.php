<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Individual Relationship Diagram</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<style>
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
	</style>
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
	<div class="container">
		<div class="jumbotron">
			<h1>Individual Relation Shares</h1>
			<p>
				<a href="/user/profile/<?php echo $introduced_user_id; ?>">自己紹介</a>
				　|　<a href="/user/sharedprofile/<?php echo $introduced_user_id; ?>">他己紹介</a>
				　|　<a href="/user/relationdiagram/<?php echo $introduced_user_id; ?>">相関図</a>
			</p>
		</div>
		<div>
			<div >
			<div class="profile"><a href="/user/profile/<?php echo $introduced_user['post_user_id']; ?>">
					<img src="<?php echo $introduced_user['url']; ?>"></img>
					</a>
					<?php echo $introduced_user['name']; ?> さんの紹介です</div>
			<ul class="list-group">
			<?php
				$distance = array(6=>'とても親しい', 5=>'親しい', 4=>'おつきあいがある', 3=>'何度かお話したことがある', 2=>'挨拶程度', 1=>'まだ挨拶した事が無い', 0=>'知らない');

			?>
								<?php foreach ($users as $user) :?>
					<?php if (empty($user['id'])) continue; ?>

				<li class="list-group-item">
					<dl class="dl-horizontal">
  						<dt>どんな人？</dt>
  						<dd><?php echo Security::htmlentities($user['feature']); ?></dd>
  						<dt>関係性は？</dt>
  						<dd><?php echo $distance[$user['distance']]; ?></dd>
 						<dt>自分が思う強みは？</dt>
  						<dd><?php echo Security::htmlentities($user['charm']); ?></dd>
 						<dt>どうして？</dt>
  						<dd><?php echo Security::htmlentities($user['charm_why']); ?></dd>
 						<dt>何が得意？</dt>
  						<dd><?php echo Security::htmlentities($user['skillfull']); ?></dd>
 						<dt>どうして？</dt>
  						<dd><?php echo Security::htmlentities($user['skillfull_why']); ?></dd>
 						<dt>期待していること</dt>
  						<dd><?php echo Security::htmlentities($user['expectation']); ?></dd>
					</dl>
					<div class="introducerprofile pull-right"><a href="/user/profile/<?php echo $user['user_id']; ?>">
					<img src="<?php echo $user['url']; ?>"></img>
					</a>
					<?php echo $user['name']; ?> さんより</div>
					
					<div class="clearfix"></div>


				</li>
					<?php endforeach; ?>
			</ul>
			</div>
			<div class="clearfix"></div>
		</div>
		<footer>
			<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			<p>
				<a href="https://github.com/sugoiyo72/individual-relationship-diagram">Individual Relationship Diagram</a> is released under the MIT license.<br>
				<small>Version: <?php echo IRD_VERSION; ?></small>
			</p>
		</footer>
	</div>
</body>
</html>
