const menu = document.getElementById('headerNav');
const menuOpen = document.getElementById('menuOpen');
const menuClose = document.getElementById('menuClose');

menuOpen.addEventListener('click', function () {
	menu.classList.add('active');
});
menuClose.addEventListener('click', function () {
	menu.classList.remove('active');
});

let resizeTimeout;
window.onresize = () => {
	clearTimeout(resizeTimeout);
	resizeTimeout = setTimeout(() => {
		if (window.innerWidth > 780) {
			menu.classList.remove('active');
		}
	}, 500);
};
