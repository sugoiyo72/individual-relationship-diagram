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
			<h1>Individual Relationship Diagram</h1>
			<p>
				<a href="/user/profile/<?php echo $introduced_user_id; ?>">自己紹介</a>
				　|　<a href="/user/sharedprofile/<?php echo $introduced_user_id; ?>">他己紹介</a>
				　|　<a href="/user/relationdiagram/<?php echo $introduced_user_id; ?>">相関図</a>
			</p>
		</div>
		<div>
			<div >
			<ul class="list-group">

				<li class="list-group-item">
					<div class="profile"><a name="introduction_<?php echo $introduced_user['post_user_id']; ?>" href="/user/profile/<?php echo $introduced_user['post_user_id']; ?>">
					<img src="<?php echo $introduced_user['url']; ?>"></img>
					</a>
					<?php echo $me['name']; ?> さんの自己紹介です</div>
					<?php //var_dump($users); ?>
					<dl class="dl-horizontal">
  						<dt>どんな人？</dt>
  						<dd><?php echo Security::htmlentities($introduced_user['feature']); ?></dd>
 						<dt>自分が思う強みは？</dt>
  						<dd><?php echo Security::htmlentities($introduced_user['charm']); ?></dd>
 						<dt>どうして？</dt>
  						<dd><?php echo Security::htmlentities($introduced_user['charm_why']); ?></dd>
 						<dt>何が得意？</dt>
  						<dd><?php echo Security::htmlentities($introduced_user['skillfull']); ?></dd>
 						<dt>どうして？</dt>
  						<dd><?php echo Security::htmlentities($introduced_user['skillfull_why']); ?></dd>
					</dl>
					<?php
				?>


				</li>
				<?php //endforeach:?>
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
