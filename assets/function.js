Waves.attach('.waves-effect', ['waves-button']);
Waves.attach('.waves-light', ['waves-button', 'waves-float', 'waves-light']);
Waves.attach('.waves-ripple', ['waves-circle', 'waves-float']);
Waves.init();
function getRandomSvgColorPalette(){
	let colors = [
	{
		fill: '#e37400',
		color: '#ffffff'
	},
	{
		fill: '#a50e0e',
		color: '#ffffff'
	},
	{
		fill: '#681da8',
		color: '#ffffff'
	},
	{
		fill: '#9c166b',
		color: '#ffffff'
	},
	{
		fill: '#0d652d',
		color: '#ffffff'
	},
	{
		fill: '#ee675c',
		color: '#ffffff'
	}
	];
	return colors[Math.floor(Math.random()*colors.length)];
}
function getDayName(date) {
	var fullDate = new Date(date);
	var weekdays = ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'];
	return weekdays[fullDate.getDay()];
}
function getMonthName(date) {
	var fullDate = new Date(date);
	var monthNames = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
	return monthNames[fullDate.getMonth()];
}
function getDayNumm(date) {
	var fullDate = new Date(date);
	return fullDate.getDate();
}
function onlyUnique(value, index, self) {
	return self.indexOf(value) === index;
}
function removeScript(src) {
	let script = document.querySelector('script[src="'+ src +'"]');
	script.parentNode.removeChild(script);
}
function addScripts(links) {
	function appendScript(src) {
		let script = document.createElement('script');
		script.setAttribute('type', 'text/javascript');
		script.setAttribute('src', src);
		script.setAttribute('async', 'false');
		document.querySelector('body').append(script);
	}
	if (Array.isArray(links)) {
		links.forEach(function(src){appendScript(src)})
	}
	else {
		appendScript(links)
	}
}
function removeScriptsViaSrc(array) {
	array.forEach(function(src){removeScript(src)})
}
function rebaseGroceryCrud() {
	let getCrudScripts = document.querySelectorAll('script[src]');
	let linkArray = []
	getCrudScripts.forEach(function(script) {
		let link = script.getAttribute('src');
		let status = link.indexOf('grocery_crud') !== -1;
		(status == true) && linkArray.push(link)
	})
	removeScriptsViaSrc(linkArray);
	addScripts(linkArray);
	console.log(linkArray);
}
function rebaseScriptsViaStrings(str) {
	function rebaseScript(string) {
		let getScripts = document.querySelectorAll('script[src]');
		let linkArray = []
		getScripts.forEach(function(script) {
			let link = script.getAttribute('src');
			let status = link.indexOf(str) !== -1;
			(status == true) && linkArray.push(link)
		});
		removeScriptsViaSrc(linkArray);
		addScripts(linkArray);
		console.log(linkArray);
	}
	if (Array.isArray(str)) {
		str.forEach(function(src){rebaseScript(src)})
	}
	else {
		rebaseScript(str)
	}
}
if (window !== window.top) {
	let body = document.querySelector('body');
	let sideHeader = body.querySelector('.side-header');
	body.querySelector('.side-nav').style.display = 'none';
	let main = body.querySelector('main');
	main.style.padding = '0';
	main.style.paddingLeft = '0';
	main.style.paddingTop = '0';
	main.style.height = 'calc(100vh - 1.1rem)';
	let pageInner = document.querySelector('.pageInner');
	pageInner.removeAttribute('style');
	pageInner.style.padding = '1px';
	pageInner.style.paddingRight = '16px';
	if (body.querySelector('.pDiv')) {
		let buttons = body.querySelector('.pDiv');
		if (buttons.querySelector('#save-and-go-back-button')) {
			let goBackBtn = buttons.querySelector('#save-and-go-back-button');
			goBackBtn.parentNode.removeChild(goBackBtn);
		}
		if (buttons.querySelector('#cancel-button')) {
			let cancelBtn = buttons.querySelector('#cancel-button');
			cancelBtn.parentNode.removeChild(cancelBtn);
		}
		if (body.querySelector('.mDiv')) {
			let mDiv = body.querySelector('.mDiv');
			mDiv.parentNode.removeChild(mDiv);

		}
		if (document.querySelector('.form-div')) {
			let formDiv = document.querySelector('.form-div');
			formDiv.style.borderRadius = '4px'
			formDiv.querySelector('.form-field-box').style.borderTop = '1px solid var(--minGray)';
			formDiv.querySelector('.form-field-box').style.borderRadius = '4px 4px 0 0';
		}

	}


	body.removeChild(sideHeader)
}


$.fn.stickynav = function ( options ){
	var
	nav       = $(this),
	navHeight = nav.height(),
	$window   = $(window);

	function scrollEvent() {

		var scrollTop = $window.scrollTop();

		if (scrollTop == 0) {
			nav.removeClass('sticky');
		}

		if (scrollTop > navHeight) {

			setTimeout( function(){
				nav.addClass('sticky');
			});

		}
		else {

			nav.removeClass('sticky');

		}
	};
	scrollEvent();

	$window.scroll(function() {
		scrollEvent();
	});
}
function generateCrudDom(link, parentHeight) {
	let content = document.createElement('div');
	content.classList.add('modal__ajax-content');
	return fetch(link, {
		headers : {'Content-Type': 'application/x-www-form-urlencoded'},
		method: 'POST',
		body: 'token=' + self.token,
	}).then(response => response.json())
	.then(result => {
		let head = document.querySelector('head'),
		body = document.querySelector('body');
		let inpageCss = []
		document.querySelectorAll('link').forEach(function(link) {
			let extension = link.href.substring(link.href.lastIndexOf("."));
			if (extension == '.css') inpageCss.push(link.getAttribute('href'))
		})
		let cssFiles = Object.values(result.css_files).filter(function(link) {
			return inpageCss.indexOf(link) === -1;
		});
		cssFiles.forEach(function(file) {
			let link = document.createElement('link');
			link.setAttribute('href', file);
			link.setAttribute('type', 'text/css');
			link.setAttribute('rel', 'stylesheet');
			head.prepend(link);
		});

		let newDoc = new DOMParser().parseFromString(result.output, 'text/html');
		let doc = newDoc.querySelector('body');
		let mDiv = doc.querySelector('.mDiv');
		mDiv.parentNode.removeChild(mDiv);
		if (doc.querySelector('.form-div')) {
			let formDiv = doc.querySelector('.form-div');
			formDiv.style.borderRadius = '4px';
			let fieldBox = formDiv.querySelector('.form-field-box');
			fieldBox.style.borderTop = '1px solid var(--minGray)';
			fieldBox.style.borderRadius = '4px 4px 0 0';

		}
		if (doc.querySelector('.edit_button--settings')) {
			removeElems('.edit_button--settings', doc);

		}
		if (doc.querySelector('input.back-to-list')) {
			removeElems('.pDiv', doc);
			let allFieldBox = formDiv.querySelectorAll('.form-field-box'),
			lastOfFieldBox = allFieldBox[allFieldBox.length - 1];
			lastOfFieldBox.style.borderRadius = '0 0 4px 4px';
		}
		let innerOfScripts = []
		doc.querySelectorAll('script').forEach(function(script) {
			innerOfScripts.push(script.innerHTML)
		});
		let newScript = document.createElement('script');
		newScript.setAttribute('type', 'text/javascript');
		newScript.setAttribute('async', 'false');
		newScript.insertAdjacentHTML('afterbegin', innerOfScripts.join(''));
		content.prepend(newScript);
		content.style.height = parentHeight + 'px';
		doc.children.forEach(function(child){
			content.append(child)
		});
		let inPageJs = []
		document.querySelectorAll('script').forEach(function(script) {
			let extension = script.src.substring(script.src.lastIndexOf("."));
			(extension == '.js') && inPageJs.push(script.getAttribute('src'));

		})
		let jsFiles = Object.values(result.js_lib_files)
		jsFiles = jsFiles.filter(onlyUnique);
		jsFiles = jsFiles.filter(function(script) {
			return inPageJs.indexOf(script) === -1;
		});
		jsFiles.forEach(function(file) {
			let script = document.createElement('script');
			script.type = "text/javascript";
			script.setAttribute('async', 'false');
			script.src = file;
			body.append(script);
		});
		let jsConfigs = Object.values(result.js_config_files);
		jsConfigs.forEach(function(file) {
			let script = document.createElement('script');
			script.type = "text/javascript";
			script.setAttribute('async', 'false');
			script.src = file;
			body.append(script);
		});
		return content;
	});

}
function generateIframeDOM(link, identificator) {
	let content = document.createElement('iframe');
	content.setAttribute('frameborder', 0);
	content.setAttribute('src', link)
	content.dataset.id = identificator;
	content.classList.add('modal__iframe-content');
	return content;
}
function hideElems(selector, parent) {
	let getParent = ( typeof parent !== 'undefined' ) ? parent : document;
	getParent.querySelectorAll(selector).forEach(function(content) {
		content.style.display = 'none';
	});
}
function removeElems(selector, parent) {
	let getParent = ( typeof parent !== 'undefined' ) ? parent : document;
	getParent.querySelectorAll(selector).forEach(function(content) {
		content.parentNode.removeChild(content);
	});
}
function contentGenerator(link, parent, isSpecific, identificator, isIframe) {
	let flags = self.flags,
	userId = findParentBySelector(parent, '.modal').dataset.id,
	addon = (isSpecific == true) ? ('/' + userId) : '',
	fullLink = window.base_url + link + addon;

	hideElems('.modal__ajax-content, .modal__iframe-content', parent);
	if (flags['content' + identificator] == true) {
		let iframeContent = parent.querySelector('.modal__iframe-content[data-id="'+ identificator +'"]');
		iframeContent.style.display = 'block';
	}
	else {
		flags['content' + identificator] = true;
		let innerOfContent = generateIframeDOM(fullLink, identificator)
		let inner = parent.querySelector('.modal-iframe-inner')
		inner.appendChild(innerOfContent);
	}
	// CRUD Modal kaldırıldı.
	// if(isIframe) {}
	// else {
	// 	hideElems('.modal__iframe-content', parent);
	// 	removeElems('.modal__ajax-content', parent);
	// 	let parentHeight = parent.querySelector('.modal-iframe-inner').clientHeight - 20;
	// 	generateCrudDom(fullLink, parentHeight).then(response => {
	// 		let inner = parent.querySelector('.modal-iframe-inner')
	// 		inner.appendChild(response);
	// 	});
	// }

}

function closeDropdown(element) {
	document.querySelectorAll('.dropdown-list--open').forEach(function(element) {
		let list = element.parentNode.querySelector('ul.dropdown-list');
		list.removeAttribute('style')
		element.parentNode.querySelector('.dropdown-trigger').classList.remove('dropdown-trigger--opened');
		list.classList.remove('dropdown-list--open');
		list.setAttribute('tab-index', -1);
		list.querySelectorAll('.dropdown-list-item').forEach(function(element) {
			element.setAttribute('tab-index', -1);
		})
		element.classList.remove('dropdown-trigger--opened')
	})

}

function dropdown(element) {
	element.onclick = function(event) {
		closeDropdown(element);
		element.classList.add('dropdown-trigger--opened');
		let parentModal = findParentBySelector(element, '.modal')
		let modalRects = parentModal.getBoundingClientRect();
		let elRects = element.getBoundingClientRect();
		let list = element.parentNode.querySelector('ul.dropdown-list');
		list.classList.add('dropdown-list--open');
		list.style.top = (elRects.bottom - modalRects.top) + 8 + 'px';
		list.style.left = (elRects.left - modalRects.left) + 'px';
		list.style.maxHeight = (42 * list.childElementCount) + 16 + 'px';
		list.style.zIndex = parentModal.style.zIndex + 1;
		list.removeAttribute('tab-index');
		list.querySelectorAll('.dropdown-list-item').forEach(function(element) {
			element.removeAttribute('tab-index');
		});
		document.addEventListener('click', function (event) {
			if (!event.target.classList.contains('dropdown-trigger--opened')) {
				closeDropdown(element);
			}
		}, false)

	}
}

function openModal(id) {
	if (!self.flags['modal_opened' + id]) {
		function closeFunc(event) {
			setTimeout(function(){modal.classList.remove('modal--opened')})
			overlay.classList.remove('overlay--opened');
		}
		let body = document.querySelector('body');
		let overlay = document.createElement('div');
		overlay.classList.add('modal-overlay');
		overlay.classList.add('overlay--opened');
		overlay.dataset.id = id;
		overlay.onclick = function (event) {
			closeFunc(event)
		}

		let modal = document.createElement('div');
		modal.classList.add('modal');
		modal.dataset.id = id;

		let modalHeader = document.createElement('div');
		modalHeader.classList.add('modal__header');
		modalHeader.classList.add('m-header');

		let modalHeaderTitle = document.createElement('h3');
		modalHeaderTitle.classList.add('m-header__title');
		modalHeaderTitle.textContent = (self['modalText'] !== undefined) ? self.modalText : 'Hızlı İşlemler';

		let modalInner = document.createElement('div');
		modalInner.classList.add('modal__inner');
		modalInner.classList.add('m-inner');

		let iframeInner = document.createElement('div');
		iframeInner.classList.add('modal-iframe-inner');

		let closeBtn = document.createElement('button');
		closeBtn.classList.add('modal__close');
		closeBtn.classList.add('waves-effect');
		closeBtn.insertAdjacentHTML('beforeend', '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>');
		closeBtn.onclick = function (event) {
			closeFunc(event)
		}

		let btnList = document.createElement('ul')
		btnList.classList.add('modal__btn-group');
		btnList.classList.add('button-group');

		let buttonGroups = self.buttons

		buttonGroups.forEach(function(group) {
			let
			groupListItem = document.createElement('li');
			groupListItem.classList.add('button-group-item');
			let groupButton = document.createElement('button');
			groupButton.classList.add('button-group__button');
			groupButton.classList.add('dropdown-trigger');
			groupButton.textContent = group.group_name;
			let childrensList = document.createElement('ul');
			childrensList.classList.add('dropdown-list');
			childrensList.setAttribute('tab-index', -1);

			let childrensArray = group.grup_buttons;
			childrensArray.forEach(function(children) {
				let listItem = document.createElement('li');
				listItem.classList.add('dropdown-list-item');
				listItem.setAttribute('tab-index', -1);
				listItem.textContent = children.name;
				listItem.dataset.href = children.link;
				listItem.dataset.who = uniqId();
				listItem.onclick = function(event) {
					contentGenerator(listItem.dataset.href, findParentBySelector(listItem, '.modal__inner'), children.isSpecific, listItem.dataset.who, children.isIframe)
				};
				childrensList.appendChild(listItem)
			});

			groupListItem.appendChild(groupButton);
			groupListItem.appendChild(childrensList);
			btnList.appendChild(groupListItem);
			dropdown(groupButton)

		})



		modalInner.appendChild(btnList);
		modalInner.appendChild(iframeInner);
		modalHeader.appendChild(modalHeaderTitle);
		modalHeader.appendChild(closeBtn);
		modal.appendChild(modalHeader);
		modal.appendChild(modalInner);
		body.appendChild(overlay);
		body.prepend(modal);

		self.flags['modal_opened' + id] = true;
	}
	setTimeout(()=>document.querySelector('.modal[data-id="' + id + '"]').classList.add('modal--opened'))

	document.querySelector('.modal-overlay[data-id="' + id + '"]').classList.add('overlay--opened');
}

function settings(me) {
	console.log(me)
	let getId;
	if (me.dataset.id) {
		getId = me.dataset.id
	}
	else {
		let sibling = me.parentNode.querySelector('a'),
		siblingHref = sibling.getAttribute('href');
		getId = siblingHref.substring(siblingHref.lastIndexOf('/') + 1);

	}
	console.log(getId)
	openModal(getId);
}
function createChatLine(message) {
	let msgDate = new Date(message.date);
	let minutes = (msgDate.getMinutes() < 10) ? '0' + msgDate.getMinutes() : msgDate.getMinutes();
	let hoursAndMinutes = msgDate.getHours() + ':' + minutes;
	let messageWrapper = document.createElement('div');
	messageWrapper.classList.add('chat-box-row');
	(message.from == 'me') && messageWrapper.classList.add('chat-box-row--self')
	let textWrapper = document.createElement('div');
	textWrapper.classList.add('chat-box-line');
	textWrapper.insertAdjacentHTML('beforeEnd', message.message);
	let messageTime = document.createElement('span');
	messageTime.classList.add('chat-box-line-time');
	messageTime.innerText = hoursAndMinutes;
	let messageDate = document.createElement('span');
	messageDate.classList.add('chat-box-row__time');
	messageDate.innerText = getDayName(message.date) + ' · '
	+ getDayNumm(message.date) + ' '
	+ getMonthName(message.date);
	let loaderSpan = document.createElement('span');
	loaderSpan.classList.add('chat-box-loader');
	loaderSpan.insertAdjacentHTML('beforeEnd', '<svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="20px" height="20px" viewBox="0 0 128 128" xml:space="preserve"><g transform="rotate(204.121 64 64)"><path d="M64 9.75A54.25 54.25 0 0 0 9.75 64H0a64 64 0 0 1 128 0h-9.75A54.25 54.25 0 0 0 64 9.75z" fill="#1a73e8" fill-opacity="1"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1800ms" repeatCount="indefinite"/></g></svg>');

	messageWrapper.setAttribute('data-time', message.date)
	textWrapper.append(messageTime);
	messageWrapper.append(textWrapper);
	messageWrapper.append(messageDate);
	messageWrapper.append(loaderSpan);
	return messageWrapper;
}
function removeDates() {
	let chatRows = newChatBox.querySelectorAll('.chat-box-row');
	for (let i = 0; i < chatRows.length; i++) {
		let chatRow = chatRows[i];
		let mineDate = new Date(chatRow.getAttribute('data-time')),
		mineDateNoTime = new Date(mineDate.getFullYear(), mineDate.getMonth(), mineDate.getDate()),
		nextSibling = chatRow.nextSibling;
		if (nextSibling == null) {break;}
		let nextSiblingDate = new Date(nextSibling.getAttribute('data-time')),
		nextSiblingDateNoTime = new Date(nextSiblingDate.getFullYear(), nextSiblingDate.getMonth(), nextSiblingDate.getDate());

		if (mineDateNoTime.getTime() == nextSiblingDateNoTime.getTime()) {
			let timeSpan = nextSibling.querySelector('.chat-box-row__time');
			if (timeSpan == null) {break;}
			nextSibling.removeChild(timeSpan);
		}

	}

}
function renderChatRow(person) {
	let msgDate = new Date(person.tarih),
	minutes = (msgDate.getMinutes() < 10) ? '0' + msgDate.getMinutes() : msgDate.getMinutes(),
	hoursAndMinutes = msgDate.getHours() + ':' + minutes;

	let dateDayName = getDayName(person.tarih),
	dateDayNum = getDayNumm(person.tarih),
	dateMonthName = getMonthName(person.tarih),
	dateText = dateDayName + ' · ' + dateDayNum + ' ' + dateMonthName;

	let chatRow = document.createElement('div')
	chatRow.classList.add('chats-row');
	if (person.message) {
		chatRow.classList.add('chats-row--withMessage');
	}
	let chatLink = document.createElement('a')
	chatLink.classList.add('chats-row__link')
	chatLink.setAttribute('href', self.base_url + person.url);
	let personIco = document.createElement('span');
	personIco.classList.add('icon')
	personIco.classList.add('chats-row__avatar');
	let parser = new DOMParser(),
	icon = parser.parseFromString('<svg viewBox="0 0 192 192"><path d="M96 85.09c13.28 0 24-10.72 24-24s-10.72-24-24-24-24 10.72-24 24 10.72 24 24 24zm0 14.18c-29.33 0-52.36 14.18-52.36 27.27C54.73 143.6 74.15 154.9 96 154.9s41.27-11.3 52.36-28.36c0-13.09-23.03-27.27-52.36-27.27z"></path></svg>', "text/html").querySelector('svg');
	let colorPalette = getRandomSvgColorPalette();
	icon.style.backgroundColor = colorPalette.fill;
	icon.style.fill = colorPalette.color;
	personIco.append(icon);
	let textBar = document.createElement('div');
	textBar.classList.add('chats-row__text-bar');
	let personTitle = document.createElement('h3');
	personTitle.classList.add('chats-row__name');
	personTitle.innerText = person.name;
	let chatOther = document.createElement('div');
	chatOther.classList.add('chats-row-other');
	if (person.message) {
		let chatMessage = document.createElement('div');
		chatMessage.classList.add('chats-row-text');
		chatMessage.insertAdjacentHTML('beforeend', person.message);
		chatOther.append(chatMessage);
	}
	let chatDate = document.createElement('span');
	chatDate.classList.add('chats-row__date');
	chatDate.innerText = dateText;
	let rightSide = document.createElement('div');
	rightSide.classList.add('chats-row__right-side');
	let chatTime = document.createElement('span');
	chatTime.classList.add('chats-row__time');
	chatTime.innerText = hoursAndMinutes;
	if (person.okunmamis > 0) {
		let isUnread = document.createElement('span');
		isUnread.classList.add('chats-row__isread');
		isUnread.classList.add('chats-row__isread--unread');
		isUnread.innerText = person.okunmamis
		rightSide.append(isUnread)
	}
	chatRow.append(chatLink)
	if (person.message) {
		chatRow.removeChild(chatLink)
	}
	chatRow.append(personIco)
	chatOther.prepend(chatDate)
	textBar.append(personTitle)
	textBar.append(chatOther)
	chatRow.append(textBar)
	rightSide.prepend(chatTime)
	chatRow.append(rightSide)

	console.log(chatRow)
	return chatRow;




}
document.addEventListener('DOMContentLoaded', function(event) {domLoaded(event)});
function domLoaded(event) {
	if (document.querySelector('.icon')) {
		let elems = document.querySelectorAll('.icon')
		loadIcons(elems);
	}
	function loadIcons(elems) {
		elems.forEach(function(ico) {
			let getIcoName = ico.dataset.svg,
			svgUrl = self.base_url + 'assets/icons/' + getIcoName + '.svg';
			fetch(svgUrl, {
				mode: 'no-cors',
				method: 'GET',
			}).then(function(response) {return response.text()})
			.then(function (xml) {
				let parser = new DOMParser();
				svg = parser.parseFromString(xml, "image/svg+xml").querySelector('svg');
				ico.append(svg)
			})
		})

	}
	if (self.chat) {
		let messages = self.chat;
		let chatBox = document.querySelector('.chat-box')

		new SimpleBar(chatBox);
		chatBox.querySelector('.simplebar-content').classList.add('chat-box');
		newChatBox = chatBox.querySelector('.simplebar-content.chat-box');
		messages.forEach(function(message) {
			newChatBox.append(createChatLine(message));
		});

		let lastMessage = newChatBox.querySelector('.chat-box-row')
		lastMessage.scrollIntoView({block: "center"});

		removeDates()
	}
	if (self.chats) {
		let parent = document.querySelector('.chat-rows');
		console.log(self.chats)
		self.chats.forEach(function(person) {
			let chatLine = renderChatRow(person);
			parent.append(chatLine);
		});
	}
	if (document.querySelector('.chats-send')) {
		let chatSendBtn = document.querySelector('.chats-send-new');
		chatSendBtn.onclick = function(e) {
			document.querySelector('form').classList.toggle('hide');
		};
	}
}

$(document).ready(function(event) {
	if ($('.material-container__heading') && (window === window.top)) {
		$('.material-container__heading').prepend(`<a href="javascript: 
            history.back()" class="material-container__btn" style="text-decoration:none; 
            font-weight:25; font-size: 25px; color: black;">Geri</a> `)
	}


	$("#search").keyup(function () {
		var value = this.value.toLowerCase().trim();

		$("table tr").each(function (index) {
			if (!index) return;
			$(this).find("td").each(function () {
				var id = $(this).text().toLowerCase().trim();
				var not_found = (id.indexOf(value) == -1);
				$(this).closest('tr').toggle(!not_found);
				return not_found;
			});
		});
	});
	if (self.chat){
		$('form').submit(function(e){
			var my_crud_form = $(this);

			$(this).ajaxSubmit({
				url: $(this).data('action'),
				dataType: 'json',
				cache: 'false',
				beforeSend: function(jqxhr, data) {
					let textareaVal = $('textarea.texteditor').val();
					if (textareaVal == '') {return false;}
					let messageData = {
						from: 'me',
						date: new Date(),
						message: textareaVal
					}
					$('.simplebar-content.chat-box').prepend(createChatLine(messageData))
					let lastMessage = newChatBox.querySelector('.chat-box-row')
					lastMessage.scrollIntoView({block: "center"});
					$('.chat-box-loader').first().addClass('chat-box-loader--active');
					$('.chat-box-row__time').first().hide();

				},
				success: function(data){
					$('.chat-box-loader').first().removeClass('chat-box-loader--active');
					$('.chat-box-row__time').first().show();
					$('.texteditor').empty();
					removeDates();
				},
				error: function(data){
					$('.chat-box-row').first().remove();
				}
			});
			return false;
		});
	}
	if (self.chats){
		$('form').submit(function(e){
			$('.chat-send--sending').addClass('hide')
			$('.chat-send--success').addClass('hide')
			$('.chat-send--error').addClass('hide')
			var my_crud_form = $(this);
			let newMessages = [];
			$(this).ajaxSubmit({
				url: $(this).data('action'),
				dataType: 'json',
				cache: 'false',
				beforeSend: function(jqxhr, data) {
					$('.chat-send--sending').removeClass('hide')
					let textareaVal = $('textarea.texteditor').val();
					if (textareaVal == '') {return false;}
					if (self.IsChatsMessage == true) {
						let messageObj = {
							name: self.onlineUser,
							okunmamis: 0,
							tarih: new Date(),
							url: false,
							message: textareaVal
						}
						self.chats.push(messageObj);
						newMessages = self.chats;
					}
					else {
						let selectedIDs = $('.m_s_msg').val()
						let selectedNames = [];
						$('.m_s_msg option:selected').each(function(){
							var $value = $(this).data('name');
							selectedNames.push($value)
						});
						let existChats = self.chats
						existChats = existChats.filter(function(script) {
							return selectedNames.indexOf(script.name) === -1;
						});

						selectedNames.forEach(function(names, index) {
							existChats.push({
								name: names,
								okunmamis: 0,
								tarih: new Date(),
								url: 'yonetim/mesajdetay/' +  selectedNames[index]
							})
						});
						newMessages = existChats;
						self.chats = existChats;
						console.log(newMessages)

					}
				},
				success: function(data){
					$('.texteditor').empty();
					$('.chat-send--sending').addClass('hide')
					$('.chat-send--success').removeClass('hide')
					$('.chats-row').remove();
					newMessages.forEach(function(message) {
						$('.chat-rows').append(renderChatRow(message));
					});
					console.log('success')
					console.log(data)
				},
				error: function(data){
					$('.chat-send--sending').addClass('hide')
					$('.chat-send--error').removeClass('hide')
					newMessages = []
					console.log('error')
					console.log(data)
				}
			});
			return false;
		});
	}
	(document.querySelector('.edit_button--settings')) && checkPage();
	if ($('.side-nav')) {
		$("#istek").load(window.self.base_url + "yonetim/okunmamis_kontrol");
		var refreshId = setInterval(function() {
			$("#istek").load(window.self.base_url + "yonetim/okunmamis_kontrol");
		}, 60000);
	}


	var
	pageURL			= $(location).attr('href'),
	linkURL			= $( "a[href='"+ pageURL +"']" );

	linkURL.addClass('sidenav__link--active').parents('.mine-trigger').addClass('mine-trigger-open mine-trigger-page').each(function() {

		var
		howmuchchildrens	= $(this).children('.mine-content').children('.mine-content__link').length,
		calcPixels			= (howmuchchildrens * 48) + 'px';
		$(this).children('.mine-content').siblings('.sidenav__link').addClass('sidenav__link--active');
		$(this).children('.mine-content').children('.sidenav__link--active').addClass('bcgNone');
		$(this).children('.mine-content').css('max-height', calcPixels);

	});

	$('.iframeTrigger, .editIframeTrigger').on('click', function(e) {
		e.preventDefault();
		var
		iframeId	= $(this).attr('href'),
		thisText	= $(this).text();

		$('.iframeModal__backdrop').addClass('iframeModal__backdrop--active');
		$('.iframeModal').addClass('iframModalActive');
		if ($(this).hasClass('calculator')){
			$('.iframeModal').addClass('calculatorIframe');
		}
		if ($(this).hasClass('editIframeTrigger')){
			$('.iframeModal').addClass('editIframe');
		}
		$('.iframeModal__heading').text(thisText);


		$('.iframeModal__iframe').attr('src', iframeId);

	});
	$('.iframeModal__backdrop, .iframeModal__close').on('click', function() {
		if ($('.iframModalActive').hasClass('editIframe')){
			location.reload();
		}

		$('.iframeModal').removeClass('iframModalActive');
		if ($('.iframeModal').hasClass('calculatorIframe')){
			$('.iframeModal').removeClass('calculatorIframe');
		}
		$('.iframeModal__heading').text('');
		$('.iframeModal__iframe').attr('src', '');
		$('.iframeModal__backdrop').removeClass('iframeModal__backdrop--active');
	});


	var winW = $(window).width();
	$('.s-n_h').height($('.side-header').height());
	$('.side-nav, .side-header, .y-n_r_i').addClass('noselect');
	$('.side-nav, .side-header, .y-n_r_i').find('i').addClass('material-icons');
	$('.side-header > h3').html($('.form-title-left > a').text()).addClass('side-header__title');
	$('.form-title-left').hide()
	$('.form-title').hide();
	$('.o_s-n').click(function(){
		$('.side-nav').addClass('side-nav-open');
		$('.s-n_o').addClass('s-n_o_o');
	});
	$('.s-n_o').click(function(){
		$('.side-nav').removeClass('side-nav-open');
		$('.s-n_o').removeClass('s-n_o_o');
	});
	$('.side-header').stickynav();
	$('.m_s_msg').SumoSelect({
		selectAll: true,
		locale: ['Ok', 'Kapat', 'Hepsini Seç']
	});


	$('.mine-trigger').click(function(e){

		var
		control_click		= $(this).hasClass('mine-trigger-open'),
		from_link			= control_click && $(e.target).closest('.mine-content__link').length == 1;
		howmuchchildrens	= $(this).children('.mine-content').children('.mine-content__link').length,
		calcPixels			= (howmuchchildrens * 48) + 'px';

		if (!control_click){
			$(this).addClass('mine-trigger-open');
			$(this).children('.mine-content').css('max-height', calcPixels);
		} else if (control_click  && !from_link) {
			$(this).removeClass('mine-trigger-open');
			$(this).children('.mine-content').css('max-height', 0);
		}
	});


	$('.y_r_y_b').click(function() {
		setTimeout(function(){
			window.location.reload();
		});
	});


	if ( (winW < 768) && ($('.side-header > h3').width() > 300) ) {
		$('.s-h_r').hide();
	}


	if (window.matchMedia('(min-width: 991px)').matches){
		$('.side-nav').addClass('side-nav-open');
	}
	if (window.matchMedia('(max-width: 991px)').matches) {
		$('.side-nav').removeClass('side-nav-open');
	}

	$('.y_r_m').on('mouseover', function(){

		$(this).addClass('clickable');

		$(this).not('.y_r_m > a').click(function() {

			$(this).children('a').hide();
			$(this).children('img').addClass('fullWH');
			$('.s-n_o').addClass('s-n_o_o').css({
				'cursor': 'zoom-out',
				'cursor': '-webkit-zoom-out',
				'background': 'rgba(0,0,0,.85)'
			});
			$('body').css('overflow', 'hidden');

			$('.s-n_o_o').click(function() {

				$('.y_r_m').children('a').show();
				$('.fullWH').removeClass('fullWH');
				$('.s-n_o').css({
					'cursor': '',
					'background': '',
				}).removeClass('s-n_o_o');
				$('body').css('overflow', 'auto');

			});

		});
	}).on('mouseout', function() {
		$(this).removeClass('clickable');
	});






	$('.user-menu').click(function() {
		var
		checkClick = $('.user-menu__trigger').hasClass('user-menu__trigger--active');

		if (checkClick) {
			$('.user-menu__trigger').removeClass('user-menu__trigger--active');
			$('.user-menu__inner').removeClass('user-menu__inner--active');
		}
		else {
			$('.user-menu__trigger').addClass('user-menu__trigger--active');
			$('.user-menu__inner').addClass('user-menu__inner--active');
		}


	});
	var a = document.getElementById("field-baslangic_saati");
	var b = document.getElementById("field-bitis_saati");

	if ( (a) || (b) ){
		a.type="time";
		b.type="time";

	}


});

$(window).resize(function(){
	if (window.matchMedia('(min-width: 991px)').matches)
	{
		$('.side-nav').addClass('side-nav-open');
	}
	if (window.matchMedia('(max-width: 991px)').matches) {
		$('.side-nav').removeClass('side-nav-open');
	}
});
$(document).mouseup(function(e) {
	var my_inner = $('.user-menu');

	if (!my_inner.is(e.target) && my_inner.has(e.target).length === 0) {
		$('.user-menu__trigger').removeClass('user-menu__trigger--active');
		$('.user-menu__inner').removeClass('user-menu__inner--active');
	}
});
