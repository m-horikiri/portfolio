//NAVIGATION
function slide(elm) {
	const slideElm = elm;
	if(slideElm.classList.contains('active')){
		slideElm.style.height = slideElm.scrollHeight + 'px';
	}else{
		slideElm.style.height = 0;
	}
}
const navPc = document.querySelectorAll('.header_pc .nav_parent');
navPc.forEach((elm) => {
	elm.addEventListener('mouseover', function(){
		const navChild = this.getElementsByClassName('nav_child').item(0);
		navChild.classList.add('active');
		slide(navChild);
	});
	elm.addEventListener('mouseleave', function(){
		const navChild = this.getElementsByClassName('nav_child').item(0);
		navChild.classList.remove('active');
		slide(navChild);
	});
});
const navSp = document.querySelectorAll('#header_sp .nav_parent');
navSp.forEach((elm) => {
	elm.addEventListener('click', function(){
		if(this.classList.contains('tenkai')){
			this.classList.remove('tenkai');
		}else{
			this.classList.add('tenkai');
		}
		const navChild = this.getElementsByClassName('nav_child').item(0);
		navChild.classList.toggle('active');
		slide(navChild);
	});
});
document.querySelector('#header_sp .spnav_close_btn')?.addEventListener('click', () => {
	document.querySelector('#header_sp .check').checked = false;
});

//CSS
setTimeout(function(){
	document.getElementById('fontAwesomeCss').setAttribute('href', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css');
	document.getElementById('googleFont').setAttribute('href', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap');
}, 1);

//SMOOTH SCROLL
const hashLink = document.querySelectorAll('a[href^="#"]');
hashLink.forEach((elm) => {
	elm.addEventListener('click', function(event){
		event.preventDefault();
		const targetId = this.getAttribute('href').substring(1);
		const targetElement = document.getElementById(targetId);
		if (targetElement) {
			targetElement.scrollIntoView({
				behavior: 'smooth',
				block: 'start',
			});
		}
	});
});
