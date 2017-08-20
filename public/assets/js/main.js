(function (exports) {
	function InvalidInputHelper(input, options) {
		function changeOrInput() {
			this.setCustomValidity(options.change.call(this, this.value));
		}
		function invalid() {
			this.setCustomValidity(options.change.call(this, this.value));
		}
		input.addEventListener("change", changeOrInput);
		input.addEventListener("input", changeOrInput);
		input.addEventListener("invalid", invalid);
	}
	exports.InvalidInputHelper = InvalidInputHelper;
})(window);

function on_mouse_over(e) {
	var obj = e.target;
	
	// обрабатываем картинку по over (если требуется)
	if (obj.getAttribute('data-active') != '1') {
		obj.style.background = 'url(/public/assets/img/img04.jpg) no-repeat left top';
	}
	
	// обрабатываем раскрытие меню (если требуется)
	if (obj.childNodes.length > 0) {
		for(var i=0; i<obj.childNodes.length; i++) {
			if (obj.childNodes[i].tagName == 'UL') {
				var ul = obj.childNodes[i];
				ul.style.display = 'block';
			}
		}
	}
}

function on_mouse_out(e) {
	console.log(e);
	var obj = e.target;
	// обрабатываем картинку (если требуется)
	if (obj.getAttribute('data-active') != '1') {
		obj.style.background = 'url(/public/assets/img/img02.jpg) no-repeat left top';
	}
	
	// обрабатываем скрытие меню (если требуется)
	if (obj.childNodes.length > 0) {
		for(var i=0; i<obj.childNodes.length; i++) {
			if (obj.childNodes[i].tagName == 'UL') {
				var ul = obj.childNodes[i];
				ul.style.display = 'none';
			}
		}
	}
}

function check_zero(s) {
	s = s + '';
	if (s.length == 1)
		s = '0' + s;
	return s;
}

function setPageTime() {
	var currentDateObj = document.getElementById('current-date');
	if (currentDateObj) {
		var monthList = new Array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 
			'августа', 'сентября', 'октября', 'ноября', 'декабря');
		var currDate = new Date();
		var m = monthList[currDate.getMonth()];
		var s = check_zero(currDate.getDate()) + ' ' + m + ' ' + Math.round(currDate.getFullYear()%1000) + ' ' +
			check_zero(currDate.getHours()) + ':' + check_zero(currDate.getMinutes()) + ':' + 
			check_zero(currDate.getSeconds());
		currentDateObj.innerHTML = s;
	}
	setTimeout('setPageTime(1000)');
        
}

function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, options) {
	options = options || {};
	var expires = options.expires;
	if (typeof expires == "number" && expires) {
		var d = new Date();
		d.setTime(d.getTime() + expires * 1000);
		expires = options.expires = d;
	}
	if (expires && expires.toUTCString) {
		options.expires = expires.toUTCString();
	}
	value = encodeURIComponent(value);
	var updatedCookie = name + "=" + value;
	for (var propName in options) {
		updatedCookie += "; " + propName;
		var propValue = options[propName];
		if (propValue !== true) {
			updatedCookie += "=" + propValue;
		}
	}
	document.cookie = updatedCookie;
}

function updatePagesInfo(pages) {
	var updated = false;
	for(var i=0; i<pages.length; i++) {
		if (pages[i].url == window.location + '') {
			pages[i].views++;
			updated = true;
		}
	}
	if (!updated) {
		pages.push({
			'url': window.location + '',
			'views': 1
		});
	}
	return pages;
}

document.addEventListener("DOMContentLoaded", function(event) { 
	var loc = window.location.pathname;
	var m = loc.match(/\/([^\/]+)/i);
        if (m !== null){
           var curr_page = m[1];
        }else {
            curr_page = 'index';
        }
	

	var nav = document.getElementById('navmenu');
	if (nav) {
		for(var j=0; j<nav.childNodes.length; j++) {
			if (nav.childNodes[j].tagName == 'UL') {
				var links = nav.childNodes[j].childNodes;
				for(var i=0; i<links.length; i++) {
					
					if (links[i].tagName == 'LI') {
						links[i].addEventListener("mouseenter", on_mouse_over, false);
						links[i].addEventListener("mouseleave", on_mouse_out, false);
						var innerLinks = links[i].getElementsByTagName('A');
						var active = innerLinks[0].getAttribute('href') == curr_page ? '1' : '0';
						links[i].setAttribute("data-active", active);
						if (active == '1') {
							links[i].style.background = 'url(/public/assets/img/img03.jpg) no-repeat left top';
						}
					}
				}
				break;
			}
		}
	}
	
	setPageTime();
	
	var pages = updatePagesInfo(JSON.parse(getCookie('history') || '[]'));
	setCookie('history', JSON.stringify(pages), {
		'expires': 3600,
		'path': '/'
	});
	pages = updatePagesInfo(JSON.parse(localStorage.getItem('history') || '[]'));
	localStorage.setItem('history', JSON.stringify(pages));
});
