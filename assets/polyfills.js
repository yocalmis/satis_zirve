if (!Array.prototype.find) {
	Object.defineProperty(Array.prototype, 'find', {
		value: function(predicate) {
			if (this == null) {
				throw new TypeError('"this" is null or not defined');
			}

			var o = Object(this);

			var len = o.length >>> 0;

			if (typeof predicate !== 'function') {
				throw new TypeError('predicate must be a function');
			}


			var thisArg = arguments[1];


			var k = 0;


			while (k < len) {

				var kValue = o[k];
				if (predicate.call(thisArg, kValue, k, o)) {
					return kValue;
				}

				k++;
			}

			return undefined;
		},
		configurable: true,
		writable: true
	});
}
if (!Array.prototype.includes) {
	Object.defineProperty(Array.prototype, 'includes', {
		value: function(searchElement, fromIndex) {

			if (this == null) {
				throw new TypeError('"this" is null or not defined');
			}

			var o = Object(this);

			var len = o.length >>> 0;

			if (len === 0) {
				return false;
			}
			var n = fromIndex | 0;
			var k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

			function sameValueZero(x, y) {
				return x === y || (typeof x === 'number' && typeof y === 'number' && isNaN(x) && isNaN(y));
			}

			while (k < len) {
				if (sameValueZero(o[k], searchElement)) {
					return true;
				}
				k++;
			}
			return false;
		}
	});
}

function uniqId() {
	return Math.round(new Date().getTime() + (Math.random() * 100));
}

function collectionHas(a, b) {
	for(var i = 0, len = a.length; i < len; i ++) {
		if(a[i] == b) return true;
	}
	return false;
}
function findParentBySelector(elm, selector) {
	var all = document.querySelectorAll(selector);
	var cur = elm.parentNode;
	while(cur && !collectionHas(all, cur)) {
		cur = cur.parentNode;
	}
	return cur;
}
(function(ELEMENT) {
	ELEMENT.matches = ELEMENT.matches || ELEMENT.mozMatchesSelector || ELEMENT.msMatchesSelector || ELEMENT.oMatchesSelector || ELEMENT.webkitMatchesSelector;
	ELEMENT.closest = ELEMENT.closest || function closest(selector) {
		if (!this) return null;
		if (this.matches(selector)) return this;
		if (!this.parentElement) {return null}
			else return this.parentElement.closest(selector)
		};
}(Element.prototype));
(function(e){
	e.closest = e.closest || function(css){ 
		var node = this;

		while (node) { 
			if (node.matches(css)) return node; 
			else node = node.parentElement; 
		} 
		return null; 
	} 
})(Element.prototype);