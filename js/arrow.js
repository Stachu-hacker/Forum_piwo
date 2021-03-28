//arrow taking you to the top of the page//

function arrow() {
	window.scroll({
		top: 0,
		left: 0,
		behavior: "smooth"
	});
}
const strzalka = document.querySelector(".ScrollTopButton");
document.addEventListener("scroll", () => {
	const y = window.scrollY;
	y > 80 ? strzalka.classList.add("show") : strzalka.classList.remove("show");
});
