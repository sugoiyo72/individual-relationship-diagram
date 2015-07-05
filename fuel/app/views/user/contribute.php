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
			<p>紹介文を書きましょう！</p>
		</div>
		<div>
			<div >
			<ul class="list-group">
				<?php foreach ($users as $user) :?>
				<li class="list-group-item">
					<div class="profile"><a name="introduction_<?php echo $user['post_user_id']; ?>" href="/user/profile/<?php echo $user['post_user_id']; ?>">
					<img src="<?php echo $user['url']; ?>"></img>
					</a>
					<?php echo $user['name']; ?> さんを紹介しましょう</div>
					<?php //var_dump($users); ?>
					<?php
						$user_form = Fieldset::forge('user_form'.$user['post_user_id']);
						$user_form->add('id', '', array('type'=>'hidden', 'value'=>$user['id']));
						$user_form->add('user_id', '', array('type'=>'hidden', 'value'=>$me['id']));
						$user_form->add('introduced_user_id', '', array('type'=>'hidden', 'value'=>$user['post_user_id']));
						$user_form->add('distance', '親しさ',
							array('type'=>'radio',
								'options'=>array(6=>'とても親しい', 5=>'親しい', 4=>'おつきあいがある', 3=>'何度かお話したことがある', 2=>'挨拶程度', 1=>'まだ挨拶した事が無い', 0=>'知らない'),
								'value'=> !empty($user['distance']) ? $user['distance'] : 0 ));
						$user_form->add('feature', '一言で表すとどんな人？', array('type'=>'text', 'value'=>!empty($user['feature']) ? $user['feature'] : '', 'class'=>'feature text-box'));
						$user_form->add('charm', '素敵なところ・褒めたいところは？', array('type'=>'text', 'value'=>!empty($user['charm']) ? $user['charm'] : '', 'class'=>'charm text-box'));
						$user_form->add('charm_why', 'それはどうしてですか？（具体的に）',
							array('type' => 'textarea', 'cols' => 70, 'rows' => 6, 'value'=>!empty($user['charm_why']) ? $user['charm_why'] : '', 'class'=>'charm_why'));
						$user_form->add('humanity', '人柄(人間性・個性・ビジョン)', 
							array('type'=>'radio',
								'options'=>array(6=>'とても尊敬', 5=>'尊敬', 4=>'とても信頼', 3=>'信頼', 2=>'とても期待', 1=>'期待', 0=>'わからない'),
								'value'=> !empty($user['humanity']) ? $user['humanity'] : 0 ));
						$user_form->add('skillfull', '何が得意な人？', array('type'=>'text', 'value'=>!empty($user['skillfull']) ? $user['skillfull'] : '', 'class'=>'skillfull text-box'));
						$user_form->add('skillfull_why', 'それはどうしてですか？（具体的に）',
							array('type' => 'textarea', 'cols' => 70, 'rows' => 6, 'value'=>!empty($user['skillfull_why']) ? $user['skillfull_why'] : '', 'class'=>'feature'));
						$user_form->add('ability', '能力(知識・知見・専門性・実現力)', 
							array('type'=>'radio',
								'options'=>array(6=>'とても尊敬', 5=>'尊敬', 4=>'とても信頼', 3=>'信頼', 2=>'とても期待', 1=>'期待', 0=>'わからない'),
								'value'=> !empty($user['ability']) ? $user['ability'] : 0 ));
						$user_form->add('expectation', '期待している事',
							array('type' => 'textarea', 'cols' => 70, 'rows' => 6, 'value'=>!empty($user['expectation']) ? $user['expectation'] : '', 'class'=>'expectation'));
						$user_form->add('submit', '', array('type'=>'submit', 'value'=>'送信'));
						echo $user_form->build('user/introduction/'.$me['id']. '/'. $user['post_user_id']);
						unset($user_form);
						
					?>


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
