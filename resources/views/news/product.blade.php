<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>新闻详情页-{{$news->title}}</h1>
    <span>作者:{{$man}}</span>&nbsp&nbsp   <span>发布时间:{{date('Y-m-d H:i:s',$news->news_time)}}</span>&nbsp&nbsp <span>访问量:{{$count}}</span>
    <p>主体内容:{{$news->content}}</p>
</body>
</html>
