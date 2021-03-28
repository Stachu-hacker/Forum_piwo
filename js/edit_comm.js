const edit_btn = document.querySelectorAll(".edit_button_comm");
const form = document.querySelectorAll("#form_edit_comm");
const post = document.querySelector("#posts");
function hide() {
	form.forEach(element => {
		element.style.display = "none";
	});
}
edit_btn.forEach((element, index) => {
	element.addEventListener("click", function (event) {
		hide();
		form[index].style.display = "block";
	});
});
post.addEventListener("click", function (event) {
	if (event.currentTarget === event.target) {
		hide();
	}
});
