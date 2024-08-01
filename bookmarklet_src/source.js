//TODO
//BUILD EASILY HERE https://mrcoles.com/bookmarklet/
// build catching



console.log('1');
if (document.getElementsByTagName('meta') !== null){
	var metas =document.getElementsByTagName('meta');
}else{
	var metas ='';
}
	

console.log('2');
if (document.querySelector("meta[property='og:image']") !== null){
    var image= document.querySelector("meta[property='og:image']").getAttribute("content");
}else {
    var image="";
}


console.log('3');
if (document.querySelector("meta[name=description]") !== null){
	var description =document.querySelector("meta[name=description]").getAttribute("content") || '';
}else {
    var description ='';
}


console.log('4');
var keywords='';
for (var x=0,y=metas.length; x<y; x++) {
    if (metas[x].name.toLowerCase() == 'keywords'){
        keywords += metas[x].content;
    }
}

console.log('5');
passlink =         'http://554.ben-connors.com/superbook/add.php?'+
    's='+encodeURIComponent(keywords)+
    '&url='+encodeURIComponent(location.href)+
    '&title='+encodeURIComponent(document.title)+
    '&image='+encodeURIComponent(image)+
    '&desc='+encodeURIComponent(description);

console.log(passlink);

window.location.replace(
passlink
);
