<?php
function getFileList($dir) {
	$files = glob(rtrim($dir, '/') . '/*');
	$list = array();
	foreach ($files as $file) {
		if (is_file($file)) {
			$list[] = $file;
		}
		if (is_dir($file)) {
			$list = array_merge($list, getFileList($file));
		}
	}

	return $list;
}

$title = "Debussy";
$list = <<<EOM
	{file:'data/Debussy-Girl-with-Flaxen-Hair.mp3',name:'Girl with Flaxen Hair'},
	{file:'data/Debussy-Menuet.mp3',name:'Menuet'},
EOM
?>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge"＞ 
		<meta name="application-name" content="<?=$title?>">
		<title><?=$title?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no,minimal-ui">

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<style>
body {
	padding: 0 10px;
}
#title {
	margin-bottom: 10px;
}
#music-wrap {
	box-shadow: 0 1px -2px #ddd;
	border-radius: 5px;
	margin-bottom: 20px;
}
#ticker-text {
	overflow: hidden;
}
#ticker-text p {
	color: #777;
	display: inline-block;
	white-space: nowrap;
	padding-left: 100%;
	-webkit-animation:ticker-animation linear infinite 10s;
	animation:ticker-animation linear infinite 10s;
}
@-webkit-keyframes ticker-animation {
  from   { -webkit-transform: translate(0%);
  }
  99%,to { -webkit-transform: translate(-100%);
	   }
 } 
@keyframes ticker-animation {
  from    { transform: translate(0%);
  }
  99%,to { transform: translate(-100%);
  }
}
		</style>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</head>

	<body>
		<h2 id="title" class="text-center"><?=$title?>
			<small>0.1</small>
		</h2>

		<script>
var musicList = [
<?=$list?>
]

document.write('<ul id="music-wrap" class="list-group">');
for (var i=0; i<musicList.length; i++) {
	document.write('<li class="music-list list-group-item">' + [i+1] + ' . ' + musicList[i].name + '</li>' )
}
document.write('</ul>');

$(function(){
	$(".music-list").click(function(){
		var index = $(".music-list").index(this);
		i = index;
		ffCount = i+1;
		play(index);
	});
});

function play(i)
{
	$("#ticker-text p").text('♪ Now on play - ' + musicList[i].name);
	$('#music-wrap .music-list').css("background-color","#fff");
	$('#music-wrap .music-list:nth-child(' + (i+1) + ')').css("background-color","#ddd");
	$("#aplay").attr("src", musicList[i].file);
	$("#aplay").get(0).play();
	$("#awaseme-play").attr("class","fa fa-pause");
	playCount=1
}

var i = 0;
var ffCount = 1;
var playCount = 0

function next()
{
	// 次の曲へ
	if (ffCount < musicList.length) {
		i++;
		ffCount++;
	} else {
		i = 0;
		ffCount = 1;
	}
	play(i);
}

$(function(){
	$("#play-button").click(function(){
		// 再生
		if (playCount > 0) {
			$("#ticker-text p").text('♪ Now on play - ' + musicList[i].name);
			$("#ticker-text p").css("color","#333");
			$('#music-wrap .music-list:nth-child(' + ffCount + ')').css("background-color","#ddd");

			$("#aplay").get(0).pause();
			$("#awaseme-play").attr("class","fa fa-play");
			playCount=0
		} else {
			play(i);
		}
	});
});
  
$(function(){
	$("#stop-button").click(function(){
		// 停止
		$("#ticker-text p").text('Please Play "<?=$title?>"');
		$("#ticker-text p").css("color","#777");
		$('#music-wrap .music-list:nth-child(' + ffCount + ')').css("background-color","#ddd");
		$("#aplay").get(0).pause();
//		$("#aplay").get(0).currentTime = 0;
		$('#music-wrap .music-list').css("background-color","#fff");
		$("#awaseme-play").attr("class","fa fa-play");
		playCount=0
		i = 0;
		ffCount = 1;
	});
});
  
$(function(){
	$("#ff-button").click(function(){
		next();
	});
});

$(function(){
	$("#bw-button").click(function(){
		// 前の曲へ
		if(ffCount > 1){
			i--;
			ffCount--;
		} else {
			i = musicList.length-1;
			ffCount = musicList.length;
		}
		play(i);
	});
});
	</script>

		<div id="ticker-text">
			<p>Please Play "<?=$title?>"</p>
		</div>
		<div class="btn-group btn-group-justified">
		<div class="btn-group">
		<button id="bw-button" class="btn btn-default" />
			<i id="awaseme-bw" class="fa fa-backward"></i>
		</button>
		</div>
		<div class="btn-group">
		<button id="stop-button" class="btn btn-default" />
			<i id="awaseme-stop" class="fa fa-stop"></i>
		</button>
		</div>
		<div class="btn-group">
		<button id="play-button" class="btn btn-default" />
			<i id="awaseme-play" class="fa fa-play"></i>
		</button>
		</div>
		<div class="btn-group">
		<button id="ff-button" class="btn btn-default" />
			<i id="awaseme-ff" class="fa fa-forward"></i>
		</button>
		</div>
		</div>
		</div>
		<audio id="aplay" preload="auto" onended="next()"></audio>
	</body>
</html>
