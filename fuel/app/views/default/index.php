<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Individual Relationship Diagram</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<style>
	.profile img {
		width: 100px;
		height: 100px;
		border-radius: 50%;
	}
	.myProfile img {
		width: 50px;
		height: 50px;
		border-radius: 50%;
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
			</ul>
			<?php endif; ?>

		</div>
	</header>
	<div class="container">
		<div class="jumbotron">
			<h1>Individual Relationship Diagram</h1>
			<?php if (empty($me)) : ?>
			<p>ログインをどうぞ</p>
			<?php endif; ?>
			<div >
			<ul class="list-group">
				<?php foreach ($users as $user) :?>
				<li class="list-group-item pull-left">
					<a class="profile" href="./user/profile/<?php echo $user['id']; ?>"><img src="<?php echo $user['url']; ?>"></img></a>
					<?php if (empty($me)) : ?>

					<br />
					<a class="btn btn-primary" href="./user/set/<?php echo $user['id']; ?>">ログイン</a>
					<?php endif; ?>

				</li>
				<?php endforeach; ?>
			</ul>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<h2>Get Started</h2>
				<p>ユーザーを選択して、他のユーザーの紹介文を書きます。</p>
			</div>
			<div class="col-md-4">
				<h2>Learn</h2>
				<p>相手のマイナスブランディングとならないと同時に、持ち上げすぎないようにしましょう</p>
				<p>どこに「価値を感じて」紹介するのか、「どうして」紹介するのか、「具体的な事例とともに」記載するとGreate Presenter となるでしょう。</p>
			</div>
			<div class="col-md-4">
				<h2>Contribute</h2>
				<p>ご意見ご感想は<a href="http://weblog.sugoiyo.com/tag/individual-relationship-diagram/">weblog.sugoiyo.comへ</a></p>
			</div>
		</div>
		<hr/>
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
