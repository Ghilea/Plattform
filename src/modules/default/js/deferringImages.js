//Deferring Images
let imgDefer = document.querySelectorAll('img');

imgDefer.forEach(element => {
	if (element.getAttribute('data-src')) {
		element.setAttribute('src', element.getAttribute('data-src'));
	}
});
 
