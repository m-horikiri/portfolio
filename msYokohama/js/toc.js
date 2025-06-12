//ADD TOC TITLE
const tocHtml = '<div class="title">目次</div><div id="tocBtn">[<span class="btnText">OPEN</span>]</div>';
document.getElementsByClassName('ez-toc-title').item(0).innerHTML = tocHtml;

//TOC BTN
document.getElementById('tocBtn').addEventListener('click', function() {
	this.classList.toggle('active')
	if(this.classList.contains('active')){
		this.getElementsByClassName('btnText').item(0).textContent = 'CLOSE';
	}else{
		this.getElementsByClassName('btnText').item(0).textContent = 'OPEN';
	}
	const navChild = document.getElementById('ez-toc-container').getElementsByTagName('nav').item(0);
	navChild.classList.toggle('active');
	slide(navChild);
});

//SMOOTH SCROLL
const ezTocs = document.querySelectorAll('.ez-toc-section');
ezTocs.forEach((elm) => {
	let decoded = decodeURI(elm.getAttribute('id'));
	elm.setAttribute('id', decoded);
});
const ezTocsLink = document.querySelectorAll('a.ez-toc-link[href^="#"]');
ezTocsLink.forEach((elm) => {
	let decoded = decodeURI(elm.getAttribute('href'));
	elm.setAttribute('href', decoded);
	// elm.addEventListener('click', function(event){
	// 	event.preventDefault();
	// 	const targetId = this.getAttribute('href').substring(1);
	// 	const targetElement = document.getElementById(targetId);
	// 	if (targetElement) {
	// 		targetElement.scrollIntoView({
	// 			behavior: 'smooth',
	// 			block: 'start',
	// 		});
	// 	}
});
