<?php
$Mowajjeh = new Classes\Mowajjeh();

$Mowajjeh->get("/",null,function(){
	$v = new Classes\Viewer('index');
	$v->links = (new Classes\Json('links'))->load()->links;
	$v->personal = (new Classes\Json('personal'))->load();
	$v->social_media = (new Classes\Json('socialmedia'))->load()->social_media;
	$v->load()->view();
});

$Mowajjeh->get('/works',null,function(){
	$v = new Classes\Viewer('works');
	$v->title = 'Works';
	$v->description = 'my works..';
	$v->personal = (new Classes\Json('personal'))->load();
	$v->works = (new Classes\Json('works'))->load(true);
	$v->load()->view();
});
/* Set not Found */
$Mowajjeh->setNotFound(function(){
	echo "not found.";
});

$Mowajjeh->run(function(){

});
