let html = "";

function captcha(status) {
	const scripts = document.getElementsByTagName("script");
	if (status) {
		const recaptcha_api = document.createElement("script");
		recaptcha_api.type = "text/javascript";
		recaptcha_api.src = "https://www.google.com/recaptcha/api.js";
		scripts[0].parentNode.insertBefore(recaptcha_api, scripts[0]);
	} else {
		scripts[1].remove();
		scripts[0].remove();
	}
}

function error_rej() {
	const form = document.querySelector(".formularz");
	const errors_rej = document.getElementById("errors_rej");
	const password = document.getElementById("password").value;
	const password_check = document.getElementById("password_check").value;
	const login = document.getElementById("loogin").value;

	let error = false;

	const wszystko = document.querySelectorAll(".check");
	wszystko.forEach(input => {
		if (!error) {
			if (input.value.length == 0) {
				error = true;
			}
		}
	});
	const response = grecaptcha.getResponse();
	if (error) {
		errors_rej.style.display = "block";
		errors_rej.innerHTML = "Nie podano wszystkich danych!";
	} else if (login.length < 3 || login.length > 20) {
		errors_rej.style.display = "block";
		errors_rej.innerHTML = "Login nie spełnia warunków długości (od 3 do 20 znaków)!";
	} else if (login.match(/[^a-z0-9]/gi)) {
		errors_rej.style.display = "block";
		errors_rej.innerHTML = "Login nie może zawierać znaków specjalnych!";
	} else if (password.length < 5 || password.length > 20) {
		errors_rej.style.display = "block";
		errors_rej.innerHTML = "Hasło nie spełnia warunków długości (od 5 do 20 znaków)!";
	} else if (password != password_check) {
		errors_rej.style.display = "block";
		errors_rej.innerHTML = "Hasła nie są takie same!";
	} else if (!response) {
		errors_rej.style.display = "block";
		errors_rej.innerHTML = "Musimy sie upewnić, że jesteś człowiekiem!";
	} else {
		form.submit();
	}
}

function powrot_function() {
	html = /*html*/ ` 
	

	<input name= "login" type="text" placeholder="Login"/>
    <input name= "password" type="password" placeholder="Hasło"/>
    <br>
    <button id="log_in" class="button" type="submit">Zaloguj się</button>
	<div id='frgt_options'>
    <span>Zapomniałeś hasła?</span> 
    <span>Nie masz konta?</span>
    </div>
   <div id='buttons'>
    <br>
    <br>
    <button id="restart" class="button" onclick="	event.preventDefault(); password_restart_function()">Odzyskaj hasło</button>  
    <button id="register" class="button" onclick="	event.preventDefault(); register_function()">Dołącz do piwoszy!</button>    
	
	</div>
    
    `;
	swap(html);
}

function register_function() {
	html = /*html*/ `
	<div id="sort">
	<div>
		<input class="check" name="login" id="loogin" type="text" placeholder="Login" />
		<input class="check" id="password" name="password" type="password" placeholder="Hasło" />
		<input class="check" id="password_check" name="password_check" type="password" placeholder="Powtórz hasło" />
	</div>

	<div>
		<input class="check" name="first_name" type="text" placeholder="Imie" />
		<input class="check" name="last_name" type="text" placeholder="Nazwisko" />
		<input class="check" name="email" type="text" placeholder="E-mail" />
	</div>
	</div>
	<input class="check" name="photo" type="text" placeholder="Url zdjęcia" />
	<input class="check" name="piwo" type="text" placeholder="Ulubione piwo (pytanie kontrolne)" />
	<div>
	<div id="cap">
		<div id="captcha" class="g-recaptcha" data-sitekey="6Lfd1XQaAAAAANrDlRONdW-C8iAHdGfox43_s9mN"></div>
		
	</div>
	<button id="powrot" class="button" onclick="event.preventDefault(); powrot_function()">Powrót</button>

	<button id="zarejestruj" class="button" type="submit" onclick="event.preventDefault(); error_rej()">
		Zostań piwoszem
	</button>
	
</div>

<div id="errors_rej"></div>

        `;

	swap(html, "rejestr");
}
function password_restart_function() {
	html = /*html*/ `
       <input class='check' name="login" id='loogin' type="text" placeholder="Login"/>
	   <input class='check' name="email" type="text" placeholder="E-mail"/>
       <input class='check' name="piwo" type="text" placeholder="Ulubione piwo"/>
     <div> 
        <button id="restart" class="button" type="submit">Resetuj hasło</button> 
		<button id="powrot" class="button" onclick="event.preventDefault(); powrot_function()">Powrót</button> 
	</div>
		<div id='errors_rej'></div>
        `;

	swap(html, "restart");
}

const swap = (html, cel) => {
	const form = document.querySelector(".form");
	const log = document.querySelector(".formularz");
	form.style.transform = log.classList.contains("log")
		? cel === "rejestr"
			? "rotate(1440deg)"
			: "rotate(-1440deg)"
		: log.classList.contains("rejestr")
		? "rotate(0deg)"
		: "rotate(0deg)";
	setTimeout(() => {
		log.innerHTML = html;

		if (log.classList.contains("log")) {
			log.classList.remove("log");
			if (cel === "rejestr") {
				log.classList.add("rejestr");
				log.action = "/php/register.php";
				captcha(true);
			} else {
				log.classList.add("restart");
				log.action = "/php/restart_password.php";
			}
		} else {
			log.classList.remove("rejestr");
			log.classList.add("log");
			log.action = "/php/log_in.php";
			captcha(false);
		}
	}, 500);
	const nowe = document.getElementById("new");
	if (nowe) {
		nowe.remove();
	}
	const error = document.getElementById("error");
	if (error) {
		error.remove();
	}
};
